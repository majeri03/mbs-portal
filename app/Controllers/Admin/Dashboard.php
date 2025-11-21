<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PostModel;
use App\Models\SchoolModel;
use App\Models\EventModel;
use App\Models\UserModel;

class Dashboard extends BaseController
{
    protected $postModel;
    protected $schoolModel;
    protected $eventModel;
    protected $userModel;

    public function __construct()
    {
        $this->postModel = new PostModel();
        $this->schoolModel = new SchoolModel();
        $this->eventModel = new EventModel();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        // Statistik untuk Card Dashboard
        $data['stats'] = [
            'total_posts'   => $this->postModel->countAll(),
            'total_schools' => $this->schoolModel->countAll(),
            'total_events'  => $this->eventModel->countAll(),
            'total_users'   => $this->userModel->countAll(),
        ];

        // Data Berita Terbaru (untuk tabel preview)
        $data['latest_posts'] = $this->postModel->orderBy('created_at', 'DESC')->findAll(5);

        // Data User Login
        $data['user'] = [
            'username'  => session()->get('username'),
            'full_name' => session()->get('full_name'),
            'role'      => session()->get('role'),
        ];

        $data['title'] = 'Dashboard Admin - MBS Portal';
        
        return view('admin/dashboard/index', $data);
    }
}