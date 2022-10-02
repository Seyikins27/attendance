<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('home.index');
});
Route::get('/logout',[App\Http\Controllers\IndexController::class, 'logout'])->name('logout');
Route::post('/logout',[App\Http\Controllers\IndexController::class, 'logout'])->name('logout');

/** Tutor Routes */
Route::get('/tutor',[App\Http\Controllers\IndexController::class, 'tutor'])->name('tutor-index');
Route::post('/tutor/add',[App\Http\Controllers\IndexController::class, 'tutor_register'])->name('tutor-add');
Route::post('/tutor/auth',[App\Http\Controllers\IndexController::class, 'tutor_auth'])->name('tutor-auth');

Route::get('/tutor/register', function(){
    return view('tutor.register');
})->name('tutor-register');

Route::get('/tutor/login', function(){
    return view('tutor.login');
})->name('tutor-login');

Route::group(['prefix'=>'tutor','as'=>'tutor-','middleware'=>['tutor']], function(){
    Route::get('/dashboard',[App\Http\Controllers\TeacherController::class, 'index'])->name('dashboard');
    Route::resource('classroom', App\Http\Controllers\ClassroomController::class);
    Route::resource('venue', App\Http\Controllers\VenueController::class);
    Route::resource('attendance', App\Http\Controllers\AttendanceController::class);
    Route::get('/classroom/students/{classroom}', [App\Http\Controllers\ClassroomStudentController::class,'index'])->name('classroom-students');
    Route::get('/attendance/student/{classroom}/{student_id}',[App\Http\Controllers\AttendanceLogController::class, 'student_attendance'])->name('student-attendance-log');
    Route::get('/attendance/log/classroom/{classroom}',[App\Http\Controllers\AttendanceLogController::class, 'tutor_log'])->name('attendance-log');
});


/** Student Routes */
Route::get('/student',[App\Http\Controllers\IndexController::class, 'student'])->name('student-index');
Route::post('/student/add',[App\Http\Controllers\IndexController::class, 'student_register'])->name('student-add');
Route::post('/student/auth',[App\Http\Controllers\IndexController::class, 'student_auth'])->name('student-auth');

Route::get('/student/register', function(){

    return view('student.register');
})->name('student-register');

Route::get('/student/webcam', function(){
    return view('student.attendance.webcam');
})->name('student-webcam');
Route::get('/student/login', function(){
    return view('student.login');
})->name('student-login');

Route::group(['prefix'=>'student','as'=>'student-','middleware'=>['student'] ], function(){
    Route::get('/dashboard',[App\Http\Controllers\StudentController::class, 'index'])->name('dashboard');
    Route::get('/classroom/enrol',[App\Http\Controllers\StudentController::class, 'enrol_in_class'])->name('classroom-enrol');
    Route::post('/classroom/enrolment',[App\Http\Controllers\StudentController::class, 'enrol'])->name('classroom-enrolment');
    Route::post('/classroom/enrolment/drop',[App\Http\Controllers\StudentController::class, 'drop_enrolment'])->name('classroom-enrolment-drop');
    Route::get('/classroom/details',[App\Http\Controllers\ClassroomController::class, 'get_by_code'])->name('classroom-details');
    Route::get('/attendance/active',[App\Http\Controllers\StudentController::class, 'active_attendance'])->name('active-attendance');
    Route::post('/attendance/signin',[App\Http\Controllers\AttendanceLogController::class, 'store'])->name('attendance-signin');
    Route::post('/attendance/signout',[App\Http\Controllers\AttendanceLogController::class, 'signout'])->name('attendance-signout');
    Route::get('/attendance/log',[App\Http\Controllers\AttendanceLogController::class, 'student_log'])->name('attendance-log');
    Route::get('/attendance/log/{classroom}',[App\Http\Controllers\AttendanceLogController::class, 'student_log'])->name('classroom-attendance-log');
    Route::post('/attendance/verify_face',[App\Http\Controllers\AttendanceLogController::class, 'verify_face'])->name('verify-face');
});


