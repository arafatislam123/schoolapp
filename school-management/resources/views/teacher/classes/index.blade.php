@extends('layouts.app')

@section('content')
<div style="padding: 20px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <h1>My Classes</h1>
        <a href="{{ route('teacher.dashboard') }}" style="padding: 10px 20px; background: #6c757d; color: white; text-decoration: none; border-radius: 4px;">
            ← Back to Dashboard
        </a>
    </div>

    @if($classes->count() > 0)
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 20px;">
            @foreach($classes as $class)
                <div style="background: white; border-radius: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); overflow: hidden;">
                    <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 20px;">
                        <h3 style="margin: 0 0 10px 0;">{{ $class->name }}</h3>
                        <p style="margin: 0; opacity: 0.9;">{{ $class->subject->name }}</p>
                    </div>
                    
                    <div style="padding: 20px;">
                        <div style="margin-bottom: 15px;">
                            <div style="color: #666; font-size: 14px;">Room</div>
                            <div style="font-weight: bold;">{{ $class->room_number }}</div>
                        </div>
                        
                        <div style="margin-bottom: 15px;">
                            <div style="color: #666; font-size: 14px;">Schedule</div>
                            <div style="font-weight: bold;">{{ $class->schedule ?? 'Not set' }}</div>
                        </div>
                        
                        <div style="margin-bottom: 15px;">
                            <div style="color: #666; font-size: 14px;">Students Enrolled</div>
                            <div style="font-weight: bold; font-size: 24px; color: #007bff;">
                                {{ $class->enrollments->where('status', 'active')->count() }} / {{ $class->max_students }}
                            </div>
                        </div>
                        
                        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 10px; margin-top: 20px;">
                            <a href="{{ route('teacher.classes.show', $class) }}" style="padding: 10px; background: #007bff; color: white; text-decoration: none; border-radius: 4px; text-align: center; font-size: 14px;">
                                View
                            </a>
                            <a href="{{ route('teacher.classes.attendance.create', $class) }}" style="padding: 10px; background: #28a745; color: white; text-decoration: none; border-radius: 4px; text-align: center; font-size: 14px;">
                                Attendance
                            </a>
                            <a href="{{ route('teacher.classes.grades.create', $class) }}" style="padding: 10px; background: #17a2b8; color: white; text-decoration: none; border-radius: 4px; text-align: center; font-size: 14px;">
                                Grades
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div style="background: white; padding: 60px; border-radius: 12px; text-align: center;">
            <div style="font-size: 64px; margin-bottom: 20px;">📚</div>
            <h3 style="color: #666;">No Classes Assigned</h3>
            <p style="color: #999;">You don't have any classes assigned yet. Please contact the administrator.</p>
        </div>
    @endif
</div>
@endsection
