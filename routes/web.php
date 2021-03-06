<?php

use App\Http\Controllers\FavoritesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfilesController;
use App\Http\Controllers\RepliesController;
use App\Http\Controllers\ThreadsController;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::view('/', 'welcome');
Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('threads', [ThreadsController::class, 'index'])->name('threads.index');
Route::get('threads/create', [ThreadsController::class, 'create'])->name('threads.create');
Route::get('threads/{channel}/{thread}', [ThreadsController::class, 'show'])->name('threads.show');
Route::delete('threads/{channel}/{thread}', [ThreadsController::class, 'destroy'])->name('threads.delete');
Route::post('threads', [ThreadsController::class, 'store'])->name('threads.store');
Route::get('threads/{channel}', [ThreadsController::class, 'index'])->name('threads.by.channel');

Route::get('threads/{channel}/{thread}/replies', [RepliesController::class, 'index'])->name('replies.index');
Route::post('threads/{channel}/{thread}/replies', [RepliesController::class, 'store'])->name('replies.store');
Route::patch('/replies/{reply}', [RepliesController::class, 'update'])->name('replies.update');
Route::delete('/replies/{reply}', [RepliesController::class, 'destroy'])->name('replies.delete');


Route::post('/replies/{reply}/favorites', [FavoritesController::class, 'store'])->name('reply.favorite');
Route::delete('/replies/{reply}/favorites', [FavoritesController::class, 'destroy'])->name('reply.favorite.delete');

Route::get('/profiles/{user}', [ProfilesController::class, 'show'])->name('profile');
