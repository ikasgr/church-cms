<?php

namespace App\Models;

use CodeIgniter\Model;

class FeedbackModel extends Model
{
    protected $table            = 'feedback';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'name',
        'email',
        'phone',
        'subject',
        'message',
        'type',
        'status',
        'response',
        'responded_by',
        'responded_at'
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
        'name'    => 'required|min_length[3]|max_length[255]',
        'email'   => 'permit_empty|valid_email',
        'subject' => 'required|min_length[3]|max_length[255]',
        'message' => 'required',
        'type'    => 'required|in_list[masukan,saran,keluhan,lainnya]',
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

    public function getByStatus($status)
    {
        return $this->where('status', $status)->orderBy('created_at', 'DESC')->findAll();
    }

    public function markAsRead($id)
    {
        return $this->update($id, ['status' => 'read']);
    }

    public function respond($id, $response, $userId)
    {
        return $this->update($id, [
            'response' => $response,
            'responded_by' => $userId,
            'responded_at' => date('Y-m-d H:i:s'),
            'status' => 'responded'
        ]);
    }
}
