<?php namespace Config;

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
//$routes->setDefaultController('Home');
$routes->setDefaultController('Login');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
//$routes->get('/', 'Home::index');
$routes->get('/', 'Login::index');
$routes->get('/admdashboard', 'Dashboard::index');
$routes->get('/admagama', 'Master/Agamacontroller::index');
$routes->get('/adminfotype', 'Information/Typecontroller::index');
$routes->get('/adminfocat', 'Information/Categorycontroller::index');
$routes->get('/adminfonews', 'Information/Newscontroller::index');
$routes->get('/admpackagefeature', 'Package/Featurecontroller::index');
$routes->get('/admpackageprice', 'Package/Pricecontroller::index');
$routes->get('/admaccountuserlevel', 'Account/Userlevelcontroller::index');
$routes->get('/admaccountmember', 'Account/Membercontroller::index');
$routes->get('/admaccountadministrator', 'Account/Administratorcontroller::index');
$routes->get('/admaccountuser', 'Account/Usercontroller::index');
$routes->get('/admmasteranggota', 'Account/Master/Anggotacontroller::index');
$routes->get('/admmasterkomunitas', 'Account/Master/Komunitascontroller::index');
$routes->get('/admmediafilter', 'Media/Filtermedcontroller::index');
$routes->get('/admfeedbackquestion', 'Feedback/Questioncontroller::index');
$routes->get('/admfeedbacksubscribe', 'Feedback/Subscribercontroller::index');
$routes->get('/admsettingbenefit', 'Setting/Benefitcontroller::index');
$routes->get('/admsettingcustom', 'Setting/Customcontroller::index');

/**
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
