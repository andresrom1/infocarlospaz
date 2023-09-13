<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

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

Route::get('/dashboard/{cat?}',[PostController::class, 'index'] )->middleware(['auth'])->name('dashboard');
Route::get('/dashboard/{cat}/filter',[PostController::class, 'filter'] )->middleware(['auth'])->name('filter');
Route::patch('/post/{postId}/edit',[PostController::class, 'update'] )->middleware(['auth'])->name('update');
Route::delete('/post/{postId}/destroy',[PostController::class, 'destroy'] )->middleware(['auth'])->name('destroy');
Route::get('/post/create',[PostController::class, 'create'] )->middleware(['auth'])->name('create');
Route::post('/post',[PostController::class, 'store'] )->middleware(['auth'])->name('store');

Route::get('/buscar-posts', [PostController::class, 'toPost'])->middleware(['auth'])->name('buscarPosts');

Route::get('/dashboard2',[PostController::class, 'index2'] )->middleware(['auth'])->name('dashboard');


require __DIR__.'/auth.php';
