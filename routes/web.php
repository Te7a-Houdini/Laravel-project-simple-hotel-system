<?php


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
    return view('welcome');
});


//*********************************Admin*****



/*

Diaa Section 

*/
Route::get('/' , 'clients\ClientReservationController@index')->name('client.home');
Route::resource('/reservations/rooms', 'clients\ClientReservationController')->except([
    'index'])->middleware('auth','forbid-banned-user');

Route::get('/client/reservations/{id}' , 'clients\LastClientReservationController@show')->name('client.reservations');
Route::get('/client/reservations/' , 'clients\LastClientReservationController@index')->name('client.reservations.index');

Route::get('/client/editprofile/{id}' , 'clients\editpofileController@edit')->name('editprofile.edit')->middleware('auth','forbid-banned-user');
Route::Put('/client/update/{id}' , 'clients\editpofileController@update')->name('editprofile.update')->middleware('auth','forbid-banned-user');



/*

Mai Section 

*/

Route::get('receptionist','UsersController@home')->middleware('forbid-banned-user');
Route::get('receptionist/manage','UsersController@manageClients')->middleware('forbid-banned-user');
Route::get('receptionist/manage/getdatatable','UsersController@getdatatable')->middleware('forbid-banned-user');

Route::get('receptionist/approved','UsersController@approvedClients')->middleware('forbid-banned-user');
Route::get('receptionist/approved/getdatatable','UsersController@getdatatableApproved');

Route::get('receptionist/reservations','UsersController@reservations');
Route::get('receptionist/reservations/getdatatable','UsersController@getdatatableReservations');

Route::get('receptionist/{id}/approve','UsersController@approve')->middleware('forbid-banned-user');
Route::delete('receptionist/{id}','UsersController@delete');

//*********************************Admin*****

Route::get('admin/clients','UsersController@showClients')->middleware('forbid-banned-user');
Route::get('admin/clients/getdatatable','UsersController@getdatatableClients');

Route::get('admin/clients/{id}/edit','UsersController@editClient')->middleware('forbid-banned-user');
Route::put('admin/clients/{id}','UsersController@updateClient')->middleware('forbid-banned-user');
Route::get('admin/clients/{id}/delete','UsersController@deleteClient')->middleware('forbid-banned-user');
Route::get('admin/clients/add','UsersController@createClient')->middleware('forbid-banned-user');
Route::post('admin/clients','UsersController@storeClient')->middleware('forbid-banned-user');

/*



Deena Section 


*/
Route::get('ERROR' , 'Controller@index'); ///error page
Route::get(
    'managers',
    'ManagersController@index'
)->name('managers.index')->middleware('auth','role:admin','forbid-banned-user');

Route::get(
    'receptionists',
    'ReceptionistsController@index'
)->name('receptionists.index')->middleware('auth','role:admin|manager|receptionist','forbid-banned-user');

Route::get('admin','Controller@showadmin')->middleware('auth','role:admin|manager|receptionist','forbid-banned-user');
Route::get('managers/create','ManagersController@create')->middleware('auth','role:admin','forbid-banned-user');
Route::get('managers/getdata','ManagersController@getdata')->name('managers.data')->middleware('auth','role:admin','forbid-banned-user');
Route::post('managers','ManagersController@store')->middleware('auth','role:admin','forbid-banned-user');
Route::get('managers/{id}/edit','ManagersController@edit')->middleware('auth','role:admin','forbid-banned-user');
Route::put('managers/{id}','ManagersController@update')->middleware('auth','role:admin','forbid-banned-user');
Route::get('managers/{id}','ManagersController@show')->middleware('auth','role:admin','forbid-banned-user');
Route::delete('managers/{id}','ManagersController@destroy')->middleware('auth','role:admin','forbid-banned-user');

Route::get('receptionists/create','ReceptionistsController@create')->middleware('auth','role:admin|manager','forbid-banned-user');
Route::get('receptionists/getdata','ReceptionistsController@getdata')->name('receptionists.data')->middleware('auth','role:admin|manager','forbid-banned-user');
Route::post('receptionists','ReceptionistsController@store')->middleware('auth','role:admin|manager','forbid-banned-user');
Route::get('receptionists/{id}/edit','ReceptionistsController@edit')->middleware('auth','role:admin|manager','forbid-banned-user');
Route::put('receptionists/{id}','ReceptionistsController@update')->middleware('auth','role:admin|manager','forbid-banned-user');
Route::get('receptionists/{id}','ReceptionistsController@show')->middleware('auth','role:admin|manager','forbid-banned-user');
Route::delete('receptionists/{id}','ReceptionistsController@destroy')->middleware('auth','role:admin|manager','forbid-banned-user');
Route::get('receptionists/{id}/bann','ReceptionistsController@bann')->middleware('auth','role:admin|manager','forbid-banned-user');
/*


Aya Section 
*/
########## Floors Routes ############
Route::get('floors','FloorsController@index')->middleware('auth','role:admin|manager','forbid-banned-user');
Route::get('floors/create','FloorsController@create')->middleware('auth','role:admin|manager','forbid-banned-user');
Route::post('floors','FloorsController@store')->middleware('auth','role:admin|manager','forbid-banned-user');
Route::get('floors/{id}/edit','FloorsController@edit')->middleware('auth','role:admin|manager','forbid-banned-user')->name('floors.edit');
Route::put('floors/{id}','FloorsController@update')->middleware('auth','role:admin|manager','forbid-banned-user');
Route::delete('floors/{id}', 'FloorsController@delete')->middleware('auth','role:admin|manager','forbid-banned-user');

Route::get('floors/getdatatable','FloorsDataTablesController@getdatatable')->middleware('auth','role:admin|manager','forbid-banned-user');

/*____________________________________
#### Rooms Routes #################
*/
Route::get('rooms','RoomsController@index')->middleware('auth','role:admin|manager','forbid-banned-user');
Route::get('rooms/getdatatable','RoomsController@getdatatable')->middleware('auth','role:admin|manager','forbid-banned-user');
Route::get('rooms/create','RoomsController@create')->middleware('auth','role:admin|manager','forbid-banned-user');
Route::post('rooms','RoomsController@store')->middleware('auth','role:admin|manager','forbid-banned-user');
Route::get('rooms/{id}/edit','RoomsController@edit')->middleware('auth','role:admin|manager','forbid-banned-user');
Route::put('rooms/{id}','RoomsController@update')->middleware('auth','role:admin|manager','forbid-banned-user');
Route::delete('rooms/{id}','RoomsController@delete')->middleware('auth','role:admin|manager','forbid-banned-user');


Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

