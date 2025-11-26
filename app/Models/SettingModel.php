<?php

namespace App\Models;

use CodeIgniter\Model;

class SettingModel extends Model
{
    protected $table            = 'settings';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['school_id','setting_key', 'setting_value', 'setting_group'];

    public function getSettings($schoolId = null)
    {   
        $builder = $this->where('school_id', $schoolId);
        $settings = $builder->findAll();
        $data = [];
        foreach ($settings as $row) {
            $data[$row['setting_key']] = $row['setting_value'];
        }
        return $data;
    }
    public function getSiteSettings($schoolId = null)
    {
        return $this->getSettings($schoolId);
    }
}