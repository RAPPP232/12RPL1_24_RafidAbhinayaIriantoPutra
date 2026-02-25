<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PartController;
use App\Http\Controllers\OperatorController;
use App\Http\Controllers\ProductionController;
use App\Http\Controllers\QCInspectionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin Only Routes
    Route::middleware('role:admin')->group(function () {
        // Parts Management
        Route::resource('parts', PartController::class);
        
        // Operators Management
        Route::resource('operators', OperatorController::class);
        
        // Users Management
        Route::resource('users', UserController::class);
        
        // Reports
        Route::get('/reports/export-pdf', [ReportController::class, 'exportPdf'])->name('reports.export-pdf');
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    });

    // Operator Routes
    Route::middleware('role:operator,admin')->group(function () {
        Route::resource('productions', ProductionController::class)->except(['destroy']);
        Route::patch('/productions/{production}/status', [ProductionController::class, 'updateStatus'])
            ->name('productions.updateStatus');
    });

    // QC Inspector Routes
    Route::middleware('role:qc_inspector,admin')->group(function () {
        Route::resource('qc-inspections', QCInspectionController::class)->only(['index', 'create', 'store', 'show']);
    });

    // Shared Routes (All roles can view)
    Route::get('/productions/{production}', [ProductionController::class, 'show'])->name('productions.show');
});

require __DIR__.'/auth.php';
