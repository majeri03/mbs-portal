<?php

namespace App\Models;

use CodeIgniter\Model;

class DocumentCategoryModel extends Model
{
    protected $table            = 'document_categories';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['school_id', 'name', 'slug'];
    protected $useTimestamps    = true;

    // Ambil kategori berdasarkan sekolah (atau umum)
    public function getCategories($schoolId = null)
    {
        return $this->where('school_id', $schoolId)->findAll();
    }
}