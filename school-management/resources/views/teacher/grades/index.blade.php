@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Grades - {{ $class->name }}</h1>
            <p class="text-gray-600">{{ $class->subject->name }} • {{ $class->section }}</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('teacher.classes.show', $class) }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                ← Back to Class
            </a>
            <a href="{{ route('teacher.classes.grades.create', $class) }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                + Enter New Grades
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-6">
            <h2 class="text-xl font-semibold mb-4">All Grades</h2>
            
            @php
                $allGrades = $students->flatMap(function($enrollment) {
                    return $enrollment->grades->map(function($grade) use ($enrollment) {
                        $grade->student = $enrollment->student;
                        return $grade;
                    });
                })->sortByDesc('assessment_date');
            @endphp

            @if($allGrades->isEmpty())
                <div class="text-center py-12 text-gray-500">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <p class="mt-2">No grades entered yet</p>
                    <a href="{{ route('teacher.classes.grades.create', $class) }}" class="mt-4 inline-block text-blue-600 hover:underline">
                        Enter your first grades →
                    </a>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Assessment</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Student</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Score</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Grade</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($allGrades as $grade)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ \Carbon\Carbon::parse($grade->assessment_date)->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <div class="font-medium text-gray-900">{{ $grade->assessment_name }}</div>
                                    <div class="text-gray-500">{{ ucfirst($grade->assessment_type) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $grade->student->user->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $grade->score }}/{{ $grade->max_score }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                        @if($grade->letter_grade == 'A') bg-green-100 text-green-800
                                        @elseif($grade->letter_grade == 'B') bg-blue-100 text-blue-800
                                        @elseif($grade->letter_grade == 'C') bg-yellow-100 text-yellow-800
                                        @elseif($grade->letter_grade == 'D') bg-orange-100 text-orange-800
                                        @else bg-red-100 text-red-800
                                        @endif">
                                        {{ $grade->letter_grade }} ({{ round($grade->percentage, 1) }}%)
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <a href="{{ route('teacher.classes.grades.edit', [$class, $grade]) }}" class="text-blue-600 hover:underline mr-3">Edit</a>
                                    <form action="{{ route('teacher.classes.grades.destroy', [$class, $grade]) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this grade?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <div class="mt-6 bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-semibold mb-4">Student Grade Summary</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Student</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total Assessments</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Average Grade</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Letter Grade</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($students as $enrollment)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $enrollment->student->user->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $enrollment->grades->count() }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            @if($enrollment->grades->count() > 0)
                                {{ round($enrollment->averageGrade(), 1) }}%
                            @else
                                <span class="text-gray-400">No grades</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($enrollment->grades->count() > 0)
                                @php
                                    $avg = $enrollment->averageGrade();
                                    $letter = $avg >= 90 ? 'A' : ($avg >= 80 ? 'B' : ($avg >= 70 ? 'C' : ($avg >= 60 ? 'D' : 'F')));
                                @endphp
                                <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                    @if($letter == 'A') bg-green-100 text-green-800
                                    @elseif($letter == 'B') bg-blue-100 text-blue-800
                                    @elseif($letter == 'C') bg-yellow-100 text-yellow-800
                                    @elseif($letter == 'D') bg-orange-100 text-orange-800
                                    @else bg-red-100 text-red-800
                                    @endif">
                                    {{ $letter }}
                                </span>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
