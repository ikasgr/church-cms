<?php

namespace App\Models;

use CodeIgniter\Model;

class FamilyModel extends Model
{
    protected $table            = 'family';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'family_code',
        'family_name',
        'head_of_family',
        'address',
        'wilayah',
        'phone',
        'notes'
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules = [
        'family_code'    => 'required|is_unique[family.family_code,id,{id}]',
        'family_name'    => 'required|min_length[3]|max_length[255]',
        'head_of_family' => 'required|max_length[255]',
    ];

    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function getFamilyWithMembers($id)
    {
        $family = $this->find($id);
        if ($family) {
            $jemaatModel = new JemaatModel();
            $family['members'] = $jemaatModel->where('family_id', $id)->findAll();
        }
        return $family;
    }

    public function generateFamilyCode()
    {
        $lastFamily = $this->orderBy('id', 'DESC')->first();
        $lastNumber = $lastFamily ? intval(substr($lastFamily['family_code'], 3)) : 0;
        $newNumber = $lastNumber + 1;
        return 'KK-' . str_pad($newNumber, 5, '0', STR_PAD_LEFT);
    }
}
