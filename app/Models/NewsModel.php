<?php

namespace App\Models;

use CodeIgniter\Model;

class NewsModel extends Model
{
    protected $table            = 'news';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'title',
        'slug',
        'category',
        'content',
        'excerpt',
        'featured_image',
        'author_id',
        'is_published',
        'published_at',
        'views',
        'meta_keywords',
        'meta_description'
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
        'title'    => 'required|min_length[3]|max_length[255]',
        'slug'     => 'required|is_unique[news.slug,id,{id}]',
        'category' => 'required|in_list[artikel,pengumuman,renungan,agenda]',
        'content'  => 'required',
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['generateSlug'];
    protected $afterInsert    = [];
    protected $beforeUpdate   = ['generateSlug'];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    protected function generateSlug(array $data)
    {
        if (isset($data['data']['title']) && !isset($data['data']['slug'])) {
            $data['data']['slug'] = url_title($data['data']['title'], '-', true);
        }
        return $data;
    }

    public function getPublished($limit = null)
    {
        $builder = $this->where('is_published', 1)
                        ->where('published_at <=', date('Y-m-d H:i:s'))
                        ->orderBy('published_at', 'DESC');
        
        if ($limit) {
            $builder->limit($limit);
        }
        
        return $builder->findAll();
    }

    public function getByCategory($category, $limit = null)
    {
        $builder = $this->where('category', $category)
                        ->where('is_published', 1)
                        ->where('published_at <=', date('Y-m-d H:i:s'))
                        ->orderBy('published_at', 'DESC');
        
        if ($limit) {
            $builder->limit($limit);
        }
        
        return $builder->findAll();
    }

    public function getBySlug($slug)
    {
        return $this->where('slug', $slug)->first();
    }

    public function incrementViews($id)
    {
        $this->set('views', 'views+1', false)->where('id', $id)->update();
    }

    public function getPopular($limit = 5)
    {
        return $this->where('is_published', 1)
                    ->orderBy('views', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }
}
