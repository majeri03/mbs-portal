<?php

namespace App\Models;

use CodeIgniter\Model;

class AnnouncementModel extends Model
{
    protected $table            = 'announcements';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['content', 'link_url', 'is_active', 'start_date', 'end_date'];

    public function getActiveAnnouncements()
    {
        $today = date('Y-m-d');
        
        return $this->where('is_active', 1)
                    ->groupStart() // Kurung buka untuk logika OR tanggal
                        ->where('end_date >=', $today) // Tanggal selesai belum lewat
                        ->orWhere('end_date', null)    // ATAU tidak ada batas waktu
                    ->groupEnd()
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }
}