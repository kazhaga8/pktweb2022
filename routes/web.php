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

Route::get('/webmin', function () {
    return redirect()->route('login');
});
Route::get('/e-book', function ($book) {
    return view('web.ebook',compact('book'));
})->name('ebook.index');
Route::get('/e-book/{book}', function ($book) {
    return view('web.ebook',compact('book'));
})->name('ebook');
Route::prefix('{locale?}')->middleware('locale')->group(function() {
    Route::get('/', function () {
        return view('welcome');
    });
});
