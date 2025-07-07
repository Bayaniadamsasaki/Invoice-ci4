<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRekananTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_rek' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'nama_rek' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'alamat' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'npwp' => [
                'type' => 'VARCHAR',
                'constraint' => 15,
            ],
        ]);
        $this->forge->addKey('id_rek', true);
        $this->forge->createTable('tbl_input_data_rekanan');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_input_data_rekanan');
    }
}
