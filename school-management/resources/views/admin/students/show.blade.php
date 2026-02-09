@extends('layouts.app')

@section('content')
<div style="max-width: 1200px; margin: 30px auto; padding: 20px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2>Student Profile: {{ $student->user->name }}</h2>
        <div>
            <a href="{{ route('admin.reports.report-card', $student) }}" style="padding: 10px 20px; background: #28a745; color: white; text-decoration: none; border-radius: 4px; margin-right: 10px;">
                📄 Report Card
            </a>
            <a href="{{ route('admin.reports.transcript', $student) }}" style="padding: 10px 20px; background: #17a2b8; color: white; text-decoration: none; border-radius: 4px; margin-right: 10px;">
                📋 Transcript
            </a>
            <a href="{{ route('admin.reports.analytics', $student) }}" style="padding: 10px 20px; background: #ffc107; color: white; text-decoration: none; border-radius: 4px; margin-right: 10px;">
                📊 Analytics
            </a>
            <a href="{{ route('admin.students.edit', $student) }}" style="padding: 10px 20px; background: #007bff; color: white; text-decoration: none; border-radius: 4px; margin-right: 10px;">
                Edit Student
            </a>
            <a href="{{ route('admin.students.index') }}" style="padding: 10px 20px; background: #6c757d; color: white; text-decoration: none; border-radius: 4px;">
                Back to List
            </a>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
        <!-- Personal Information -->
        <div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            <h3 style="margin-top: 0; padding-bottom: 10px; border-bottom: 2px solid #007bff;">Personal Information</h3>
            
            <div style="margin-bottom: 15px;">
                <strong style="color: #666;">Full Name:</strong><br>
                <span style="font-size: 18px;">{{ $student->user->name }}</span>
            </div>

            <div style="margin-bottom: 15px;">
                <strong style="color: #666;">Email:</strong><br>
                {{ $student->user->email }}
            </div>

            <div style="margin-bottom: 15px;">
                <strong style="color: #666;">Phone:</strong><br>
                {{ $student->user->phone ?? 'Not provided' }}
            </div>

            <div style="margin-bottom: 15px;">
                <strong style="color: #666;">Date of Birth:</strong><br>
                {{ $student->user->date_of_birth?->format('F d, Y') ?? 'Not provided' }}
                @if($student->user->date_of_birth)
                    <span style="color: #666;">({{ $student->user->date_of_birth->age }} years old)</span>
                @endif
            </div>

            <div style="margin-bottom: 15px;">
                <strong style="color: #666;">Address:</strong><br>
                {{ $student->user->address ?? 'Not provided' }}
            </div>
        </div>

        <!-- Student Information -->
        <div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            <h3 style="margin-top: 0; padding-bottom: 10px; border-bottom: 2px solid #28a745;">Student Information</h3>
            
            <div style="margin-bottom: 15px;">
                <strong style="color: #666;">Student ID:</strong><br>
                <span style="font-size: 18px; font-weight: bold; color: #007bff;">{{ $student->student_id }}</span>
            </div>

            <div style="margin-bottom: 15px;">
                <strong style="color: #666;">Grade Level:</strong><br>
                {{ $student->grade_level }}
                @if($student->section)
                    - Section {{ $student->section }}
                @endif
            </div>

            <div style="margin-bottom: 15px;">
                <strong style="color: #666;">Admission Date:</strong><br>
                {{ $student->admission_date->format('F d, Y') }}
            </div>

            <div style="margin-bottom: 15px;">
                <strong style="color: #666;">Status:</strong><br>
                <span style="padding: 4px 12px; background: {{ $student->status === 'active' ? '#28a745' : ($student->status === 'graduated' ? '#007bff' : '#dc3545') }}; color: white; border-radius: 4px;">
                    {{ ucfirst($student->status) }}
                </span>
            </div>

            <div style="margin-bottom: 15px;">
                <strong style="color: #666;">Parent/Guardian:</strong><br>
                @if($student->parent)
                    {{ $student->parent->name }}<br>
                    <small style="color: #666;">{{ $student->parent->email }}</small><br>
                    <small style="color: #666;">{{ $student->parent->phone ?? 'No phone' }}</small>
                @else
                    <span style="color: #999;">No parent assigned</span>
                @endif
            </div>
        </div>
    </div>

    <!-- Medical & Emergency Information -->
    <div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-top: 20px;">
        <h3 style="margin-top: 0; padding-bottom: 10px; border-bottom: 2px solid #dc3545;">Medical & Emergency Information</h3>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div>
                <strong style="color: #666;">Medical Information:</strong><br>
                <div style="margin-top: 10px; padding: 10px; background: #f8f9fa; border-radius: 4px;">
                    {{ $student->medical_info ?? 'No medical information provided' }}
                </div>
            </div>

            <div>
                <strong style="color: #666;">Emergency Contact:</strong><br>
                <div style="margin-top: 10px; padding: 10px; background: #f8f9fa; border-radius: 4px;">
                    {{ $student->emergency_contact ?? 'No emergency contact provided' }}
                </div>
            </div>
        </div>
    </div>

    <!-- Enrolled Classes -->
    <div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-top: 20px;">
        <h3 style="margin-top: 0; padding-bottom: 10px; border-bottom: 2px solid #17a2b8;">Enrolled Classes</h3>
        
        @if($student->enrollments->count() > 0)
            <table style="width: 100%; border-collapse: collapse; margin-top: 15px;">
                <thead>
                    <tr style="background: #f8f9fa;">
                        <th style="padding: 10px; text-align: left; border-bottom: 2px solid #dee2e6;">Class Name</th>
                        <th style="padding: 10px; text-align: left; border-bottom: 2px solid #dee2e6;">Subject</th>
                        <th style="padding: 10px; text-align: left; border-bottom: 2px solid #dee2e6;">Teacher</th>
                        <th style="padding: 10px; text-align: left; border-bottom: 2px solid #dee2e6;">Schedule</th>
                        <th style="padding: 10px; text-align: left; border-bottom: 2px solid #dee2e6;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($student->enrollments as $enrollment)
                    <tr style="border-bottom: 1px solid #dee2e6;">
                        <td style="padding: 10px;">{{ $enrollment->schoolClass->name }}</td>
                        <td style="padding: 10px;">{{ $enrollment->schoolClass->subject->name }}</td>
                        <td style="padding: 10px;">{{ $enrollment->schoolClass->teacher->user->name }}</td>
                        <td style="padding: 10px;">{{ $enrollment->schoolClass->schedule ?? 'Not set' }}</td>
                        <td style="padding: 10px;">
                            <span style="padding: 4px 8px; background: {{ $enrollment->status === 'active' ? '#28a745' : '#6c757d' }}; color: white; border-radius: 4px; font-size: 12px;">
                                {{ ucfirst($enrollment->status) }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p style="color: #999; text-align: center; padding: 20px;">No classes enrolled yet</p>
        @endif
    </div>

    <!-- Academic Summary -->
    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px; margin-top: 20px;">
        <div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); text-align: center;">
            <div style="font-size: 36px; font-weight: bold; color: #007bff;">{{ $student->enrollments->where('status', 'active')->count() }}</div>
            <div style="color: #666; margin-top: 5px;">Active Classes</div>
        </div>

        <div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); text-align: center;">
            <div style="font-size: 36px; font-weight: bold; color: #28a745;">{{ $student->grades->count() }}</div>
            <div style="color: #666; margin-top: 5px;">Total Grades</div>
        </div>

        <div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); text-align: center;">
            <div style="font-size: 36px; font-weight: bold; color: #17a2b8;">{{ $student->attendances->count() }}</div>
            <div style="color: #666; margin-top: 5px;">Attendance Records</div>
        </div>
    </div>
</div>
@endsection
