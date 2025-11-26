<?php

namespace App\Models;

use CodeIgniter\Model;

class PageModel extends Model
{
    protected $table            = 'pages';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['school_id','title', 'slug', 'content', 'is_active', 'is_featured'];
    protected $useTimestamps    = true;

    // Ambil halaman aktif untuk menu
    public function getActivePages()
    {
        return $this->where('is_active', 1)
                    ->where('school_id', null) // Hanya ambil yang umum (Pusat)
                    ->findAll();
    }
}