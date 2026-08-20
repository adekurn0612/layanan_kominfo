<?php

use App\Http\Controllers\Admin\OrganizationController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\ServiceCategoryController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Admin\ServiceFieldController;
use App\Http\Controllers\Admin\ServiceRequirementController;
use App\Http\Controllers\Admin\TicketController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ServiceApplicationController;
use App\Http\Controllers\ServiceCatalogController;
use App\Http\Controllers\TicketLookupController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('welcome');
Route::view('/berita', 'news.coming-soon')->name('news.index');
Route::get('/cek-tiket', TicketLookupController::class)->name('tickets.lookup');
Route::get('/cek-tiket/{ticket:uuid}/qr', [TicketLookupController::class, 'qr'])->name('tickets.qr');
Route::get('/cek-tiket/{ticket:uuid}/qr/download', [TicketLookupController::class, 'downloadQr'])->name('tickets.qr.download');
Route::get('/cek-tiket/{ticket:uuid}/follow-ups/{followUp}/file', [TicketLookupController::class, 'downloadFollowUpFile'])
    ->middleware('auth')
    ->name('tickets.follow-ups.file');
Route::get('/services', [ServiceCatalogController::class, 'index'])->name('services.index');
Route::get('/services/categories/{category:code}', [ServiceCatalogController::class, 'category'])->name('services.categories.show');
Route::get('/services/{service}', [ServiceCatalogController::class, 'show'])->name('services.show');

Route::middleware('guest')->group(function (): void {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])->middleware('throttle:5,1');
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store'])->middleware('throttle:5,1');
});

Route::middleware('auth')->group(function (): void {
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::get('/services/{service}/apply', [ServiceApplicationController::class, 'create'])->name('services.apply');
    Route::post('/services/{service}/apply', [ServiceApplicationController::class, 'store'])->name('services.apply.store');

    Route::prefix('admin')->name('admin.')->middleware('can:view-admin')->group(function (): void {
        Route::resource('organizations', OrganizationController::class)->except(['show', 'destroy']);
        Route::get('users/{user}/reset-password', [UserController::class, 'editPassword'])->name('users.password.edit');
        Route::put('users/{user}/reset-password', [UserController::class, 'resetPassword'])->name('users.password.update');
        Route::resource('users', UserController::class)->except(['show', 'destroy']);
        Route::resource('roles', RoleController::class)->only(['index', 'edit', 'update']);
        Route::resource('permissions', PermissionController::class)->only(['index']);
        Route::resource('service-categories', ServiceCategoryController::class)->except(['show', 'destroy']);
        Route::resource('services', AdminServiceController::class)->except(['destroy']);
        Route::get('tickets', [TicketController::class, 'index'])->name('tickets.index');
        Route::get('tickets/{ticket}/edit', [TicketController::class, 'edit'])->name('tickets.edit');
        Route::put('tickets/{ticket}', [TicketController::class, 'update'])->name('tickets.update');
        Route::post('tickets/{ticket}/follow-ups', [TicketController::class, 'storeFollowUp'])->name('tickets.follow-ups.store');
        Route::get('tickets/{ticket}/follow-ups/{followUp}/file', [TicketController::class, 'downloadFollowUpFile'])->name('tickets.follow-ups.file');
        Route::get('services/{service}/fields/create', [ServiceFieldController::class, 'create'])->name('services.fields.create');
        Route::post('services/{service}/fields', [ServiceFieldController::class, 'store'])->name('services.fields.store');
        Route::get('services/{service}/fields/{field}/edit', [ServiceFieldController::class, 'edit'])->name('services.fields.edit');
        Route::put('services/{service}/fields/{field}', [ServiceFieldController::class, 'update'])->name('services.fields.update');
        Route::get('services/{service}/requirements/create', [ServiceRequirementController::class, 'create'])->name('services.requirements.create');
        Route::post('services/{service}/requirements', [ServiceRequirementController::class, 'store'])->name('services.requirements.store');
        Route::get('services/{service}/requirements/{requirement}/edit', [ServiceRequirementController::class, 'edit'])->name('services.requirements.edit');
        Route::put('services/{service}/requirements/{requirement}', [ServiceRequirementController::class, 'update'])->name('services.requirements.update');
    });
});
