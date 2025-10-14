<?php

namespace App\Models;

use CodeIgniter\Model;

class SettingModel extends Model
{
    protected $table            = 'settings';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'key',
        'value',
        'type',
        'group',
        'description'
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
        'key'   => 'required|is_unique[settings.key,id,{id}]',
        'value' => 'required',
        'type'  => 'required|in_list[text,textarea,number,boolean,json]',
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

    public function getSetting($key, $default = null)
    {
        $setting = $this->where('key', $key)->first();
        
        if (!$setting) {
            return $default;
        }
        
        // Cast value based on type
        switch ($setting['type']) {
            case 'boolean':
                return (bool) $setting['value'];
            case 'number':
                return (int) $setting['value'];
            case 'json':
                return json_decode($setting['value'], true);
            default:
                return $setting['value'];
        }
    }

    public function setSetting($key, $value, $type = 'text', $group = 'general')
    {
        $existing = $this->where('key', $key)->first();
        
        // Convert value based on type
        if ($type === 'json') {
            $value = json_encode($value);
        } elseif ($type === 'boolean') {
            $value = $value ? '1' : '0';
        }
        
        $data = [
            'key' => $key,
            'value' => $value,
            'type' => $type,
            'group' => $group
        ];
        
        if ($existing) {
            return $this->update($existing['id'], $data);
        } else {
            return $this->insert($data);
        }
    }

    public function getByGroup($group)
    {
        $settings = $this->where('group', $group)->findAll();
        $result = [];
        
        foreach ($settings as $setting) {
            $result[$setting['key']] = $this->getSetting($setting['key']);
        }
        
        return $result;
    }

    public function getAllSettings()
    {
        $settings = $this->findAll();
        $result = [];
        
        foreach ($settings as $setting) {
            $result[$setting['key']] = $this->getSetting($setting['key']);
        }
        
        return $result;
    }
}
