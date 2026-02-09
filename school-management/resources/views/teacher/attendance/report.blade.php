@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Attendance Report</h1>
            <p class="text-gray-600">{{ $class->name }} • {{ $class->subject->name }}</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('teacher.classes.attendance.index', $class) }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                ← Back
            </a>
            <button onclick="window.print()" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                🖨️ Print Report
            </button>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden print:shadow-none">
        <div class="p-6">
            <h2 class="text-xl font-semibold mb-6">Student Attendance Summary</h2>
            
            @if($students->isEmpty())
                <div class="text-center py-12 text-gray-500">
                    <p>No attendance data available</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Student</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Total Days</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Present</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Absent</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Late</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Excused</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Attendance %</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($students as $studentData)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $studentData['student']->user->name }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ $studentData['student']->student_id }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center text-sm text-gray-900">
                                    {{ $studentData['total_days'] }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                        {{ $studentData['present'] }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                        {{ $studentData['absent'] }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        {{ $studentData['late'] }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                        {{ $studentData['excused'] }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center">
                                        <div class="text-sm font-semibold 
                                            @if($studentData['percentage'] >= 90) text-green-600
                                            @elseif($studentData['percentage'] >= 75) text-blue-600
                                            @elseif($studentData['percentage'] >= 60) text-yellow-600
                                            @else text-red-600
                                            @endif">
                                            {{ $studentData['percentage'] }}%
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($studentData['percentage'] >= 90)
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                            Excellent
                                        </span>
                                    @elseif($studentData['percentage'] >= 75)
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                            Good
                                        </span>
                                    @elseif($studentData['percentage'] >= 60)
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            Fair
                                        </span>
                                    @else
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                            Poor
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-gray-50">
                            <tr>
                                <td colspan="8" class="px-6 py-4">
                                    <div class="flex justify-between items-center">
                                        <div class="text-sm text-gray-600">
                                            <strong>Class Average:</strong> 
                                            {{ $students->isEmpty() ? 0 : round($students->avg('percentage'), 1) }}%
                                        </div>
                                        <div class="text-sm text-gray-600">
                                            <strong>Total Students:</strong> {{ $students->count() }}
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6 print:grid-cols-3">
                    <div class="bg-green-50 rounded-lg p-4 border border-green-200">
                        <h3 class="text-sm font-semibold text-green-800 mb-2">Excellent Attendance (≥90%)</h3>
                        <div class="text-3xl font-bold text-green-600">
                            {{ $students->where('percentage', '>=', 90)->count() }}
                        </div>
                        <p class="text-sm text-green-700 mt-1">students</p>
                    </div>

                    <div class="bg-yellow-50 rounded-lg p-4 border border-yellow-200">
                        <h3 class="text-sm font-semibold text-yellow-800 mb-2">At Risk (60-75%)</h3>
                        <div class="text-3xl font-bold text-yellow-600">
                            {{ $students->whereBetween('percentage', [60, 74.9])->count() }}
                        </div>
                        <p class="text-sm text-yellow-700 mt-1">students</p>
                    </div>

                    <div class="bg-red-50 rounded-lg p-4 border border-red-200">
                        <h3 class="text-sm font-semibold text-red-800 mb-2">Critical (<60%)</h3>
                        <div class="text-3xl font-bold text-red-600">
                            {{ $students->where('percentage', '<', 60)->count() }}
                        </div>
                        <p class="text-sm text-red-700 mt-1">students</p>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div class="mt-4 text-sm text-gray-500 print:mt-8">
        <p>Report generated on {{ now()->format('F d, Y \a\t g:i A') }}</p>
    </div>
</div>

<style>
@media print {
    .print\:shadow-none {
        box-shadow: none !important;
    }
    button, a {
        display: none !important;
    }
    .print\:grid-cols-3 {
        grid-template-columns: repeat(3, minmax(0, 1fr)) !important;
    }
}
</style>
@endsection
