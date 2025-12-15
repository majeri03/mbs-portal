<?php

namespace App\Models;

use CodeIgniter\Model;

class SliderModel extends Model
{
    protected $table            = 'sliders';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['school_id', 'badge_text','title', 'description', 'image_url', 'button_text', 'button_link', 'order_position', 'is_active'];
    protected $useTimestamps    = true;

    // Ambil slider aktif untuk landing page (urut berdasarkan order_position)
    public function getActiveSliders($schoolId = null)
    {
        $query = $this->where('is_active', 1);
        
        // ✅ FIX: Jika schoolId === null (Portal Pusat), ambil HANYA slider pusat
        if ($schoolId === null) {
            $query->where('school_id', null);
        } 
        // ✅ Jika ada schoolId (MTs/MA/SMK), ambil slider sekolah tersebut
        else {
            $query->where('school_id', $schoolId);
        }
        
        return $query->orderBy('order_position', 'ASC')->findAll();
    }
}