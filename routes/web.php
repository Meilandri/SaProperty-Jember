<?php

use App\Http\Controllers\Admin\CatalogItemController as AdminCatalogController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProjectController as AdminProjectController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

// Publik
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::view('/tentang-kami', 'pages.about')->name('about');
Route::view('/kontak', 'pages.contact')->name('contact');

Route::get('/katalog', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/katalog/{slug}', [CatalogController::class, 'show'])->name('catalog.show');

Route::get('/proyek', [ProjectController::class, 'index'])->name('projects.index');
Route::get('/proyek/{slug}', [ProjectController::class, 'show'])->name('projects.show');

// Login
Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'store'])->middleware('throttle:5,1')->name('login.store');
Route::post('/logout', [LoginController::class, 'destroy'])->middleware('auth')->name('logout');

// Admin
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('katalog', AdminCatalogController::class)
        ->except('show')->parameters(['katalog' => 'item'])->names('catalog');

    Route::resource('proyek', AdminProjectController::class)
        ->except('show')->parameters(['proyek' => 'project'])->names('projects');

    Route::resource('kategori', CategoryController::class)
        ->only(['index', 'store', 'update', 'destroy'])
        ->parameters(['kategori' => 'category'])->names('categories');

    Route::get('/pengaturan/{group}', [SettingController::class, 'edit'])->name('settings.edit');
    Route::put('/pengaturan/{group}', [SettingController::class, 'update'])->name('settings.update');
});