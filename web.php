<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;

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

//ALL POSTS View Route
Route::get('/', [AuthController::class, 'view'])->name('/');
Route::get('/viewpost/{id}', [AuthController::class, 'viewpost'])->name('viewpost');


//Registration Sign Up
Route::get('/register', [AuthController::class, 'index'])->name('register');
Route::post('postregister', [AuthController::class, 'store'])->name('postregister');
Route::get('account/verify/{token}', [AuthController::class, 'verifyAccount'])->name('user.verify');


//Login and Logout Route
Route::get('login', [UserController::class, 'index'])->name('login');
Route::post('li', [UserController::class, 'login']);
Route::get('logout', [AuthController::class, 'destroy'])->name('logout');



//Middleware Routes After User Login Successfully
Route::middleware(['isUser', 'is_verify_email'])->group(function(){

    Route::get('wall', [UserController::class, 'home'])->name('wall');
    Route::post('post', [UserController::class, 'store'])->name('post');

    Route::post('comment', [UserController::class, 'comment'])->name('comment');

    Route::post('like/{id}', [UserController::class, 'like'])->name('like');
    Route::post('dislike/{id}', [UserController::class, 'dislike'])->name('dislike');

    Route::get('edit/{id}', [UserController::class, 'edit'])->name('edit');
    Route::patch('update/{id}', [UserController::class, 'update'])->name('update');
    Route::get('delete/{id}', [UserController::class, 'destroy'])->name('delete');


});

//MiddleWare Routes After Admin Login Successfully
Route::middleware(['isAdmin'])->group(function(){

    Route::get('post', [AdminController::class, 'index'])->name('post');
    Route::get('users', [AdminController::class, 'users'])->name('users');
    Route::get('ban/{id}', [AdminController::class, 'banned'])->name('ban');
    Route::get('unban/{id}', [AdminController::class, 'unbanned'])->name('unban');

    Route::get('accept/{id}', [AdminController::class, 'accept'])->name('accept');
    Route::get('reject/{id}', [AdminController::class, 'reject'])->name('reject');

});