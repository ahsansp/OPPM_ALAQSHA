<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Config\Database;

class Main extends Model
{
    protected $table            = 'santri';
    protected $primaryKey       = 'santri_id';
    protected $returnType       = 'array';
    protected $protectFields    = true;
    protected $allowedFields    = ['santri_id', 'kelas_id', 'kobong_id', 'nama_lengkap', 'nama_pendek'];

    function getSelect($select = ['*'], $where = [null])
    {
        $db = \Config\Database::connect();
        $builder = $db->table('santri');
        $builder->where('kobong', $where[0]);
        if (count($where) > 1) {
            for ($i = 1; $i < count($where); $i++) {
                $builder->orWhere('kobong', $where[$i]);
            }
        }
        $builder->select($select);
        $builder->join('kobong', 'kobong.id = santri.kobong_id');
        $query = $builder->get();
        return  $query->getResult();
    }

    function getLike($select = '*', $like = [])
    {
        $db = \Config\Database::connect();
        $builder = $db->table('santri');
        if (count($like) == 1) {
            $builder->like('kmmi', $like[0], 'after');
        } else {
            $builder->like('kmmi', $like[0], 'after');
            for ($i = 1; $i < count($like); $i++) {
                $builder->orLike('kmmi', $like[$i], 'after');
            }
        }

        $builder->select($select);
        $builder->join('kelas', 'kelas.id = santri.kelas_id');
        $query = $builder->get();
        // dd($query->getResult());
        return  $query->getResult();
    }
}
