<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['register' => false]);

//Admin routers
Route::middleware('auth')->group(function () {
    Route::get('/admin', [App\Http\Controllers\Admin\AdminController::class, 'showAdmin']);
});

//APIs Admin panel
Route::group(['prefix' => 'api'], function () {
    Route::resource('company', 'App\Http\Controllers\Admin\CompanyController');
    Route::resource('employee', 'App\Http\Controllers\Admin\EmployeeController');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
