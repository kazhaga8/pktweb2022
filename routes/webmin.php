<?php

use Illuminate\Support\Facades\Auth;
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


Auth::routes();
Auth::routes(['verify' => true]);
Route::group(['middleware' => ['auth']], function() {
    Route::get('/files', function () {     return view('webmin.files.index'); })->name('files.index');;

    Route::resource('pages','PageController')->except(['edit', 'show']);
    Route::get('/pages/json','PageController@json')->name('pages.json');
    Route::get('/pages/{page}','PageController@edit')->name('pages.edit');
    
    Route::resource('menus','MenuController')->except(['edit', 'show']);
    Route::get('/menus/json','MenuController@json')->name('menus.json');
    Route::get('/menus/{menu}','MenuController@edit')->name('menus.edit');

    Route::resource('sliders','SliderController')->except(['edit', 'show']);
    Route::get('/sliders/json','SliderController@json')->name('sliders.json');
    Route::get('/sliders/{slider}','SliderController@edit')->name('sliders.edit');
    
    Route::resource('sliders-bottom','SliderBottomController')->except(['edit', 'show']);
    Route::get('/sliders-bottom/json','SliderBottomController@json')->name('sliders-bottom.json');
    Route::get('/sliders-bottom/{slider}','SliderBottomController@edit')->name('sliders-bottom.edit');

    Route::resource('news','NewsController')->except(['edit', 'show']);
    Route::get('/news/json','NewsController@json')->name('news.json');
    Route::get('/news/{news}','NewsController@edit')->name('news.edit');

    Route::get('/sustainability-report','SustainabilityController@index')->name('sustainability-report.index');
    Route::get('/sustainability-report/json','SustainabilityController@json')->name('sustainability-report.json');
    Route::get('/sustainability-report/create','SustainabilityController@create')->name('sustainability-report.create');
    Route::post('/sustainability-report','SustainabilityController@store')->name('sustainability-report.store');
    Route::get('/sustainability-report/{ebook}','SustainabilityController@edit')->name('sustainability-report.edit');
    Route::match(['put', 'patch'],'sustainability-report/{ebook}','SustainabilityController@update')->name('sustainability-report.update');
    Route::delete('/sustainability-report/{ebook}','SustainabilityController@destroy')->name('sustainability-report.destroy');

    Route::get('/annual-report','AnnualController@index')->name('annual-report.index');
    Route::get('/annual-report/json','AnnualController@json')->name('annual-report.json');
    Route::get('/annual-report/create','AnnualController@create')->name('annual-report.create');
    Route::post('/annual-report','AnnualController@store')->name('annual-report.store');
    Route::get('/annual-report/{ebook}','AnnualController@edit')->name('annual-report.edit');
    Route::match(['put', 'patch'],'annual-report/{ebook}','AnnualController@update')->name('annual-report.update');
    Route::delete('/annual-report/{ebook}','AnnualController@destroy')->name('annual-report.destroy');

    Route::get('/financial-statements','FinancialStateController@index')->name('financial-statements.index');
    Route::get('/financial-statements/json','FinancialStateController@json')->name('financial-statements.json');
    Route::get('/financial-statements/create','FinancialStateController@create')->name('financial-statements.create');
    Route::post('/financial-statements','FinancialStateController@store')->name('financial-statements.store');
    Route::get('/financial-statements/{ebook}','FinancialStateController@edit')->name('financial-statements.edit');
    Route::match(['put', 'patch'],'financial-statements/{ebook}','FinancialStateController@update')->name('financial-statements.update');
    Route::delete('/financial-statements/{ebook}','FinancialStateController@destroy')->name('financial-statements.destroy');

    Route::get('/e-magazine','EmagazineController@index')->name('e-magazine.index');
    Route::get('/e-magazine/json','EmagazineController@json')->name('e-magazine.json');
    Route::get('/e-magazine/create','EmagazineController@create')->name('e-magazine.create');
    Route::post('/e-magazine','EmagazineController@store')->name('e-magazine.store');
    Route::get('/e-magazine/{ebook}','EmagazineController@edit')->name('e-magazine.edit');
    Route::match(['put', 'patch'],'e-magazine/{ebook}','EmagazineController@update')->name('e-magazine.update');
    Route::delete('/e-magazine/{ebook}','EmagazineController@destroy')->name('e-magazine.destroy');

    Route::get('/roles/json','RoleController@json')->name('roles.json');
    Route::resource('roles','RoleController');

    Route::get('/users/json','UserController@json')->name('users.json');
    Route::resource('users','UserController');

    Route::get('/my-profile','UserController@profile')->name('myprofile');
    Route::put('/my-profile/{id}','UserController@profileUpdate')->name('myprofile.update');
    Route::get('/change-password','UserController@changePassword')->name('changepassword');
    Route::put('/change-password/{id}','UserController@changePasswordUpdate')->name('changepassword.update');

    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
});
