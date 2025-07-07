<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class InvoiceSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'tgl_so' => '2024-07-07',
                'nama_rek' => 'PT Rekanan Satu',
                'alamat' => 'Jl. Mawar No. 1',
                'npwp' => '01.234.567.8-999.000',
                'nama_jenis_produk' => 'Beton Ready Mix',
                'order_btg' => '100',
                'ppn' => '11',
                'total_harga' => 15000000,
            ],
            [
                'tgl_so' => '2024-07-08',
                'nama_rek' => 'PT Rekanan Dua',
                'alamat' => 'Jl. Melati No. 2',
                'npwp' => '02.345.678.9-888.000',
                'nama_jenis_produk' => 'Beton Precast',
                'order_btg' => '50',
                'ppn' => '11',
                'total_harga' => 8000000,
            ],
            [
                'tgl_so' => '2024-07-09',
                'nama_rek' => 'PT Rekanan Tiga',
                'alamat' => 'Jl. Kenanga No. 3',
                'npwp' => '03.456.789.0-777.000',
                'nama_jenis_produk' => 'Beton Instan',
                'order_btg' => '75',
                'ppn' => '11',
                'total_harga' => 12000000,
            ],
        ];
        $this->db->table('tbl_mengelola_invoice')->insertBatch($data);
    }
} 