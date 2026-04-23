<?php

use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LinkController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\PublicPortfolioController;
use Illuminate\Support\Facades\Route;

/* ================================================================
 | ROTAS PÚBLICAS — Landing Page do Portfólio
 * ================================================================ */
Route::get('/', [PublicPortfolioController::class, 'home'])->name('home');
Route::get('/l/{link}', [PublicPortfolioController::class, 'trackLink'])->name('links.track');

/* ================================================================
 | ROTAS AUTENTICADAS (área administrativa)
 * ================================================================ */
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', DashboardController::class)->name('dashboard');

    // Links (Linktree)
    Route::get   ('/links',             [LinkController::class, 'index'  ])->name('links.index');
    Route::post  ('/links',             [LinkController::class, 'store'  ])->name('links.store');
    Route::put   ('/links/{link}',      [LinkController::class, 'update' ])->name('links.update');
    Route::delete('/links/{link}',      [LinkController::class, 'destroy'])->name('links.destroy');
    Route::post  ('/links/reorder',     [LinkController::class, 'reorder'])->name('links.reorder');

    // Projects
    Route::get   ('/projects',              [ProjectController::class, 'index'  ])->name('projects.index');
    Route::post  ('/projects',              [ProjectController::class, 'store'  ])->name('projects.store');
    Route::post  ('/projects/{project}',    [ProjectController::class, 'update' ])->name('projects.update'); // POST p/ aceitar upload
    Route::delete('/projects/{project}',    [ProjectController::class, 'destroy'])->name('projects.destroy');

    // Profile (dono do portfólio)
    Route::get ('/profile', [AdminProfileController::class, 'edit'  ])->name('profile.edit');
    Route::post('/profile', [AdminProfileController::class, 'update'])->name('profile.update');

    // Banner
    Route::get   ('/banner', [BannerController::class, 'edit'   ])->name('banner.edit');
    Route::post  ('/banner', [BannerController::class, 'update' ])->name('banner.update');
    Route::delete('/banner', [BannerController::class, 'destroy'])->name('banner.destroy');
});

// Redirect legacy /dashboard -> /admin.
// Precisa do nome 'dashboard' para que o Wayfinder gere o export
// `dashboard` em resources/js/routes (usado por Dashboard.vue, Welcome.vue, AppSidebar.vue).
Route::middleware(['auth', 'verified'])
    ->get('/dashboard', fn () => redirect()->route('admin.dashboard'))
    ->name('dashboard');

require __DIR__.'/settings.php';
