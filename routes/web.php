<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\dashboard\Analytics;
use App\Http\Controllers\layouts\WithoutMenu;
use App\Http\Controllers\layouts\WithoutNavbar;
use App\Http\Controllers\layouts\Fluid;
use App\Http\Controllers\layouts\Container;
use App\Http\Controllers\layouts\Blank;
use App\Http\Controllers\pages\AccountSettingsAccount;
use App\Http\Controllers\pages\AccountSettingsNotifications;
use App\Http\Controllers\pages\AccountSettingsConnections;
use App\Http\Controllers\pages\MiscError;
use App\Http\Controllers\pages\MiscUnderMaintenance;
use App\Http\Controllers\authentications\LoginBasic;
use App\Http\Controllers\authentications\RegisterBasic;
use App\Http\Controllers\authentications\ForgotPasswordBasic;
use App\Http\Controllers\cards\CardBasic;
use App\Http\Controllers\user_interface\Accordion;
use App\Http\Controllers\user_interface\Alerts;
use App\Http\Controllers\user_interface\Badges;
use App\Http\Controllers\user_interface\Buttons;
use App\Http\Controllers\user_interface\Carousel;
use App\Http\Controllers\user_interface\Collapse;
use App\Http\Controllers\user_interface\Dropdowns;
use App\Http\Controllers\user_interface\Footer;
use App\Http\Controllers\user_interface\ListGroups;
use App\Http\Controllers\user_interface\Modals;
use App\Http\Controllers\user_interface\Navbar;
use App\Http\Controllers\user_interface\Offcanvas;
use App\Http\Controllers\user_interface\PaginationBreadcrumbs;
use App\Http\Controllers\user_interface\Progress;
use App\Http\Controllers\user_interface\Spinners;
use App\Http\Controllers\user_interface\TabsPills;
use App\Http\Controllers\user_interface\Toasts;
use App\Http\Controllers\user_interface\TooltipsPopovers;
use App\Http\Controllers\user_interface\Typography;
use App\Http\Controllers\extended_ui\PerfectScrollbar;
use App\Http\Controllers\extended_ui\TextDivider;
use App\Http\Controllers\icons\Boxicons;
use App\Http\Controllers\form_elements\BasicInput;
use App\Http\Controllers\form_elements\InputGroups;
use App\Http\Controllers\form_layouts\VerticalForm;
use App\Http\Controllers\form_layouts\HorizontalForm;
use App\Http\Controllers\tables\Basic as TablesBasic;
use App\Http\Controllers\dashboard\DashboardController;
use App\Http\Controllers\data_barang\DataBarangController;
use App\Http\Controllers\pengaturan\PengaturanController;
use App\Http\Controllers\ruangan\RuanganController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\maintenance\MaintenanceController;
use App\Http\Controllers\ExportController;


// Main Page Route
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// layout
Route::get('/layouts/without-menu', [WithoutMenu::class, 'index'])->name('layouts-without-menu');
Route::get('/layouts/without-navbar', [WithoutNavbar::class, 'index'])->name('layouts-without-navbar');
Route::get('/layouts/fluid', [Fluid::class, 'index'])->name('layouts-fluid');
Route::get('/layouts/container', [Container::class, 'index'])->name('layouts-container');
Route::get('/layouts/blank', [Blank::class, 'index'])->name('layouts-blank');

// pages
Route::get('/pages/account-settings-account', [AccountSettingsAccount::class, 'index'])->name('pages-account-settings-account')->middleware('auth');
Route::get('/pages/account-settings-notifications', [AccountSettingsNotifications::class, 'index'])->name('pages-account-settings-notifications');
Route::get('/pages/account-settings-connections', [AccountSettingsConnections::class, 'index'])->name('pages-account-settings-connections');
Route::get('/pages/misc-error', [MiscError::class, 'index'])->name('pages-misc-error');
Route::get('/pages/misc-under-maintenance', [MiscUnderMaintenance::class, 'index'])->name('pages-misc-under-maintenance');

// authentication
Route::get('/auth/login-basic', [LoginBasic::class, 'index'])->name('auth-login-basic');
Route::get('/auth/register-basic', [RegisterBasic::class, 'index'])->name('auth-register-basic');
Route::get('/auth/forgot-password-basic', [ForgotPasswordBasic::class, 'index'])->name('auth-reset-password-basic');

// cards
Route::get('/cards/basic', [CardBasic::class, 'index'])->name('cards-basic');

// User Interface
Route::get('/ui/accordion', [Accordion::class, 'index'])->name('ui-accordion');
Route::get('/ui/alerts', [Alerts::class, 'index'])->name('ui-alerts');
Route::get('/ui/badges', [Badges::class, 'index'])->name('ui-badges');
Route::get('/ui/buttons', [Buttons::class, 'index'])->name('ui-buttons');
Route::get('/ui/carousel', [Carousel::class, 'index'])->name('ui-carousel');
Route::get('/ui/collapse', [Collapse::class, 'index'])->name('ui-collapse');
Route::get('/ui/dropdowns', [Dropdowns::class, 'index'])->name('ui-dropdowns');
Route::get('/ui/footer', [Footer::class, 'index'])->name('ui-footer');
Route::get('/ui/list-groups', [ListGroups::class, 'index'])->name('ui-list-groups');
Route::get('/ui/modals', [Modals::class, 'index'])->name('ui-modals');
Route::get('/ui/navbar', [Navbar::class, 'index'])->name('ui-navbar');
Route::get('/ui/offcanvas', [Offcanvas::class, 'index'])->name('ui-offcanvas');
Route::get('/ui/pagination-breadcrumbs', [PaginationBreadcrumbs::class, 'index'])->name('ui-pagination-breadcrumbs');
Route::get('/ui/progress', [Progress::class, 'index'])->name('ui-progress');
Route::get('/ui/spinners', [Spinners::class, 'index'])->name('ui-spinners');
Route::get('/ui/tabs-pills', [TabsPills::class, 'index'])->name('ui-tabs-pills');
Route::get('/ui/toasts', [Toasts::class, 'index'])->name('ui-toasts');
Route::get('/ui/tooltips-popovers', [TooltipsPopovers::class, 'index'])->name('ui-tooltips-popovers');
Route::get('/ui/typography', [Typography::class, 'index'])->name('ui-typography');

// extended ui
Route::get('/extended/ui-perfect-scrollbar', [PerfectScrollbar::class, 'index'])->name('extended-ui-perfect-scrollbar');
Route::get('/extended/ui-text-divider', [TextDivider::class, 'index'])->name('extended-ui-text-divider');

// icons
Route::get('/icons/boxicons', [Boxicons::class, 'index'])->name('icons-boxicons');

// form elements
Route::get('/forms/basic-inputs', [BasicInput::class, 'index'])->name('forms-basic-inputs');
Route::get('/forms/input-groups', [InputGroups::class, 'index'])->name('forms-input-groups');

// form layouts
Route::get('/form/layouts-vertical', [VerticalForm::class, 'index'])->name('form-layouts-vertical');
Route::get('/form/layouts-horizontal', [HorizontalForm::class, 'index'])->name('form-layouts-horizontal');

// tables
Route::get('/tables/basic', [TablesBasic::class, 'index'])->name('tables-basic');

// data barang
Route::get('/data-barang', [DataBarangController::class, 'index'])->name('data-barang');
Route::get('/data-barang/create', [DataBarangController::class, 'create'])->name('data-barang.create');
Route::post('/data-barang', [DataBarangController::class, 'store'])->name('data-barang.store');
Route::get('/data-barang/{id}', [DataBarangController::class, 'show'])->name('data-barang.show');
Route::get('/data-barang/{id}/edit', [DataBarangController::class, 'edit'])->name('data-barang.edit');
Route::put('/data-barang/{id}', [DataBarangController::class, 'update'])->name('data-barang.update');
Route::delete('/data-barang/destroy-multiple', [DataBarangController::class, 'destroyMultiple'])->name('data-barang.destroy-multiple');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
});

Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware(['auth'])->group(function () {
    // Main Page Route
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // data barang
    Route::get('/data-barang', [DataBarangController::class, 'index'])->name('data-barang');
    Route::get('/data-barang/create', [DataBarangController::class, 'create'])->name('data-barang.create');
    Route::post('/data-barang', [DataBarangController::class, 'store'])->name('data-barang.store');
    Route::get('/data-barang/{id}', [DataBarangController::class, 'show'])->name('data-barang.show');
    Route::get('/data-barang/{id}/edit', [DataBarangController::class, 'edit'])->name('data-barang.edit');
    Route::put('/data-barang/{id}', [DataBarangController::class, 'update'])->name('data-barang.update');
    Route::delete('/data-barang/destroy-multiple', [DataBarangController::class, 'destroyMultiple'])->name('data-barang.destroy-multiple');
    
    // Add other protected routes here...
});

// Admin Routes
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('users', App\Http\Controllers\Admin\UserController::class);
});

// Pengaturan Route
Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('pengaturan')->middleware('auth');


Route::get('/ruangan', [RuanganController::class, 'index'])->name('ruangan.index');
Route::get('/ruangan/create', [RuanganController::class, 'create'])->name('ruangan.create');
Route::post('/ruangan', [RuanganController::class, 'store'])->name('ruangan.store');
Route::get('ruangan/{id_ruangan}/edit', [RuanganController::class, 'edit'])->name('ruangan.edit');
Route::put('ruangan/{id_ruangan}', [RuanganController::class, 'update'])->name('ruangan.update');
Route::delete('/ruangan/destroy-multiple', [RuanganController::class, 'destroyMultiple'])->name('ruangan.destroy-multiple');
Route::get('ruangan/{id_ruangan}', [RuanganController::class, 'show'])->name('ruangan.show');

Route::get('/barang/{id}', [AssetController::class, 'show'])->name('detail-barang');


Route::get('/maintenance/proses', [MaintenanceController::class, 'proses'])->name('maintenance.proses');
Route::get('/maintenance/selesai', [MaintenanceController::class, 'selesai'])->name('maintenance.selesai');
Route::get('/maintenance/{id}/edit', [MaintenanceController::class, 'edit'])->name('maintenance.edit');
Route::post('/maintenance', [MaintenanceController::class, 'store'])->name('maintenance.store');

// routes/web.php

Route::post('/maintenance/before-image/delete-batch', [MaintenanceController::class, 'destroyBeforeImagesBatch'])->name('maintenance.before_image.batch_destroy');

Route::post('/maintenance/after-image/delete-batch', [MaintenanceController::class, 'destroyAfterImagesBatch'])->name('maintenance.after_image.batch_destroy');

Route::get('/maintenance/{id_maintenance}/detail', [MaintenanceController::class, 'detail'])
     ->name('maintenance.detail');

Route::get('/export/maintenance/detail/{id_maintenance}', [ExportController::class, 'exportDetailMaintenance'])->name('export.maintenance.detail');

// Export Routes
Route::get('/export/users', [ExportController::class, 'exportUsers'])->name('export.users');
Route::get('/export/roles', [ExportController::class, 'exportRoles'])->name('export.roles');
Route::get('/export/ruangan', [ExportController::class, 'exportRuangan'])->name('export.ruangan');
Route::get('/export/jadwal', [ExportController::class, 'exportJadwal'])->name('export.jadwal');
Route::get('/export/maintenance', [ExportController::class, 'exportMaintenance'])->name('export.maintenance');
Route::get('/export/assets', [ExportController::class, 'exportAssets'])->name('export.assets');
Route::get('/export/before-images', [ExportController::class, 'exportBeforeImages'])->name('export.before-images');
Route::get('/export/after-images', [ExportController::class, 'exportAfterImages'])->name('export.after-images');