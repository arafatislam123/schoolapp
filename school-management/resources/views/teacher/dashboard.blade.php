@extends('layouts.app')

@section('content')
<div style="padding: 20px;">
    <div style="margin-bottom: 30px;">
        <h1>Teacher Dashboard</h1>
        <p style="color: #666;">Welcome back, {{ auth()->user()->name }}!</p>
    </div>

    <!-- Quick Stats -->
    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 30px;">
        <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
            <div style="font-size: 14px; opacity: 0.9;">My Classes</div>
            <div style="font-size: 48px; font-weight: bold; margin: 10px 0;">{{ $totalClasses }}</div>
            <div style="font-size: 14px; opacity: 0.9;">Active Classes</div>
        </div>

        <div style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
            <div style="font-size: 14px; opacity: 0.9;">Total Students</div>
            <div style="font-size: 48px; font-weight: bold; margin: 10px 0;">{{ $totalStudents }}</div>
            <div style="font-size: 14px; opacity: 0.9;">Across All Classes</div>
        </div>

        <div style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
            <div style="font-size: 14px; opacity: 0.9;">Grades This Week</div>
            <div style="font-size: 48px; font-weight: bold; margin: 10px 0;">{{ $recentGrades }}</div>
            <div style="font-size: 14px; opacity: 0.9;">Last 7 Days</div>
        </div>

        <div style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); color: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
            <div style="font-size: 14px; opacity: 0.9;">Attendance Today</div>
            <div style="font-size: 48px; font-weight: bold; margin: 10px 0;">{{ $attendanceToday }}</div>
            <div style="font-size: 14px; opacity: 0.9;">Records Marked</div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-bottom: 30px;">
        <h3 style="margin-top: 0; padding-bottom: 15px; border-bottom: 2px solid #007bff;">Quick Actions</h3>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-top: 20px;">
            <a href="{{ route('teacher.classes.index') }}" style="padding: 20px; background: #007bff; color: white; text-decoration: none; border-radius: 8px; text-align: center; transition: transform 0.2s;">
                <div style="font-size: 32px; margin-bottom: 10px;">📚</div>
                <div style="font-weight: bold;">My Classes</div>
            </a>
            @if($classes->count() > 0)
                <a href="{{ route('teacher.classes.attendance.create', $classes->first()) }}" style="padding: 20px; background: #28a745; color: white; text-decoration: none; border-radius: 8px; text-align: center;">
                    <div style="font-size: 32px; margin-bottom: 10px;">✓</div>
                    <div style="font-weight: bold;">Mark Attendance</div>
                </a>
                <a href="{{ route('teacher.classes.grades.create', $classes->first()) }}" style="padding: 20px; background: #17a2b8; color: white; text-decoration: none; border-radius: 8px; text-align: center;">
                    <div style="font-size: 32px; margin-bottom: 10px;">📝</div>
                    <div style="font-weight: bold;">Enter Grades</div>
                </a>
            @endif
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
        <!-- Today's Classes -->
        <div style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            <h3 style="margin-top: 0; padding-bottom: 15px; border-bottom: 2px solid #28a745;">Today's Schedule</h3>
            @if($todayClasses->count() > 0)
                <div style="margin-top: 20px;">
                    @foreach($todayClasses as $class)
                        <div style="padding: 15px; background: #f8f9fa; border-left: 4px solid #28a745; border-radius: 4px; margin-bottom: 15px;">
                            <div style="font-weight: bold; color: #007bff; margin-bottom: 5px;">{{ $class->name }}</div>
                            <div style="color: #666; font-size: 14px;">{{ $class->subject->name }}</div>
                            <div style="color: #666; font-size: 14px; margin-top: 5px;">
                                📍 Room {{ $class->room_number }} | ⏰ {{ $class->schedule }}
                            </div>
                            <div style="margin-top: 10px;">
                                <a href="{{ route('teacher.classes.show', $class) }}" style="color: #007bff; font-size: 14px;">View Class →</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p style="text-align: center; color: #999; padding: 40px 20px;">No classes scheduled for today</p>
            @endif
        </div>

        <!-- Recent Activity -->
        <div style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            <h3 style="margin-top: 0; padding-bottom: 15px; border-bottom: 2px solid #17a2b8;">Recent Activity</h3>
            @if($recentActivity->count() > 0)
                <div style="margin-top: 20px;">
                    @foreach($recentActivity as $activity)
                        <div style="padding: 15px; border-bottom: 1px solid #dee2e6;">
                            <div style="display: flex; align-items: start; gap: 10px;">
                                <div style="font-size: 24px;">{{ $activity['icon'] }}</div>
                                <div style="flex: 1;">
                                    <div style="font-weight: bold; color: #333; margin-bottom: 5px;">{{ $activity['message'] }}</div>
                                    <div style="color: #666; font-size: 14px;">{{ $activity['details'] }}</div>
                                    <div style="color: #999; font-size: 12px; margin-top: 5px;">{{ $activity['time']->diffForHumans() }}</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p style="text-align: center; color: #999; padding: 40px 20px;">No recent activity</p>
            @endif
        </div>
    </div>

    <!-- My Classes Overview -->
    <div style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-top: 30px;">
        <h3 style="margin-top: 0; padding-bottom: 15px; border-bottom: 2px solid #ffc107;">My Classes Overview</h3>
        @if($classes->count() > 0)
            <div style="margin-top: 20px;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background: #f8f9fa;">
                            <th style="padding: 12px; text-align: left; border-bottom: 2px solid #dee2e6;">Class Name</th>
                            <th style="padding: 12px; text-align: left; border-bottom: 2px solid #dee2e6;">Subject</th>
                            <th style="padding: 12px; text-align: center; border-bottom: 2px solid #dee2e6;">Students</th>
                            <th style="padding: 12px; text-align: center; border-bottom: 2px solid #dee2e6;">Schedule</th>
                            <th style="padding: 12px; text-align: center; border-bottom: 2px solid #dee2e6;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($classes as $class)
                            <tr style="border-bottom: 1px solid #dee2e6;">
                                <td style="padding: 12px;">
                                    <strong>{{ $class->name }}</strong><br>
                                    <small style="color: #666;">Room {{ $class->room_number }}</small>
                                </td>
                                <td style="padding: 12px;">{{ $class->subject->name }}</td>
                                <td style="padding: 12px; text-align: center;">
                                    <strong style="font-size: 18px;">{{ $class->enrollments->where('status', 'active')->count() }}</strong>
                                </td>
                                <td style="padding: 12px; text-align: center;">
                                    <small style="color: #666;">{{ $class->schedule ?? 'Not set' }}</small>
                                </td>
                                <td style="padding: 12px; text-align: center;">
                                    <a href="{{ route('teacher.classes.show', $class) }}" style="color: #007bff; margin-right: 10px;">View</a>
                                    <a href="{{ route('teacher.classes.attendance.create', $class) }}" style="color: #28a745; margin-right: 10px;">Attendance</a>
                                    <a href="{{ route('teacher.classes.grades.create', $class) }}" style="color: #17a2b8;">Grades</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p style="text-align: center; color: #999; padding: 40px 20px;">No classes assigned yet</p>
        @endif
    </div>
</div>
@endsection
