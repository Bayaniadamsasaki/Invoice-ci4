<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RekananSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id_rek' => 1,
                'nama_rek' => 'Adhi - Jaya Konstruksi - Waskita KSO',
                'alamat' => 'Jalan Raya Pasar Minggu Km. 18 Jakarta Selatan 12510',
                'npwp' => '',
            ],
            [
                'id_rek' => 2,
                'nama_rek' => 'Adhi - Waskita - Jaya Konstruksi KSO',
                'alamat' => 'Proyek Pembangunan Jalan Tol Banyu Lencir - Tempino Seksi 1',
                'npwp' => '00.000.000.0-000.000',
            ],
            [
                'id_rek' => 3,
                'nama_rek' => 'DAELIM - WIKA - WASKITA, KSO',
                'alamat' => 'DKI JAKARTA',
                'npwp' => '',
            ],
            [
                'id_rek' => 4,
                'nama_rek' => 'Konsortium ZUG, PT - WASKITA KARYA, PT',
                'alamat' => 'Jl. Rawa Melati Blok A-1/5 Kalideres Jakarta Barat',
                'npwp' => '',
            ],
            [
                'id_rek' => 5,
                'nama_rek' => 'WASKITA - AGUNG, KSO',
                'alamat' => 'Jl.Truntum Krapyak Lor Pekalongan Utara 51149',
                'npwp' => '',
            ],
        ];

        $this->db->table('tbl_input_data_rekanan')->insertBatch($data);
    }
}
