<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;

class BaseAdminController extends BaseController {
    protected $mySchoolId;

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger) {
        parent::initController($request, $response, $logger);
        
        // Ambil ID Sekolah dari user yang login
        // Jika user adalah Admin MTs, nilainya 1. Jika Superadmin, nilainya NULL.
        $this->mySchoolId = session()->get('school_id'); 
    }

    // Fungsi pembantu untuk filter query otomatis
    protected function filterBySchool($model) {
        if ($this->mySchoolId) {
            // Jika bukan superadmin, paksa hanya lihat data sekolahnya sendiri
            return $model->where('school_id', $this->mySchoolId);
        }
        // Jika superadmin, lihat semua
        return $model;
    }
}