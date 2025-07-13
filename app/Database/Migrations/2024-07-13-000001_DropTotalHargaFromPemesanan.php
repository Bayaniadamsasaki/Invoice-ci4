<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DropTotalHargaFromPemesanan extends Migration
{
    public function up()
    {
        $this->forge->dropColumn('tbl_mengelola_pemesanan', 'total_harga');
    }

    public function down()
    {
        $this->forge->addColumn('tbl_mengelola_pemesanan', [
            'total_harga' => [
                'type' => 'DOUBLE',
                'after' => 'order_btg'
            ]
        ]);
    }
}
