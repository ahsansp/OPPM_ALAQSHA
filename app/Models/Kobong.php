<?php

namespace App\Models;

use CodeIgniter\Model;

class Kobong extends Model
{
    protected $table            = 'kobong';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;
    protected $allowedFields    = ['kobong'];
}
