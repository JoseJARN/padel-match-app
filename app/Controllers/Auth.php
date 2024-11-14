<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
  public function register()
  {
    helper('form'); // Cargar helper de formularios

    if ($this->request->getMethod() === 'POST') { // Detectar método POST
      // Definir reglas de validación
      $rules = [
        'email' => 'required|valid_email|is_unique[users.email]',
        'password' => 'required|min_length[8]',
        'repeat_password' => 'required|matches[password]',
        'first_name' => 'required|max_length[50]',
        'last_name' => 'required|max_length[50]',
      ];

      // Validar datos enviados
      if (!$this->validate($rules)) {
        // Inicializamos $error_form como null
        $error_form = null;

        // Obtenemos todos los errores de validación
        $validationErrors = $this->validator->getErrors();

        // Asignamos mensajes personalizados si hay errores
        if (isset($validationErrors['email'])) {
          $error_form = 'El correo electrónico ya está registrado o es inválido.';
        } elseif (isset($validationErrors['repeat_password'])) {
          $error_form = 'Las contraseñas no coinciden.';
        } elseif (isset($validationErrors['password'])) {
          $error_form = 'La contraseña debe tener al menos 8 caracteres.';
        } else {
          $error_form = 'El formulario contiene errores.';
        }

        // Recargamos la vista con errores
        return view('register', [
          'title' => 'Registra tu Usuario',
          'validation' => $this->validator,
          'error_form' => $error_form
        ]);
      }

      // Guardar usuario en la base de datos
      $userModel = new UserModel();
      $userModel->save([
        'email' => $this->request->getPost('email'),
        'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT), // Encriptar contraseña
        'first_name' => $this->request->getPost('first_name'),
        'last_name' => $this->request->getPost('last_name'),
        'registration_date' => date('Y-m-d H:i:s'),
        'registration_ip' => $this->request->getIPAddress(),
        'last_login' => null,
        'last_ip' => null,
      ]);

      // Redirigir al login con un mensaje de éxito
      return redirect()->to('/login')->with('success', 'Registro exitoso. Por favor, inicia sesión.');
    }

    // Si la solicitud es GET, mostrar el formulario
    return view('register', ['title' => 'Registro de Usuario']);
  }

  /* Código para gestionar el login y las sesiones */
  protected $session;

  public function __construct()
  {
    $this->session = session(); // Inicializamos la sesión
  }

  public function login()
  {
    helper('form'); // Cargar el helper de formularios

    if ($this->request->getMethod() === 'POST') {
      // Reglas de validación
      $rules = [
        'email' => 'required|valid_email',
        'password' => 'required',
      ];

      // Validar datos enviados
      if (!$this->validate($rules)) {
        return view('login', [
          'title' => 'Iniciar sesión',
          'validation' => $this->validator,
        ]);
      }

      $userModel = new UserModel();
      $user = $userModel->where('email', $this->request->getPost('email'))->first();

      // Verificar usuario y contraseña
      if ($user === null || !password_verify($this->request->getPost('password'), $user['password'])) {
        return view('login', [
          'title' => 'Iniciar sesión',
          'error' => 'Usuario o contraseña incorrectos',
        ]);
      }

      // Actualizar el último inicio de sesión
      $userModel->update($user['id'], [
        'last_login' => date('Y-m-d H:i:s'),
        'last_ip' => $this->request->getIPAddress() ?? '0.0.0.0',
      ]);

      // Configurar la sesión
      $this->session->set([
        'user_id' => $user['id'],
        'email' => $user['email'],
        'first_name' => $user['first_name'],
        'last_name' => $user['last_name'],
        'isLoggedIn' => true,
      ]);

      // Redirigir al dashboard o página principal
      return redirect()->to('/board');
    }

    // Si la solicitud es GET, mostrar el formulario de inicio de sesión
    return view('login', ['title' => 'Iniciar sesión']);
  }
}
