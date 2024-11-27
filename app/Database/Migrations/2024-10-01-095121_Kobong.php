<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Kobong extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'jumlah' => [
                'type' => 'INT',
                'constraint' => 5,
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('kobong');
    }

    public function down()
    {
        $this->forge->dropTable('kobong');
    }
}
