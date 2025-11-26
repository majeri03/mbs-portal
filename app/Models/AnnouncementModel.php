<?php

namespace App\Models;

use CodeIgniter\Model;

class AnnouncementModel extends Model
{
    protected $table            = 'announcements';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    
    protected $allowedFields    = [
        'school_id',
        'title',
        'content',
        'category',
        'start_date',
        'end_date',
        'is_active',
        'priority',
        'icon',
        'created_by'
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Ambil pengumuman aktif untuk landing page
     * (Hanya yang aktif, belum expired, dan dalam rentang tanggal)
     */
    public function getActiveAnnouncements()
    {
        $today = date('Y-m-d');
        
        return $this->where('is_active', 1)
                    ->where('start_date <=', $today)
                    ->where('end_date >=', $today)
                    ->orderBy('priority', 'ASC')
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }
    
    /**
     * Cek apakah pengumuman sudah expired
     */
    public function isExpired($endDate)
    {
        return strtotime($endDate) < strtotime(date('Y-m-d'));
    }
    
    /**
     * Auto-nonaktifkan pengumuman yang sudah expired
     * (Bisa dipanggil via cron job atau setiap load landing page)
     */
    public function autoDisableExpired()
    {
        $today = date('Y-m-d');
        
        return $this->where('end_date <', $today)
                    ->where('is_active', 1)
                    ->set(['is_active' => 0])
                    ->update();
    }
    
    /**
     * Get badge color by category
     */
    public function getBadgeColor($category)
    {
        return match($category) {
            'urgent'    => 'bg-danger',
            'important' => 'bg-warning',
            'normal'    => 'bg-info',
            default     => 'bg-secondary'
        };
    }
    
    /**
     * Get category label
     */
    public function getCategoryLabel($category)
    {
        return match($category) {
            'urgent'    => 'Mendesak',
            'important' => 'Penting',
            'normal'    => 'Biasa',
            default     => 'Lainnya'
        };
    }
}