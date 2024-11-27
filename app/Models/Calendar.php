<?php

namespace App\Models;

use CodeIgniter\Model;

class Calendar extends Model
{
    protected $table            = 'calendar';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;
    protected $allowedFields    = ['start','end','title','color','all_day','url'];
}
