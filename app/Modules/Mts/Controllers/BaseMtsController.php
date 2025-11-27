<?php
namespace Modules\Mts\Controllers;

use App\Controllers\BaseController;
use App\Models\{SchoolModel, PageModel, SettingModel};

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
        $this->data['school_pages_grouped'] = $pageModel->getPagesGrouped($this->schoolId);

        // 4. Ambil Kategori Dokumen untuk Navbar (NEW)
        $docCategoryModel = new \App\Models\DocumentCategoryModel();
        // Ambil kategori milik MTs (ID 1) ATAU kategori Umum (NULL)
        $this->data['nav_doc_categories'] = $docCategoryModel->groupStart()
                                                             ->where('school_id', $this->schoolId)
                                                             ->orWhere('school_id', null)
                                                             ->groupEnd()
                                                             ->findAll();
        $settingModel = new SettingModel();
        // 3. Setting Sekolah dengan Konsep FALLBACK (Warisan Pusat)
        $settingModel = new SettingModel();
        
        // A. Ambil Settingan PUSAT (Default)
        $centerSettings = $settingModel->getSettings(null);
        
        // B. Ambil Settingan SEKOLAH (MTs)
        $schoolSettings = $settingModel->getSettings($this->schoolId);
        
        // C. GABUNGKAN (Merge)
        // Mulai dengan data Pusat sebagai dasar
        $finalSettings = $centerSettings;

        // Timpa dengan data Sekolah JIKA data sekolah ada isinya
        foreach ($schoolSettings as $key => $value) {
            if (!empty($value)) {
                $finalSettings[$key] = $value;
            }
        }

        // Masukkan ke data view
        $this->data['school_site'] = $finalSettings;
        // 3. Set Warna Tema Default
        $this->data['theme_color'] = 'success'; 
    }
}