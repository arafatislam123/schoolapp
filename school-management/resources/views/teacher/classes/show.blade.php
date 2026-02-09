@extends('layouts.app')

@section('content')
<div style="max-width: 1400px; margin: 30px auto; padding: 20px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <div>
            <h1>{{ $class->name }}</h1>
            <p style="color: #666; margin: 5px 0 0 0;">{{ $class->subject->name }} - Room {{ $class->room_number }}</p>
        </div>
        <a href="{{ route('teacher.classes.index') }}" style="padding: 10px 20px; background: #6c757d; color: white; text-decoration: none; border-radius: 4px;">
            ← Back to Classes
        </a>
    </div>

    <!-- Class Statistics -->
    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 30px;">
        <div style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); text-align: center;">
            <div style="font-size: 48px; font-weight: bold; color: #007bff;">{{ $totalStudents }}</div>
            <div style="color: #666; margin-top: 10px;">Total Students</div>
        </div>

        <div style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); text-align: center;">
            <div style="font-size: 48px; font-weight: bold; color: #28a745;">{{ round($averageGrade ?? 0, 1) }}%</div>
            <div style="color: #666; margin-top: 10px;">Class Average</div>
        </div>

        <div style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); text-align: center;">
            <div style="font-size: 48px; font-weight: bold; color: #17a2b8;">{{ $averageAttendance }}%</div>
            <div style="color: #666; margin-top: 10px;">Attendance Rate</div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-bottom: 30px;">
        <h3 style="margin-top: 0; padding-bottom: 15px; border-bottom: 2px solid #007bff;">Quick Actions</h3>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-top: 20px;">
            <a href="{{ route('teacher.classes.attendance.create', $class) }}" style="padding: 20px; background: #28a745; color: white; text-decoration: none; border-radius: 8px; text-align: center;">
                <div style="font-size: 32px; margin-bottom: 10px;">✓</div>
                <div style="font-weight: bold;">Mark Attendance</div>
            </a>
            <a href="{{ route('teacher.classes.grades.create', $class) }}" style="padding: 20px; background: #17a2b8; color: white; text-decoration: none; border-radius: 8px; text-align: center;">
                <div style="font-size: 32px; margin-bottom: 10px;">📝</div>
                <div style="font-weight: bold;">Enter Grades</div>
            </a>
            <a href="{{ route('teacher.classes.attendance.index', $class) }}" style="padding: 20px; background: #ffc107; color: white; text-decoration: none; border-radius: 8px; text-align: center;">
                <div style="font-size: 32px; margin-bottom: 10px;">📊</div>
                <div style="font-weight: bold;">View Attendance</div>
            </a>
            <a href="{{ route('teacher.classes.grades.index', $class) }}" style="padding: 20px; background: #6f42c1; color: white; text-decoration: none; border-radius: 8px; text-align: center;">
                <div style="font-size: 32px; margin-bottom: 10px;">📋</div>
                <div style="font-weight: bold;">View Grades</div>
            </a>
        </div>
    </div>

    <!-- Student List -->
    <div style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
        <h3 style="margin-top: 0; padding-bottom: 15px; border-bottom: 2px solid #28a745;">Enrolled Students</h3>
        
        @if($students->count() > 0)
            <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
                <thead>
                    <tr style="background: #f8f9fa;">
                        <th style="padding: 12px; text-align: left; border-bottom: 2px solid #dee2e6;">Student ID</th>
                        <th style="padding: 12px; text-align: left; border-bottom: 2px solid #dee2e6;">Name</th>
                        <th style="padding: 12px; text-align: center; border-bottom: 2px solid #dee2e6;">Average Grade</th>
                        <th style="padding: 12px; text-align: center; border-bottom: 2px solid #dee2e6;">Attendance</th>
                        <th style="padding: 12px; text-align: center; border-bottom: 2px solid #dee2e6;">Total Grades</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $studentData)
                        <tr style="border-bottom: 1px solid #dee2e6;">
                            <td style="padding: 12px;">
                                <strong>{{ $studentData['student']->student_id }}</strong>
                            </td>
                            <td style="padding: 12px;">{{ $studentData['student']->user->name }}</td>
                            <td style="padding: 12px; text-align: center;">
                                @php
                                    $avg = $studentData['average_grade'];
                                    $color = $avg >= 90 ? '#28a745' : ($avg >= 80 ? '#17a2b8' : ($avg >= 70 ? '#ffc107' : ($avg >= 60 ? '#fd7e14' : '#dc3545')));
                                @endphp
                                <strong style="font-size: 18px; color: {{ $color }};">{{ $avg }}%</strong>
                            </td>
                            <td style="padding: 12px; text-align: center;">
                                @php
                                    $attRate = $studentData['attendance_rate'];
                                    $attColor = $attRate >= 95 ? '#28a745' : ($attRate >= 85 ? '#17a2b8' : ($attRate >= 75 ? '#ffc107' : '#dc3545'));
                                @endphp
                                <strong style="color: {{ $attColor }};">{{ $attRate }}%</strong>
                            </td>
                            <td style="padding: 12px; text-align: center;">{{ $studentData['total_grades'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p style="text-align: center; color: #999; padding: 40px;">No students enrolled yet</p>
        @endif
    </div>
</div>
@endsection
