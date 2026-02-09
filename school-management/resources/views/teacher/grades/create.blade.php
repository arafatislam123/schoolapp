@extends('layouts.app')

@section('content')
<div style="max-width: 1200px; margin: 30px auto; padding: 20px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <div>
            <h1>Enter Grades</h1>
            <p style="color: #666; margin: 5px 0 0 0;">{{ $class->name }} - {{ $class->subject->name }}</p>
        </div>
        <a href="{{ route('teacher.classes.show', $class) }}" style="padding: 10px 20px; background: #6c757d; color: white; text-decoration: none; border-radius: 4px;">
            ← Back to Class
        </a>
    </div>

    @if($errors->any())
        <div style="padding: 15px; background: #f8d7da; color: #721c24; margin-bottom: 20px; border-radius: 4px;">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('teacher.classes.grades.store', $class) }}" style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
        @csrf

        <!-- Assessment Details -->
        <h3 style="margin-top: 0; padding-bottom: 15px; border-bottom: 2px solid #007bff;">Assessment Details</h3>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin: 20px 0;">
            <div>
                <label for="assessment_type" style="display: block; font-weight: bold; margin-bottom: 5px;">Assessment Type *</label>
                <select id="assessment_type" name="assessment_type" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
                    <option value="">Select Type</option>
                    <option value="quiz" {{ old('assessment_type') == 'quiz' ? 'selected' : '' }}>Quiz</option>
                    <option value="exam" {{ old('assessment_type') == 'exam' ? 'selected' : '' }}>Exam</option>
                    <option value="assignment" {{ old('assessment_type') == 'assignment' ? 'selected' : '' }}>Assignment</option>
                    <option value="project" {{ old('assessment_type') == 'project' ? 'selected' : '' }}>Project</option>
                    <option value="lab" {{ old('assessment_type') == 'lab' ? 'selected' : '' }}>Lab Work</option>
                    <option value="essay" {{ old('assessment_type') == 'essay' ? 'selected' : '' }}>Essay</option>
                </select>
            </div>

            <div>
                <label for="assessment_name" style="display: block; font-weight: bold; margin-bottom: 5px;">Assessment Name *</label>
                <input type="text" id="assessment_name" name="assessment_name" value="{{ old('assessment_name') }}" placeholder="e.g., Midterm Exam, Chapter 5 Quiz" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 25px;">
            <div>
                <label for="assessment_date" style="display: block; font-weight: bold; margin-bottom: 5px;">Assessment Date *</label>
                <input type="date" id="assessment_date" name="assessment_date" value="{{ old('assessment_date', today()->format('Y-m-d')) }}" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
            </div>

            <div>
                <label for="max_score" style="display: block; font-weight: bold; margin-bottom: 5px;">Maximum Score *</label>
                <input type="number" id="max_score" name="max_score" value="{{ old('max_score', 100) }}" min="1" step="0.01" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
            </div>
        </div>

        <!-- Student Grades -->
        <h3 style="margin-top: 30px; padding-bottom: 15px; border-bottom: 2px solid #28a745;">Student Scores</h3>

        @if($students->count() > 0)
            <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
                <thead>
                    <tr style="background: #f8f9fa;">
                        <th style="padding: 12px; text-align: left; border-bottom: 2px solid #dee2e6;">Student ID</th>
                        <th style="padding: 12px; text-align: left; border-bottom: 2px solid #dee2e6;">Student Name</th>
                        <th style="padding: 12px; text-align: center; border-bottom: 2px solid #dee2e6; width: 150px;">Score *</th>
                        <th style="padding: 12px; text-align: left; border-bottom: 2px solid #dee2e6;">Remarks (Optional)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $index => $enrollment)
                        <tr style="border-bottom: 1px solid #dee2e6;">
                            <td style="padding: 12px;">
                                <strong>{{ $enrollment->student->student_id }}</strong>
                                <input type="hidden" name="grades[{{ $index }}][enrollment_id]" value="{{ $enrollment->id }}">
                            </td>
                            <td style="padding: 12px;">{{ $enrollment->student->user->name }}</td>
                            <td style="padding: 12px; text-align: center;">
                                <input type="number" name="grades[{{ $index }}][score]" value="{{ old("grades.{$index}.score") }}" min="0" step="0.01" required style="width: 100px; padding: 8px; border: 1px solid #ddd; border-radius: 4px; text-align: center;">
                            </td>
                            <td style="padding: 12px;">
                                <input type="text" name="grades[{{ $index }}][remarks]" value="{{ old("grades.{$index}.remarks") }}" placeholder="Optional feedback" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #ddd;">
                <button type="submit" style="padding: 12px 30px; background: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 16px;">
                    Save Grades
                </button>
                <a href="{{ route('teacher.classes.show', $class) }}" style="margin-left: 10px; padding: 12px 30px; background: #6c757d; color: white; text-decoration: none; border-radius: 4px; display: inline-block;">
                    Cancel
                </a>
            </div>
        @else
            <p style="text-align: center; color: #999; padding: 40px;">No students enrolled in this class</p>
        @endif
    </form>
</div>
@endsection
