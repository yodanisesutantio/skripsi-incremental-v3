<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Controller;
use App\Http\Controllers\generalPage;
use App\Http\Controllers\loginController;
use App\Http\Controllers\adminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Landing Page
Route::get('/', [generalPage::class, 'landing']);

// Guest Dashboard Page
Route::get('/tamu', [generalPage::class, 'tamu']);

// About App Page
Route::get('/about-app', [generalPage::class, 'about']);

// Contact Us Page
Route::get('/contact-us', [generalPage::class, 'contact']);

// Login Page
Route::get('/login', [loginController::class, 'index'])->middleware('guest')->name('login');
// Login Logic Handler
Route::post('/login', [loginController::class, 'authenticate']);
// Logout Logic Handler
Route::post('/logout', [loginController::class, 'logout']);

// Admin Specific Route
Route::middleware(['auth', 'App\Http\Middleware\adminMiddleware'])->group(function () {
    // Admin Dashboard Page
    Route::get('/admin-index', [adminController::class, 'index']);
    // Admin Profile Page
    Route::get('/admin-profile', [adminController::class, 'profile']);
    // Admin Edit Profile Page
    Route::get('/admin-profile/edit', [adminController::class, 'editProfile']);
    // Admin Edit Profile Logic Handler
    Route::post('/admin-profile/edit', [adminController::class, 'update']);
    // Admin Delete Account Logic Handler
    Route::delete('/admin-delete-account', [adminController::class, 'destroy'])->name('admin.account.destroy');
});