<?php

namespace App\Models;

use CodeIgniter\Model;

class LaporanInvoiceModel extends Model
{
    protected $table = 'tbl_laporan_invoice';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'data_invoice'
    ];

    protected array $casts = [
        'data_invoice' => 'integer'
    ];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';
} 