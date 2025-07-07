<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call('LoginSeeder');
        $this->call('ProdukSeeder');
        $this->call('RekananSeeder');
        $this->call('PemesananSeeder');
        $this->call('InvoiceSeeder');
    }
}
