<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'AuthController::index');
$routes->match(['GET', 'POST'], 'login', 'AuthController::Login');
$routes->match(['GET', 'POST'], 'register', 'AuthController::Register');

$routes->group('dashboard' , ['filter' => 'authMiddleware'] , function($routes) {
    $routes->get('logout', 'DashboardController::Logout');
    $routes->get('/', 'DashboardController::index');

    //Client
    $routes->match(['GET', 'POST'], 'client/(:any)', 'ClientController::index/$1');

    //User
    $routes->match(['GET', 'POST'], 'users', 'UsersController::index');
    $routes->match(['GET', 'POST'], 'users/update/(:num)', 'UsersController::update/$1');
    $routes->get('users/delete/(:num)', 'UsersController::delete/$1');

    //Orders
    $routes->match(['GET', 'POST'], 'orders','OrdersController::index');
    $routes->match(['GET', 'POST'], 'orders/update/(:num)', 'OrdersController::update/$1');
    $routes->get('orders/delete/(:num)', 'OrdersController::delete/$1');
    $routes->get('orders/get/users', 'OrdersController::getUser');

    //JenisTanaman
    $routes->match(['GET', 'POST'], 'jenis', 'JenisController::index');
    $routes->match(['GET', 'POST'], 'jenis/update/(:num)', 'JenisController::update/$1');
    $routes->get('jenis/delete/(:num)', 'JenisController::delete/$1');
});

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
