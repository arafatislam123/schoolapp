@extends('layouts.app')

@section('content')
<div style="max-width: 1200px; margin: 30px auto; padding: 20px;">
    <!-- Header -->
    <div style="text-align: center; margin-bottom: 30px; padding: 25px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 8px;">
        <h1 style="margin: 0; font-size: 32px;">PROGRESS REPORT</h1>
        <p style="margin: 10px 0 0 0; font-size: 16px;">Last 30 Days Performance Summary</p>
    </div>

    <!-- Action Buttons -->
    <div style="display: flex; justify-content: space-between; margin-bottom: 20px;">
        <a href="{{ route('admin.students.show', $student) }}" style="padding: 10px 20px; background: #6c757d; color: white; text-decoration: none; border-radius: 4px;">
            ← Back to Profile
        </a>
        <div>
            <a href="{{ route('admin.reports.report-card', $student) }}" style="padding: 10px 20px; background: #28a745; color: white; text-decoration: none; border-radius: 4px; margin-right: 10px;">
                Full Report Card
            </a>
            <button onclick="window.print()" style="padding: 10px 20px; background: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer;">
                🖨️ Print
            </button>
        </div>
    </div>

    <!-- Student Info -->
    <div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-bottom: 20px;">
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px;">
            <div>
                <strong style="color: #666;">Student:</strong> {{ $student->user->name }}<br>
                <strong style="color: #666;">ID:</strong> {{ $student->student_id }}
            </div>
            <div>
                <strong style="color: #666;">Grade:</strong> {{ $student->grade_level }}<br>
                <strong style="color: #666;">Period:</strong> {{ now()->subDays(30)->format('M d') }} - {{ now()->format('M d, Y') }}
            </div>
            <div>
                <strong style="color: #666;">GPA:</strong> {{ $academicSummary['gpa'] }}<br>
                <strong style="color: #666;">Overall Average:</strong> {{ $academicSummary['average_grade'] }}%
            </div>
        </div>
    </div>

    <!-- Recent Performance Summary -->
    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 30px;">
        <div style="background: white; padding: 25px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); text-align: center;">
            <div style="font-size: 48px; font-weight: bold; color: #007bff;">{{ $recentGrades->count() }}</div>
            <div style="color: #666; margin-top: 10px;">Recent Assessments</div>
            <div style="margin-top: 10px; font-size: 14px; color: #999;">Last 30 days</div>
        </div>

        <div style="background: white; padding: 25px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); text-align: center;">
            <div style="font-size: 48px; font-weight: bold; color: #28a745;">{{ round($recentGrades->avg('percentage') ?? 0, 1) }}%</div>
            <div style="color: #666; margin-top: 10px;">Recent Average</div>
            <div style="margin-top: 10px; font-size: 14px; color: #999;">
                @php
                    $recentAvg = $recentGrades->avg('percentage') ?? 0;
                    $overallAvg = $academicSummary['average_grade'];
                    $diff = $recentAvg - $overallAvg;
                @endphp
                @if($diff > 0)
                    <span style="color: #28a745;">↑ {{ round($diff, 1) }}% improvement</span>
                @elseif($diff < 0)
                    <span style="color: #dc3545;">↓ {{ round(abs($diff), 1) }}% decline</span>
                @else
                    <span style="color: #666;">Stable performance</span>
                @endif
            </div>
        </div>

        <div style="background: white; padding: 25px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); text-align: center;">
            @php
                $recentAttendanceRate = $recentAttendance->count() > 0 
                    ? round(($recentAttendance->where('status', 'present')->count() / $recentAttendance->count()) * 100, 1)
                    : 0;
            @endphp
            <div style="font-size: 48px; font-weight: bold; color: #17a2b8;">{{ $recentAttendanceRate }}%</div>
            <div style="color: #666; margin-top: 10px;">Recent Attendance</div>
            <div style="margin-top: 10px; font-size: 14px; color: #999;">{{ $recentAttendance->count() }} days tracked</div>
        </div>
    </div>

    <!-- Recent Grades -->
    <div style="background: white; padding: 25px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-bottom: 20px;">
        <h3 style="margin-top: 0; padding-bottom: 15px; border-bottom: 2px solid #007bff;">Recent Assessments (Last 30 Days)</h3>
        
        @if($recentGrades->count() > 0)
            <table style="width: 100%; border-collapse: collapse; margin-top: 15px;">
                <thead>
                    <tr style="background: #f8f9fa;">
                        <th style="padding: 12px; text-align: left; border-bottom: 2px solid #dee2e6;">Date</th>
                        <th style="padding: 12px; text-align: left; border-bottom: 2px solid #dee2e6;">Subject</th>
                        <th style="padding: 12px; text-align: left; border-bottom: 2px solid #dee2e6;">Assessment</th>
                        <th style="padding: 12px; text-align: center; border-bottom: 2px solid #dee2e6;">Score</th>
                        <th style="padding: 12px; text-align: center; border-bottom: 2px solid #dee2e6;">Grade</th>
                        <th style="padding: 12px; text-align: left; border-bottom: 2px solid #dee2e6;">Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentGrades->sortByDesc('assessment_date') as $grade)
                        @php
                            $gradeColor = $grade->percentage >= 90 ? '#28a745' : ($grade->percentage >= 80 ? '#17a2b8' : ($grade->percentage >= 70 ? '#ffc107' : ($grade->percentage >= 60 ? '#fd7e14' : '#dc3545')));
                        @endphp
                        <tr style="border-bottom: 1px solid #dee2e6;">
                            <td style="padding: 12px;">{{ $grade->assessment_date->format('M d, Y') }}</td>
                            <td style="padding: 12px;">{{ $grade->enrollment->schoolClass->subject->name }}</td>
                            <td style="padding: 12px;">
                                <strong>{{ $grade->assessment_name }}</strong><br>
                                <small style="color: #666;">{{ ucfirst($grade->assessment_type) }}</small>
                            </td>
                            <td style="padding: 12px; text-align: center;">
                                {{ $grade->score }}/{{ $grade->max_score }}<br>
                                <small style="color: #666;">({{ round($grade->percentage, 1) }}%)</small>
                            </td>
                            <td style="padding: 12px; text-align: center;">
                                <span style="padding: 6px 12px; background: {{ $gradeColor }}; color: white; border-radius: 4px; font-weight: bold;">
                                    {{ $grade->letter_grade }}
                                </span>
                            </td>
                            <td style="padding: 12px;">
                                <small style="color: #666;">{{ $grade->remarks ?? 'No remarks' }}</small>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p style="text-align: center; color: #999; padding: 20px;">No assessments in the last 30 days</p>
        @endif
    </div>

    <!-- Recent Attendance -->
    <div style="background: white; padding: 25px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-bottom: 20px;">
        <h3 style="margin-top: 0; padding-bottom: 15px; border-bottom: 2px solid #28a745;">Recent Attendance (Last 30 Days)</h3>
        
        @if($recentAttendance->count() > 0)
            @php
                $attendanceByStatus = $recentAttendance->groupBy('status');
            @endphp
            
            <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px; margin: 20px 0;">
                <div style="text-align: center; padding: 15px; background: #d4edda; border-radius: 8px;">
                    <div style="font-size: 32px; font-weight: bold; color: #28a745;">{{ $attendanceByStatus->get('present', collect())->count() }}</div>
                    <div style="color: #666; margin-top: 5px;">Present</div>
                </div>
                <div style="text-align: center; padding: 15px; background: #f8d7da; border-radius: 8px;">
                    <div style="font-size: 32px; font-weight: bold; color: #dc3545;">{{ $attendanceByStatus->get('absent', collect())->count() }}</div>
                    <div style="color: #666; margin-top: 5px;">Absent</div>
                </div>
                <div style="text-align: center; padding: 15px; background: #fff3cd; border-radius: 8px;">
                    <div style="font-size: 32px; font-weight: bold; color: #ffc107;">{{ $attendanceByStatus->get('late', collect())->count() }}</div>
                    <div style="color: #666; margin-top: 5px;">Late</div>
                </div>
                <div style="text-align: center; padding: 15px; background: #d1ecf1; border-radius: 8px;">
                    <div style="font-size: 32px; font-weight: bold; color: #17a2b8;">{{ $attendanceByStatus->get('excused', collect())->count() }}</div>
                    <div style="color: #666; margin-top: 5px;">Excused</div>
                </div>
            </div>

            <table style="width: 100%; border-collapse: collapse; margin-top: 15px;">
                <thead>
                    <tr style="background: #f8f9fa;">
                        <th style="padding: 12px; text-align: left; border-bottom: 2px solid #dee2e6;">Date</th>
                        <th style="padding: 12px; text-align: left; border-bottom: 2px solid #dee2e6;">Class</th>
                        <th style="padding: 12px; text-align: center; border-bottom: 2px solid #dee2e6;">Status</th>
                        <th style="padding: 12px; text-align: left; border-bottom: 2px solid #dee2e6;">Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentAttendance->sortByDesc('date')->take(10) as $attendance)
                        @php
                            $statusColor = $attendance->status === 'present' ? '#28a745' : ($attendance->status === 'absent' ? '#dc3545' : ($attendance->status === 'late' ? '#ffc107' : '#17a2b8'));
                        @endphp
                        <tr style="border-bottom: 1px solid #dee2e6;">
                            <td style="padding: 12px;">{{ $attendance->date->format('M d, Y') }}</td>
                            <td style="padding: 12px;">{{ $attendance->enrollment->schoolClass->name }}</td>
                            <td style="padding: 12px; text-align: center;">
                                <span style="padding: 4px 12px; background: {{ $statusColor }}; color: white; border-radius: 4px; font-size: 12px;">
                                    {{ ucfirst($attendance->status) }}
                                </span>
                            </td>
                            <td style="padding: 12px;">
                                <small style="color: #666;">{{ $attendance->remarks ?? '-' }}</small>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p style="text-align: center; color: #999; padding: 20px;">No attendance records in the last 30 days</p>
        @endif
    </div>

    <!-- Teacher Comments & Recommendations -->
    <div style="background: white; padding: 25px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
        <h3 style="margin-top: 0; padding-bottom: 15px; border-bottom: 2px solid #17a2b8;">Progress Summary</h3>
        
        <div style="margin-top: 20px;">
            @php
                $recentAvg = $recentGrades->avg('percentage') ?? 0;
                $overallAvg = $academicSummary['average_grade'];
            @endphp
            
            @if($recentAvg > $overallAvg + 5)
                <div style="padding: 15px; background: #d4edda; border-left: 4px solid #28a745; border-radius: 4px; margin-bottom: 15px;">
                    <strong style="color: #28a745;">✓ Excellent Progress!</strong><br>
                    <span style="color: #666;">Recent performance ({{ round($recentAvg, 1) }}%) is significantly higher than overall average ({{ $overallAvg }}%). Keep up the great work!</span>
                </div>
            @elseif($recentAvg < $overallAvg - 5)
                <div style="padding: 15px; background: #fff3cd; border-left: 4px solid #ffc107; border-radius: 4px; margin-bottom: 15px;">
                    <strong style="color: #856404;">⚠ Needs Attention</strong><br>
                    <span style="color: #666;">Recent performance ({{ round($recentAvg, 1) }}%) has declined from overall average ({{ $overallAvg }}%). Consider additional support or tutoring.</span>
                </div>
            @else
                <div style="padding: 15px; background: #d1ecf1; border-left: 4px solid #17a2b8; border-radius: 4px; margin-bottom: 15px;">
                    <strong style="color: #0c5460;">Steady Performance</strong><br>
                    <span style="color: #666;">Student is maintaining consistent performance. Continue current study habits.</span>
                </div>
            @endif

            @if($recentAttendanceRate < 85)
                <div style="padding: 15px; background: #f8d7da; border-left: 4px solid #dc3545; border-radius: 4px; margin-bottom: 15px;">
                    <strong style="color: #721c24;">⚠ Attendance Concern</strong><br>
                    <span style="color: #666;">Recent attendance ({{ $recentAttendanceRate }}%) is below acceptable levels. Please address attendance issues.</span>
                </div>
            @endif
        </div>
    </div>

    <!-- Footer -->
    <div style="margin-top: 30px; padding: 20px; background: #f8f9fa; border-radius: 8px; text-align: center;">
        <p style="margin: 0; color: #666;">Progress Report Generated on {{ now()->format('F d, Y') }}</p>
        <p style="margin: 5px 0 0 0; color: #666; font-size: 14px;">For questions or concerns, please contact the school administration</p>
    </div>
</div>

<style>
@media print {
    button, a[href*="back"], a[href*="report-card"] {
        display: none !important;
    }
}
</style>
@endsection
