<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Kobong extends Seeder
{
    public function run()
    {
        $data = [
            "UBK" => 6,
            "ALI" => 4,
            "SAA" => 4,
            "ABBAS" => 6
        ];
        foreach ($data as $key => $value){
            for ($i=1; $i <= $value; $i++) { 
                $insert = ["nama" => $key . " " . $i];
                $this->db->table('kobong')->insert($insert);    
            }
            
        }
        // Simple Queries
        // $this->db->query('INSERT INTO users (username, email) VALUES(:username:, :email:)', $data);

        // Using Query Builder
        // $this->db->table('users')->insert($data);
    }
}
