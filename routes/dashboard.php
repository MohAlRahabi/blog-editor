<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin;

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
    return view('dashboard.index');
})->name('dashboard');

Route::get('get_users',[Admin\UserController::class,'data'])->name('users.data');
Route::resource('users',Admin\UserController::class);

Route::get('get_articles',[Admin\ArticleController::class,'data'])->name('articles.data');
Route::resource('articles',Admin\ArticleController::class);
