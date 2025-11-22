<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// Route Admin (Grouping biar rapi)
$routes->group('admin', function ($routes) {
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
});
