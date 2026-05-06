<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing', [
        'siteData' => SiteSetting::toKeyValueMap()->all(),
    ]);
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    Route::get('/dashboard/branding', [DashboardController::class, 'branding'])->name('dashboard.branding');
    Route::post('/dashboard/branding', [DashboardController::class, 'updateBranding'])->name('dashboard.branding.update');

    Route::get('/dashboard/home', [DashboardController::class, 'home'])->name('dashboard.home');
    Route::post('/dashboard/home', [DashboardController::class, 'updateHome'])->name('dashboard.home.update');

    Route::get('/dashboard/about', [DashboardController::class, 'about'])->name('dashboard.about');
    Route::post('/dashboard/about', [DashboardController::class, 'updateAbout'])->name('dashboard.about.update');

    Route::get('/dashboard/contact', [DashboardController::class, 'contact'])->name('dashboard.contact');
    Route::post('/dashboard/contact', [DashboardController::class, 'updateContact'])->name('dashboard.contact.update');

    Route::get('/dashboard/stats', [DashboardController::class, 'stats'])->name('dashboard.stats');
    Route::post('/dashboard/stats', [DashboardController::class, 'updateStats'])->name('dashboard.stats.update');

    Route::get('/dashboard/footer', [DashboardController::class, 'footer'])->name('dashboard.footer');
    Route::post('/dashboard/footer', [DashboardController::class, 'updateFooter'])->name('dashboard.footer.update');

    Route::get('/dashboard/core-services', [DashboardController::class, 'coreServices'])->name('dashboard.core-services');
    Route::post('/dashboard/core-services', [DashboardController::class, 'updateCoreServices'])->name('dashboard.core-services.update');

    Route::get('/dashboard/products', [DashboardController::class, 'products'])->name('dashboard.products');
    Route::post('/dashboard/products', [DashboardController::class, 'updateProducts'])->name('dashboard.products.update');

    Route::get('/dashboard/clients', [DashboardController::class, 'clients'])->name('dashboard.clients');
    Route::post('/dashboard/clients', [DashboardController::class, 'updateClients'])->name('dashboard.clients.update');
    Route::post('/dashboard/clients/logo', [DashboardController::class, 'uploadClientLogo'])->name('dashboard.clients.upload-logo');

    Route::get('/dashboard/blog', [DashboardController::class, 'blog'])->name('dashboard.blog');
    Route::post('/dashboard/blog', [DashboardController::class, 'updateBlog'])->name('dashboard.blog.update');
    Route::post('/dashboard/blog/image', [DashboardController::class, 'uploadBlogImage'])->name('dashboard.blog.upload-image');

    Route::get('/dashboard/leads', [DashboardController::class, 'leads'])->name('dashboard.leads');
    Route::post('/logout', [AuthController::class, 'logout']);
});
