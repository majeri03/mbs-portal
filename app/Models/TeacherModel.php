<?php

namespace App\Models;

use CodeIgniter\Model;

class TeacherModel extends Model
{
    protected $table = 'teachers';
    protected $primaryKey = 'id';
    protected $allowedFields = ['school_id','name', 'position', 'photo', 'is_leader', 'order_position'];

    public function getLeaders()
    {
        return $this->where('is_leader', 1)
                    ->where('school_id', null)
                    ->orderBy('order_position', 'ASC')
                    ->findAll();
    }
}