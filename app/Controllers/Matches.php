<?php

namespace App\Controllers;

use App\Models\MatchModel;

class Matches extends BaseController
{
  protected $matchModel;
  protected $session;

  public function __construct()
  {
    $this->matchModel = new MatchModel(); // Instanciar el modelo
    $this->session = session(); // Iniciar sesión
  }

  // Método privado para calcular estadísticas de un rango de fechas
  private function getStatsByPeriod($userId, $startDate)
  {
    $matches = $this->matchModel
      ->resetQuery() // Resetea el modelo
      ->where('user_id', $userId)
      ->where('date >=', $startDate)
      ->findAll();

    $total = count($matches);
    $wins = count(array_filter($matches, fn($m) => $m['win'] == 1));
    $losses = $total - $wins;
    $winPercentage = $total > 0 ? round(($wins / $total) * 100, 2) : 0;
    $cost = array_sum(array_column($matches, 'cost'));

    log_message('debug', 'Estadísticas calculadas: Total: ' . $total . ', Ganados: ' . $wins . ', Pérdidas: ' . $losses);

    return [
      'total' => $total,
      'wins' => $wins,
      'losses' => $losses,
      'winPercentage' => $winPercentage,
      'totalCost' => $cost,
    ];
  }


  // Método público para manejar la vista principal de partidos
  public function index()
  {
    if (!$this->session->get('isLoggedIn')) {
      return redirect()->to('/login')->with('error', 'Debes iniciar sesión para acceder.');
    }

    $userId = $this->session->get('user_id');

    // Estadísticas generales
    $totalMatches = $this->matchModel->where('user_id', $userId)->countAllResults(false);
    $totalWins = $this->matchModel->where('user_id', $userId)->where('win', 1)->countAllResults(false);
    $totalLosses = $totalMatches - $totalWins;
    $winPercentage = $totalMatches > 0 ? round(($totalWins / $totalMatches) * 100, 2) : 0;
    $totalCost = $this->matchModel->where('user_id', $userId)->selectSum('cost')->get()->getRow()->cost;

    // Recuento por modalidades
    $modalities = [
      'amistoso' => $this->matchModel->where('user_id', $userId)->where('mode', 'amistoso')->countAllResults(false),
      'torneo' => $this->matchModel->resetQuery()->where('user_id', $userId)->where('mode', 'torneo')->countAllResults(false),
      'liga' => $this->matchModel->resetQuery()->where('user_id', $userId)->where('mode', 'liga')->countAllResults(false),
      'otro' => $this->matchModel->resetQuery()->where('user_id', $userId)->where('mode', 'otro')->countAllResults(false),
    ];

    // Recuento por categorías
    $categories = $this->matchModel->getCategoriesCount($userId);

    // Estadísticas por períodos
    $lastWeekStats = $this->getStatsByPeriod($userId, date('Y-m-d H:i:s', strtotime('-7 days')));
    $lastMonthStats = $this->getStatsByPeriod($userId, date('Y-m-d H:i:s', strtotime('-1 month')));
    $lastYearStats = $this->getStatsByPeriod($userId, date('Y-m-d H:i:s', strtotime('-1 year')));

    // Primer partido del usuario
    $firstMatch = $this->matchModel->resetQuery()
      ->where('user_id', $userId)
      ->orderBy('date', 'ASC')
      ->first();
    $firstMatchDate = $firstMatch ? $firstMatch['date'] : 'N/A';

    // Último partido del usuario
    $lastMatch = $this->matchModel->resetQuery()
      ->where('user_id', $userId)
      ->orderBy('date', 'DESC')
      ->first();
    $lastMatchDate = $lastMatch ? $lastMatch['date'] : 'N/A';

    // Paginación de partidos
    $matches = $this->matchModel->resetQuery()
      ->where('user_id', $userId)
      ->orderBy('date', 'DESC')
      ->paginate(6); // Partidos por página

    $pager = $this->matchModel->pager; // Objeto de paginación

    return view('matches', [
      'title' => 'Todos los Partidos',
      'matches' => $matches,
      'pager' => $pager,
      'stats' => [
        'total' => $totalMatches,
        'wins' => $totalWins,
        'losses' => $totalLosses,
        'winPercentage' => $winPercentage,
        'totalCost' => $totalCost,
        'lastWeek' => $lastWeekStats,
        'lastMonth' => $lastMonthStats,
        'lastYear' => $lastYearStats,
        'firstMatch' => $firstMatchDate,
        'lastMatch' => $lastMatchDate,
      ],
      'modalities' => $modalities,
      'categories' => $categories,
    ]);
  }

  // Métodos edit, update y delete se mantienen iguales
  public function edit($id)
  {
    if (!$this->session->get('isLoggedIn')) {
      return redirect()->to('/login')->with('error', 'Debes iniciar sesión para acceder.');
    }

    $match = $this->matchModel->find($id);

    if (!$match) {
      return redirect()->to('/matches')->with('error', 'El partido no existe.');
    }

    if ($match['user_id'] != $this->session->get('user_id')) {
      return redirect()->to('/matches')->with('error', 'No tienes permiso para editar este partido.');
    }

    return view('edit_match', [
      'title' => 'Editar Partido',
      'match' => $match
    ]);
  }

  public function update($id)
  {
    if (!$this->session->get('isLoggedIn')) {
      return redirect()->to('/login')->with('error', 'Debes iniciar sesión para acceder.');
    }

    $match = $this->matchModel->find($id);

    if (!$match) {
      return redirect()->to('/matches')->with('error', 'El partido no existe.');
    }

    $rules = [
      'partner' => 'required|max_length[100]',
      'rivals' => 'required|max_length[200]',
      'result' => 'required|max_length[20]',
      'win' => 'required|in_list[0,1]',
      'category' => 'required|max_length[10]',
      'mode' => 'required|max_length[10]',
      'club' => 'required|max_length[50]',
      'location' => 'required|max_length[50]',
      'date' => 'required|valid_date',
      'cost' => 'required|decimal',
    ];

    if (!$this->validate($rules)) {
      return redirect()->to("/matches/edit/$id")
        ->with('error', 'Datos inválidos. Por favor, revisa el formulario.')
        ->withInput();
    }

    $this->matchModel->update($id, [
      'partner' => $this->request->getPost('partner'),
      'rivals' => $this->request->getPost('rivals'),
      'result' => $this->request->getPost('result'),
      'win' => $this->request->getPost('win'),
      'category' => $this->request->getPost('category'),
      'mode' => $this->request->getPost('mode'),
      'club' => $this->request->getPost('club'),
      'location' => $this->request->getPost('location'),
      'date' => $this->request->getPost('date'),
      'cost' => $this->request->getPost('cost'),
    ]);

    return redirect()->to('/matches')->with('success', 'Partido actualizado correctamente.');
  }

  public function delete($id)
  {
    if (!$this->session->get('isLoggedIn')) {
      return redirect()->to('/login')->with('error', 'Debes iniciar sesión para acceder.');
    }

    $match = $this->matchModel->find($id);

    if (!$match) {
      return redirect()->to('/matches')->with('error', 'El partido no existe.');
    }

    if ($match['user_id'] != $this->session->get('user_id')) {
      return redirect()->to('/matches')->with('error', 'No tienes permiso para eliminar este partido.');
    }

    $this->matchModel->delete($id);

    return redirect()->to('/matches')->with('success', 'Partido eliminado correctamente.');
  }
}
