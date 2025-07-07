<?php

namespace App\Controllers;

use App\Models\ProdukModel;
use App\Models\RekananModel;
use CodeIgniter\RESTful\ResourceController;

class Api extends ResourceController
{
    protected $format = 'json';

    public function getProduk($id)
    {
        $produkModel = new ProdukModel();
        $produk = $produkModel->find($id);

        if (!$produk) {
            return $this->failNotFound('Produk tidak ditemukan');
        }

        return $this->respond($produk);
    }

    public function getRekanan($id)
    {
        $rekananModel = new RekananModel();
        $rekanan = $rekananModel->find($id);

        if (!$rekanan) {
            return $this->failNotFound('Rekanan tidak ditemukan');
        }

        return $this->respond($rekanan);
    }

    public function getDashboardStats()
    {
        $produkModel = new ProdukModel();
        $rekananModel = new RekananModel();
        $pemesananModel = new \App\Models\PemesananModel();
        $invoiceModel = new \App\Models\InvoiceModel();

        $stats = [
            'total_produk' => $produkModel->countAllResults(),
            'total_rekanan' => $rekananModel->countAllResults(),
            'total_pemesanan' => $pemesananModel->countAllResults(),
            'total_invoice' => $invoiceModel->countAllResults(),
            'pending_orders' => $pemesananModel->countAllResults()
        ];

        return $this->respond($stats);
    }
}
