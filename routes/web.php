<?php

use App\Http\Controllers\AuthUser;
use App\Http\Controllers\Dashboard;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\FE\HomeController;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\ExportDataController;
use App\Http\Controllers\FE\ServiceController;
use App\Http\Controllers\FE\EmployeeController;
use App\Http\Controllers\SubmissionDataController;
use App\Http\Controllers\TrainingContentController;

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

Route::middleware('guest')->group(function () {
    Route::get('/admin', function () {
        return redirect('/login-admin');
    });
    
    Route::get('/login-admin', [AuthUser::class, 'index']);
    Route::post('/login-admin', [AuthUser::class, 'auth']);
    Route::get('/register-admin', [AuthUser::class, 'register']);
    Route::post('/register-admin', [AuthUser::class, 'store']);
});



Route::middleware('admin')->group(function () {
    Route::get('/profile', [AdminController::class, 'index']);
    Route::get('/dashboard', [Dashboard::class, 'index']);
    
    Route::resource('/posts', PostsController::class)->except('show');

    Route::get('/export/admin', [ExportDataController::class, 'export']);

    Route::get('/data-admin', [AdminController::class, 'dataAdmin']);
    Route::get('/getDetailAdmin', [AdminController::class, 'getDetailAdmin']);
    Route::get('/form-add-admin', [AdminController::class, 'addFormAdmin']);
    Route::post('/add-new-admin', [AdminController::class, 'storeAdmin']);
    Route::get('/form-edit-admin/{number}', [AdminController::class, 'editFormAdmin']);
    Route::post('/edit-new-admin', [AdminController::class, 'updateAdmin']);
    Route::delete('/delete-admin/{number}', [AdminController::class, 'deleteAdmin']);

    Route::get('/data-karyawan', [EmployeesController::class, 'dataEmployee']);
    Route::get('/getDetailEmployee', [EmployeesController::class, 'getDetailEmployee']);
    Route::get('/form-add-karyawan', [EmployeesController::class, 'addFormEmployee']);
    Route::post('/add-new-karyawan', [EmployeesController::class, 'storeEmployee']);
    Route::get('/form-edit-karyawan/{number}', [EmployeesController::class, 'editFormEmployee']);
    Route::post('/edit-new-karyawan', [EmployeesController::class, 'updateEmployee']);
    Route::delete('/delete-karyawan/{number}', [EmployeesController::class, 'deleteEmployee']);

    Route::get('/manage-leave-emp', [GeneralController::class, 'manage_leave_emp']); // data pengajuan cuti
    Route::post('/update-manage-leave/{nik}', [GeneralController::class, 'update_manage_leave']); // data pengajuan cuti

    Route::get('/e-cuti', [SubmissionDataController::class, 'e_cuti']); // data pengajuan cuti
    Route::get('/e-izin', [SubmissionDataController::class, 'e_izin']); // data pengajuan izin
    Route::get('/e-sakit', [SubmissionDataController::class, 'e_sakit']); // data pengajuan sakit
    Route::get('/detail-submission/{id}', [SubmissionDataController::class, 'detail_submission']); // detail pengajuan
    Route::get('/detail-submission-em/{nik}', [SubmissionDataController::class, 'detail_submission_nik']); // detail pengajuan

    Route::post('/acc-submission', [SubmissionDataController::class, 'acc_submission']); // terima
    Route::post('/reject-submission', [SubmissionDataController::class, 'reject_submission']); // penolakan
    
    Route::put('/reset-password/{number}', [AdminController::class, 'resetPassword']); // reset password pendaftar akun
    
    // REPORTING //
    Route::get('/submission-report', [GeneralController::class, 'submissionReport']);
    Route::get('/submission-rpt', [GeneralController::class, 'submissionRpt']);
    Route::get('/open-submission-rpt', [GeneralController::class, 'openSubmissionRpt']);
    Route::get('/export_submission', [ExportDataController::class, 'submission']);

    Route::get('/participant-report', [GeneralController::class, 'participantReport']);
    Route::get('/participant-rpt', [GeneralController::class, 'participantRpt']);
    Route::get('/open-participant-rpt', [GeneralController::class, 'openParticipantRpt']);
    Route::get('/export_participant', [ExportDataController::class, 'participant']);

    // END REPORTING //
    
    Route::post('/logout-admin', [AuthUser::class, 'logout']);
});

Route::middleware('employee')->group(function () {
    Route::get('/home', [HomeController::class, 'index']);
    Route::get('/pengajuan', [HomeController::class, 'submission']);
    Route::post('/submission', [HomeController::class, 'storeSubmission']);
    Route::get('/riwayat', [HomeController::class, 'histories']);
    Route::get('/detail-pengajuan/{id}', [HomeController::class, 'detailSubmission']);

    Route::get('/wishlist', [EmployeeController::class, 'wishlist']);
    Route::get('/_profile', [EmployeeController::class, 'profile']);
    Route::get('/update-profile', [EmployeeController::class, 'updateProfile']);
    Route::put('/update-profile/{number}', [EmployeeController::class, 'updateProfileData']);
    Route::get('/checkDataUser/{id}', [GeneralController::class, 'checkDataUser']);
    
    Route::post('/logout', [EmployeeController::class, 'logout']);
});

Route::get('/register', [EmployeeController::class, 'index']);
Route::post('/register', [EmployeeController::class, 'store']);
Route::get('/', [EmployeeController::class, 'login']);
Route::get('/login', [EmployeeController::class, 'login']);
Route::post('/login', [EmployeeController::class, 'loginValidation']);

