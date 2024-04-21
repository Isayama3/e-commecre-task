<?php

use App\Http\Controllers\Admin\Web\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('logout', [AuthController::class, 'logout'])->name('logout');
Route::get('profile', [AuthController::class, 'updateProfileView'])->name('profile.view');
Route::put('profile', [AuthController::class, 'updateProfile'])->name('profile.post');


Route::resource('admins', 'AdminController');
Route::resource('categories', 'CategoryController');
Route::resource('products', 'ProductController');
Route::get('/products-pdf', 'ProductController@generatePDF')->name('products.pdf');
