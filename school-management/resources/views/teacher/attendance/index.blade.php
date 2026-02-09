@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Attendance - {{ $class->name }}</h1>
            <p class="text-gray-600">{{ $class->subject->name }} • {{ $class->section }}</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('teacher.classes.show', $class) }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                ← Back to Class
            </a>
            <a href="{{ route('teacher.classes.attendance.report', $class) }}" class="px-4 py-2 bg-purple-600 text-white rounded hover:bg-purple-700">
                📊 View Report
            </a>
            <a href="{{ route('teacher.classes.attendance.create', $class) }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                + Mark Attendance
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
            <h2 class="text-xl font-semibold mb-4">Attendance History (Last 30 Days)</h2>
            
            @if($attendances->isEmpty())
                <div class="text-center py-12 text-gray-500">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    <p class="mt-2">No attendance records yet</p>
                    <a href="{{ route('teacher.classes.attendance.create', $class) }}" class="mt-4 inline-block text-blue-600 hover:underline">
                        Mark your first attendance →
                    </a>
                </div>
            @else
                <div class="space-y-4">
                    @foreach($attendances as $date => $dayAttendances)
                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="flex justify-between items-center mb-3">
                            <h3 class="text-lg font-semibold text-gray-800">
                                {{ \Carbon\Carbon::parse($date)->format('l, F d, Y') }}
                            </h3>
                            <a href="{{ route('teacher.classes.attendance.edit', [$class, $date]) }}" class="text-blue-600 hover:underline text-sm">
                                Edit
                            </a>
                        </div>
                        
                        <div class="grid grid-cols-4 gap-4 mb-3">
                            @php
                                $present = $dayAttendances->where('status', 'present')->count();
                                $absent = $dayAttendances->where('status', 'absent')->count();
                                $late = $dayAttendances->where('status', 'late')->count();
                                $excused = $dayAttendances->where('status', 'excused')->count();
                            @endphp
                            <div class="text-center">
                                <div class="text-2xl font-bold text-green-600">{{ $present }}</div>
                                <div class="text-sm text-gray-600">Present</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-red-600">{{ $absent }}</div>
                                <div class="text-sm text-gray-600">Absent</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-yellow-600">{{ $late }}</div>
                                <div class="text-sm text-gray-600">Late</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-blue-600">{{ $excused }}</div>
                                <div class="text-sm text-gray-600">Excused</div>
                            </div>
                        </div>

                        <details class="mt-2">
                            <summary class="cursor-pointer text-sm text-gray-600 hover:text-gray-800">View Details</summary>
                            <div class="mt-3 space-y-1">
                                @foreach($dayAttendances->sortBy('enrollment.student.user.name') as $attendance)
                                <div class="flex justify-between items-center py-1 px-2 hover:bg-gray-50 rounded">
                                    <span class="text-sm">{{ $attendance->enrollment->student->user->name }}</span>
                                    <span class="px-2 py-1 text-xs font-semibold rounded
                                        @if($attendance->status == 'present') bg-green-100 text-green-800
                                        @elseif($attendance->status == 'absent') bg-red-100 text-red-800
                                        @elseif($attendance->status == 'late') bg-yellow-100 text-yellow-800
                                        @else bg-blue-100 text-blue-800
                                        @endif">
                                        {{ ucfirst($attendance->status) }}
                                    </span>
                                </div>
                                @endforeach
                            </div>
                        </details>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
