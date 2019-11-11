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

Route::get('menu', function() {
    return 'Kunjungi <a href="'.Route('home.welcome').'">Halaman Welcome</a>';
});

Route::group(['prefix'=>'dashboard'], function() {
    Route::get('menu', function() {
        return 'Kunjungi <a href="'.Route('home.welcome').'">Halaman Welcome</a>';
    });

    Route::get('welcome/{nama?}',['as'=>'home.welcome',
    function($nama='Pengujung') {
        return "Selamat datang <b>" . $nama . ". </b> Anda luar biasa!";
    }])->where('nama', '[A-Za-z]+');
});

//Route::group(['middleware'], function (){
//    Route::get('/', function () {
//        return view('welcome');
//    });
//});

Route::get('/','bookController@index');
Route::resource('book','BookProductController');

Route::group(['middleware'], function (){
    Auth::routes();
    Route::get('/home', 'HomeController@index')->name('home');
    Route::resource('book','BookProductController');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware'], function (){
    Route::resource('book','BookProductController');
   });