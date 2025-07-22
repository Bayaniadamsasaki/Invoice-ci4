<?php

namespace App\Models;

use CodeIgniter\Model;

class RekananModel extends Model
{
    protected $table = 'tbl_input_data_rekanan';
    protected $primaryKey = 'id_rek';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'nama_rek',
        'alamat',
        'npwp'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    // Validation
    protected $validationRules = [
        'nama_rek' => 'required|min_length[3]|max_length[255]',
        'alamat' => 'required|min_length[5]|max_length[500]',
        'npwp' => 'permit_empty|min_length[15]|max_length[20]'
    ];
    protected $validationMessages = [
        'nama_rek' => [
            'required' => 'Nama rekanan harus diisi',
            'min_length' => 'Nama rekanan minimal 3 karakter',
            'max_length' => 'Nama rekanan maksimal 255 karakter'
        ],
        'alamat' => [
            'required' => 'Alamat harus diisi',
            'min_length' => 'Alamat minimal 5 karakter',
            'max_length' => 'Alamat maksimal 500 karakter'
        ],
        'npwp' => [
            'min_length' => 'Format NPWP tidak valid (minimal 15 karakter)',
            'max_length' => 'Format NPWP tidak valid (maksimal 20 karakter)'
        ]
    ];
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
