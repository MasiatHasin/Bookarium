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

Auth::routes();
Route::get('/', function () 
{
    return redirect('/bookarium');
});
Route::get('/bookarium', [App\Http\Controllers\HomeController::class, 'index'])->name('bookarium');
Route::get('/bookarium/books/{isbn}', [App\Http\Controllers\BookController::class, 'info'])->name('info');
Route::get('/bookarium/user/settings', [App\Http\Controllers\SettingsController::class, 'index'])->name('settings');
Route::get('/bookarium/user/change_settings', [App\Http\Controllers\SettingsController::class, 'settings'])->name('change_settings');
Route::get('/bookarium/user/request', [App\Http\Controllers\RequestController::class, 'index'])->name('request');
Route::post('/bookarium/user/sendrequest', [App\Http\Controllers\RequestController::class, 'sendrequest'])->name('sendrequest');
Route::get('/bookarium/user/orders', [App\Http\Controllers\OrderController::class, 'orders'])->name('orders');
