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

Route::get('/e-book', function ($book) {
    return view('web.ebook',compact('book'));
})->name('ebook.index');
Route::get('/e-book/{book}', function ($book) {
    return view('web.ebook',compact('book'));
})->name('ebook');
Route::get('/webmin', function () {
    return redirect()->route('login');
});
Route::post('/send-contact','WebController@sendContact')->name('send-contact');
Route::post('/get-news','WebController@getNews')->name('get-news.index');
Route::post('/get-certificate','WebController@getCertificate')->name('get-certificate.index');
Route::post('/get-gallery','WebController@getGallery')->name('get-gallery.index');
Route::prefix('{locale?}')->middleware('locale')->group(function($locale) {
    Route::get('/', function ($locale) {
        return redirect()->route('web.index', [$locale, 'home']);
    });
    Route::get('/{pages}/{url}','WebController@pageDetail')->name('web.page-det');
    Route::get('/{pages}','WebController@index')->name('web.index');
});
