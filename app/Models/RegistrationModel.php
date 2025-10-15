<?php

namespace App\Models;

use CodeIgniter\Model;

class RegistrationModel extends Model
{
    protected $table            = 'registrations';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'type',
        'full_name',
        'birth_place',
        'birth_date',
        'gender',
        'address',
        'phone',
        'email',
        'parent_name',
        'parent_phone',
        'baptism_place',
        'baptism_date',
        'partner_name',
        'partner_birth_place',
        'partner_birth_date',
        'partner_address',
        'partner_phone',
        'preferred_date',
        'notes',
        'status',
        'processed_by',
        'processed_at',
        'admin_notes',
        'document_path'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'type'       => 'required|in_list[baptis,sidi,nikah]',
        'full_name'  => 'required|min_length[3]|max_length[255]',
        'birth_date' => 'required|valid_date',
        'gender'     => 'required|in_list[L,P]',
        'phone'      => 'required',
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function getByType($type)
    {
        return $this->where('type', $type)->orderBy('created_at', 'DESC')->findAll();
    }

    public function getByStatus($status)
    {
        return $this->where('status', $status)->orderBy('created_at', 'DESC')->findAll();
    }

    public function approve($id, $userId, $notes = '')
    {
        return $this->update($id, [
            'status' => 'approved',
            'processed_by' => $userId,
            'processed_at' => date('Y-m-d H:i:s'),
            'admin_notes' => $notes
        ]);
    }

    public function reject($id, $userId, $notes = '')
    {
        return $this->update($id, [
            'status' => 'rejected',
            'processed_by' => $userId,
            'processed_at' => date('Y-m-d H:i:s'),
            'admin_notes' => $notes
        ]);
    }
}
