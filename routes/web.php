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
Route::prefix('{locale?}')->middleware('locale')->group(function($locale) {
    Route::get('/', function ($locale) {
        return redirect()->route('web.index', [$locale, 'home']);
    });
    Route::get('/{pages}','WebController@index')->name('web.index');
});
