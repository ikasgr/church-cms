<?php

namespace App\Models;

use CodeIgniter\Model;

class SurveyModel extends Model
{
    protected $table            = 'surveys';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'title',
        'description',
        'type',
        'start_date',
        'end_date',
        'is_active',
        'is_anonymous',
        'max_responses',
        'created_by'
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
        'title'      => 'required|min_length[3]|max_length[255]',
        'type'       => 'required|in_list[survey,poll]',
        'start_date' => 'required|valid_date',
        'end_date'   => 'required|valid_date',
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

    public function getActive()
    {
        return $this->where('is_active', 1)
                    ->where('start_date <=', date('Y-m-d'))
                    ->where('end_date >=', date('Y-m-d'))
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }

    public function getWithQuestions($id)
    {
        $survey = $this->find($id);
        if ($survey) {
            $questionModel = new SurveyQuestionModel();
            $survey['questions'] = $questionModel->where('survey_id', $id)
                                                 ->orderBy('order_position', 'ASC')
                                                 ->findAll();
        }
        return $survey;
    }

    public function getResponseCount($id)
    {
        $responseModel = new SurveyResponseModel();
        return $responseModel->where('survey_id', $id)->countAllResults();
    }
}
