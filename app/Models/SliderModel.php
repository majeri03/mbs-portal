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
    public function getActiveSliders($schoolId = null)
    {
        $query = $this->where('is_active', 1);
        
        // Jika ada schoolId, ambil slider pusat (NULL) atau slider sekolah tertentu
        if ($schoolId) {
            $query->groupStart()
                    ->where('school_id', null)
                    ->orWhere('school_id', $schoolId)
                ->groupEnd();
        }
        
        return $query->orderBy('order_position', 'ASC')
                     ->findAll();
    }
}