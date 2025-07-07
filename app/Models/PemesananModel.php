<?php

namespace App\Models;

use CodeIgniter\Model;

class PemesananModel extends Model
{
    protected $table = 'tbl_mengelola_pemesanan';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'id_so',
        'tgl_so',
        'no_po',
        'nama_rek',
        'nama_jenis_produk',
        'order_btg',
        'total_harga'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [
        'harga_satuan' => 'float',
        'total_harga' => 'float',
        'order_btg' => 'integer',
        'rekanan_id' => 'integer',
        'produk_id' => 'integer',
        'created_by' => 'integer'
    ];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    // Validation
    protected $validationRules = [
        'no_so' => 'required|is_unique[tbl_mengelola_pemesanan.no_so,id,{id}]',
        'tanggal_so' => 'required|valid_date',
        'rekanan_id' => 'required|integer',
        'produk_id' => 'required|integer',
        'order_btg' => 'required|integer|greater_than[0]',
        'harga_satuan' => 'required|decimal|greater_than[0]'
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
