<?php

namespace App\Models;

use CodeIgniter\Model;

class KegiatanModel extends Model
{
    protected $table            = 'kegiatan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'title',
        'slug',
        'category',
        'description',
        'date_start',
        'date_end',
        'location',
        'organizer',
        'contact_person',
        'contact_phone',
        'image',
        'max_participants',
        'is_registration_open',
        'is_published'
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules = [
        'title'      => 'required|min_length[3]|max_length[255]',
        'slug'       => 'required|is_unique[kegiatan.slug,id,{id}]',
        'date_start' => 'required|valid_date',
    ];

    protected $validationMessages = [];
    protected $skipValidation     = false;
    protected $beforeInsert       = ['generateSlug'];
    protected $beforeUpdate       = ['generateSlug'];

    protected function generateSlug(array $data)
    {
        if (isset($data['data']['title']) && !isset($data['data']['slug'])) {
            $data['data']['slug'] = url_title($data['data']['title'], '-', true);
        }
        return $data;
    }

    public function getUpcomingKegiatan($limit = 10)
    {
        return $this->where('date_start >=', date('Y-m-d H:i:s'))
                    ->where('is_published', 1)
                    ->orderBy('date_start', 'ASC')
                    ->limit($limit)
                    ->findAll();
    }

    public function getKegiatanByCategory($category)
    {
        return $this->where('category', $category)
                    ->where('is_published', 1)
                    ->orderBy('date_start', 'DESC')
                    ->findAll();
    }

    public function getKegiatanWithRegistrationCount($id)
    {
        $kegiatan = $this->find($id);
        if ($kegiatan) {
            $registrationModel = new KegiatanRegistrationModel();
            $kegiatan['registration_count'] = $registrationModel->where('kegiatan_id', $id)->countAllResults();
        }
        return $kegiatan;
    }
}
