<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\FetchController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileSettingsController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

use App\Http\Controllers\AdminControllers\StudentListController;
use App\Http\Controllers\AdminControllers\ReportListController;
use App\Http\Controllers\AdminControllers\DropListController;
use App\Http\Controllers\AdminControllers\GMListController;
use App\Http\Controllers\AdminControllers\AppointmentListController;
use App\Http\Controllers\AdminControllers\FormController;
use App\Http\Controllers\AdminControllers\ModuleController;
use App\Http\Controllers\AdminControllers\CounselorListController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes([
    'verify' => true
]);

Route::get('/', [HomeController::class, 'redirectPage']);

//fetch image
Route::get('/student/image/{id}', [FetchController::class, 'fetchImage'])->name('student.image');

//fetch student information
Route::get('/student/info/{id}', [FetchController::class, 'fetchStudentInformation'])->name('student.information');

Route::middleware(['guest', 'preventBackHistory'])->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login')->middleware(\App\Http\Middleware\RedirectIfAuthenticated::class);
    Route::post('/login', [LoginController::class, 'login'])->name('auto_login');
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register')->middleware(\App\Http\Middleware\RedirectIfAuthenticated::class);
    Route::post('/register', [RegisterController::class, 'register']);
});

//ADMIN
Route::middleware(['auth', 'userAuth:1', 'preventBackHistory'])->group(function () {
    //sidebars
    Route::get('/admin', [AdminController::class, 'viewDashboard'])->name('admin.viewDashboard');
    Route::get('/admin/students', [AdminController::class, 'viewStudentList'])->name('admin.viewStudentList');
    Route::get('/admin/createmodule', [AdminController::class, 'viewCreateModule'])->name('admin.viewCreateModule');
    Route::get('/admin/coc', [AdminController::class, 'viewCOC'])->name('admin.viewCOC');
    Route::get('/admin/requests/drop', [AdminController::class, 'viewDropRequestList'])->name('admin.viewDropRequestList');
    Route::get('/admin/requests/moral', [AdminController::class, 'viewGoodMoralList'])->name('admin.viewGoodMoralList');
    Route::get('/admin/reports', [AdminController::class, 'viewReports'])->name('admin.viewReports');
    Route::get('/admin/appointments', [AdminController::class, 'viewAppointments'])->name('admin.viewAppointments');
    Route::get('/admin/forms', [AdminController::class, 'viewForms'])->name('admin.viewForms');
    Route::get('/admin/srdRecords', [AdminController::class, 'viewSrdRecords'])->name('admin.viewSrdRecords');
    Route::get('/admin/addaccount', [AdminController::class, 'viewAddAccount'])->name('admin.viewAddAccount');

    //forms
    Route::get('/admin/form/moral', [AdminController::class, 'viewGoodMoralCert'])->name('admin.viewGoodMoralCert');
    Route::get('/admin/form/visit', [AdminController::class, 'viewHomeVisitationForm'])->name('admin.viewHomeVisitationForm');
    // Route::get('/admin/form/referral', [AdminController::class, 'viewReferralForm'])->name('admin.viewReferralForm');
    Route::get('/admin/form/travel', [AdminController::class, 'viewTravelForm'])->name('admin.viewTravelForm');

    //fetching
    Route::get('fetch-counselor-studentList', [FetchController::class, 'fetchStudentsAll'])->name('fetch.counselor.studentList');
    Route::get('fetch-counselor-reports', [FetchController::class, 'fetchReports'])->name('fetch.counselor.reports');
    Route::get('fetch-counselor-drop-requests', [FetchController::class, 'fetchDropRequest2'])->name('fetch.counselor.drop.requests');
    Route::get('fetch-counselor-gm-requests', [FetchController::class, 'fetchGoodMoralRequest2'])->name('fetch.counselor.gm.requests');
    Route::get('fetch-counselor-appointments', [FetchController::class, 'fetchAppointmentRequest2'])->name('fetch.counselor.appointment.requests');
    Route::get('fetch-counselor-modules', [FetchController::class, 'fetchModules'])->name('fetch.counselor.modules');
    Route::get('fetch-counselor-sardo', [FetchController::class, 'fetchSardoRecords'])->name('fetch.counselor.sardo');
    Route::get('fetch-counselor-counselorList', [FetchController::class, 'fetchCounselorList'])->name('fetch.counselor.counselorList');
    Route::get('fetch-grade-level', [FetchController::class, 'fetchGradeLevel'])->name('fetch.grade.level');
    Route::get('admin/getSections/{id}', [FetchController::class, 'fetchSections'])->name('fetch.sections');
    Route::get('fetch-adviser-available', [FetchController::class, 'fetchAdvisers'])->name('fetch.adviser.available');
    Route::get('fetch-counselor-information', [CounselorListController::class, 'fetchCounselor'])->name('fetch.counselor.information');

    //student list functions
    Route::post('/admin/student/update', [StudentListController::class, 'UpdateStudentInfo'])->name('admin.student.update');
    Route::post('/admin/student/email', [StudentListController::class, 'sendEMail'])->name('admin.student.email');
    Route::get('/admin/student/pdf/information', [StudentListController::class, 'downloadStudentInfo'])->name('admin.student.pdf.information');

     //locations
     Route::get('/admin/getProvinces', [AppController::class, 'getProvinces'])->name('fetch.admin.location.provinces');
     Route::get('/admin/getCities/{province_code}', [AppController::class, 'getCities'])->name('fetch.admin.location.cities');
     Route::get('/admin/getBarangays/{province_code}/{city_code}', [AppController::class, 'getBarangays'])->name('fetch.admin.location.barangays');

     //student reports functions
     Route::get('fetch-report-information', [ReportListController::class, 'fetchReportInformation'])->name('fetch.report.information');
     Route::post('/admin/student/report/action', [ReportListController::class, 'updateStudentConcern'])->name('admin.student.concern.action');
     Route::post('/admin/student/report/status', [ReportListController::class, 'updateConcernStatus'])->name('admin.student.concern.status');
     Route::get('/admin/student/report/download', [ReportListController::class, 'downloadConcernInformation'])->name('admin.student.concern.download');
     Route::post('/admin/student/report/remove', [ReportListController::class, 'removeStudentConcern'])->name('admin.student.concern.remove');

     //student drop functions
     Route::post('/admin/student/drop/approve', [DropListController::class, 'approveDropItem'])->name('admin.student.drop.approve');
     Route::post('/admin/student/drop/status', [DropListController::class, 'updateDropStatus'])->name('admin.student.drop.status');
     Route::post('/admin/student/drop/download', [DropListController::class, 'downloadDropForm'])->name('admin.student.drop.download');
     Route::post('/admin/student/drop/archive', [DropListController::class, 'archiveDropItem'])->name('admin.student.drop.archive');

     //student good moral functions
     Route::post('/admin/student/goodmoral/approve', [GMListController::class, 'approveGoodMoralItem'])->name('admin.student.goodmoral.approve');
     Route::post('/admin/student/goodmoral/status', [GMListController::class, 'updateGoodMoralStatus'])->name('admin.student.goodmoral.status');
     Route::get('/admin/student/goodmoral/download', [GMListController::class, 'downloadGoodMoralForm'])->name('admin.student.goodmoral.download');
     Route::post('/admin/student/goodmoral/archive', [GMListController::class, 'archiveGoodMoralItem'])->name('admin.student.goodmoral.archive');

    //student appointment functions
    Route::post('/admin/student/appointment/status', [AppointmentListController::class, 'updateAppointmentStatus'])->name('admin.student.appointment.status');
    Route::post('/admin/student/appointment/email', [AppointmentListController::class, 'emailAppointment'])->name('admin.student.appointment.email');
    Route::post('/admin/student/appointment/remove', [AppointmentListController::class, 'removeAppointmentItem'])->name('admin.student.appointment.remove');

    //form downloads
    Route::get('/admin/forms/download', [FormController::class, 'downloadForm'])->name('admin.forms.download');
    Route::get('/admin/sardo/download', [FormController::class, 'downloadSardo'])->name('admin.sardo.download');
    Route::post('/admin/forms/download/customize/gm', [FormController::class, 'customizeGMCert'])->name('admin.forms.download.customize.gm');
    Route::post('/admin/forms/download/customize/hv', [FormController::class, 'customizeHomeVisitation'])->name('admin.forms.download.customize.hv');
    Route::post('/admin/forms/download/customize/tf', [FormController::class, 'customizeTravelForm'])->name('admin.forms.download.customize.tf');

    //modules pdf
    Route::post('/admin/upload/module', [ModuleController::class, 'uploadModule'])->name('admin.upload.module');
    Route::post('/admin/delete/module', [ModuleController::class, 'deleteModule'])->name('admin.delete.module');
    Route::get('admin/view/{filename}', function ($filename) {
        $path = public_path('modules_pdf/'.$filename);
        $fileContents = file_get_contents($path);
        return Response::make($fileContents, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'.$filename.'"'
        ]);
    })->name('pdf.view');

    //counselor crud
    Route::post('/admin/counselor/add', [CounselorListController::class, 'addCounselor'])->name('admin.counselor.add');
    Route::post('/admin/counselor/edit', [CounselorListController::class, 'editCounselor'])->name('admin.counselor.edit');
});

//STUDENTS
Route::middleware(['auth', 'userAuth:2', 'preventBackHistory'])->group(function () {
    //sidebars
    Route::get('/user', [AppController::class, 'viewDashboard'])->name('user.viewDashboard')->middleware('verified');
    Route::get('/user/report', [AppController::class, 'viewReportForm'])->name('user.viewReportForm')->middleware('verified');
    Route::get('/user/appointments', [AppController::class, 'viewAppointments'])->name('user.viewAppointments')->middleware('verified');
    Route::get('/user/code', [AppController::class, 'viewCOC'])->name('user.viewCOC')->middleware('verified');
    Route::get('/user/profile/', [AppController::class, 'viewProfile'])->name('user.viewProfile')->middleware('verified');

    //forms
    Route::get('/user/form/appointment', [AppController::class, 'viewFormAppointment'])->name('user.viewFormAppointment')->middleware('verified');
    Route::get('/user/form/drop', [AppController::class, 'viewFormDrop'])->name('user.viewFormDrop')->middleware('verified');
    Route::get('/user/form/moral', [AppController::class, 'viewFormMoral'])->name('user.viewFormMoral')->middleware('verified');

    //requests
    Route::post('user/request/appointment', [RequestController::class, 'submitAppointmentRequest'])->name('user.request.appointment');
    Route::post('user/request/drop', [RequestController::class, 'submitDropRequest'])->name('user.request.drop');
    Route::post('user/request/moral', [RequestController::class, 'submitMoralRequest'])->name('user.request.moral');
    Route::post('user/request/report', [RequestController::class, 'submitReportRequest'])->name('user.request.report');

    //cancel request
    Route::post('user/request/cancel', [RequestController::class, 'cancelRequest'])->name('user.request.cancel');

    //fetching
    Route::get('fetch-user-appointments', [FetchController::class, 'fetchAppointmentRequest'])->name('fetch.user.appointments');
    Route::get('fetch-user-drop-request', [FetchController::class, 'fetchDropRequest'])->name('fetch.user.drop.request');
    Route::get('fetch-user-gm-request', [FetchController::class, 'fetchGoodMoralRequest'])->name('fetch.user.gm.request');

    //locations
    Route::get('/getProvinces', [AppController::class, 'getProvinces'])->name('fetch.user.location.provinces');
    Route::get('/getCities/{province_code}', [AppController::class, 'getCities'])->name('fetch.user.location.cities');
    Route::get('/getBarangays/{province_code}/{city_code}', [AppController::class, 'getBarangays'])->name('fetch.user.location.barangays');
    Route::get('/getBarangays/{grade_id}', [AppController::class, 'getSections'])->name('fetch.user.sections');
    //profile editor
    Route::post('user/profile/edit', [ProfileSettingsController::class, 'profile_editor'])->name('student.profile.editor');
    Route::post('user/profile/edit/educational', [ProfileSettingsController::class, 'profile_editor2'])->name('student.profile.editor.educational');
});




