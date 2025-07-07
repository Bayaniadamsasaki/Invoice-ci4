<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProdukTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'kode_jenis_produk' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'nama_jenis_produk' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'kode_kategori_produk_' => [
                'type' => 'VARCHAR',
                'constraint' => 1000,
            ],
            'nama_kategori_produk' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'berat' => [
                'type' => 'VARCHAR',
                'constraint' => 15,
            ],
        ]);
        $this->forge->addKey('kode_jenis_produk', true);
        $this->forge->createTable('tbl_input_data_produk');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_input_data_produk');
    }
}
