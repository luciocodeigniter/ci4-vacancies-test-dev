<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
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
$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index', ['filter' => 'candidate', 'as' => 'home']);


// Login
$routes->group('login', function ($routes) {
    $routes->get('/', 'Login::index', ['as' => 'login', 'filter' => 'guest']);
    $routes->post('create', 'Login::create', ['as' => 'login.create']);
    $routes->post('logout', 'Login::destroy', ['as' => 'login.destroy']);
});


// Register
$routes->group('register', function ($routes) {
    $routes->get('/', 'Register::index', ['as' => 'register', 'filter' => 'guest']);
    $routes->post('create', 'Register::create', ['as' => 'register.create']);
    $routes->get('success', 'Register::success', ['as' => 'register.success']);
    $routes->get('activate/(:any)', 'Register::activate/$1', ['as' => 'register.activate']);
});

// Password recovery
$routes->group('password', function ($routes) {
    $routes->get('/', 'Password::index', ['as' => 'password', 'filter' => 'guest']);
    $routes->post('recovery', 'Password::recovery', ['as' => 'password.recovery']);
    $routes->get('reset/(:any)', 'Password::reset/$1', ['as' => 'password.reset']);
    $routes->get('reset-send', 'Password::resetSend', ['as' => 'password.reset.send']);
    $routes->post('create/(:any)', 'Password::create/$1', ['as' => 'password.create']);
});


// Vacancies
$routes->group('vacancies', ['filter' => 'admin'], function ($routes) {
    $routes->get('/', 'Vacancies::index', ['as' => 'vacancies']);
    $routes->get('show/(:num)', 'Vacancies::show/$1', ['as' => 'vacancies.show']);
    $routes->get('new', 'Vacancies::new', ['as' => 'vacancies.new']);
    $routes->post('create', 'Vacancies::create', ['as' => 'vacancies.create']);
    $routes->get('edit/(:num)', 'Vacancies::edit/$1', ['as' => 'vacancies.edit']);
    $routes->put('update/(:num)', 'Vacancies::update/$1', ['as' => 'vacancies.update']);
    $routes->delete('delete/(:num)', 'Vacancies::delete/$1', ['as' => 'vacancies.delete']);
    $routes->delete('delete-all', 'Vacancies::deleteAllSelected', ['as' => 'vacancies.delete.all']);
});


// Candidates
$routes->group('candidates', ['filter' => 'admin'], function ($routes) {
    $routes->get('/', 'Candidates::index', ['as' => 'candidates']);
    $routes->get('show/(:num)', 'Candidates::show/$1', ['as' => 'candidates.show']);
    $routes->get('new', 'Candidates::new', ['as' => 'candidates.new']);
    $routes->post('create', 'Candidates::create', ['as' => 'candidates.create']);
    $routes->get('edit/(:num)', 'Candidates::edit/$1', ['as' => 'candidates.edit']);
    $routes->put('update/(:num)', 'Candidates::update/$1', ['as' => 'candidates.update']);
    $routes->delete('delete/(:num)', 'Candidates::delete/$1', ['as' => 'candidates.delete']);
    $routes->delete('delete-all', 'Candidates::deleteAllSelected', ['as' => 'candidates.delete.all']);
});


// Jobs - applications
$routes->group('jobs', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Jobs::index', ['as' => 'jobs']);
    $routes->get('my', 'Jobs::myJobs', ['as' => 'jobs.my']);
    $routes->put('apply/(:num)', 'Jobs::apply/$1', ['as' => 'jobs.apply']);
    $routes->delete('givup/(:num)', 'Jobs::givUp/$1', ['as' => 'jobs.givup']);
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
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
