<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateInvoiceTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'no_invoice' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'tgl_so' => [
                'type' => 'DATE',
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
                'constraint' => 16,
            ],
            'nama_jenis_produk' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'order_btg' => [
                'type' => 'VARCHAR',
                'constraint' => 30,
            ],
            'ppn' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            'total_harga' => [
                'type' => 'DOUBLE',
            ],
        ]);
        $this->forge->addKey('no_invoice', true);
        $this->forge->createTable('tbl_mengelola_invoice');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_mengelola_invoice');
    }
}
