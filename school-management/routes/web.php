<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthLoginController;
use App\Http\Controllers\AuthRegisterController;
use App\Http\Controllers\DashboardController;

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

Route::get('/', function () {
    return view('welcome');
});

// Redirect /home to /dashboard for compatibility
Route::get('/home', function () {
    return redirect()->route('dashboard');
})->middleware('auth');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthLoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthLoginController::class, 'login']);
    Route::get('/register', [AuthRegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthRegisterController::class, 'register']);
});

Route::post('/logout', [AuthLoginController::class, 'logout'])->name('logout');

// Dashboard Routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Admin Routes
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'adminDashboard'])->name('dashboard');
        Route::resource('users', \App\Http\Controllers\AdminUserController::class);
        Route::resource('students', \App\Http\Controllers\AdminStudentController::class);
        Route::get('/generate-student-id', [\App\Http\Controllers\AdminStudentController::class, 'generateStudentId'])->name('generate-student-id');
        
        // Academic Reports
        Route::prefix('reports')->name('reports.')->group(function () {
            Route::get('/student/{student}/report-card', [\App\Http\Controllers\AdminReportCardController::class, 'show'])->name('report-card');
            Route::get('/student/{student}/transcript', [\App\Http\Controllers\AdminReportCardController::class, 'transcript'])->name('transcript');
            Route::get('/student/{student}/progress-report', [\App\Http\Controllers\AdminReportCardController::class, 'progressReport'])->name('progress-report');
            Route::get('/student/{student}/analytics', [\App\Http\Controllers\AdminReportCardController::class, 'analytics'])->name('analytics');
            Route::get('/student/{student}/report-card/download', [\App\Http\Controllers\AdminReportCardController::class, 'downloadReportCard'])->name('report-card.download');
            Route::get('/student/{student}/transcript/download', [\App\Http\Controllers\AdminReportCardController::class, 'downloadTranscript'])->name('transcript.download');
        });
    });
    
    // Teacher Routes
    Route::middleware('role:teacher')->prefix('teacher')->name('teacher.')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\TeacherDashboardController::class, 'index'])->name('dashboard');
        
        // Classes
        Route::get('/classes', [\App\Http\Controllers\TeacherClassController::class, 'index'])->name('classes.index');
        Route::get('/classes/{class}', [\App\Http\Controllers\TeacherClassController::class, 'show'])->name('classes.show');
        
        // Grades
        Route::get('/classes/{class}/grades', [\App\Http\Controllers\TeacherGradeController::class, 'index'])->name('classes.grades.index');
        Route::get('/classes/{class}/grades/create', [\App\Http\Controllers\TeacherGradeController::class, 'create'])->name('classes.grades.create');
        Route::post('/classes/{class}/grades', [\App\Http\Controllers\TeacherGradeController::class, 'store'])->name('classes.grades.store');
        Route::get('/classes/{class}/grades/{grade}/edit', [\App\Http\Controllers\TeacherGradeController::class, 'edit'])->name('classes.grades.edit');
        Route::put('/classes/{class}/grades/{grade}', [\App\Http\Controllers\TeacherGradeController::class, 'update'])->name('classes.grades.update');
        Route::delete('/classes/{class}/grades/{grade}', [\App\Http\Controllers\TeacherGradeController::class, 'destroy'])->name('classes.grades.destroy');
        
        // Attendance
        Route::get('/classes/{class}/attendance', [\App\Http\Controllers\TeacherAttendanceController::class, 'index'])->name('classes.attendance.index');
        Route::get('/classes/{class}/attendance/create', [\App\Http\Controllers\TeacherAttendanceController::class, 'create'])->name('classes.attendance.create');
        Route::post('/classes/{class}/attendance', [\App\Http\Controllers\TeacherAttendanceController::class, 'store'])->name('classes.attendance.store');
        Route::get('/classes/{class}/attendance/{date}/edit', [\App\Http\Controllers\TeacherAttendanceController::class, 'edit'])->name('classes.attendance.edit');
        Route::get('/classes/{class}/attendance/report', [\App\Http\Controllers\TeacherAttendanceController::class, 'report'])->name('classes.attendance.report');
    });
    
    // Student Routes
    Route::middleware('role:student')->prefix('student')->name('student.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'studentDashboard'])->name('dashboard');
    });
    
    // Parent Routes
    Route::middleware('role:parent')->prefix('parent')->name('parent.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'parentDashboard'])->name('dashboard');
    });
});

