<?php

namespace App\Models;

use CodeIgniter\Model;

class SettingModel extends Model
{
    protected $table            = 'settings';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['setting_key', 'setting_value', 'setting_group'];

    public function getSiteSettings()
    {
        $settings = $this->findAll();
        $data = [];
        foreach ($settings as $row) {
            $data[$row['setting_key']] = $row['setting_value'];
        }
        return $data;
    }
}