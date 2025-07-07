<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProdukSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'kode_jenis_produk' => 1,
                'nama_jenis_produk' => 'PC SPUN PILE',
                'kode_kategori_produk_' => 'PCA',
                'nama_kategori_produk' => 'PCA 600 - 6 UP',
                'berat' => '244.800',
            ],
            [
                'kode_jenis_produk' => 2,
                'nama_jenis_produk' => 'PC SPUN PILE',
                'kode_kategori_produk_' => 'PCA',
                'nama_kategori_produk' => 'PCA 300 - 7 BP',
                'berat' => '0.821',
            ],
            [
                'kode_jenis_produk' => 3,
                'nama_jenis_produk' => 'PC SPUN PILE',
                'kode_kategori_produk_' => 'PCA',
                'nama_kategori_produk' => 'PCA 300 - 7 UP',
                'berat' => '0.821',
            ],
            [
                'kode_jenis_produk' => 4,
                'nama_jenis_produk' => 'PC SPUN PILE',
                'kode_kategori_produk_' => 'PCA',
                'nama_kategori_produk' => 'PCA 300 - 8 BP',
                'berat' => '0.940',
            ],
            [
                'kode_jenis_produk' => 5,
                'nama_jenis_produk' => 'PC SPUN PILE',
                'kode_kategori_produk_' => 'PCA',
                'nama_kategori_produk' => 'PCA 300 - 8 UP',
                'berat' => '0.940',
            ],
        ];

        $this->db->table('tbl_input_data_produk')->insertBatch($data);
    }
}
