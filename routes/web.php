<?php

use Illuminate\Support\Facades\Route;
use App\Models;
use App\Http\Controllers;
use App\Http\Middleware;

Route::get('/csrf-token', function() {
    return response()->json(['csrf_token' => csrf_token()]);
});
Route::controller(Controllers\AuthController::class)->group(function(){
    Route::get('login', 'index')->name('login')->middleware(Middleware\isLogin::class);
    Route::post('login', 'login');
    Route::post('logout', 'logout')->name('logout');
});
Route::prefix('admin')->middleware('auth')->group(function (){
    Route::get('/', function(){return view('dashboard', ['page'=>'dashboard']);})->name('dashboard');
    Route::resource('member', Controllers\MemberController::class)->except(['edit', 'show', 'create']);
    Route::resource('division', Controllers\DivisionController::class)->except(['edit', 'show', 'create']);
    Route::resource('event', Controllers\EventController::class)->except(['edit','show', 'create']);
    Route::resource('mentor', Controllers\MentorController::class)->except(['edit', 'show', 'create']);
    Route::resource('post', Controllers\PostController::class)->except(['edit','show', 'create']);
    Route::resource('prodi', Controllers\ProdiController::class)->except(['edit', 'show', 'create']);
    Route::resource('registrant', Controllers\RegistrantController::class)->except(['edit', 'show', 'create']);
    // Route::resource('user', Controllers\UserController::class)->except(['edit', 'show', 'create']);
});
