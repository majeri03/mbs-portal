<?php

namespace App\Models;

use CodeIgniter\Model;

class CurriculumModel extends Model
{
    protected $table            = 'curriculums';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['school_id', 'title', 'file_url', 'description'];
    protected $useTimestamps    = true;
}