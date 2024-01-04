<?php

namespace App\Models;

use CodeIgniter\Model;

class RegisterModel extends Model
{
    // ...
    protected $table = 'auth_ajax';
    protected $primaryKey = 'id';
    protected $protectFields = [];
}