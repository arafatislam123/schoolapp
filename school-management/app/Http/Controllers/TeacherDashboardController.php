<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Teacher;
use App\Models\SchoolClass;
use App\Models\Enrollment;
use App\Models\Grade;
use App\Models\Attendance;

class TeacherDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:teacher']);
    }

    public function index()
    {
        $user = auth()->user();
        $teacher = $user->teacher;

        if (!$teacher) {
            return redirect()->route('dashboard')->with('error', 'Teacher profile not found.');
        }

        // Get teacher's classes
        $classes = $teacher->classes()->with(['subject', 'enrollments.student.user'])->get();

        // Calculate statistics
        $totalClasses = $classes->count();
        $totalStudents = $classes->sum(function($class) {
            return $class->enrollments()->where('status', 'active')->count();
        });

        // Recent grades entered (last 7 days)
        $recentGrades = Grade::whereHas('enrollment.schoolClass', function($q) use ($teacher) {
            $q->where('teacher_id', $teacher->id);
        })->where('created_at', '>=', now()->subDays(7))->count();

        // Attendance marked today
        $attendanceToday = Attendance::whereHas('enrollment.schoolClass', function($q) use ($teacher) {
            $q->where('teacher_id', $teacher->id);
        })->whereDate('date', today())->count();

        // Upcoming classes (today's schedule)
        $todayClasses = $classes->filter(function($class) {
            $schedule = strtolower($class->schedule ?? '');
            $today = strtolower(now()->format('D'));
            return str_contains($schedule, $today);
        });

        // Recent activity
        $recentActivity = $this->getRecentActivity($teacher);

        return view('teacher.dashboard', compact(
            'teacher',
            'classes',
            'totalClasses',
            'totalStudents',
            'recentGrades',
            'attendanceToday',
            'todayClasses',
            'recentActivity'
        ));
    }

    private function getRecentActivity($teacher)
    {
        $activities = collect();

        // Recent grades
        $grades = Grade::whereHas('enrollment.schoolClass', function($q) use ($teacher) {
            $q->where('teacher_id', $teacher->id);
        })
        ->with(['enrollment.student.user', 'enrollment.schoolClass.subject'])
        ->latest()
        ->take(5)
        ->get()
        ->map(function($grade) {
            return [
                'type' => 'grade',
                'icon' => '📝',
                'message' => "Graded {$grade->enrollment->student->user->name} in {$grade->enrollment->schoolClass->subject->name}",
                'details' => "{$grade->assessment_name}: {$grade->letter_grade} ({$grade->percentage}%)",
                'time' => $grade->created_at,
            ];
        });

        // Recent attendance
        $attendance = Attendance::whereHas('enrollment.schoolClass', function($q) use ($teacher) {
            $q->where('teacher_id', $teacher->id);
        })
        ->with(['enrollment.student.user', 'enrollment.schoolClass'])
        ->latest()
        ->take(5)
        ->get()
        ->map(function($att) {
            return [
                'type' => 'attendance',
                'icon' => '✓',
                'message' => "Marked attendance for {$att->enrollment->schoolClass->name}",
                'details' => "{$att->date->format('M d, Y')} - {$att->enrollment->student->user->name}: {$att->status}",
                'time' => $att->created_at,
            ];
        });

        return $activities->merge($grades)->merge($attendance)->sortByDesc('time')->take(10);
    }
}
