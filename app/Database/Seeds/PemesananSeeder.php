<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PemesananSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'tgl_so' => '2024-07-07',
                'no_po' => 'PO-001',
                'nama_rek' => 'PT Rekanan Satu',
                'nama_jenis_produk' => 'Beton Ready Mix',
                'order_btg' => '100',
                'total_harga' => 15000000,
            ],
            [
                'tgl_so' => '2024-07-08',
                'no_po' => 'PO-002',
                'nama_rek' => 'PT Rekanan Dua',
                'nama_jenis_produk' => 'Beton Precast',
                'order_btg' => '50',
                'total_harga' => 8000000,
            ],
            [
                'tgl_so' => '2024-07-09',
                'no_po' => 'PO-003',
                'nama_rek' => 'PT Rekanan Tiga',
                'nama_jenis_produk' => 'Beton Instan',
                'order_btg' => '75',
                'total_harga' => 12000000,
            ],
        ];
        $this->db->table('tbl_mengelola_pemesanan')->insertBatch($data);
    }
} 