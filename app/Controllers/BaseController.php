<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Models\AnnouncementModel;
/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var list<string>
     */
    protected $helpers = [];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        $uri = service('uri');
        if ($uri->getSegment(1) !== 'admin') {
            
            $annoModel = new AnnouncementModel();
            $today = date('Y-m-d');

            // QUERY PENTING: Hanya ambil pengumuman milik PUSAT
            $portal_announcements = $annoModel
                ->where('school_id', null)       // <--- KUNCI FILTER: HANYA PUSAT (NULL)
                ->where('is_active', 1)          // Hanya yang statusnya Aktif
                ->where('start_date <=', $today) // Sudah masuk tanggal tayang
                ->where('end_date >=', $today)   // Belum kadaluarsa
                ->orderBy('priority', 'ASC')     // Urutkan prioritas (Angka kecil duluan)
                ->findAll();
                
            // BAGIKAN DATA KE SEMUA VIEW SECARA OTOMATIS
            // Ini membuat variabel $portal_announcements bisa dipakai di file template.php
            \Config\Services::renderer()->setData(['portal_announcements' => $portal_announcements], 'raw');
        }
    }
}
