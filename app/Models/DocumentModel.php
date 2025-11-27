<?php

namespace App\Models;

use CodeIgniter\Model;

class DocumentModel extends Model
{
    protected $table            = 'documents';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'school_id', 'category_id', 'title', 'slug', 
        'description', 'external_url', 'file_type', 
        'is_public', 'created_by'
    ];
    protected $useTimestamps    = true;

    // Ambil dokumen lengkap dengan nama kategorinya
    public function getDocumentsWithCategory($schoolId = null)
    {
        $builder = $this->select('documents.*, document_categories.name as category_name')
                        ->join('document_categories', 'document_categories.id = documents.category_id')
                        ->where('documents.is_public', 1);

        if ($schoolId) {
            $builder->where('documents.school_id', $schoolId);
        } else {
            $builder->where('documents.school_id', null);
        }

        return $builder->orderBy('created_at', 'DESC')->findAll();
    }
}