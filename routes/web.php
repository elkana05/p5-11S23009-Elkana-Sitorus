<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Livewire\TodoDetailLivewire;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('auth.login');
});

Route::name('auth.')->prefix('auth')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware('check.auth')->name('app.')->prefix('app')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/todo/{todo_id}', TodoDetailLivewire::class)->name('todo.detail');
});