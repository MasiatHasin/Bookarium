<?php

use Illuminate\Support\Facades\Route;

use App\Models\user;

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
Route::get('/bookarium/resetpass', function () 
{
    return view('forgotpass');
})->name('resetpass');
Route::get('/bookarium/admin/login', function () 
{
    return view('admin_login');
})->name('adminLoginView');
Route::get('/bookarium/admin_panel', [App\Http\Controllers\AdminController::class, 'index'])->name('adminPanel');
Route::get('/bookarium/admin_books', [App\Http\Controllers\AdminController::class, 'adminBooks'])->name('adminBooks');
Route::post('/bookarium/admin_login', [App\Http\Controllers\AdminController::class, 'adminLogin'])->name('adminLogin');
Route::post('/bookarium/sendmail', [App\Http\Controllers\UserController::class, 'sendmail'])->name('sendmail');
Route::post('/bookarium/verification', [App\Http\Controllers\UserController::class, 'verification'])->name('verification');
Route::post('/bookarium/reset_password', [App\Http\Controllers\UserController::class, 'changepass'])->name('changepass');
Route::get('/bookarium/books/{isbn}', [App\Http\Controllers\BookController::class, 'info'])->name('info');
Route::get('/bookarium/edit/books/{isbn}', [App\Http\Controllers\AdminController::class, 'info'])->name('adminBookInfo');
Route::get('/bookarium/user/settings', [App\Http\Controllers\SettingsController::class, 'index'])->name('settings');
Route::get('/bookarium/user/change_settings', [App\Http\Controllers\SettingsController::class, 'settings'])->name('change_settings');
Route::get('/bookarium/user/request', [App\Http\Controllers\RequestController::class, 'index'])->name('request');
Route::post('/bookarium/user/sendrequest', [App\Http\Controllers\RequestController::class, 'sendrequest'])->name('sendrequest');
Route::get('/bookarium/user/orders', [App\Http\Controllers\OrderController::class, 'orders'])->name('orders');
Route::post('/bookarium/search', [App\Http\Controllers\BookController::class, 'search'])->name('search');
Route::post('/bookarium/discover', [App\Http\Controllers\BookController::class, 'discover'])->name('discover');
Route::get('/bookarium/user/cart', [App\Http\Controllers\CartController::class, 'cart'])->name('cart');
Route::post('/bookarium/user/add2cart', [App\Http\Controllers\CartController::class, 'add'])->name('add2cart');
Route::get('/bookarium/user/remove4cart', [App\Http\Controllers\CartController::class, 'remove'])->name('remove4cart');
Route::post('/bookarium/user/payment', [App\Http\Controllers\CartController::class, 'payment'])->name('payment');
Route::post('/bookarium/books/{isbn}/postreview', [App\Http\Controllers\ReviewController::class, 'postReview'])->name('postReview');
Route::post('/bookarium/books/{isbn}/editreview', [App\Http\Controllers\ReviewController::class, 'editReview'])->name('editReview');
Route::post('/bookarium/books/{isbn}/deletereview', [App\Http\Controllers\ReviewController::class, 'deleteReview'])->name('deleteReview');
Route::post('/bookarium/edit/books/save', [App\Http\Controllers\AdminController::class, 'admin_save_edit'])->name('saveBookEdit');