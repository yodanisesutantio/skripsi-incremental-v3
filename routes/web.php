<?php

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\generalPage;
use App\Http\Controllers\userController;
use App\Http\Controllers\adminController;
use App\Http\Controllers\systemController;
use App\Http\Controllers\loginController;
use App\Http\Controllers\courseController;
use App\Http\Controllers\enrollmentController;
use App\Http\Controllers\instructorController;
use App\Http\Controllers\paymentMethodController;
use App\Http\Controllers\coursePaymentsController;
use App\Http\Controllers\CourseScheduleController;
use App\Http\Controllers\drivingSchoolLicenseController;
use App\Http\Controllers\InstructorCertificateController;

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

// Clear Cache
Route::get('/bersihkan', function() {
    $exitCode = Artisan::call('config:clear');
    $exitCode = Artisan::call('route:clear');
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('config:cache');
    $exitCode = Artisan::call('route:cache');
    return 'DONE';
});

// Landing Page
Route::get('/', [generalPage::class, 'landing']);

// Search Page
Route::get('/search', [generalPage::class, 'searchPage']);
// Search Results Page
Route::get('/search/results', [generalPage::class, 'searchResult'])->name('search.results');
// Delete Search History Query
Route::delete('/search-history/{id}', [generalPage::class, 'deleteSearchHistoryItem'])->name('search.history.delete');

// Guest Dashboard Page
Route::get('/tamu', [generalPage::class, 'tamu'])->middleware('guest');

// About App Page
Route::get('/about-app', [generalPage::class, 'about']);

// Contact Us Page
Route::get('/contact-us', [generalPage::class, 'contact']);

// Login Page
Route::get('/login', [loginController::class, 'loginPage'])->middleware('guest')->name('login');
// Login Logic Handler
Route::post('/login', [loginController::class, 'authenticate']);
// Logout Logic Handler
Route::post('/logout', [loginController::class, 'logout']);
// Forgot Password Initial Page
Route::get('/forgot-password', [generalPage::class, 'forgotPasswordPage'])->middleware('guest');
// Forgot Password Challenge Page Using Username
Route::get('/forgot-password/username/{username}', [generalPage::class, 'forgotPasswordUsername'])->middleware('guest');
// Forgot Password Challenge Page Using Phone Number
Route::get('/forgot-password/phone/{phone_number}', [generalPage::class, 'forgotPasswordPhoneNumber'])->middleware('guest');
// Check the Answer from the Password Challenge Page
Route::post('/password-challenge/{username}', [generalPage::class, 'passwordChallenge'])->middleware('guest');
// Reset Password Page
Route::get('/reset-password/{username}', [generalPage::class, 'resetPasswordForm'])->middleware('guest')->name('reset-password');
// Reset Password Logic Handler
Route::post('/reset-password/{username}', [userController::class, 'resetPassword'])->middleware('guest');
// Register Page
Route::get('/register', [loginController::class, 'registerPage'])->middleware('guest')->name('register');
// Register Logic Handler
Route::post('/register', [loginController::class, 'registerAccount']);

// Guest / Student Access Course Details Page
Route::get('/course/{course_name}/{course_id}', [generalPage::class, 'courseDetailsPage']);
// Guest / Student Access Admin Course List Page
Route::get('/course/{admin_username}', [generalPage::class, 'drivingSchoolCoursePage']);

// Admin Specific Route
Route::middleware(['auth', 'App\Http\Middleware\adminMiddleware'])->group(function () {
    // Admin Dashboard Page
    Route::get('/admin-index', [adminController::class, 'indexPage']);
    // Admin Course Page
    Route::get('/admin-course', [adminController::class, 'coursePage']);
    // Admin Profile Page
    Route::get('/admin-profile', [adminController::class, 'profilePage']);

    // Admin License Page
    Route::get('/admin-driving-school-license', [adminController::class, 'drivingSchoolLicensePage']);
    // Admin Upload License Form
    Route::get('/admin-driving-school-license/create', [adminController::class, 'drivingSchoolLicenseForm']);
    // Admin Upload License Form Logic Handler
    Route::post('/admin-driving-school-license/create', [DrivingSchoolLicenseController::class, 'drivingSchoolLicenseCreate']);
    // Admin's Delete License Logic Handler
    Route::delete('/admin-delete-driving-school-license/{id}', [DrivingSchoolLicenseController::class, 'drivingSchoolLicenseDelete']);    

    // Admin Edit Profile Page
    Route::get('/admin-profile/edit', [adminController::class, 'editProfilePage']);
    // Admin Edit Account Info Logic Handler
    Route::post('/edit-admin-account-info', [adminController::class, 'editAccountInfo']);
    // Admin Edit Payment Method Logic Handler
    Route::post('/edit-admin-payment-method', [paymentMethodController::class, 'editPaymentMethod']);
    // Admin Remove Payment Method Logic Handler
    Route::post('/delete-admin-payment-method', [paymentMethodController::class, 'deletePaymentMethod'])->name('deletePaymentMethod');
    // Admin Edit Password Logic Handler
    Route::post('/edit-admin-password', [adminController::class, 'editPassword']);
    
    // Admin Check Availability Logic Handler
    Route::post('/change-availability', [adminController::class, 'changeAvailability'])->name('changeAvailability');
    // Admin Delete Account Logic Handler
    Route::delete('/admin-delete-account', [adminController::class, 'destroy'])->name('admin.account.destroy');

    // Admin's My Course Page
    Route::get('/admin-manage-course', [adminController::class, 'manageCoursePage']);
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
    // Admin Activate Course Switch Logic Handler
    Route::post('/admin-activate-course', [courseController::class, 'activateCourse']);

    // Admin's My Instructor Page
    Route::get('/admin-manage-instructor', [adminController::class, 'manageInstructorPage']);
    // Admin's Create Instructor Page
    Route::get('/admin-manage-instructor/create', [adminController::class, 'createInstructorPage']);
    // Admin's Create Instructor Logic Handler
    Route::post('/admin-manage-instructor/create', [instructorController::class, 'createInstructorLogic']);
    // Admin's Delete Instructor Logic Handler
    Route::delete('/admin-delete-instructor/{id}', [instructorController::class, 'deleteInstructor']);
    // Admin Deactivate Instructor Switch Logic Handler
    Route::post('/admin-deactivate-instructor', [instructorController::class, 'deactivateInstructor']);
    // Admin Activate Instructor Switch Logic Handler
    Route::post('/admin-activate-instructor', [instructorController::class, 'activateInstructor']);

    // Admin's Course Details Preview
    Route::get('/admin-course/{course_name}/{course_id}', [adminController::class, 'courseDetailsPreview']);
    // Admin's Active Student List
    Route::get('/admin-course/active-student-list', [adminController::class, 'activeStudentPage']);
    // Admin's View Course Progress Detail Page
    Route::get('/admin-course-progress/{student_real_name}/{enrollment_id}', [adminController::class, 'courseProgressPage']);
    // Admin's Access Registration Form
    Route::get('/admin-course/registration-form/{student_real_name}/{enrollment_id}', [adminController::class, 'registrationForm']);
    // Admin's Propose New Schedule Form
    Route::get('/admin-course/new-schedule/schedule/{course_schedule_id}', [adminController::class, 'newScheduleForm']);
    // Admin's Propose New Schedule Form
    Route::post('/admin-course/new-schedule/{course_schedule_id}', [CourseScheduleController::class, 'proposeNewSchedule']);
    // Admin's Verify Payment 
    Route::get('/admin-course/payment-verification/{student_real_name}/{enrollment_id}', [adminController::class, 'paymentVerification']);
    // Admin's Verify Payment Logic Handler
    Route::post('/verify-payment/{coursePayment_id}', [coursePaymentsController::class, 'verifyPaymentLogic']);
    // Admin's Unverify Payment Logic Handler
    Route::post('/unverify-payment/{coursePayment_id}', [coursePaymentsController::class, 'unverifyPaymentLogic']);
    // Admin's Delete Active Student Logic Handler
    Route::delete('/delete-student', [enrollmentController::class, 'deleteStudent']);
});

// System Admin Specific Route
Route::middleware(['auth', 'App\Http\Middleware\sysAdminMiddleware'])->group(function () {
    // System Admin Dashboard Manage Account Page
    Route::get('/sysAdmin-index', [systemController::class, 'systemIndex']);
    // Reset Account Password Page 
    Route::post('/sysAdmin-reset-password/{id}', [systemController::class, 'resetPassword']);
    // System Admin Manage Instructor Certificate Page
    Route::get('/sysAdmin-certificate', [systemController::class, 'certificatePage']);
    // System Admin Update Certificate Status of Instructor Certificate Logic Handler
    Route::post('/sysAdmin-certificate/status/{id}', [systemController::class, 'updateCertificateStatus']);
    // System Admin Delete Instructor Certificate Logic Handler
    Route::delete('/sysAdmin-certificate/delete/{id}', [systemController::class, 'deleteCertificate']);
    // System Admin Manage Driving School License Page
    Route::get('/sysAdmin-license', [systemController::class, 'licensePage']);
    // System Admin Update Status of Driving School Licenses Logic Handler
    Route::post('/sysAdmin-license/status/{id}', [systemController::class, 'updateLicenseStatus']);
    // System Admin Delete Driving School Licenses Logic Handler
    Route::delete('/sysAdmin-license/delete/{id}', [systemController::class, 'deleteLicense']);
});

// Instructor Specific Route
Route::middleware(['auth', 'App\Http\Middleware\instructorMiddleware'])->group(function () {
    // Instructor Dashboard Page
    Route::get('/instructor-index', [instructorController::class, 'instructorIndex']);
    // Instructor Course Page
    Route::get('/instructor-course', [instructorController::class, 'instructorCoursePage']);
    // Instructor Profile Page
    Route::get('/instructor-profile', [instructorController::class, 'instructorProfile']);

    // Instructor Edit Profile Page
    Route::get('/instructor-profile/edit', [instructorController::class, 'editProfilePage']);
    // Instructor Edit Account Info Logic Handler
    Route::post('/edit-instructor-account-info', [instructorController::class, 'editAccountInfo']);
    // Instructor Edit Password Logic Handler
    Route::post('/edit-instructor-password', [instructorController::class, 'editPassword']);

    // Instructor License Page
    Route::get('/instructor-certificate', [instructorController::class, 'instructorCertificatePage']);
    // Create Instructor License Page
    Route::get('/instructor-certificate/create', [instructorController::class, 'instructorCertificateForm']);
    // Create Instructor License Logic Handler
    Route::post('/instructor-certificate/create', [InstructorCertificateController::class, 'instructorCertificateCreate']);
    // Delete Instructor License Logic Handler
    Route::delete('/instructor-delete-certificate/{id}', [InstructorCertificateController::class, 'instructorCertificateDelete']);

    // Instructor's View Course Progress Detail Page
    Route::get('/instructor-course-progress/{student_real_name}/{enrollment_id}', [instructorController::class, 'courseProgressPage']);
    // Instructor's View Course Progress Detail Page
    Route::get('/instructor-course/registration-form/{student_real_name}/{enrollment_id}', [instructorController::class, 'registrationForm']);
    // Instructor's View Course Progress Detail Page
    Route::get('/instructor-course/payment/{student_real_name}/{enrollment_id}', [instructorController::class, 'paymentPage']);
});

// User Specific Route
Route::middleware(['auth', 'App\Http\Middleware\userMiddleware'])->group(function () {
    // User Dashboard Page
    Route::get('/user-index', [userController::class, 'userIndex']);
    // User Course Page
    Route::get('/user-course', [userController::class, 'userCoursePage']);
    // User Profile Page
    Route::get('/user-profile', [userController::class, 'userProfile']);

    // User Delete Account Logic Handler
    Route::delete('/delete-account-KEMUDI', [userController::class, 'deleteAccountPermanently']);

    // User Edit Profile Page
    Route::get('/user-profile/edit', [userController::class, 'editProfilePage']);
    // User Edit Account Info Logic Handler
    Route::post('/edit-user-account-info', [userController::class, 'editAccountInfo']);
    // User Edit Password Logic Handler
    Route::post('/edit-user-password', [userController::class, 'editPassword']);

    // User Course History / Course List Page
    Route::get('/user-course-list', [userController::class, 'courseHistoryPage']);

    // Course Registration Form Page
    Route::get('/course/registration-form/{course_name}/{course_id}', [userController::class, 'courseRegistrationForm']);
    // Course Registration Form Logic Handler
    Route::post('/course/registration-form/{course_name}/{course_id}', [enrollmentController::class, 'newStudent']);

    // Student's View Course Progress Detail Page
    Route::get('/user-course-progress/{student_real_name}/{enrollment_id}', [userController::class, 'courseProgressPage']);
    // Student's Choose Course Schedule Page
    Route::get('/user-course/schedule/{student_real_name}/{enrollment_id}', [userController::class, 'chooseFirstSchedulePage']);
    // Student's Choose Course Schedule Logic Handler
    Route::post('/user-course/schedule/{student_real_name}/{enrollment_id}', [CourseScheduleController::class, 'createNewSchedule']);
    // Student's Payment Page Controller
    Route::get('/user-course/payment/{student_real_name}/{enrollment_id}', [userController::class, 'paymentPage']);
    // Student's Payment Logic Handler
    Route::post('/user-course/payment/{student_real_name}/{enrollment_id}', [CoursePaymentsController::class, 'sendPaymentReceipt']);
    // Student's Theory Page Controller
    Route::get('/user-course/theory/{enrollment_id}/{meeting_number}', [userController::class, 'theoryPage']);
    // Student's Theory Page Done Reading Logic Handler
    Route::post('/user-course/theory/{enrollment_id}/{meeting_number}', [CourseScheduleController::class, 'markTheoryAsDone']);
    // Student's Quiz Page Controller
    Route::get('/user-course/quiz/{enrollment_id}/{meeting_number}', [userController::class, 'quizPage']);
    // Student's Quiz Page Done Reading Logic Handler
    Route::post('/user-course/quiz/{enrollment_id}/{meeting_number}', [CourseScheduleController::class, 'markQuizAsDone']);

    // General User Submit New Driving School Page Controller
    Route::get('/new-driving-school', [userController::class, 'newDrivingSchool']);
    // General User Submit New Driving School Logic Handler
    Route::post('/new-driving-school', [drivingSchoolLicenseController::class, 'newDrivingSchoolLicense']);
    // General User Update their Account Info Page
    Route::get('/new-driving-school/account-info', [userController::class, 'newDrivingSchoolAccountInfo']);
    // General User Update their Account Info Logic Handler
    Route::post('/new-driving-school/account-info', [adminController::class, 'newDrivingSchoolAccountInfoLogic']);
    // General User Add Payment Method Page
    Route::get('/new-driving-school/payment-method', [userController::class, 'newDrivingSchoolPayment']);
    // General User Add Payment Method Logic Handler
    Route::post('/new-driving-school/payment-method', [paymentMethodController::class, 'newDrivingSchoolPaymentLogic']);
});