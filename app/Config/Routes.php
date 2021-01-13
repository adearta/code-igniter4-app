<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
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
$routes->get('/', 'Pages::index');
//----------('jika ada yang mengakses(/)','tampilkan kontroller(home)::method(index)');
$routes->add('/coba', 'Coba::index');
$routes->get('/coba/(:alpha)/(:num)', 'Coba::tentang/$1/$2');
//kalau ada request method nya delete arahin ke film / angka(id) lalu arahkan ke kontroller film methodnya delete ambil id nya
$routes->delete('/komik/(:num)', 'Komik::delete/$1');
//edit
$routes->get('/komik/edit/(:segment)', 'Komik::edit/$1');
//------get dapat digunakan untuk mengambil data namun dapat bermasalah jika nilainya adalah (:any)
// $routes->get('/user', 'Admin\User::index');
//$routes-> request methodnya get(kalau ada yang ngakses ke '/user',arahkan ke namespace nya 'Admin\kontrolernya user::methodnya index')
//code igniter akan membuat jalur jika ada akses yang metode requestnya get, alamatnya adalah slash
//jadi kalau kalau ada yang mengakses halaman root arahkan ke kontroler home lalu methodnya index
$routes->get('/komik/(:any)', 'Komik::detail/$1');
// membut rute baru untuk langsung menampilkan halaman detail komik
$routes->get('/review/(:segment)', 'Review::review/$1');
// membuat rute untuk movie
//ternyata urutanyya harus seperti ini kalau tidak dia tidak bisa di gunakan 
$routes->delete('/movie/(:num)', 'Movie::delete/$1');
$routes->get('/movie/edit/(:segment)', 'Movie::edit/$1');
$routes->get('/movie/(:any)', 'Movie::detail/$1');
$routes->get('/api/get', 'Api::getData');
$routes->post('/api/save', 'Api::saveKomik');




/**membuat rute baru dengan reques method get, kalau ada yang mengakses /Review/segmen maka akan memanggil kontroller dengan nama Review dengan methodnya yaitu review dan mengirim nilai segment 
untuk dimasukkan ke dalam parameter**/
// membuat untuk film
// $routes->get('/film/(:any)', 'Film::detail/$1');
// $routes->get('/film/edit/(:segment)', 'Film::edit/$1');
// $routes->delete('/film/(:num)', 'Film::delete/$1');
//kalau ada request method nya delete arahin ke film / angka(id) lalu arahkan ke kontroller film methodnya delete ambil id nya
//
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
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
