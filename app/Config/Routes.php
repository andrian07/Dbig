<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

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
//$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');

$routes->group('devman', static function ($routes) {
    $routes->get('/', 'Devman::index');
    $routes->get('auth', 'Devman::index');
    $routes->post('auth/login', 'Devman::login', ['filter' => 'csrf']);
    $routes->get('auth/logout', 'Devman::logout');

    $routes->get('log-queries', 'Devman::logQueries', ['filter' => 'devauth']);
    $routes->post('log-queries-table', 'Devman::getLogQueries', ['filter' => 'devauth']);
    $routes->get('log-queries-detail/(:num)', 'Devman::getLogQueriesDetail/$1', ['filter' => 'devauth']);
});


$routes->group('webmin', static function ($routes) {
    $routes->get('/', 'Webmin\Auth::index');
    $routes->get('auth', 'Webmin\Auth::index');
    $routes->post('auth/login', 'Webmin\Auth::login', ['filter' => 'csrf']);
    $routes->get('auth/logout', 'Webmin\Auth::logout');
});

$routes->group('webmin', ['filter' => 'webminauth'], static function ($routes) {
    $routes->get('profile', 'Webmin\Profile::index');
    $routes->get('profile/update-password', 'Webmin\Profile::update_password');
});


$routes->group('webmin/category', ['filter' => 'webminauth'], static function ($routes) {
    $routes->get('/', 'Webmin\Category::index');
    $routes->get('getbyid/(:num)', 'Webmin\Category::getById/$1');
    $routes->get('getbyname', 'Webmin\Category::getByName');
    $routes->post('table', 'Webmin\Category::table');
    $routes->post('save/(:alpha)', 'Webmin\Category::save/$1');
    $routes->get('delete/(:num)', 'Webmin\Category::delete/$1');
});

$routes->group('webmin/purchase-order', ['filter' => 'webminauth'], static function ($routes) {
     $routes->get('/', 'Webmin\Purchase_order::index');
});

$routes->group('webmin/submission', ['filter' => 'webminauth'], static function ($routes) {
    $routes->get('/', 'Webmin\Submission::index');
    $routes->get('submissiondetaildemo', 'Webmin\Submission::submissiondetaildemo');
    
});


$routes->group('webmin/unit', ['filter' => 'webminauth'], static function ($routes) {
    $routes->get('/', 'Webmin\Category::index');
    $routes->get('getbyid/(:num)', 'Webmin\Category::getById/$1');
    $routes->get('getbyname', 'Webmin\Category::getByName');
    $routes->post('table', 'Webmin\Category::table');
    $routes->post('save/(:alpha)', 'Webmin\Category::save/$1');
    $routes->get('delete/(:num)', 'Webmin\Category::delete/$1');
});



/* POS */
$routes->group('pos', static function ($routes) {
    $routes->get('/', 'Pos\Auth::index');
    $routes->get('auth', 'Pos\Auth::index');
    $routes->post('auth/login', 'Pos\Auth::login', ['filter' => 'csrf']);
    $routes->get('auth/logout', 'Pos\Auth::logout');
});


$routes->group('pos', ['filter' => 'posauth'], static function ($routes) {
    //$routes->get('profile', 'Webmin\Profile::index');
    //$routes->get('profile/update-password', 'Webmin\Profile::update_password');
    $routes->get('dashboard', 'Pos\Dashboard::index');
    $routes->get('customer-display', 'Pos\Dashboard::customerDisplay');

    $routes->get('sales', 'Pos\Sales::index');
    $routes->get('sales-return', 'Pos\Sales_return::index');
});
/* END POS */


/* Eric Demo */
$routes->group('webmin', ['filter' => 'webminauth'], static function ($routes) {
    $routes->get('unit', 'Webmin\EricDemo::unit');
    $routes->get('brand', 'Webmin\EricDemo::brand');
    $routes->get('warehouse', 'Webmin\EricDemo::warehouse');
    $routes->get('customer', 'Webmin\EricDemo::customer');
    $routes->get('supplier', 'Webmin\EricDemo::supplier');
    $routes->get('product', 'Webmin\EricDemo::product');
});
/* End Eric Demo */


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
