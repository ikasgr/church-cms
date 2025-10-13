<?php

namespace App\Models;

use CodeIgniter\Model;

class IbadahModel extends Model
{
    protected $table            = 'ibadah';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'title',
        'type',
        'date',
        'time_start',
        'time_end',
        'location',
        'theme',
        'preacher',
        'liturgist',
        'description',
        'is_published'
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules = [
        'title'      => 'required|min_length[3]|max_length[255]',
        'type'       => 'required|in_list[mingguan,khusus]',
        'date'       => 'required|valid_date',
        'time_start' => 'required',
    ];

    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function getUpcomingIbadah($limit = 5)
    {
        return $this->where('date >=', date('Y-m-d'))
                    ->where('is_published', 1)
                    ->orderBy('date', 'ASC')
                    ->orderBy('time_start', 'ASC')
                    ->limit($limit)
                    ->findAll();
    }

    public function getIbadahByMonth($year, $month)
    {
        return $this->where('YEAR(date)', $year)
                    ->where('MONTH(date)', $month)
                    ->where('is_published', 1)
                    ->orderBy('date', 'ASC')
                    ->findAll();
    }
}
