<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SchoolClass;
use App\Models\Enrollment;
use App\Models\Grade;

class TeacherGradeController extends Controller
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

        $class->load(['subject', 'enrollments.student.user', 'enrollments.grades']);

        $students = $class->enrollments()
            ->where('status', 'active')
            ->with(['student.user', 'grades'])
            ->get();

        return view('teacher.grades.index', compact('class', 'students'));
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

        return view('teacher.grades.create', compact('class', 'students'));
    }

    public function store(Request $request, SchoolClass $class)
    {
        $teacher = auth()->user()->teacher;

        if ($class->teacher_id !== $teacher->id) {
            abort(403, 'Unauthorized access.');
        }

        $validated = $request->validate([
            'assessment_type' => 'required|in:quiz,exam,assignment,project,lab,essay',
            'assessment_name' => 'required|string|max:255',
            'assessment_date' => 'required|date',
            'max_score' => 'required|numeric|min:1',
            'grades' => 'required|array',
            'grades.*.enrollment_id' => 'required|exists:enrollments,id',
            'grades.*.score' => 'required|numeric|min:0',
            'grades.*.remarks' => 'nullable|string',
        ]);

        foreach ($validated['grades'] as $gradeData) {
            // Verify enrollment belongs to this class
            $enrollment = Enrollment::find($gradeData['enrollment_id']);
            if ($enrollment->school_class_id !== $class->id) {
                continue;
            }

            Grade::create([
                'enrollment_id' => $gradeData['enrollment_id'],
                'assessment_type' => $validated['assessment_type'],
                'assessment_name' => $validated['assessment_name'],
                'score' => $gradeData['score'],
                'max_score' => $validated['max_score'],
                'assessment_date' => $validated['assessment_date'],
                'remarks' => $gradeData['remarks'] ?? null,
            ]);
        }

        return redirect()
            ->route('teacher.classes.grades.index', $class)
            ->with('success', 'Grades entered successfully!');
    }

    public function edit(SchoolClass $class, Grade $grade)
    {
        $teacher = auth()->user()->teacher;

        if ($class->teacher_id !== $teacher->id) {
            abort(403, 'Unauthorized access.');
        }

        $grade->load('enrollment.student.user');

        return view('teacher.grades.edit', compact('class', 'grade'));
    }

    public function update(Request $request, SchoolClass $class, Grade $grade)
    {
        $teacher = auth()->user()->teacher;

        if ($class->teacher_id !== $teacher->id) {
            abort(403, 'Unauthorized access.');
        }

        $validated = $request->validate([
            'assessment_type' => 'required|in:quiz,exam,assignment,project,lab,essay',
            'assessment_name' => 'required|string|max:255',
            'score' => 'required|numeric|min:0',
            'max_score' => 'required|numeric|min:1',
            'assessment_date' => 'required|date',
            'remarks' => 'nullable|string',
        ]);

        $grade->update($validated);

        return redirect()
            ->route('teacher.classes.grades.index', $class)
            ->with('success', 'Grade updated successfully!');
    }

    public function destroy(SchoolClass $class, Grade $grade)
    {
        $teacher = auth()->user()->teacher;

        if ($class->teacher_id !== $teacher->id) {
            abort(403, 'Unauthorized access.');
        }

        $grade->delete();

        return redirect()
            ->route('teacher.classes.grades.index', $class)
            ->with('success', 'Grade deleted successfully!');
    }
}
