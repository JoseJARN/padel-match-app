<?php

namespace App\Models;

use CodeIgniter\Model;

class MatchModel extends Model
{
  protected $table = 'matches';
  protected $primaryKey = 'id';
  protected $allowedFields = [
    'user_id',
    'partner',
    'rivals',
    'result',
    'win',
    'category',
    'mode',
    'club',
    'location',
    'date',
    'cost'
  ];
  protected $useTimestamps = false;
}
