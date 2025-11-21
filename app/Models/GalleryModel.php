<?php

namespace App\Models;

use CodeIgniter\Model;

class GalleryModel extends Model
{
    protected $table            = 'galleries';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['school_id', 'title', 'image_url', 'category'];
    protected $useTimestamps    = true; // Pastikan ini true jika di migration ada created_at

    // Ambil foto terbaru, bisa difilter per sekolah nanti
    public function getLatestPhotos($limit = 8)
    {
        return $this->orderBy('created_at', 'DESC')
                    ->findAll($limit);
    }
}