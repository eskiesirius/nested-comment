<?php

use App\Http\Controllers\CommentController;
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

Route::get('/', [CommentController::class,'index'])->name('comments.index');
Route::post('/', [CommentController::class,'store'])->name('comments.store');
Route::post('/{comment}', [CommentController::class,'reply'])->name('comments.reply');
