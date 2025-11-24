<?php
namespace Modules\Mts\Controllers;

use App\Controllers\BaseController;
use App\Models\{SchoolModel, PageModel};

class BaseMtsController extends BaseController
{
    protected $schoolId = 1; // ID MTs
    protected $data = []; // Variabel penampung data untuk View

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        
        // 1. Ambil Identitas Sekolah (Otomatis untuk semua halaman MTs)
        $schoolModel = new SchoolModel();
        $this->data['school'] = $schoolModel->find($this->schoolId);

        // 2. Ambil Daftar Halaman untuk Navbar (Profil -> Visi Misi, Sejarah, dll)
        $pageModel = new PageModel();
        $this->data['school_pages'] = $pageModel->where('school_id', $this->schoolId)
                                                ->where('is_active', 1)
                                                ->findAll();
        
        // 3. Set Warna Tema Default
        $this->data['theme_color'] = 'success'; 
    }
}