@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Edit Attendance</h1>
        <p class="text-gray-600">{{ $class->name }} • {{ \Carbon\Carbon::parse($date)->format('F d, Y') }}</p>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('teacher.classes.attendance.store', $class) }}" method="POST">
            @csrf
            
            <input type="hidden" name="date" value="{{ $date }}">

            <div class="mb-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold">Student Attendance</h2>
                    <div class="flex gap-2">
                        <button type="button" onclick="markAll('present')" class="px-3 py-1 text-sm bg-green-100 text-green-700 rounded hover:bg-green-200">
                            Mark All Present
                        </button>
                        <button type="button" onclick="markAll('absent')" class="px-3 py-1 text-sm bg-red-100 text-red-700 rounded hover:bg-red-200">
                            Mark All Absent
                        </button>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Student</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Remarks</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($students as $enrollment)
                            @php
                                $existingAttendance = $attendances->get($enrollment->id);
                                $currentStatus = $existingAttendance ? $existingAttendance->status : 'present';
                                $currentRemarks = $existingAttendance ? $existingAttendance->remarks : '';
                            @endphp
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $enrollment->student->user->name }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ $enrollment->student->student_id }}
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="attendance[{{ $loop->index }}][enrollment_id]" value="{{ $enrollment->id }}">
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex gap-4">
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="attendance[{{ $loop->index }}][status]" value="present" {{ $currentStatus == 'present' ? 'checked' : '' }} class="form-radio text-green-600" required>
                                            <span class="ml-2 text-sm">Present</span>
                                        </label>
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="attendance[{{ $loop->index }}][status]" value="absent" {{ $currentStatus == 'absent' ? 'checked' : '' }} class="form-radio text-red-600">
                                            <span class="ml-2 text-sm">Absent</span>
                                        </label>
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="attendance[{{ $loop->index }}][status]" value="late" {{ $currentStatus == 'late' ? 'checked' : '' }} class="form-radio text-yellow-600">
                                            <span class="ml-2 text-sm">Late</span>
                                        </label>
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="attendance[{{ $loop->index }}][status]" value="excused" {{ $currentStatus == 'excused' ? 'checked' : '' }} class="form-radio text-blue-600">
                                            <span class="ml-2 text-sm">Excused</span>
                                        </label>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <input type="text" name="attendance[{{ $loop->index }}][remarks]" value="{{ $currentRemarks }}" placeholder="Optional notes" class="w-full px-3 py-1 text-sm border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Update Attendance
                </button>
                <a href="{{ route('teacher.classes.attendance.index', $class) }}" class="px-6 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<script>
function markAll(status) {
    const radios = document.querySelectorAll(`input[type="radio"][value="${status}"]`);
    radios.forEach(radio => {
        radio.checked = true;
    });
}
</script>
@endsection
