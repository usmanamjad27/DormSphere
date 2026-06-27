<?php

use App\Http\Controllers\Admin\AnnouncementController as AdminAnnouncementController;
use App\Http\Controllers\Admin\ApplicationController as AdminApplicationController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DormController;
use App\Http\Controllers\Admin\MaintenanceController as AdminMaintenanceController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\ResidentController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\HouseRuleController;
use App\Http\Controllers\Student\ApplicationController as StudentApplicationController;
use App\Http\Controllers\Student\MaintenanceController as StudentMaintenanceController;
use App\Http\Controllers\Student\ProfileController as StudentProfileController;
use App\Http\Controllers\Student\AuthController as StudentAuthController;
use App\Services\GooglePlaceImageService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;

Route::get('/', function (GooglePlaceImageService $googleImages) {
    $heroImage = Cache::remember('welcome_hero_image', now()->addHours(24), function () use ($googleImages) {
        return $googleImages->heroImage();
    });

    return view('welcome', compact('heroImage'));
})->name('home');

Route::prefix('admin')->group(function () {
    Route::middleware('guest.admin')->group(function () {
        Route::get('login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
        Route::post('login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
    });
    Route::post('logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

    Route::middleware(['auth.admin'])->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::resource('dorms', DormController::class)->names('admin.dorms');
        Route::resource('rooms', RoomController::class)->names('admin.rooms');
        Route::resource('applications', AdminApplicationController::class)->names('admin.applications');
        Route::resource('residents', ResidentController::class)->names('admin.residents');
        Route::resource('maintenance', AdminMaintenanceController::class)->names('admin.maintenance');
        Route::resource('announcements', AdminAnnouncementController::class)->names('admin.announcements');
        Route::resource('house-rules', HouseRuleController::class)->names('admin.house-rules');
        Route::get('reports', [ReportController::class, 'index'])->name('admin.reports');
        Route::get('profile', [AdminProfileController::class, 'show'])->name('admin.profile');
        Route::put('profile', [AdminProfileController::class, 'update'])->name('admin.profile.update');
    });
});

Route::prefix('student')->group(function () {
    Route::middleware('guest.student')->group(function () {
        Route::get('register', [StudentAuthController::class, 'showRegistrationForm'])->name('student.register');
        Route::post('register', [StudentAuthController::class, 'register'])->name('student.register.submit');
        Route::get('login', [StudentAuthController::class, 'showLoginForm'])->name('student.login');
        Route::post('login', [StudentAuthController::class, 'login'])->name('student.login.submit');
        Route::get('forgot-password', [StudentAuthController::class, 'showForgotPasswordForm'])->name('password.request');
        Route::post('forgot-password', [StudentAuthController::class, 'sendPasswordResetLink'])->name('password.email');
        Route::get('reset-password/{token}', [StudentAuthController::class, 'showResetForm'])->name('password.reset');
        Route::post('reset-password', [StudentAuthController::class, 'resetPassword'])->name('password.update');
    });
    Route::post('logout', [StudentAuthController::class, 'logout'])->name('student.logout');

    Route::middleware(['auth.student'])->group(function () {
        Route::get('dashboard', [StudentApplicationController::class, 'dashboard'])->name('student.dashboard');
        Route::get('apply', [StudentApplicationController::class, 'create'])->name('student.apply');
        Route::get('apply/dorms/{dorm}/preview', [StudentApplicationController::class, 'dormPreview'])->name('student.apply.dorm-preview');
        Route::get('apply/estimate-price', [StudentApplicationController::class, 'estimatePrice'])->name('student.apply.estimate-price');
        Route::post('apply', [StudentApplicationController::class, 'store'])->name('student.apply.submit');
        Route::get('application', [StudentApplicationController::class, 'show'])->name('student.application');
        Route::delete('application', [StudentApplicationController::class, 'destroy'])->name('student.application.withdraw');
        Route::get('room', [StudentApplicationController::class, 'room'])->name('student.room');
        Route::resource('maintenance', StudentMaintenanceController::class)->names('student.maintenance');
        Route::get('notices', [StudentApplicationController::class, 'notices'])->name('student.notices');
        Route::get('house-rules', [StudentApplicationController::class, 'houseRules'])->name('student.house-rules');
        Route::get('profile', [StudentProfileController::class, 'show'])->name('student.profile');
        Route::put('profile', [StudentProfileController::class, 'update'])->name('student.profile.update');
    });
});
