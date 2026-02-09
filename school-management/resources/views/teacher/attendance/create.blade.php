@extends('layouts.app')

@section('content')
<div style="max-width: 1200px; margin: 30px auto; padding: 20px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <div>
            <h1>Mark Attendance</h1>
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

    @if($todayAttendance->count() > 0)
        <div style="padding: 15px; background: #fff3cd; color: #856404; margin-bottom: 20px; border-radius: 4px;">
            ⚠️ Attendance has already been marked for today. You can edit it or mark for a different date.
        </div>
    @endif

    <form method="POST" action="{{ route('teacher.classes.attendance.store', $class) }}" style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
        @csrf

        <div style="margin-bottom: 25px;">
            <label for="date" style="display: block; font-weight: bold; margin-bottom: 5px;">Date *</label>
            <input type="date" id="date" name="date" value="{{ old('date', today()->format('Y-m-d')) }}" required style="padding: 10px; border: 1px solid #ddd; border-radius: 4px; width: 200px;">
        </div>

        <h3 style="margin-top: 30px; padding-bottom: 15px; border-bottom: 2px solid #007bff;">Student Attendance</h3>

        @if($students->count() > 0)
            <!-- Quick Actions -->
            <div style="margin: 20px 0; padding: 15px; background: #f8f9fa; border-radius: 4px;">
                <strong>Quick Actions:</strong>
                <button type="button" onclick="markAll('present')" style="margin-left: 10px; padding: 5px 15px; background: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer;">
                    Mark All Present
                </button>
                <button type="button" onclick="markAll('absent')" style="margin-left: 10px; padding: 5px 15px; background: #dc3545; color: white; border: none; border-radius: 4px; cursor: pointer;">
                    Mark All Absent
                </button>
            </div>

            <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
                <thead>
                    <tr style="background: #f8f9fa;">
                        <th style="padding: 12px; text-align: left; border-bottom: 2px solid #dee2e6;">Student ID</th>
                        <th style="padding: 12px; text-align: left; border-bottom: 2px solid #dee2e6;">Student Name</th>
                        <th style="padding: 12px; text-align: center; border-bottom: 2px solid #dee2e6;">Status</th>
                        <th style="padding: 12px; text-align: left; border-bottom: 2px solid #dee2e6;">Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $index => $enrollment)
                        @php
                            $existingAttendance = $todayAttendance->get($enrollment->id);
                            $defaultStatus = $existingAttendance ? $existingAttendance->status : 'present';
                        @endphp
                        <tr style="border-bottom: 1px solid #dee2e6;">
                            <td style="padding: 12px;">
                                <strong>{{ $enrollment->student->student_id }}</strong>
                                <input type="hidden" name="attendance[{{ $index }}][enrollment_id]" value="{{ $enrollment->id }}">
                            </td>
                            <td style="padding: 12px;">{{ $enrollment->student->user->name }}</td>
                            <td style="padding: 12px; text-align: center;">
                                <div style="display: flex; gap: 10px; justify-content: center;">
                                    <label style="cursor: pointer;">
                                        <input type="radio" name="attendance[{{ $index }}][status]" value="present" {{ $defaultStatus === 'present' ? 'checked' : '' }} required>
                                        <span style="padding: 5px 10px; background: #28a745; color: white; border-radius: 4px; font-size: 12px;">Present</span>
                                    </label>
                                    <label style="cursor: pointer;">
                                        <input type="radio" name="attendance[{{ $index }}][status]" value="absent" {{ $defaultStatus === 'absent' ? 'checked' : '' }}>
                                        <span style="padding: 5px 10px; background: #dc3545; color: white; border-radius: 4px; font-size: 12px;">Absent</span>
                                    </label>
                                    <label style="cursor: pointer;">
                                        <input type="radio" name="attendance[{{ $index }}][status]" value="late" {{ $defaultStatus === 'late' ? 'checked' : '' }}>
                                        <span style="padding: 5px 10px; background: #ffc107; color: white; border-radius: 4px; font-size: 12px;">Late</span>
                                    </label>
                                    <label style="cursor: pointer;">
                                        <input type="radio" name="attendance[{{ $index }}][status]" value="excused" {{ $defaultStatus === 'excused' ? 'checked' : '' }}>
                                        <span style="padding: 5px 10px; background: #17a2b8; color: white; border-radius: 4px; font-size: 12px;">Excused</span>
                                    </label>
                                </div>
                            </td>
                            <td style="padding: 12px;">
                                <input type="text" name="attendance[{{ $index }}][remarks]" value="{{ $existingAttendance ? $existingAttendance->remarks : '' }}" placeholder="Optional remarks" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #ddd;">
                <button type="submit" style="padding: 12px 30px; background: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 16px;">
                    Save Attendance
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

<script>
function markAll(status) {
    const radios = document.querySelectorAll(`input[type="radio"][value="${status}"]`);
    radios.forEach(radio => {
        radio.checked = true;
    });
}
</script>

<style>
input[type="radio"] {
    display: none;
}
input[type="radio"]:checked + span {
    box-shadow: 0 0 0 3px rgba(0,0,0,0.2);
    transform: scale(1.05);
}
label {
    display: inline-block;
    transition: transform 0.2s;
}
label:hover {
    transform: scale(1.05);
}
</style>
@endsection
