<?php

namespace App\Models;

use CodeIgniter\Model;

class InvoiceModel extends Model
{
    protected $table = 'tbl_mengelola_invoice';
    protected $primaryKey = 'no_invoice';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'no_invoice',
        'tgl_so',
        'nama_rek',
        'alamat',
        'npwp',
        'nama_jenis_produk',
        'order_btg',
        'ppn',
        'total_harga',
        'pemesanan_id',
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [
        'pemesanan_id' => 'integer',
        'ppn' => 'float',
        'total_sebelum_ppn' => 'float',
        'nilai_ppn' => 'float',
        'jumlah_bayar' => 'float',
        'created_by' => 'integer'
    ];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    // Validation
    protected $validationRules = [
        'pemesanan_id' => 'required|integer',
        'ppn' => 'required|decimal|greater_than_equal_to[0]'
    ];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = [];
    protected $afterInsert = [];
    protected $beforeUpdate = [];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = [];
    protected $afterDelete = [];
}
