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

  public function index()
  {
    // Verificar si el usuario está autenticado
    if (!$this->session->get('isLoggedIn')) {
      return redirect()->to('/login')->with('error', 'Debes iniciar sesión para acceder.');
    }

    $userId = $this->session->get('user_id');

    // Paginación: Obtener los partidos del usuario
    $perPage = 20;
    $matches = $this->matchModel
      ->where('user_id', $userId)
      ->orderBy('date', 'DESC')
      ->paginate($perPage);

    // Estadísticas
    $totalMatches = $this->matchModel->where('user_id', $userId)->countAllResults(false); // Total de partidos
    $totalWins = $this->matchModel->where('user_id', $userId)->where('win', 1)->countAllResults(false); // Partidos ganados
    $totalLosses = $totalMatches - $totalWins; // Partidos perdidos
    $winPercentage = $totalMatches > 0 ? round(($totalWins / $totalMatches) * 100, 2) : 0; // % de victorias
    $totalCost = $this->matchModel->where('user_id', $userId)->selectSum('cost')->get()->getRow()->cost; // Dinero total
    $firstMatch = $this->matchModel->where('user_id', $userId)->orderBy('date', 'ASC')->first(); // Primer partido
    $lastMatch = $this->matchModel->where('user_id', $userId)->orderBy('date', 'DESC')->first(); // Último partido

    // Cargar la vista con los datos
    return view('matches', [
      'title' => 'Todos los Partidos',
      'matches' => $matches,
      'pager' => $this->matchModel->pager, // Paginador
      'stats' => [
        'total' => $totalMatches,
        'wins' => $totalWins,
        'losses' => $totalLosses,
        'winPercentage' => $winPercentage,
        'totalCost' => $totalCost,
        'firstMatch' => $firstMatch ? $firstMatch['date'] : 'No disponible',
        'lastMatch' => $lastMatch ? $lastMatch['date'] : 'No disponible',
      ],
    ]);
  }
}
