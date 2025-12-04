<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// 2. WEB SEKOLAH (Modular)
// Mengarah ke Module masing-masing
// GROUP ROUTE KHUSUS MTS
$routes->group('mts', ['namespace' => 'Modules\Mts\Controllers'], function ($routes) {
    $routes->get('/', 'Home::index');

    // Halaman Statis (Profil, Sejarah, dll)
    $routes->get('halaman/(:segment)', 'Page::show/$1');

    // Berita
    $routes->get('kabar', 'News::index');
    $routes->get('kabar/(:segment)', 'News::show/$1');

    // Agenda
    // Route Agenda
    $routes->get('agenda', 'Events::index');          // Daftar Agenda
    $routes->get('agenda/(:segment)', 'Events::show/$1'); // Detail Agenda

    $routes->get('galeri', 'Gallery::index');

    // Dokumen
    $routes->get('dokumen', 'Documents::index');
    $routes->get('dokumen/(:segment)', 'Documents::show/$1');
    //Informasi
    $routes->get('informasi', 'Page::index');
});

$routes->group('ma', ['namespace' => 'Modules\Ma\Controllers'], function ($routes) {
    $routes->get('/', 'Home::index'); // Diakses via: mbs.sch.id/ma
});

$routes->group('smk', ['namespace' => 'Modules\Smk\Controllers'], function ($routes) {
    $routes->get('/', 'Home::index'); // Diakses via: mbs.sch.id/smk
});

// Route Admin (Grouping biar rapi)
$routes->group('admin', function ($routes) {
    // Route Lupa Password (Bisa diakses tanpa login)
    $routes->get('forgot-password', 'Admin\Auth::forgotPassword');
    $routes->post('forgot-password', 'Admin\Auth::attemptForgot');
    $routes->get('reset-password/(:segment)', 'Admin\Auth::resetPassword/$1');
    $routes->post('reset-password', 'Admin\Auth::attemptReset');
    // Login
    $routes->get('login', 'Admin\Auth::login');
    $routes->post('login/attempt', 'Admin\Auth::attemptLogin');
    $routes->get('logout', 'Admin\Auth::logout');
    // Dashboard (nanti kita buat di Tahap 2)
    $routes->get('dashboard', 'Admin\Dashboard::index', ['filter' => 'auth']);

    // Berita CRUD
    $routes->get('posts', 'Admin\Posts::index');
    $routes->get('posts/create', 'Admin\Posts::create');
    $routes->post('posts/store', 'Admin\Posts::store');
    $routes->get('posts/edit/(:num)', 'Admin\Posts::edit/$1');
    $routes->post('posts/update/(:num)', 'Admin\Posts::update/$1');
    $routes->get('posts/delete/(:num)', 'Admin\Posts::delete/$1');

    // CRUD Sliders
    $routes->get('sliders', 'Admin\Sliders::index');
    $routes->get('sliders/create', 'Admin\Sliders::create');
    $routes->post('sliders/store', 'Admin\Sliders::store');
    $routes->get('sliders/edit/(:num)', 'Admin\Sliders::edit/$1');
    $routes->post('sliders/update/(:num)', 'Admin\Sliders::update/$1');
    $routes->get('sliders/delete/(:num)', 'Admin\Sliders::delete/$1');
    $routes->post('sliders/toggle-status/(:num)', 'Admin\Sliders::toggleStatus/$1');

    // CRUD Schools
    $routes->get('schools', 'Admin\Schools::index');
    $routes->get('schools/create', 'Admin\Schools::create');
    $routes->post('schools/store', 'Admin\Schools::store');
    $routes->get('schools/edit/(:num)', 'Admin\Schools::edit/$1');
    $routes->post('schools/update/(:num)', 'Admin\Schools::update/$1');
    $routes->get('schools/delete/(:num)', 'Admin\Schools::delete/$1');

    // CRUD Announcements
    $routes->get('announcements', 'Admin\Announcements::index');
    $routes->get('announcements/create', 'Admin\Announcements::create');
    $routes->post('announcements/store', 'Admin\Announcements::store');
    $routes->get('announcements/edit/(:num)', 'Admin\Announcements::edit/$1');
    $routes->post('announcements/update/(:num)', 'Admin\Announcements::update/$1');
    $routes->get('announcements/delete/(:num)', 'Admin\Announcements::delete/$1');
    $routes->post('announcements/toggle-active/(:num)', 'Admin\Announcements::toggleActive/$1');

    // CRUD Events (TAMBAHKAN INI) 
    $routes->get('events', 'Admin\Events::index');
    $routes->get('events/create', 'Admin\Events::create');
    $routes->post('events/store', 'Admin\Events::store');
    $routes->get('events/edit/(:num)', 'Admin\Events::edit/$1');
    $routes->post('events/update/(:num)', 'Admin\Events::update/$1');
    $routes->get('events/delete/(:num)', 'Admin\Events::delete/$1');
    $routes->get('events/getEvents', 'Admin\Events::getEvents');

    // CRUD Teachers (Pimpinan Pondok)
    $routes->get('teachers', 'Admin\Teachers::index');
    $routes->get('teachers/create', 'Admin\Teachers::create');
    $routes->post('teachers/store', 'Admin\Teachers::store');
    $routes->get('teachers/edit/(:num)', 'Admin\Teachers::edit/$1');
    $routes->post('teachers/update/(:num)', 'Admin\Teachers::update/$1');
    $routes->get('teachers/delete/(:num)', 'Admin\Teachers::delete/$1');

    // CRUD Galleries
    $routes->get('galleries', 'Admin\Galleries::index');
    $routes->get('galleries/create', 'Admin\Galleries::create');
    $routes->post('galleries/store', 'Admin\Galleries::store');
    $routes->get('galleries/edit/(:num)', 'Admin\Galleries::edit/$1');
    $routes->post('galleries/update/(:num)', 'Admin\Galleries::update/$1');
    $routes->get('galleries/delete/(:num)', 'Admin\Galleries::delete/$1');

    // Settings
    $routes->get('settings', 'Admin\Settings::index');
    $routes->post('settings/update', 'Admin\Settings::update');

    // CRUD Pages
    $routes->get('pages', 'Admin\Pages::index');
    $routes->get('pages/create', 'Admin\Pages::create');
    $routes->post('pages/store', 'Admin\Pages::store');
    $routes->get('pages/edit/(:num)', 'Admin\Pages::edit/$1');
    $routes->post('pages/update/(:num)', 'Admin\Pages::update/$1');
    $routes->get('pages/delete/(:num)', 'Admin\Pages::delete/$1');

    // CRUD Programs Pendidikan
    $routes->get('programs', 'Admin\Programs::index');
    $routes->get('programs/create', 'Admin\Programs::create');
    $routes->post('programs/store', 'Admin\Programs::store');
    $routes->get('programs/edit/(:num)', 'Admin\Programs::edit/$1');
    $routes->post('programs/update/(:num)', 'Admin\Programs::update/$1');
    $routes->get('programs/delete/(:num)', 'Admin\Programs::delete/$1');

    // 1. CRUD Kategori Dokumen
    $routes->get('document-categories', 'Admin\DocumentCategories::index');
    $routes->post('document-categories/store', 'Admin\DocumentCategories::store');
    $routes->post('document-categories/update/(:num)', 'Admin\DocumentCategories::update/$1');
    $routes->get('document-categories/delete/(:num)', 'Admin\DocumentCategories::delete/$1');

    // 2. CRUD Dokumen Utama
    $routes->get('documents', 'Admin\Documents::index');
    $routes->get('documents/create', 'Admin\Documents::create');
    $routes->post('documents/store', 'Admin\Documents::store');
    $routes->get('documents/edit/(:num)', 'Admin\Documents::edit/$1');
    $routes->post('documents/update/(:num)', 'Admin\Documents::update/$1');
    $routes->get('documents/delete/(:num)', 'Admin\Documents::delete/$1');

    // CRUD Users (Manajemen Pengguna)
    $routes->get('users', 'Admin\Users::index');
    $routes->get('users/create', 'Admin\Users::create');
    $routes->post('users/store', 'Admin\Users::store');
    $routes->get('users/edit/(:num)', 'Admin\Users::edit/$1');
    $routes->post('users/update/(:num)', 'Admin\Users::update/$1');
    $routes->get('users/delete/(:num)', 'Admin\Users::delete/$1');

    // FITUR PROFIL & GANTI PASSWORD
    $routes->get('profile', 'Admin\Auth::profile');
    $routes->post('profile/update', 'Admin\Auth::updateProfile');

    //change paassword
    $routes->get('change-password', 'Admin\Auth::changePassword'); // Halaman Form
    $routes->post('change-password', 'Admin\Auth::attemptChangePassword');
});

// Public Routes untuk Kalender
$routes->get('events', 'EventsController::calendar');
$routes->get('events/calendar', 'EventsController::calendar');
$routes->get('events/getEvents', 'EventsController::getEvents');
$routes->get('events/(:segment)', 'EventsController::show/$1');

// Route Galeri
$routes->get('gallery', 'GalleryController::index');

$routes->get('page/(:segment)', 'PageController::show/$1');

// Route Berita
$routes->get('news', 'NewsController::index');
$routes->get('news/(:segment)', 'NewsController::show/$1');

// Route Dokumen Portal Utama
$routes->get('dokumen', 'PortalDocuments::index');

//Route Tentang MBS
$routes->get('tentang', 'PageController::index');
