<?php

use Illuminate\Support\Facades\Route;

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

// Ajax Routes
Route::get('ajax/fakultas/{id}/prodis', [App\Http\Controllers\AjaxController::class, 'getProdisByFakultas'])->name('ajax.prodis');

Route::get('/', function () {
    return view('welcome');
})->name('landing');

// Custom Registration Routes
Route::get('register', [App\Http\Controllers\Auth\StudentRegisterController::class, 'showLanding'])->name('register');

// Option A: Mahasiswa Baru
Route::get('register/new', [App\Http\Controllers\Auth\StudentRegisterController::class, 'showStep1'])->name('register.new');
Route::post('register/new', [App\Http\Controllers\Auth\StudentRegisterController::class, 'storeStep1'])->name('register.step1.store');

// Option B: Mahasiswa Aktif
Route::get('register/existing', [App\Http\Controllers\Auth\StudentRegisterController::class, 'showExistingForm'])->name('register.existing');
Route::post('register/existing', [App\Http\Controllers\Auth\StudentRegisterController::class, 'storeExistingForm'])->name('register.existing.store');


Route::middleware(['auth', 'role:mahasiswa'])->group(function () {
    Route::get('register/step2', [App\Http\Controllers\Auth\StudentRegisterController::class, 'showStep2'])->name('register.step2');
    Route::post('register/step2', [App\Http\Controllers\Auth\StudentRegisterController::class, 'storeStep2'])->name('register.step2.store');
    Route::get('register/step3', [App\Http\Controllers\Auth\StudentRegisterController::class, 'showStep3'])->name('register.step3');
    Route::post('register/step3', [App\Http\Controllers\Auth\StudentRegisterController::class, 'storeStep3'])->name('register.step3.store');
    Route::get('api/prodi-by-fakultas', [App\Http\Controllers\Auth\StudentRegisterController::class, 'getProdi'])->name('api.prodi-by-fakultas');
});

Auth::routes(['register' => false]); // Disable default register routes

// Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/admin/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');

    // Master Data
    Route::resource('admin/roles', App\Http\Controllers\Admin\RoleController::class, ['as' => 'admin']);
    Route::resource('admin/users', App\Http\Controllers\Admin\UserController::class, ['as' => 'admin']);
    Route::resource('admin/fakultas', App\Http\Controllers\Admin\FakultasController::class, ['as' => 'admin']);
    Route::resource('admin/prodi', App\Http\Controllers\Admin\ProdiController::class, ['as' => 'admin']);
    Route::resource('admin/semester', App\Http\Controllers\Admin\SemesterController::class, ['as' => 'admin']);

    // Registration Management
    Route::get('admin/registrations', [App\Http\Controllers\Admin\RegistrationController::class, 'index'])->name('admin.registrations.index');
    Route::get('admin/registrations/{registration}', [App\Http\Controllers\Admin\RegistrationController::class, 'show'])->name('admin.registrations.show');
    Route::put('admin/registrations/{registration}', [App\Http\Controllers\Admin\RegistrationController::class, 'update'])->name('admin.registrations.update');
    Route::put('admin/registrations/{registration}/approve', [App\Http\Controllers\Admin\RegistrationController::class, 'approve'])->name('admin.registrations.approve');
    
    // User Management (Students)
    Route::get('admin/students', [App\Http\Controllers\Admin\UserController::class, 'students'])->name('admin.students.index');

    // Billing Management
    Route::get('admin/billings/create-bulk', [App\Http\Controllers\Admin\BillingController::class, 'createBulk'])->name('admin.billings.create-bulk');
    Route::post('admin/billings/create-bulk', [App\Http\Controllers\Admin\BillingController::class, 'storeBulk'])->name('admin.billings.store-bulk');
    Route::get('admin/billings/verification', [App\Http\Controllers\Admin\BillingController::class, 'verification'])->name('admin.billings.verification');
    Route::put('admin/billings/{billing}/approve', [App\Http\Controllers\Admin\BillingController::class, 'approve'])->name('admin.billings.approve');
    Route::put('admin/billings/{billing}/manual-verify', [App\Http\Controllers\Admin\BillingController::class, 'manualVerify'])->name('admin.billings.manual-verify');
    Route::put('admin/billings/{billing}/reject', [App\Http\Controllers\Admin\BillingController::class, 'reject'])->name('admin.billings.reject');
    Route::get('admin/billings/{billing}/print', [App\Http\Controllers\Admin\BillingController::class, 'printInvoice'])->name('admin.billings.print');
    
    // Ledger / Kartu Kontrol
    Route::get('admin/students/{user}/ledger', [App\Http\Controllers\Admin\BillingController::class, 'ledger'])->name('admin.students.ledger');
    
    Route::resource('admin/billings', App\Http\Controllers\Admin\BillingController::class, ['as' => 'admin']);

    // Non-Academic Modules
    // Non-Academic Modules
    Route::get('admin/non-academic', [App\Http\Controllers\Admin\NonAcademicController::class, 'index'])->name('admin.non-academic.index');
    Route::resource('admin/career-programs', App\Http\Controllers\Admin\CareerProgramController::class, ['as' => 'admin']);
    Route::resource('admin/lms-materials', App\Http\Controllers\Admin\LmsMaterialController::class, ['as' => 'admin']);
    Route::resource('admin/trainings', App\Http\Controllers\Admin\TrainingController::class, ['as' => 'admin']);
    // Removed old singular webinar/training routes line if duplicated, but sticking to resource above.
});

// Yayasan Routes
Route::middleware(['auth', 'role:yayasan'])->group(function () {
    Route::get('/yayasan/dashboard', function () {
        return view('yayasan.home');
    })->name('yayasan.dashboard');
});

// Student Routes
Route::middleware(['auth', 'role:mahasiswa', 'ensure_registration_complete'])->group(function () {
    Route::get('/mahasiswa/dashboard', [App\Http\Controllers\Student\DashboardController::class, 'index'])->name('student.dashboard');
    
    // Enrollment Routes for Maba
    Route::get('/mahasiswa/enrollment/step1', [App\Http\Controllers\Student\EnrollmentController::class, 'step1'])->name('student.enrollment.step1');
    Route::post('/mahasiswa/enrollment/step1', [App\Http\Controllers\Student\EnrollmentController::class, 'storeStep1'])->name('student.enrollment.storeStep1');
    Route::get('/mahasiswa/enrollment/step2', [App\Http\Controllers\Student\EnrollmentController::class, 'step2'])->name('student.enrollment.step2');
    Route::post('/mahasiswa/enrollment/step2', [App\Http\Controllers\Student\EnrollmentController::class, 'storeStep2'])->name('student.enrollment.storeStep2');
    Route::get('/mahasiswa/enrollment/step3', [App\Http\Controllers\Student\EnrollmentController::class, 'step3'])->name('student.enrollment.step3');
    Route::post('/mahasiswa/enrollment/step3', [App\Http\Controllers\Student\EnrollmentController::class, 'storeStep3'])->name('student.enrollment.storeStep3');
    
    // Finance Routes
    Route::get('/mahasiswa/billing', [App\Http\Controllers\Student\BillingController::class, 'index'])->name('student.billing.index');
    Route::post('/mahasiswa/billing/{id}/upload', [App\Http\Controllers\Student\BillingController::class, 'upload'])->name('student.billing.upload');
    Route::get('/mahasiswa/invoice/{id}/print', [App\Http\Controllers\Student\BillingController::class, 'print'])->name('student.invoice.print');
});
            
// Staff Routes
Route::middleware(['auth', 'role:staff'])->group(function () {
    Route::get('/staff/dashboard', [App\Http\Controllers\Staff\DashboardController::class, 'index'])->name('staff.dashboard');
    
    // Modules
    Route::resource('staff/validation', App\Http\Controllers\Staff\ValidationController::class, ['as' => 'staff']);
    Route::resource('staff/tickets', App\Http\Controllers\Staff\TicketController::class, ['as' => 'staff']);
    Route::post('staff/tickets/{ticket}/reply', [App\Http\Controllers\Staff\TicketController::class, 'reply'])->name('staff.tickets.reply');
    Route::put('staff/tickets/{ticket}/status', [App\Http\Controllers\Staff\TicketController::class, 'updateStatus'])->name('staff.tickets.status');
    Route::resource('staff/materials', App\Http\Controllers\Staff\MaterialController::class, ['as' => 'staff']);
});
