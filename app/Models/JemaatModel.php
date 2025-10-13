<?php

namespace App\Models;

use CodeIgniter\Model;

class JemaatModel extends Model
{
    protected $table            = 'jemaat';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'family_id',
        'no_induk',
        'full_name',
        'gender',
        'birth_place',
        'birth_date',
        'address',
        'wilayah',
        'phone',
        'email',
        'photo',
        'baptis_date',
        'baptis_place',
        'sidi_date',
        'sidi_place',
        'marriage_date',
        'marriage_place',
        'spouse_name',
        'status',
        'notes'
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules = [
        'no_induk'  => 'required|is_unique[jemaat.no_induk,id,{id}]',
        'full_name' => 'required|min_length[3]|max_length[255]',
        'gender'    => 'required|in_list[L,P]',
        'email'     => 'permit_empty|valid_email',
    ];

    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function getJemaatWithFamily($id)
    {
        return $this->select('jemaat.*, family.family_name, family.family_code')
                    ->join('family', 'family.id = jemaat.family_id', 'left')
                    ->where('jemaat.id', $id)
                    ->first();
    }

    public function searchJemaat($keyword, $wilayah = null, $status = null)
    {
        $builder = $this->builder();
        
        if ($keyword) {
            $builder->groupStart()
                    ->like('full_name', $keyword)
                    ->orLike('no_induk', $keyword)
                    ->orLike('phone', $keyword)
                    ->orLike('email', $keyword)
                    ->groupEnd();
        }
        
        if ($wilayah) {
            $builder->where('wilayah', $wilayah);
        }
        
        if ($status) {
            $builder->where('status', $status);
        }
        
        return $builder->get()->getResultArray();
    }

    public function getStatistics()
    {
        return [
            'total'     => $this->countAllResults(false),
            'aktif'     => $this->where('status', 'aktif')->countAllResults(false),
            'pria'      => $this->where('gender', 'L')->countAllResults(false),
            'wanita'    => $this->where('gender', 'P')->countAllResults(false),
            'baptis'    => $this->where('baptis_date IS NOT NULL')->countAllResults(false),
            'sidi'      => $this->where('sidi_date IS NOT NULL')->countAllResults(false),
            'menikah'   => $this->where('marriage_date IS NOT NULL')->countAllResults(),
        ];
    }
}
