<?php

namespace App\Models;

use CodeIgniter\Model;

class Santri extends Model
{
    protected $table            = 'santri';
    protected $primaryKey       = 'SANTRI_ID';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $protectFields    = true;
    protected $allowedFields    = [];
}
