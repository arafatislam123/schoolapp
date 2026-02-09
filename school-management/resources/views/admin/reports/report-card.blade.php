@extends('layouts.app')

@section('content')
<div style="max-width: 1200px; margin: 30px auto; padding: 20px;">
    <!-- Header -->
    <div style="text-align: center; margin-bottom: 30px; padding: 20px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 8px;">
        <h1 style="margin: 0; font-size: 32px;">REPORT CARD</h1>
        <p style="margin: 10px 0 0 0; font-size: 18px;">Academic Year {{ date('Y') }}</p>
    </div>

    <!-- Action Buttons -->
    <div style="display: flex; justify-content: space-between; margin-bottom: 20px;">
        <a href="{{ route('admin.students.show', $student) }}" style="padding: 10px 20px; background: #6c757d; color: white; text-decoration: none; border-radius: 4px;">
            ← Back to Profile
        </a>
        <div>
            <a href="{{ route('admin.reports.progress-report', $student) }}" style="padding: 10px 20px; background: #17a2b8; color: white; text-decoration: none; border-radius: 4px; margin-right: 10px;">
                Progress Report
            </a>
            <a href="{{ route('admin.reports.transcript', $student) }}" style="padding: 10px 20px; background: #28a745; color: white; text-decoration: none; border-radius: 4px; margin-right: 10px;">
                View Transcript
            </a>
            <button onclick="window.print()" style="padding: 10px 20px; background: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer;">
                🖨️ Print
            </button>
        </div>
    </div>

    <!-- Student Information -->
    <div style="background: white; padding: 25px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-bottom: 20px;">
        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px;">
            <div>
                <strong style="color: #666;">Student Name:</strong><br>
                <span style="font-size: 18px;">{{ $student->user->name }}</span>
            </div>
            <div>
                <strong style="color: #666;">Student ID:</strong><br>
                <span style="font-size: 18px; color: #007bff;">{{ $student->student_id }}</span>
            </div>
            <div>
                <strong style="color: #666;">Grade Level:</strong><br>
                <span style="font-size: 18px;">{{ $student->grade_level }} @if($student->section) - {{ $student->section }} @endif</span>
            </div>
        </div>
    </div>

    <!-- Academic Summary -->
    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px; margin-bottom: 20px;">
        <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 20px; border-radius: 8px; text-align: center;">
            <div style="font-size: 36px; font-weight: bold;">{{ $academicSummary['gpa'] }}</div>
            <div style="margin-top: 5px;">GPA (4.0 Scale)</div>
            @if($student->isOnHonorRoll())
                <div style="margin-top: 10px; padding: 5px; background: rgba(255,255,255,0.2); border-radius: 4px; font-size: 12px;">
                    🏆 HONOR ROLL
                </div>
            @endif
        </div>

        <div style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; padding: 20px; border-radius: 8px; text-align: center;">
            <div style="font-size: 36px; font-weight: bold;">{{ $academicSummary['average_grade'] }}%</div>
            <div style="margin-top: 5px;">Average Grade</div>
        </div>

        <div style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; padding: 20px; border-radius: 8px; text-align: center;">
            <div style="font-size: 36px; font-weight: bold;">{{ $academicSummary['attendance_percentage'] }}%</div>
            <div style="margin-top: 5px;">Attendance</div>
        </div>

        <div style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); color: white; padding: 20px; border-radius: 8px; text-align: center;">
            <div style="font-size: 36px; font-weight: bold;">{{ $classRank['rank'] ?? 'N/A' }}/{{ $classRank['total'] }}</div>
            <div style="margin-top: 5px;">Class Rank</div>
        </div>
    </div>

    <!-- Course Grades -->
    <div style="background: white; padding: 25px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-bottom: 20px;">
        <h3 style="margin-top: 0; padding-bottom: 15px; border-bottom: 2px solid #007bff;">Course Grades</h3>
        
        @if($student->enrollments->count() > 0)
            <table style="width: 100%; border-collapse: collapse; margin-top: 15px;">
                <thead>
                    <tr style="background: #f8f9fa;">
                        <th style="padding: 12px; text-align: left; border-bottom: 2px solid #dee2e6;">Course</th>
                        <th style="padding: 12px; text-align: left; border-bottom: 2px solid #dee2e6;">Teacher</th>
                        <th style="padding: 12px; text-align: center; border-bottom: 2px solid #dee2e6;">Credits</th>
                        <th style="padding: 12px; text-align: center; border-bottom: 2px solid #dee2e6;">Average</th>
                        <th style="padding: 12px; text-align: center; border-bottom: 2px solid #dee2e6;">Grade</th>
                        <th style="padding: 12px; text-align: center; border-bottom: 2px solid #dee2e6;">Attendance</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($student->enrollments as $enrollment)
                    <tr style="border-bottom: 1px solid #dee2e6;">
                        <td style="padding: 12px;">
                            <strong>{{ $enrollment->schoolClass->subject->name }}</strong><br>
                            <small style="color: #666;">{{ $enrollment->schoolClass->name }}</small>
                        </td>
                        <td style="padding: 12px;">{{ $enrollment->schoolClass->teacher->user->name }}</td>
                        <td style="padding: 12px; text-align: center;">{{ $enrollment->schoolClass->subject->credits }}</td>
                        <td style="padding: 12px; text-align: center;">
                            <strong style="font-size: 18px;">{{ round($enrollment->averageGrade() ?? 0, 1) }}%</strong>
                        </td>
                        <td style="padding: 12px; text-align: center;">
                            @php
                                $avg = $enrollment->averageGrade() ?? 0;
                                $letterGrade = $avg >= 90 ? 'A' : ($avg >= 80 ? 'B' : ($avg >= 70 ? 'C' : ($avg >= 60 ? 'D' : 'F')));
                                $gradeColor = $avg >= 90 ? '#28a745' : ($avg >= 80 ? '#17a2b8' : ($avg >= 70 ? '#ffc107' : ($avg >= 60 ? '#fd7e14' : '#dc3545')));
                            @endphp
                            <span style="padding: 6px 12px; background: {{ $gradeColor }}; color: white; border-radius: 4px; font-weight: bold; font-size: 16px;">
                                {{ $letterGrade }}
                            </span>
                        </td>
                        <td style="padding: 12px; text-align: center;">{{ $enrollment->attendancePercentage() }}%</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p style="text-align: center; color: #999; padding: 20px;">No courses enrolled</p>
        @endif
    </div>

    <!-- Grade Distribution -->
    <div style="background: white; padding: 25px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-bottom: 20px;">
        <h3 style="margin-top: 0; padding-bottom: 15px; border-bottom: 2px solid #28a745;">Grade Distribution</h3>
        
        <div style="display: grid; grid-template-columns: repeat(5, 1fr); gap: 15px; margin-top: 20px;">
            @foreach($gradeDistribution as $grade => $count)
                @php
                    $gradeColor = $grade === 'A' ? '#28a745' : ($grade === 'B' ? '#17a2b8' : ($grade === 'C' ? '#ffc107' : ($grade === 'D' ? '#fd7e14' : '#dc3545')));
                @endphp
                <div style="text-align: center; padding: 20px; background: {{ $gradeColor }}; color: white; border-radius: 8px;">
                    <div style="font-size: 48px; font-weight: bold;">{{ $grade }}</div>
                    <div style="font-size: 24px; margin-top: 10px;">{{ $count }}</div>
                    <div style="font-size: 12px; margin-top: 5px;">{{ $count === 1 ? 'Grade' : 'Grades' }}</div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Comments Section -->
    <div style="background: white; padding: 25px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
        <h3 style="margin-top: 0; padding-bottom: 15px; border-bottom: 2px solid #17a2b8;">Teacher Comments</h3>
        
        @foreach($student->enrollments as $enrollment)
            @if($enrollment->grades->count() > 0)
                <div style="margin-bottom: 20px; padding: 15px; background: #f8f9fa; border-left: 4px solid #007bff; border-radius: 4px;">
                    <strong style="color: #007bff;">{{ $enrollment->schoolClass->subject->name }}</strong>
                    <span style="color: #666;"> - {{ $enrollment->schoolClass->teacher->user->name }}</span>
                    <div style="margin-top: 10px;">
                        @php
                            $latestGrade = $enrollment->grades->sortByDesc('assessment_date')->first();
                        @endphp
                        @if($latestGrade && $latestGrade->remarks)
                            {{ $latestGrade->remarks }}
                        @else
                            <em style="color: #999;">No comments available</em>
                        @endif
                    </div>
                </div>
            @endif
        @endforeach
    </div>

    <!-- Footer -->
    <div style="margin-top: 30px; padding: 20px; background: #f8f9fa; border-radius: 8px; text-align: center;">
        <p style="margin: 0; color: #666;">Generated on {{ date('F d, Y') }}</p>
        <p style="margin: 5px 0 0 0; color: #666; font-size: 14px;">This is an official academic record</p>
    </div>
</div>

<style>
@media print {
    body * {
        visibility: hidden;
    }
    .print-area, .print-area * {
        visibility: visible;
    }
    .print-area {
        position: absolute;
        left: 0;
        top: 0;
    }
    button, a {
        display: none !important;
    }
}
</style>
@endsection
