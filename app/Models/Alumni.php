<?php

namespace App\Models;

use CodeIgniter\Model;

class Alumni extends Model
{
    protected $table            = 'alumni';
    protected $primaryKey       = 'santri_id';
    protected $returnType       = 'array';
    protected $protectFields    = true;
    protected $allowedFields    = ['santri_id', 'kelas_kmmi', 'kelas_umum','kobong' , 'nama_lengkap', 'nama_pendek'];

}
