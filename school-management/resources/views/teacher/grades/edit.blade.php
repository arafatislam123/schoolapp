@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Edit Grade</h1>
        <p class="text-gray-600">{{ $class->name }} • {{ $class->subject->name }}</p>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6 max-w-2xl">
        <form action="{{ route('teacher.classes.grades.update', [$class, $grade]) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-2">Student</h3>
                <p class="text-gray-700">{{ $grade->enrollment->student->user->name }}</p>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Assessment Type *</label>
                    <select name="assessment_type" required class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="quiz" {{ $grade->assessment_type == 'quiz' ? 'selected' : '' }}>Quiz</option>
                        <option value="exam" {{ $grade->assessment_type == 'exam' ? 'selected' : '' }}>Exam</option>
                        <option value="assignment" {{ $grade->assessment_type == 'assignment' ? 'selected' : '' }}>Assignment</option>
                        <option value="project" {{ $grade->assessment_type == 'project' ? 'selected' : '' }}>Project</option>
                        <option value="lab" {{ $grade->assessment_type == 'lab' ? 'selected' : '' }}>Lab</option>
                        <option value="essay" {{ $grade->assessment_type == 'essay' ? 'selected' : '' }}>Essay</option>
                    </select>
                    @error('assessment_type')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Assessment Date *</label>
                    <input type="date" name="assessment_date" value="{{ $grade->assessment_date }}" required class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('assessment_date')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Assessment Name *</label>
                <input type="text" name="assessment_name" value="{{ $grade->assessment_name }}" required placeholder="e.g., Midterm Exam, Chapter 5 Quiz" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('assessment_name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Score *</label>
                    <input type="number" name="score" value="{{ $grade->score }}" step="0.01" min="0" required class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('score')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Max Score *</label>
                    <input type="number" name="max_score" value="{{ $grade->max_score }}" step="0.01" min="1" required class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('max_score')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Remarks</label>
                <textarea name="remarks" rows="3" placeholder="Optional feedback for the student" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">{{ $grade->remarks }}</textarea>
                @error('remarks')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-3">
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Update Grade
                </button>
                <a href="{{ route('teacher.classes.grades.index', $class) }}" class="px-6 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
