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

Route::get('/',[\App\Http\Controllers\HomeController::class,"home"])->name('home');
Route::get('articles/{slug}',[\App\Http\Controllers\HomeController::class,"singleBlog"])->name("user.article.view");
