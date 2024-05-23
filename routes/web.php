<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;


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
Route::group(['middleware' => ['check.installation']], function() {
    Route::get('/', function () {
        return redirect('login');
    });
});
Auth::routes([

    'register' => false, // Register Routes...

    'reset' => false, // Reset Password Routes...

    'verify' => false, // Email Verification Routes...

]);
//Auth::routes();

Route::get('/link', function () {
    Artisan::call('storage:link');
    return 'Storage link created successfully';
});



Route::group(['middleware' => ['auth']], function() {

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::resource('roles', App\Http\Controllers\RoleController::class);
    Route::resource('departments', App\Http\Controllers\DepartmentController::class);
    Route::resource('users', App\Http\Controllers\UserController::class);

    Route::get('users-profile', [\App\Http\Controllers\UserController::class, 'profileView'])->name('users.profile');
    Route::post('profile-change', [\App\Http\Controllers\UserController::class, 'changeProfile'])->name('users.profile.change');

    Route::resource('sections', App\Http\Controllers\SectionController::class);
    Route::resource('classes', App\Http\Controllers\_ClassController::class);
    Route::resource('students', App\Http\Controllers\StudentController::class);
    Route::resource('transports', App\Http\Controllers\TransportController::class);
    Route::resource('transport-routes', App\Http\Controllers\TransportRoutesController::class);
    Route::resource('yearly-session', App\Http\Controllers\_SessionController::class);

    Route::get('registrations/students', [\App\Http\Controllers\RegisterationController::class, 'getRegistrations'])
        ->name('registrations.students');

    Route::get('registrations/{id}', [\App\Http\Controllers\RegisterationController::class, 'show'])
        ->name('registrations.show');

    Route::delete('registrations/cancel/{id}', [\App\Http\Controllers\RegisterationController::class, 'admissionCancel'])
        ->name('registrations.cancel');

    Route::post('admission/confirm', [\App\Http\Controllers\AdmissionController::class, 'store'])->name('admission.store');
    Route::get('admissions', [\App\Http\Controllers\AdmissionController::class, 'index'])->name('admission.index');
    Route::get('admissions/create', [\App\Http\Controllers\AdmissionController::class, 'create'])->name('admission.create');
    Route::get('admissions/edit/{id}', [\App\Http\Controllers\AdmissionController::class, 'edit'])->name('admission.edit');
    Route::patch('admissions/update/{id}', [\App\Http\Controllers\AdmissionController::class, 'update'])->name('admission.update');
    Route::delete('admissions/delete/{id}', [\App\Http\Controllers\AdmissionController::class, 'destroy'])->name('admission.destroy');

    Route::resource('transfers', \App\Http\Controllers\TransferController::class);
    Route::resource('transfers', \App\Http\Controllers\TransferController::class);
    Route::resource('students', \App\Http\Controllers\StudentController::class);
    Route::resource('subjects', \App\Http\Controllers\SubjectController::class);

    Route::resource('staffs', \App\Http\Controllers\StaffController::class);

    Route::resource('teachers', \App\Http\Controllers\TeacherController::class);
    Route::post('teachers/{staffid}/{id}/revoke', [\App\Http\Controllers\TeacherController::class, 'revokeSubject'])->name('revokeSubject');
    Route::post('teachers/assigend/subjects', [\App\Http\Controllers\TeacherController::class, 'assignSubjects'])->name('teachers.assigend.subjects');

    Route::get('/settings', [\App\Http\Controllers\SystemSettingsController::class, 'index'])->name('settings.index');
    Route::put('/settings', [\App\Http\Controllers\SystemSettingsController::class, 'update'])->name('settings.update');

    Route::resource('fees', \App\Http\Controllers\FeeController::class);
      Route::get('fees.get-substudents', [\App\Http\Controllers\FeeController::class, 'getStudents'])->name('fees.get-substudents');

    Route::get('fees/print/single/{id}', [\App\Http\Controllers\FeeController::class, 'printViewSingleID'])->name('fees.print');
    Route::get('fees/print/all', [\App\Http\Controllers\FeeController::class, 'printViewAll'])->name('fees.print.all');
    Route::get('fees/print/{ids}', [\App\Http\Controllers\FeeController::class, 'printViewByIDS'])->name('fees.print.ids');

    Route::get('student-attendance', [\App\Http\Controllers\StudentAttendenceController::class, 'create'])->name('s_atd.create');
    Route::get('student-attendance/list', [\App\Http\Controllers\StudentAttendenceController::class, 'listView'])->name('s_atd.list');
    Route::get('getStudentsFromClass/{id}', [\App\Http\Controllers\StudentAttendenceController::class, 'getStudentsFromClass']);
    Route::get('student-attendance/{id}', [\App\Http\Controllers\StudentAttendenceController::class, 'edit'])->name('s_atd.edit');
    Route::patch('student-attendance/{student_attendance}', [\App\Http\Controllers\StudentAttendenceController::class, 'update'])->name('s_atd.update');
    Route::post('save-attendance', [\App\Http\Controllers\StudentAttendenceController::class, 'store']);

    Route::resource('staff-attendance', \App\Http\Controllers\StaffAttendenceController::class);
    Route::resource('salaries', \App\Http\Controllers\salaryController::class);
    Route::resource('expenses', \App\Http\Controllers\ExpenseController::class);
    Route::resource('notices', \App\Http\Controllers\NoticeBoradController::class);

    Route::resource('results',\App\Http\Controllers\ExamResultController::class);
   Route::get('getSubjectsAndStudents/', [\App\Http\Controllers\ExamResultController::class, 'getStudents'])
    ->name('getSubjectsAndStudents');


    Route::resource('student-leaves', \App\Http\Controllers\StudentLeaveController::class);
    Route::resource('staff-leaves', \App\Http\Controllers\StaffLeaveController::class);

    Route::resource('live-classes', \App\Http\Controllers\LiveClassController::class);
    Route::resource('study-materials', \App\Http\Controllers\StudyMaterialController::class);
    Route::resource('time-tables', \App\Http\Controllers\TimeTableController::class);
    Route::get('getSubjectsByClass/{id}', [\App\Http\Controllers\TimeTableController::class, 'getSubjectsByClass']);
    Route::get('getTimetable/{id}', [\App\Http\Controllers\TimeTableController::class, 'getTimetable']);

    Route::resource('promotes', \App\Http\Controllers\PromotedOrDemotedController::class);
    Route::get('getStudents/{id}', [\App\Http\Controllers\PromotedOrDemotedController::class, 'getStudents']);
    Route::resource('gate-pass', \App\Http\Controllers\GatePassController::class);

});


Route::get('registrations', [\App\Http\Controllers\RegisterationController::class, 'index']);
Route::post('registrations', [\App\Http\Controllers\RegisterationController::class, 'store'])->name('registrations.store');


Route::get('test', function (){
    dd( auth()->user()->is_teacher );
});
