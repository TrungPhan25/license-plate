<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ViolationController;
use App\Http\Controllers\Admin\ViolationExportController;
use App\Http\Controllers\Admin\ImageUploadController;
use App\Models\Violation;

// Home page - redirect to dashboard
Route::get('/', function () {
    return redirect('/dashboard');
});

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Admin Routes (Protected by auth middleware)
Route::middleware(['auth'])->group(function () {
    // Dashboard page with search functionality
    Route::get('/dashboard', function () {
        $violations = null;
        
        if (request('license_plate')) {
            $licensePlate = trim(request('license_plate'));
            $violations = Violation::byLicensePlate($licensePlate)
                ->orderBy('violation_date', 'desc')
                ->get();
        }
        
        return view('pages.dashboard', compact('violations'));
    })->name('dashboard');

    // Admin Users Routes
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('users', UserController::class);
        
        // Additional User Routes
        Route::put('users/{id}/restore', [UserController::class, 'restore'])->name('users.restore');
        Route::delete('users/{id}/force-delete', [UserController::class, 'forceDelete'])->name('users.force-delete');
        
        // Violations Routes
        Route::resource('violations', ViolationController::class);
        
        // Violations Export Routes
        Route::get('violations-export', [ViolationExportController::class, 'index'])->name('violations.export.index');
        Route::get('violations-export/download', [ViolationExportController::class, 'export'])->name('violations.export');
        Route::get('violations-export/count', [ViolationExportController::class, 'count'])->name('violations.export.count');
        
        // Additional Violation Routes
        Route::get('violations/trash/list', [ViolationController::class, 'trash'])->name('violations.trash');
        Route::put('violations/{id}/restore', [ViolationController::class, 'restore'])->name('violations.restore');
        Route::delete('violations/{id}/force-delete', [ViolationController::class, 'forceDelete'])->name('violations.force-delete');

        // Async Image Upload Routes
        Route::post('upload/image', [ImageUploadController::class, 'upload'])->name('upload.image');
        Route::delete('upload/image', [ImageUploadController::class, 'delete'])->name('upload.image.delete');
    });
});
