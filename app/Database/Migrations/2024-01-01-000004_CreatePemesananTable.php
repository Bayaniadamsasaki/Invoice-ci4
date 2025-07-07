<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePemesananTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_so' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'tgl_so' => [
                'type' => 'DATE',
            ],
            'no_po' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'nama_rek' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'nama_jenis_produk' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'order_btg' => [
                'type' => 'VARCHAR',
                'constraint' => 15,
            ],
            'total_harga' => [
                'type' => 'DOUBLE',
            ],
        ]);
        $this->forge->addKey('id_so', true);
        $this->forge->createTable('tbl_mengelola_pemesanan');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_mengelola_pemesanan');
    }
}
