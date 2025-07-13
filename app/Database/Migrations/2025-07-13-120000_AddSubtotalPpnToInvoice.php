<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddSubtotalPpnToInvoice extends Migration
{
    public function up()
    {
        // Tambah kolom baru
        $fields = [
            'subtotal' => [
                'type' => 'DECIMAL',
                'constraint' => '15,2',
                'null' => false,
                'default' => 0,
                'after' => 'ppn'
            ],
            'ppn_amount' => [
                'type' => 'DECIMAL',
                'constraint' => '15,2',
                'null' => false,
                'default' => 0,
                'after' => 'subtotal'
            ],
            'harga_satuan' => [
                'type' => 'DECIMAL',
                'constraint' => '15,2',
                'null' => false,
                'default' => 0,
                'after' => 'ppn_amount'
            ]
        ];
        
        $this->forge->addColumn('tbl_mengelola_invoice', $fields);
        
        // Update data existing - hitung mundur dari total_harga
        $db = \Config\Database::connect();
        
        // Ambil semua invoice yang ada
        $invoices = $db->table('tbl_mengelola_invoice')->get()->getResultArray();
        
        foreach ($invoices as $invoice) {
            $total_harga = $invoice['total_harga'];
            $ppn_percent = $invoice['ppn'] / 100;
            
            // Hitung mundur: total = subtotal + (subtotal * ppn)
            // total = subtotal * (1 + ppn)
            // subtotal = total / (1 + ppn)
            $subtotal = $total_harga / (1 + $ppn_percent);
            $ppn_amount = $subtotal * $ppn_percent;
            
            // Estimate harga satuan dari order_btg jika ada
            $harga_satuan = 0;
            if ($invoice['order_btg'] > 0) {
                $harga_satuan = $subtotal / $invoice['order_btg'];
            }
            
            // Update record
            $db->table('tbl_mengelola_invoice')
                ->where('no_invoice', $invoice['no_invoice'])
                ->update([
                    'subtotal' => round($subtotal, 2),
                    'ppn_amount' => round($ppn_amount, 2),
                    'harga_satuan' => round($harga_satuan, 2)
                ]);
        }
    }

    public function down()
    {
        $this->forge->dropColumn('tbl_mengelola_invoice', ['subtotal', 'ppn_amount', 'harga_satuan']);
    }
}
