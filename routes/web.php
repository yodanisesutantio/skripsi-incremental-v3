<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Controller;
use App\Http\Controllers\generalPage;
use App\Http\Controllers\loginController;
use App\Http\Controllers\adminController;
use App\Http\Controllers\courseController;
use App\Http\Controllers\paymentMethodController;

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
Route::get('/tamu', [generalPage::class, 'tamu'])->middleware('guest');

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
    // Admin Edit Account Info Logic Handler
    Route::post('/edit-admin-account-info', [adminController::class, 'editAccountInfo']);
    // Admin Edit Payment Method Logic Handler
    Route::post('/edit-admin-payment-method', [paymentMethodController::class, 'editPaymentMethod']);
    // Admin Remove Payment Method Logic Handler
    Route::post('/delete-admin-payment-method', [paymentMethodController::class, 'deletePaymentMethod'])->name('deletePaymentMethod');
    // Admin Edit Password Logic Handler
    Route::post('/edit-admin-password', [adminController::class, 'editPassword']);
    
    // Admin Check Availability Logic Handler
    Route::post('/check-availability', [adminController::class, 'checkAvailability'])->name('changeAvailability');

    // Admin Delete Account Logic Handler
    Route::delete('/admin-delete-account', [adminController::class, 'destroy'])->name('admin.account.destroy');

    // Admin's My Course Page
    Route::get('/admin-manage-course', [adminController::class, 'manageCourse']);
    // Admin's Create Course Page
    Route::get('/admin-manage-course/create', [adminController::class, 'createCoursePage']);
    // Admin's Create Course Logic Handler
    Route::post('/admin-manage-course/create', [courseController::class, 'createCourseLogic']);
    // Admin's Edit Course Page
    Route::get('/admin-manage-course/edit/{username}/{course_name}', [adminController::class, 'editCoursePage']);
    // Admin's Edit Course Logic Handler
    Route::post('/admin-manage-course/edit/{username}/{course_name}', [courseController::class, 'editCourseLogic']);
    // Admin's Delete Course Logic Handler
    Route::delete('/admin-delete-course/{id}', [courseController::class, 'deleteCourse']);

    // Admin Deactivate Course Switch Logic Handler
    Route::post('/admin-deactivate-course', [courseController::class, 'deactivateCourse']);
    // Admin Activate Course Switch Logic
    Route::post('/admin-activate-course', [courseController::class, 'activateCourse']);
});