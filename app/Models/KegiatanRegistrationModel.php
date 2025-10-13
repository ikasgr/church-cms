<?php

namespace App\Models;

use CodeIgniter\Model;

class KegiatanRegistrationModel extends Model
{
    protected $table            = 'kegiatan_registration';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'kegiatan_id',
        'jemaat_id',
        'name',
        'phone',
        'email',
        'notes',
        'status',
        'attended'
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'kegiatan_id' => 'required|integer',
        'name'        => 'required|min_length[3]|max_length[255]',
        'phone'       => 'required|max_length[50]',
        'email'       => 'permit_empty|valid_email',
    ];

    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function getRegistrationWithKegiatan($id)
    {
        return $this->select('kegiatan_registration.*, kegiatan.title as kegiatan_title, kegiatan.date_start')
                    ->join('kegiatan', 'kegiatan.id = kegiatan_registration.kegiatan_id')
                    ->where('kegiatan_registration.id', $id)
                    ->first();
    }

    public function getRegistrationsByKegiatan($kegiatanId)
    {
        return $this->where('kegiatan_id', $kegiatanId)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }

    public function getAttendanceStats($kegiatanId)
    {
        return [
            'total'    => $this->where('kegiatan_id', $kegiatanId)->countAllResults(false),
            'approved' => $this->where('kegiatan_id', $kegiatanId)->where('status', 'approved')->countAllResults(false),
            'attended' => $this->where('kegiatan_id', $kegiatanId)->where('attended', 1)->countAllResults(),
        ];
    }
}
