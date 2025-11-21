<?php

namespace App\Models;

use CodeIgniter\Model;

class EventModel extends Model
{
    protected $table = 'events';
    protected $primaryKey = 'id';
    protected $allowedFields = ['school_id', 'title', 'slug', 'event_date', 'time_start', 'location', 'description'];

    // Ambil agenda yang belum lewat tanggalnya
    public function getUpcomingEvents($limit = 4)
    {
        return $this->where('event_date >=', date('Y-m-d'))
                    ->orderBy('event_date', 'ASC')
                    ->findAll($limit);
    }
}