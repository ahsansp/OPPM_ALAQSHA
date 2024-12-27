<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */


// -- Auth --
$routes->get('/login', 'Auth::index');
$routes->post('/login', 'Auth::checkLogin');
$routes->get('/logout', 'Auth::logout');
$routes->get('/register', 'Auth::register');
$routes->post('/register', 'Auth::register');
$routes->get('query-check', 'QueryCheck::index');
// -- Admin --
$routes->group('', ['filter' => 'Admin'], function ($routes) {
    $routes->get('account','AccountControl::index');
    $routes->get('/', 'Main::index');
    // -- home --
    $routes->get('/error', 'Home::index');
    // -- form --
    $routes->get('/form/PA', 'PA::index');
    $routes->get('/form/PT', 'PT::index');
    $routes->get('/form/imam', 'Imam::index');
    $routes->post('/form/print/(:any)', 'FormPrint::index/$1');
    // $routes->get('/form/print/(:any)', 'DirectoryControl::index/$1');
    $routes->get('api/PA', 'PAAPI::index');
    $routes->post('/exportToExcel', 'FormPrint::create_excel');
    $routes->post('/exportToExcelimam', 'FormPrint::create_excelimam');
    // -- calendar --
    $routes->get('/calendar', 'calendar::index');
    $routes->post('/api/calendar/create', 'CalendarApi::create');
    $routes->get('/api/calendar', 'CalendarApi::index');
    $routes->get('/events', 'Calendar::fetchEvents');
    $routes->post('/events/update', 'Calendar::updateEvent');
    $routes->post('/events/add', 'Calendar::addEvent'); // Route for adding new events


    // -- absen --
    $routes->get('/absen/rekap-absen/(:any)', 'Absen::rekap/$1');
    $routes->post('/absen/rekap/api', 'Absen::api');
    $routes->get('/absen/rekap/tahunan', 'Absen::Tahunan');
    $routes->get('/absen/rekap/print', 'Absen::print');
    $routes->post('/absen/rekap/print', 'Absen::rekap_absen');
    $routes->post('/absen/rekap/print-tahunan', 'Absen::print_tahunan');
    $routes->get('/absen/rekap/print-rekapan', 'Absen::print_rekapan');

    // -- Directory Control --
    $routes->get('directorycontrol', 'DirectoryControl::index');
    $routes->post('directorycontrol', 'DirectoryControl::upload');
    $routes->post('directorycontrol/file_name', 'DirectoryControl::file_name');
    $routes->get('directorycontrol/open', 'DirectoryControl::open');
    $routes->get('directorycontrol/delete/(:any)', 'DirectoryControl::delete/$1');

    // -- db control --
    $routes->get('datacontrol/kenaikan-kelas', 'DataControl::kenaikan_kelas');
    $routes->post('datacontrol/kenaikan-kelas', 'DataControl::kenaikan_kelas_file');
    $routes->get('datacontrol/kenaikan-kelas/update', 'DataControl::kenaikan_kelas_update');
    $routes->get('datacontrol/kenaikan-kelas/cencel', 'DataControl::kenaikan_kelas_cencel');
    $routes->get('datacontrol/perpindahan-kobong', 'DataControl::perpindahan_kobong');
    $routes->post('datacontrol/perpindahan-kobong', 'DataControl::perpindahan_kobong_file');
    $routes->get('datacontrol/perpindahan-kobong/update', 'DataControl::perpindahan_kobong_update');
    $routes->get('datacontrol/perpindahan-kobong/cencel', 'DataControl::perpindahan_kobong_cencel');
    $routes->get('datacontrol/santri-baru', 'DataControl::santri_baru');
    $routes->post('datacontrol/santri-baru', 'DataControl::santri_baru_file');
    $routes->get('datacontrol/santri-baru/update', 'DataControl::santri_baru_update');
    $routes->get('datacontrol/santri-baru/cencel', 'DataControl::santri_baru_cencel');
    $routes->get('datacontrol/db-control', 'DataControl::db_control');
    

    $routes->post('datacontrol/db-control/update/santri', 'DataControl::db_control_update_santri');
    $routes->post('datacontrol/db-control/update/kelas', 'DataControl::db_control_update_kelas');
    $routes->post('datacontrol/db-control/update/kobong', 'DataControl::db_control_update_kobong');
    $routes->post('datacontrol/db-control/update/drop', 'DataControl::db_control_update_drop');
});
// -- User --
$routes->group('', ['filter' => 'User'], function ($routes) {

    // -- absen --
    $routes->get('/absen/rekap/tahunan', 'Absen::Tahunan');
    $routes->post('/absen/rekap/print-tahunan', 'Absen::print_tahunan');
    // -- db control --
    $routes->get('datacontrol/kenaikan-kelas', 'DataControl::kenaikan_kelas');
    $routes->post('datacontrol/kenaikan-kelas', 'DataControl::kenaikan_kelas_file');
    $routes->get('datacontrol/kenaikan-kelas/update', 'DataControl::kenaikan_kelas_update');
    $routes->get('datacontrol/kenaikan-kelas/cencel', 'DataControl::kenaikan_kelas_cencel');
    $routes->get('datacontrol/perpindahan-kobong', 'DataControl::perpindahan_kobong');
    $routes->post('datacontrol/perpindahan-kobong', 'DataControl::perpindahan_kobong_file');
    $routes->get('datacontrol/perpindahan-kobong/update', 'DataControl::perpindahan_kobong_update');
    $routes->get('datacontrol/perpindahan-kobong/cencel', 'DataControl::perpindahan_kobong_cencel');
    $routes->get('datacontrol/santri-baru', 'DataControl::santri_baru');
    $routes->post('datacontrol/santri-baru', 'DataControl::santri_baru_file');
    $routes->get('datacontrol/santri-baru/update', 'DataControl::santri_baru_update');
    $routes->get('datacontrol/santri-baru/cencel', 'DataControl::santri_baru_cencel');
    $routes->get('datacontrol/db-control', 'DataControl::db_control');

    $routes->post('datacontrol/db-control/update/santri', 'DataControl::db_control_update_santri');
    $routes->post('datacontrol/db-control/update/kelas', 'DataControl::db_control_update_kelas');
    $routes->post('datacontrol/db-control/update/kobong', 'DataControl::db_control_update_kobong');
});
