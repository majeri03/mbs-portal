<?php

namespace App\Models;

use CodeIgniter\Model;

class PageModel extends Model
{
    protected $table            = 'pages';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['title', 'slug', 'content', 'is_active'];
    protected $useTimestamps    = true;

    // Ambil halaman aktif untuk menu
    public function getActivePages()
    {
        return $this->where('is_active', 1)->findAll();
    }
}