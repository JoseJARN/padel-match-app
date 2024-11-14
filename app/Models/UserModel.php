<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
  protected $table = 'users';
  protected $primaryKey = 'id';
  protected $allowedFields = [
    'email',
    'password',
    'first_name',
    'last_name',
    'registration_date',
    'last_login',
    'registration_ip',
    'last_ip'
  ];
  protected $useTimestamps = false;
}
