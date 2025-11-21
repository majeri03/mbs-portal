<?php

namespace App\Models;

use CodeIgniter\Model;

class PostModel extends Model
{
    protected $table = 'posts';
    protected $primaryKey = 'id';
    protected $allowedFields = ['school_id', 'title', 'slug', 'author','content', 'thumbnail', 'is_published', 'views'];
    protected $useTimestamps = true;

    // Ambil berita terbaru + Nama Sekolahnya (Join)
    public function getLatestNews($limit = 6)
    {
        return $this->select('posts.*, schools.name as school_name, schools.slug as school_slug')
                    ->join('schools', 'schools.id = posts.school_id', 'left') // Left join agar berita umum (school_id null) tetap muncul
                    ->where('is_published', 1)
                    ->orderBy('posts.created_at', 'DESC')
                    ->findAll($limit);
    }
}