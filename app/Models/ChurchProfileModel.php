<?php

namespace App\Models;

use CodeIgniter\Model;

class ChurchProfileModel extends Model
{
    protected $table            = 'church_profile';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'church_name',
        'tagline',
        'logo',
        'address',
        'phone',
        'email',
        'website',
        'history',
        'vision',
        'mission',
        'organizational_structure',
        'social_facebook',
        'social_instagram',
        'social_youtube',
        'social_twitter'
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'church_name' => 'required|min_length[3]|max_length[255]',
        'email'       => 'permit_empty|valid_email',
    ];

    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function getProfile()
    {
        return $this->first();
    }
}
