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

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();
//  webmaster, admin, author
Route::group(
    [
        'prefix' => 'admin',
        'middleware' => [
            'auth',
            'role:author|admin|webmaster',

        ],
    ],
    function () {
        Route::get('/dashboard_author', [App\Http\Controllers\HomeController::class, 'dash_author'])->name('dashboard.author');
    }
);
// webmaster, & admin only
Route::group(
    [
        'prefix' => 'admin',
        'middleware' => [
            'auth',

            'role:admin|webmaster'
        ],
    ],
    function () {
        Route::get('/dashboard_admin', [App\Http\Controllers\HomeController::class, 'dash_admin'])->name('dashboard.admin');
    }
);
// webmaster only
Route::group(
    [
        'prefix' => 'admin',
        'middleware' => [
            'auth',
            'role:webmaster'
        ],
    ],
    function () {
        Route::get('/dashboard_webmaster', [App\Http\Controllers\HomeController::class, 'dash_webmaster'])->name('dashboard.webmaster');
    }
);
