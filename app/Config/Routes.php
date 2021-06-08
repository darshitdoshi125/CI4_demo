<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('UserController');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
// $routes->get('/', 'Home::index');

$routes->get('/', 'UserController::index');
$routes->post('login', 'UserController::Login');
$routes->get('signup', 'UserController::Signup');
$routes->get('forgot-password', 'UserController::forgotPassword');
$routes->get('logout', 'UserController::Logout');
$routes->post('save-user', 'UserController::saveUser');

$routes->get('account-setting', 'Home::accountSetting');
$routes->post('update-profile', 'Home::updateProfile');
$routes->post('change-password', 'Home::changePassword');

//Product module
$routes->get('product-list', 'ProductController::index');
$routes->get('ajax-load-product-data', 'ProductController::ajaxLoadProductData');
$routes->get('add-product', 'ProductController::addProduct');
$routes->post('save-product', 'ProductController::saveProduct');
$routes->post('check-product', 'ProductController::checkProduct');
$routes->get('edit-product/(:any)', 'ProductController::addProduct/$1');
$routes->post('change-block-status', 'ProductController::changeBlockStatus');
$routes->post('delete-product', 'ProductController::deleteProduct');

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
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
