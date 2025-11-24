<?php

namespace App\Models;

use CodeIgniter\Model;

class SliderModel extends Model
{
    protected $table            = 'sliders';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['school_id','title', 'description', 'image_url', 'button_text', 'button_link', 'order_position', 'is_active'];
    protected $useTimestamps    = true;

    // Ambil slider aktif untuk landing page (urut berdasarkan order_position)
    public function getActiveSliders()
    {
        return $this->where('is_active', 1)
                    ->orderBy('order_position', 'ASC')
                    ->findAll();
    }
}