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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');






Route::group(['prefix' => 'packages'], function() {
    
    Route::get('/', 'App\Http\Controllers\ControllerPackages@packages')->middleware(['auth'])->name('packages');
    
////////////////////

    Route::get('/create', function () {
        return view('create');
    })->middleware(['auth'])->name('create');
    Route::post('/create/submit', 'App\Http\Controllers\ControllerPackages@create_submit')->middleware(['auth'])->name('create_submit');
    
    Route::get('/edit/{id}', 'App\Http\Controllers\ControllerPackages@edit')->middleware(['auth'])->name('edit');
    Route::post('/edit/submit', 'App\Http\Controllers\ControllerPackages@edit_submit')->middleware(['auth'])->name('edit_submit');
 
    Route::get('/delete/{id}', 'App\Http\Controllers\ControllerPackages@delete')->middleware(['auth'])->name('delete');
    
///////////////////
    
    
    Route::get('/load-xlsx', function () {
        return view('load-xlsx');
    })->middleware(['auth'])->name('load-xlsx');
    
    Route::post('/load-xlsx/submit', 'App\Http\Controllers\ControllerPackages@load_xlsx_submit')->middleware(['auth'])->name('load_xlsx_submit');
    
    
    Route::post('/get_cities','App\Http\Controllers\ControllerPackages@get_cities')->name('get_cities_front');

});




require __DIR__.'/auth.php';
