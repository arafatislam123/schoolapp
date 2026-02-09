<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SchoolClass;
use App\Models\Enrollment;

class TeacherClassController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:teacher']);
    }

    public function index()
    {
        $teacher = auth()->user()->teacher;
        $classes = $teacher->classes()
            ->with(['subject', 'enrollments' => function($q) {
                $q->where('status', 'active');
            }])
            ->get();

        return view('teacher.classes.index', compact('classes'));
    }

    public function show(SchoolClass $class)
    {
        $teacher = auth()->user()->teacher;

        // Verify this class belongs to the teacher
        if ($class->teacher_id !== $teacher->id) {
            abort(403, 'Unauthorized access to this class.');
        }

        $class->load([
            'subject',
            'enrollments.student.user',
            'enrollments.grades',
            'enrollments.attendances'
        ]);

        // Calculate class statistics
        $totalStudents = $class->enrollments()->where('status', 'active')->count();
        $averageGrade = $class->grades()->avg('percentage');
        $averageAttendance = $this->calculateClassAttendance($class);
        
        // Get students with their performance
        $students = $class->enrollments()
            ->where('status', 'active')
            ->with(['student.user', 'grades', 'attendances'])
            ->get()
            ->map(function($enrollment) {
                return [
                    'enrollment' => $enrollment,
                    'student' => $enrollment->student,
                    'average_grade' => round($enrollment->averageGrade() ?? 0, 1),
                    'attendance_rate' => $enrollment->attendancePercentage(),
                    'total_grades' => $enrollment->grades->count(),
                ];
            });

        return view('teacher.classes.show', compact('class', 'students', 'totalStudents', 'averageGrade', 'averageAttendance'));
    }

    private function calculateClassAttendance($class)
    {
        $totalAttendances = $class->attendances()->count();
        if ($totalAttendances === 0) return 0;

        $presentCount = $class->attendances()->where('status', 'present')->count();
        return round(($presentCount / $totalAttendances) * 100, 1);
    }
}
