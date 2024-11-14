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
      ->where('user_id', $userId)
      ->where('date >=', $startDate)
      ->findAll();

    $total = count($matches);
    $wins = count(array_filter($matches, fn($m) => $m['win'] == 1));
    $losses = $total - $wins;
    $winPercentage = $total > 0 ? round(($wins / $total) * 100, 2) : 0;
    $cost = array_sum(array_column($matches, 'cost'));

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
    $firstMatch = $this->matchModel->where('user_id', $userId)->orderBy('date', 'ASC')->first();
    $lastMatch = $this->matchModel->where('user_id', $userId)->orderBy('date', 'DESC')->first();

    // Estadísticas por períodos
    $lastWeekStats = $this->getStatsByPeriod($userId, date('Y-m-d H:i:s', strtotime('-7 days')));
    $lastMonthStats = $this->getStatsByPeriod($userId, date('Y-m-d H:i:s', strtotime('-1 month')));
    $lastYearStats = $this->getStatsByPeriod($userId, date('Y-m-d H:i:s', strtotime('-1 year')));

    // Recuento por modalidades
    $modalities = [
      'amistoso' => $this->matchModel->where('user_id', $userId)->where('mode', 'amistoso')->countAllResults(false),
      'torneo' => $this->matchModel->resetQuery()->where('user_id', $userId)->where('mode', 'torneo')->countAllResults(false),
      'liga' => $this->matchModel->resetQuery()->where('user_id', $userId)->where('mode', 'liga')->countAllResults(false),
      'otro' => $this->matchModel->resetQuery()->where('user_id', $userId)->where('mode', 'otro')->countAllResults(false),
    ];

    // Recuento por categorías
    $categories = $this->matchModel->getCategoriesCount($userId);

    // Paginación de partidos
    $matches = $this->matchModel->resetQuery()
      ->where('user_id', $userId)
      ->orderBy('date', 'DESC')
      ->paginate(20);

    return view('matches', [
      'title' => 'Todos los Partidos',
      'matches' => $matches,
      'pager' => $this->matchModel->pager,
      'stats' => [
        'total' => $totalMatches,
        'wins' => $totalWins,
        'losses' => $totalLosses,
        'winPercentage' => $winPercentage,
        'totalCost' => $totalCost,
        'firstMatch' => $firstMatch ? $firstMatch['date'] : 'No disponible',
        'lastMatch' => $lastMatch ? $lastMatch['date'] : 'No disponible',
        'lastWeek' => $lastWeekStats,
        'lastMonth' => $lastMonthStats,
        'lastYear' => $lastYearStats,
      ],
      'modalities' => $modalities,
      'categories' => $categories,
    ]);
  }
}
