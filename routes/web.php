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

Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);


// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();
// webmaster, & admin only
Route::group(
    [
        'prefix' => 'admin',
        'middleware' => [
            'auth',
            'role:admin|webmaster|reguler'
        ],
    ],
    function () {
        Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);
        Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');
        Route::get('/file_download/{file}', [App\Http\Controllers\PencairanController::class, 'download'])->name('file_download');
        Route::resource('/subkeg', App\Http\Controllers\SubKegiatanController::class);
        Route::post('/getfirstlevel', [App\Http\Controllers\SubKegiatanController::class, 'getFirstLevel'])->name('getFirstLevel');
        Route::resource('/childsubkegiatan', App\Http\Controllers\ChildSubKegiatanController::class);
        Route::resource('/rekening', App\Http\Controllers\RekeningController::class);
        Route::resource('/anggaran', App\Http\Controllers\AnggaranController::class);
        Route::resource('/pencairan', App\Http\Controllers\PencairanController::class);
    }
);
