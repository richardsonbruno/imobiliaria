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

Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'as' => 'admin.'], function () {
    // Rotas do Formulário
    Route::get('/', 'AuthController@showLoginForm')->name('login');
    Route::post('login', 'AuthController@login')->name('login.do');

    // Rotas Autenticadas, dentro do admin
    Route::group(['middleware' => 'auth'], function () {
        Route::get('home', 'AuthController@home')->name('home');
        Route::get('logout', 'AuthController@logout')->name('logout');
    });
});
