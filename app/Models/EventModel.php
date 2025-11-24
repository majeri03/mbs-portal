<?php

namespace App\Models;

use CodeIgniter\Model;

class EventModel extends Model
{
    protected $table = 'events';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    
    // PASTIKAN nama kolom sesuai dengan tabel database
    protected $allowedFields = [
        'school_id',
        'title',
        'slug',
        'event_date',
        'time_start',
        'time_end',
        'location',
        'description'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    // Validation
    protected $validationRules = [
        'title' => 'required|min_length[3]|max_length[255]',
        'slug' => 'required|is_unique[events.slug,id,{id}]',
        'event_date' => 'required|valid_date'
    ];

    protected $validationMessages = [
        'title' => [
            'required' => 'Judul agenda harus diisi',
            'min_length' => 'Judul minimal 3 karakter',
            'max_length' => 'Judul maksimal 255 karakter'
        ],
        'slug' => [
            'required' => 'Slug harus diisi',
            'is_unique' => 'Slug sudah digunakan'
        ],
        'event_date' => [
            'required' => 'Tanggal agenda harus diisi',
            'valid_date' => 'Format tanggal tidak valid'
        ]
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = [];
    protected $afterInsert = [];
    protected $beforeUpdate = [];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = [];
    protected $afterDelete = [];

    /**
     * Get upcoming events
     */
    public function getUpcomingEvents($limit = 5)
    {
        return $this->where('event_date >=', date('Y-m-d'))
                    ->orderBy('event_date', 'ASC')
                    ->limit($limit)
                    ->findAll();
    }

    /**
     * Get events by date range
     */
    public function getEventsByDateRange($startDate, $endDate)
    {
        return $this->where('event_date >=', $startDate)
                    ->where('event_date <=', $endDate)
                    ->orderBy('event_date', 'ASC')
                    ->findAll();
    }

    /**
     * Get events by month
     */
    public function getEventsByMonth($year, $month)
    {
        return $this->where('YEAR(event_date)', $year)
                    ->where('MONTH(event_date)', $month)
                    ->orderBy('event_date', 'ASC')
                    ->findAll();
    }

    /**
     * Get event by slug
     */
    public function getBySlug($slug)
    {
        return $this->where('slug', $slug)->first();
    }

    /**
     * Search events
     */
    public function searchEvents($keyword)
    {
        return $this->like('title', $keyword)
                    ->orLike('description', $keyword)
                    ->orLike('location', $keyword)
                    ->orderBy('event_date', 'DESC')
                    ->findAll();
    }

    /**
     * Ambil Agenda Berdasarkan Konteks Sekolah
     * * @param int|null $schoolId ID Sekolah (1=MTs, 2=MA, dll). NULL = Web Utama.
     * @param int $limit Jumlah data
     */
    public function getEventsByContext($schoolId = null, $limit = 5)
    {
        $builder = $this->where('event_date >=', date('Y-m-d'));

        if ($schoolId === null) {
            // WEB UTAMA: Tampilkan SEMUA agenda (Umum + Sekolah)
            // Tidak ada filter school_id, jadi semua muncul.
        } else {
            // WEB SEKOLAH: Tampilkan agenda Sekolah Tersebut ATAU Agenda Umum (NULL)
            $builder->groupStart()
                    ->where('school_id', $schoolId)
                    ->orWhere('school_id', null)
                    ->groupEnd();
        }

        return $builder->orderBy('event_date', 'ASC')
                       ->limit($limit)
                       ->findAll();
    }
}