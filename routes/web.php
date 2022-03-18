<?php

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

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

// Route::get('pass', function () {

//     echo Hash::make('francisco');
// });

// Route::get('/', function () {
//     return view('welcome');
// });

/* ************************************************************** */

// Rutas de autenticación
Route::get('/', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/', 'Auth\LoginController@login');

// Ruta para cerra sesión
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

// Ruta para para Home
Route::get('/home', 'HomeController@index')->name('home');

// Rutas para acceso usuarios
Route::get('access-users', 'UserController@showInterface')->name('users');
Route::get('users', 'UserController@getUsers');
Route::post('user', 'UserController@createUser');
Route::put('user/{id}', 'UserController@updateUser');

// Rutas para libros
Route::get('inventory-books', 'BookController@showInterface')->name('books');
Route::get('books', 'BookController@getBooks');
Route::post('book', 'BookController@createBook');
Route::put('book/{id}', 'BookController@updateBook');
Route::delete('book/{id}', 'BookController@destroyBook');

// Rutas para asignaciones
Route::get('list-assignments', 'AssignmentController@showInterface')->name('assignments');
Route::get('assignments', 'AssignmentController@geAssignments');

// Rutas para solicitar books
Route::get('loans-books', 'LoanController@showInterface')->name('loans');
Route::get('list-books', 'LoanController@getBooks');
Route::post('loan', 'LoanController@createLoansBook');

// Rutas para retornar books
Route::get('return-books', 'ReturnController@showInterface')->name('returns');
Route::get('assig-books', 'ReturnController@getListAssignmentsUser');
Route::put('return/{id}', 'ReturnController@updateReturnBook');
