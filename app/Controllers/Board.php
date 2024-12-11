<?php

namespace App\Controllers;

use App\Models\MatchModel;

class Board extends BaseController
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

    // Obtener los partidos del usuario autenticado
    $userId = $this->session->get('user_id');

    // Obtener los últimos 6 partidos del usuario
    $matches = $this->matchModel
      ->where('user_id', $userId)
      ->orderBy('date', 'DESC')
      ->findAll(6);

    // Cargar la vista con los datos
    return view('board', [
      'title' => 'Panel de partidos - Pádel Match',
      'matches' => $matches
    ]);
  }

  public function add()
  {
    // Verificar si el usuario está autenticado
    if (!$this->session->get('isLoggedIn')) {
      return redirect()->to('/login')->with('error', 'Debes iniciar sesión para acceder.');
    }

    // Reglas de validación para los campos del formulario
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

    // Validar datos
    if (!$this->validate($rules)) {
      // Si la validación falla, redirigir con un mensaje de error
      return redirect()->to('/board')
        ->with('error', 'Datos inválidos. Por favor, revisa el formulario.')
        ->withInput(); // Mantener datos ingresados
    }

    // Guardar el partido en la base de datos
    $this->matchModel->save([
      'user_id' => $this->session->get('user_id'),
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

    // Redirigir a /board con un mensaje de éxito
    return redirect()->to('/board')->with('success', 'Partido añadido correctamente.');
  }
}
