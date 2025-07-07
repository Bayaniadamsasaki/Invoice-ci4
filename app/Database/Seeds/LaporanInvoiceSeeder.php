<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class LaporanInvoiceSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [ 'data_invoice' => 1001 ],
            [ 'data_invoice' => 1002 ],
            [ 'data_invoice' => 1003 ],
        ];
        $this->db->table('tbl_laporan_invoice')->insertBatch($data);
    }
} 