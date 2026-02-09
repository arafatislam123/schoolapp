<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SchoolClass;
use App\Models\Enrollment;
use App\Models\Attendance;

class TeacherAttendanceController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:teacher']);
    }

    public function index(SchoolClass $class)
    {
        $teacher = auth()->user()->teacher;

        if ($class->teacher_id !== $teacher->id) {
            abort(403, 'Unauthorized access.');
        }

        $class->load(['subject', 'enrollments.student.user']);

        // Get attendance for the last 30 days
        $attendances = Attendance::whereHas('enrollment', function($q) use ($class) {
            $q->where('school_class_id', $class->id);
        })
        ->where('date', '>=', now()->subDays(30))
        ->with('enrollment.student.user')
        ->orderBy('date', 'desc')
        ->get()
        ->groupBy('date');

        $students = $class->enrollments()
            ->where('status', 'active')
            ->with('student.user')
            ->get();

        return view('teacher.attendance.index', compact('class', 'students', 'attendances'));
    }

    public function create(SchoolClass $class)
    {
        $teacher = auth()->user()->teacher;

        if ($class->teacher_id !== $teacher->id) {
            abort(403, 'Unauthorized access.');
        }

        $class->load(['subject', 'enrollments.student.user']);

        $students = $class->enrollments()
            ->where('status', 'active')
            ->with('student.user')
            ->get();

        // Check if attendance already marked for today
        $todayAttendance = Attendance::whereHas('enrollment', function($q) use ($class) {
            $q->where('school_class_id', $class->id);
        })
        ->whereDate('date', today())
        ->with('enrollment')
        ->get()
        ->keyBy('enrollment_id');

        return view('teacher.attendance.create', compact('class', 'students', 'todayAttendance'));
    }

    public function store(Request $request, SchoolClass $class)
    {
        $teacher = auth()->user()->teacher;

        if ($class->teacher_id !== $teacher->id) {
            abort(403, 'Unauthorized access.');
        }

        $validated = $request->validate([
            'date' => 'required|date',
            'attendance' => 'required|array',
            'attendance.*.enrollment_id' => 'required|exists:enrollments,id',
            'attendance.*.status' => 'required|in:present,absent,late,excused',
            'attendance.*.remarks' => 'nullable|string',
        ]);

        foreach ($validated['attendance'] as $attendanceData) {
            // Verify enrollment belongs to this class
            $enrollment = Enrollment::find($attendanceData['enrollment_id']);
            if ($enrollment->school_class_id !== $class->id) {
                continue;
            }

            // Update or create attendance
            Attendance::updateOrCreate(
                [
                    'enrollment_id' => $attendanceData['enrollment_id'],
                    'date' => $validated['date'],
                ],
                [
                    'status' => $attendanceData['status'],
                    'remarks' => $attendanceData['remarks'] ?? null,
                ]
            );
        }

        return redirect()
            ->route('teacher.classes.attendance.index', $class)
            ->with('success', 'Attendance marked successfully!');
    }

    public function edit(SchoolClass $class, $date)
    {
        $teacher = auth()->user()->teacher;

        if ($class->teacher_id !== $teacher->id) {
            abort(403, 'Unauthorized access.');
        }

        $class->load(['subject', 'enrollments.student.user']);

        $students = $class->enrollments()
            ->where('status', 'active')
            ->with('student.user')
            ->get();

        $attendances = Attendance::whereHas('enrollment', function($q) use ($class) {
            $q->where('school_class_id', $class->id);
        })
        ->whereDate('date', $date)
        ->with('enrollment')
        ->get()
        ->keyBy('enrollment_id');

        return view('teacher.attendance.edit', compact('class', 'students', 'attendances', 'date'));
    }

    public function report(SchoolClass $class)
    {
        $teacher = auth()->user()->teacher;

        if ($class->teacher_id !== $teacher->id) {
            abort(403, 'Unauthorized access.');
        }

        $class->load(['subject', 'enrollments.student.user', 'enrollments.attendances']);

        $students = $class->enrollments()
            ->where('status', 'active')
            ->with(['student.user', 'attendances'])
            ->get()
            ->map(function($enrollment) {
                $totalDays = $enrollment->attendances->count();
                $presentDays = $enrollment->attendances->where('status', 'present')->count();
                $absentDays = $enrollment->attendances->where('status', 'absent')->count();
                $lateDays = $enrollment->attendances->where('status', 'late')->count();
                $excusedDays = $enrollment->attendances->where('status', 'excused')->count();

                return [
                    'student' => $enrollment->student,
                    'total_days' => $totalDays,
                    'present' => $presentDays,
                    'absent' => $absentDays,
                    'late' => $lateDays,
                    'excused' => $excusedDays,
                    'percentage' => $totalDays > 0 ? round(($presentDays / $totalDays) * 100, 1) : 0,
                ];
            });

        return view('teacher.attendance.report', compact('class', 'students'));
    }
}
