<?php

namespace App\Models;

use CodeIgniter\Model;

class PageModel extends Model
{
    protected $table            = 'pages';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['school_id', 'menu_title', 'title', 'slug', 'content', 'is_active', 'is_featured'];
    protected $useTimestamps    = true;
    public function getPagesGrouped($schoolId = null)
    {
        // Ambil semua halaman aktif milik sekolah tersebut
        $pages = $this->where('is_active', 1)
            ->where('school_id', $schoolId)
            ->orderBy('menu_title', 'ASC') // Urutkan biar rapi
            ->orderBy('title', 'ASC')
            ->findAll();

        // Kelompokkan berdasarkan menu_title
        $grouped = [];
        foreach ($pages as $page) {
            // Gunakan menu_title sebagai Key array
            $menuName = $page['menu_title'] ?: 'Informasi'; // Fallback jika kosong
            $grouped[$menuName][] = $page;
        }

        return $grouped;
    }
    // Ambil halaman aktif untuk menu
    public function getActivePages($schoolId = null)
    {
        // Filter hanya yang statusnya aktif
        $builder = $this->where('is_active', 1);

        // Filter Pemilik Halaman
        if ($schoolId === null) {
            // Jika untuk Web Pusat -> Ambil yang school_id-nya NULL
            $builder->where('school_id', null);
        } else {
            // Jika untuk Web Sekolah -> Ambil yang school_id-nya sesuai ID Sekolah
            $builder->where('school_id', $schoolId);
        }

        // Urutkan (opsional, bisa ditambah kolom order_position nanti)
        return $builder->orderBy('title', 'ASC')->findAll();
    }
    // AMBIL DAFTAR NAMA MENU YANG SUDAH ADA (Untuk Suggestion di Admin)
    public function getExistingMenus($schoolId = null)
    {
        // Select DISTINCT agar nama menu tidak kembar
        $builder = $this->select('pages.menu_title, pages.school_id, schools.name as school_name')
            ->join('schools', 'schools.id = pages.school_id', 'left')
            ->where('pages.menu_title IS NOT NULL')
            ->where('pages.menu_title !=', '') // Jangan ambil yang kosong
            ->groupBy('pages.menu_title, pages.school_id') // Group agar tidak duplikat
            ->orderBy('pages.menu_title', 'ASC');

        // ✅ Filter berdasarkan role
        if ($schoolId !== null) {
            // Admin Sekolah: Filter hanya menunya sendiri
            $builder->where('pages.school_id', $schoolId);
        }

        return $builder->findAll();
    }
}
