<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminStudentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Student::with(['user', 'parent']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('student_id', 'like', "%{$search}%")
                  ->orWhere('grade_level', 'like', "%{$search}%")
                  ->orWhere('section', 'like', "%{$search}%")
                  ->orWhereHas('user', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by grade level
        if ($request->filled('grade_level')) {
            $query->where('grade_level', $request->grade_level);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $students = $query->paginate(15);
        
        // Get unique grade levels for filter
        $gradeLevels = Student::select('grade_level')->distinct()->pluck('grade_level');

        return view('admin.students.index', compact('students', 'gradeLevels'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parents = User::whereHas('role', function($q) {
            $q->where('slug', 'parent');
        })->get();

        return view('admin.students.create', compact('parents'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'date_of_birth' => 'required|date',
            'student_id' => 'required|string|unique:students',
            'grade_level' => 'required|string',
            'section' => 'nullable|string',
            'parent_id' => 'nullable|exists:users,id',
            'admission_date' => 'required|date',
            'medical_info' => 'nullable|string',
            'emergency_contact' => 'nullable|string',
            'status' => 'required|in:active,inactive,graduated,transferred',
        ]);

        DB::beginTransaction();
        try {
            // Get student role
            $studentRole = Role::where('slug', 'student')->first();

            // Create user account
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role_id' => $studentRole->id,
                'phone' => $validated['phone'] ?? null,
                'address' => $validated['address'] ?? null,
                'date_of_birth' => $validated['date_of_birth'],
                'status' => 'active',
            ]);

            // Create student profile
            Student::create([
                'user_id' => $user->id,
                'student_id' => $validated['student_id'],
                'grade_level' => $validated['grade_level'],
                'section' => $validated['section'] ?? null,
                'parent_id' => $validated['parent_id'] ?? null,
                'admission_date' => $validated['admission_date'],
                'medical_info' => $validated['medical_info'] ?? null,
                'emergency_contact' => $validated['emergency_contact'] ?? null,
                'status' => $validated['status'],
            ]);

            DB::commit();
            return redirect()->route('admin.students.index')->with('success', 'Student created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to create student: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        $student->load(['user', 'parent', 'enrollments.schoolClass.subject', 'enrollments.schoolClass.teacher']);
        return view('admin.students.show', compact('student'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        $parents = User::whereHas('role', function($q) {
            $q->where('slug', 'parent');
        })->get();

        return view('admin.students.edit', compact('student', 'parents'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $student->user_id,
            'password' => 'nullable|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'date_of_birth' => 'required|date',
            'student_id' => 'required|string|unique:students,student_id,' . $student->id,
            'grade_level' => 'required|string',
            'section' => 'nullable|string',
            'parent_id' => 'nullable|exists:users,id',
            'admission_date' => 'required|date',
            'medical_info' => 'nullable|string',
            'emergency_contact' => 'nullable|string',
            'status' => 'required|in:active,inactive,graduated,transferred',
        ]);

        DB::beginTransaction();
        try {
            // Update user account
            $student->user->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'] ?? null,
                'address' => $validated['address'] ?? null,
                'date_of_birth' => $validated['date_of_birth'],
            ]);

            if ($request->filled('password')) {
                $student->user->update(['password' => Hash::make($validated['password'])]);
            }

            // Update student profile
            $student->update([
                'student_id' => $validated['student_id'],
                'grade_level' => $validated['grade_level'],
                'section' => $validated['section'] ?? null,
                'parent_id' => $validated['parent_id'] ?? null,
                'admission_date' => $validated['admission_date'],
                'medical_info' => $validated['medical_info'] ?? null,
                'emergency_contact' => $validated['emergency_contact'] ?? null,
                'status' => $validated['status'],
            ]);

            DB::commit();
            return redirect()->route('admin.students.index')->with('success', 'Student updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to update student: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        try {
            $student->user->delete(); // This will cascade delete the student
            return redirect()->route('admin.students.index')->with('success', 'Student deleted successfully!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to delete student: ' . $e->getMessage()]);
        }
    }

    /**
     * Generate unique student ID
     */
    public function generateStudentId()
    {
        $year = date('Y');
        $lastStudent = Student::where('student_id', 'like', "STU{$year}%")->orderBy('student_id', 'desc')->first();
        
        if ($lastStudent) {
            $lastNumber = intval(substr($lastStudent->student_id, -4));
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '0001';
        }
        
        return response()->json(['student_id' => "STU{$year}{$newNumber}"]);
    }
}
