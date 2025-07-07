<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CompanyWebController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Rutas para Compañías - Usando el controlador real
    Route::get('/companies', [CompanyWebController::class, 'index'])->name('companies.index');
    Route::post('/companies', [CompanyWebController::class, 'store'])->name('companies.store');
    Route::get('/companies/{id}', [CompanyWebController::class, 'show'])->name('companies.show');
    Route::put('/companies/{id}', [CompanyWebController::class, 'update'])->name('companies.update');
    Route::delete('/companies/{id}', [CompanyWebController::class, 'destroy'])->name('companies.destroy');
    
    // Rutas para Usuarios - Usando el controlador real
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    
    // Rutas para Facturas
    Route::get('/invoices', function () {
        return view('invoices.index');
    })->name('invoices.index');
    
    Route::get('/invoices/create', function () {
        return view('invoices.create');
    })->name('invoices.create');
    
    // Rutas para Reportes
    Route::get('/reports', function () {
        return view('reports.index');
    })->name('reports.index');
});

require __DIR__.'/auth.php';