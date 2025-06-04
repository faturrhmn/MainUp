<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\dashboard\DashboardController;
use App\Http\Controllers\data_barang\DataBarangController;
use App\Http\Controllers\pengaturan\PengaturanController;
use App\Http\Controllers\ruangan\RuanganController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\maintenance\MaintenanceController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\admin\UserController;

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
});

Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Protected Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    /*
    |--------------------------------------------------------------------------
    | Dashboard Routes
    |--------------------------------------------------------------------------
    */
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    /*
    |--------------------------------------------------------------------------
    | Admin Routes
    |--------------------------------------------------------------------------
    */
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::get('/create', [UserController::class, 'create'])->name('create');
            Route::post('/', [UserController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [UserController::class, 'edit'])->name('edit');
            Route::put('/{id}', [UserController::class, 'update'])->name('update');
            Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy');
        });
    });
    
    /*
    |--------------------------------------------------------------------------
    | Data Barang Routes
    |--------------------------------------------------------------------------
    */
    Route::prefix('data-barang')->name('data-barang.')->group(function () {
        Route::get('/', [DataBarangController::class, 'index'])->name('index');
        Route::get('/create', [DataBarangController::class, 'create'])->name('create');
        Route::post('/', [DataBarangController::class, 'store'])->name('store');
        Route::get('/{id}', [DataBarangController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [DataBarangController::class, 'edit'])->name('edit');
        Route::put('/{id}', [DataBarangController::class, 'update'])->name('update');
        Route::delete('/destroy-multiple', [DataBarangController::class, 'destroyMultiple'])->name('destroy-multiple');
    });
    
    /*
    |--------------------------------------------------------------------------
    | Ruangan Routes
    |--------------------------------------------------------------------------
    */
    Route::prefix('ruangan')->name('ruangan.')->group(function () {
        Route::get('/', [RuanganController::class, 'index'])->name('index');
        Route::get('/create', [RuanganController::class, 'create'])->name('create');
        Route::post('/', [RuanganController::class, 'store'])->name('store');
        Route::get('/{id_ruangan}/edit', [RuanganController::class, 'edit'])->name('edit');
        Route::put('/{id_ruangan}', [RuanganController::class, 'update'])->name('update');
        Route::delete('/destroy-multiple', [RuanganController::class, 'destroyMultiple'])->name('destroy-multiple');
        Route::get('/{id_ruangan}', [RuanganController::class, 'show'])->name('show');
    });

    /*
    |--------------------------------------------------------------------------
    | Maintenance Routes
    |--------------------------------------------------------------------------
    */
    Route::prefix('maintenance')->name('maintenance.')->group(function () {
        Route::get('/proses', [MaintenanceController::class, 'proses'])->name('proses');
        Route::get('/selesai', [MaintenanceController::class, 'selesai'])->name('selesai');
        Route::get('/{id}/edit', [MaintenanceController::class, 'edit'])->name('edit');
        Route::post('/', [MaintenanceController::class, 'store'])->name('store');
        Route::post('/before-image/delete-batch', [MaintenanceController::class, 'destroyBeforeImagesBatch'])->name('before_image.batch_destroy');
        Route::post('/after-image/delete-batch', [MaintenanceController::class, 'destroyAfterImagesBatch'])->name('after_image.batch_destroy');
        Route::get('/{id_maintenance}/detail', [MaintenanceController::class, 'detail'])->name('detail');
    });

    /*
    |--------------------------------------------------------------------------
    | Asset Routes
    |--------------------------------------------------------------------------
    */
    Route::get('/barang/{id}', [AssetController::class, 'show'])->name('detail-barang');

    /*
    |--------------------------------------------------------------------------
    | Pengaturan Routes
    |--------------------------------------------------------------------------
    */
    Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('pengaturan');

    /*
    |--------------------------------------------------------------------------
    | Export Routes
    |--------------------------------------------------------------------------
    */
    Route::prefix('export')->name('export.')->group(function () {
        Route::get('/maintenance/detail/{id_maintenance}', [ExportController::class, 'exportDetailMaintenance'])->name('maintenance.detail');
        Route::get('/maintenance', [ExportController::class, 'exportMaintenance'])->name('maintenance');
        Route::get('/before-images', [ExportController::class, 'exportBeforeImages'])->name('before-images');
        Route::get('/after-images', [ExportController::class, 'exportAfterImages'])->name('after-images');
        Route::get('/ruangan', [ExportController::class, 'exportRuangan'])->name('ruangan');
        Route::get('/assets', [ExportController::class, 'exportAssets'])->name('assets');
        Route::get('/assets/detail/{id}', [ExportController::class, 'exportAssetDetail'])->name('assets.detail');
    });

    // Add the account settings notifications route
    Route::get('/account-settings-notifications', [App\Http\Controllers\pages\AccountSettingsNotifications::class, 'index'])->name('pages-account-settings-notifications');
});