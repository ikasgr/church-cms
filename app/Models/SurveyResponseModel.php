<?php

namespace App\Models;

use CodeIgniter\Model;

class SurveyResponseModel extends Model
{
    protected $table            = 'survey_responses';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'survey_id',
        'question_id',
        'respondent_name',
        'respondent_email',
        'answer',
        'ip_address'
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
    protected $deletedField  = null;

    // Validation
    protected $validationRules      = [
        'survey_id'   => 'required|integer',
        'question_id' => 'required|integer',
        'answer'      => 'required',
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

    public function getResponsesBySurvey($surveyId)
    {
        return $this->where('survey_id', $surveyId)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }

    public function getAnswerStatistics($questionId)
    {
        return $this->select('answer, COUNT(*) as count')
                    ->where('question_id', $questionId)
                    ->groupBy('answer')
                    ->findAll();
    }
}
