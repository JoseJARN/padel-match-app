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
        'first_name' => 'required|max_length[50]',
        'last_name' => 'required|max_length[50]',
      ];

      // Validar datos enviados
      if (!$this->validate($rules)) {
        // Si la validación falla, recargar la vista con errores
        return view('register', [
          'title' => 'Registro de Usuario',
          'validation' => $this->validator,
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
}
