<?php

use App\Http\Controllers\{
    ProfileController,
    HomeController,
    DashboardController,
    UserController,
    ViolationController,
    ApiViolationController,
    DepartmentController,
    RuleController,
    GenerationController,
    ClassController
};
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => view('welcome'));

// Home
Route::get('/home', [HomeController::class, 'index'])->middleware(['auth', 'verified'])->name('home');
Route::get('/home/{department}/{year}/{class}', [HomeController::class, 'filterStudents'])
    ->middleware(['auth', 'verified'])
    ->name('home.show');

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/dashboard/{department}/{year}/{class}', [DashboardController::class, 'show'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard.show');

// Users
Route::get('/users/{id}/details', [UserController::class, 'show']);

// Get Class
Route::get('/get-classes', [ClassController::class, 'getClasses']);

// API Violations
Route::get('/users/violations/{id}', [ApiViolationController::class, 'index']);
Route::post('/users/violations/{id}', [ApiViolationController::class, 'store']);
Route::delete('/users/violations/{id}', [ApiViolationController::class, 'destroy']);

// Departments, Generations, Classes
Route::get('/departments/list', [DepartmentController::class, 'list']);

// Rules & Violations (Resource Controllers)
Route::resource('/rules', RuleController::class)->middleware(['auth', 'verified']);
Route::resource('/violations', ViolationController::class)->middleware(['auth', 'verified']);
Route::resource('/classes', ClassController::class)->middleware(['auth', 'verified']);
Route::resource('/generations', GenerationController::class)->middleware(['auth', 'verified']);
Route::resource('/departments', DepartmentController::class)->middleware(['auth', 'verified']);
Route::resource('/users', UserController::class)->middleware(['auth', 'verified']);

// Profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
