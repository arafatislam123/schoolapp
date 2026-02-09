@extends('layouts.app')

@section('content')
<div style="max-width: 1000px; margin: 30px auto; padding: 20px;">
    <!-- Header -->
    <div style="text-align: center; margin-bottom: 30px; padding: 30px; background: white; border: 3px solid #007bff; border-radius: 8px;">
        <h1 style="margin: 0; font-size: 36px; color: #007bff;">OFFICIAL TRANSCRIPT</h1>
        <p style="margin: 10px 0 0 0; font-size: 16px; color: #666;">Academic Record</p>
    </div>

    <!-- Action Buttons -->
    <div style="display: flex; justify-content: space-between; margin-bottom: 20px;">
        <a href="{{ route('admin.students.show', $student) }}" style="padding: 10px 20px; background: #6c757d; color: white; text-decoration: none; border-radius: 4px;">
            ← Back to Profile
        </a>
        <div>
            <a href="{{ route('admin.reports.report-card', $student) }}" style="padding: 10px 20px; background: #28a745; color: white; text-decoration: none; border-radius: 4px; margin-right: 10px;">
                Report Card
            </a>
            <button onclick="window.print()" style="padding: 10px 20px; background: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer;">
                🖨️ Print
            </button>
        </div>
    </div>

    <!-- Student Information -->
    <div style="background: white; padding: 25px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-bottom: 20px;">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div>
                <div style="margin-bottom: 15px;">
                    <strong style="color: #666;">Student Name:</strong><br>
                    <span style="font-size: 18px;">{{ $student->user->name }}</span>
                </div>
                <div style="margin-bottom: 15px;">
                    <strong style="color: #666;">Student ID:</strong><br>
                    <span style="font-size: 18px; color: #007bff;">{{ $student->student_id }}</span>
                </div>
                <div style="margin-bottom: 15px;">
                    <strong style="color: #666;">Date of Birth:</strong><br>
                    {{ $student->user->date_of_birth?->format('F d, Y') }}
                </div>
            </div>
            <div>
                <div style="margin-bottom: 15px;">
                    <strong style="color: #666;">Current Grade:</strong><br>
                    <span style="font-size: 18px;">{{ $student->grade_level }}</span>
                </div>
                <div style="margin-bottom: 15px;">
                    <strong style="color: #666;">Admission Date:</strong><br>
                    {{ $student->admission_date->format('F d, Y') }}
                </div>
                <div style="margin-bottom: 15px;">
                    <strong style="color: #666;">Status:</strong><br>
                    <span style="padding: 4px 12px; background: {{ $student->status === 'active' ? '#28a745' : '#6c757d' }}; color: white; border-radius: 4px;">
                        {{ ucfirst($student->status) }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Academic Summary -->
    <div style="background: white; padding: 25px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-bottom: 20px;">
        <h3 style="margin-top: 0; padding-bottom: 15px; border-bottom: 2px solid #007bff;">Academic Summary</h3>
        
        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-top: 20px;">
            <div style="text-align: center; padding: 15px; background: #f8f9fa; border-radius: 8px;">
                <div style="font-size: 32px; font-weight: bold; color: #007bff;">{{ $academicSummary['gpa'] }}</div>
                <div style="color: #666; margin-top: 5px;">Cumulative GPA</div>
            </div>
            <div style="text-align: center; padding: 15px; background: #f8f9fa; border-radius: 8px;">
                <div style="font-size: 32px; font-weight: bold; color: #28a745;">{{ $academicSummary['total_credits'] }}</div>
                <div style="color: #666; margin-top: 5px;">Total Credits</div>
            </div>
            <div style="text-align: center; padding: 15px; background: #f8f9fa; border-radius: 8px;">
                <div style="font-size: 32px; font-weight: bold; color: #17a2b8;">{{ $academicSummary['completed_courses'] }}</div>
                <div style="color: #666; margin-top: 5px;">Completed Courses</div>
            </div>
            <div style="text-align: center; padding: 15px; background: #f8f9fa; border-radius: 8px;">
                <div style="font-size: 32px; font-weight: bold; color: #ffc107;">{{ $academicSummary['average_grade'] }}%</div>
                <div style="color: #666; margin-top: 5px;">Overall Average</div>
            </div>
        </div>
    </div>

    <!-- Course History by Year -->
    @foreach($enrollmentsByYear as $year => $enrollments)
        <div style="background: white; padding: 25px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-bottom: 20px;">
            <h3 style="margin-top: 0; padding-bottom: 15px; border-bottom: 2px solid #28a745;">Academic Year {{ $year }}</h3>
            
            <table style="width: 100%; border-collapse: collapse; margin-top: 15px;">
                <thead>
                    <tr style="background: #f8f9fa;">
                        <th style="padding: 12px; text-align: left; border-bottom: 2px solid #dee2e6;">Course Code</th>
                        <th style="padding: 12px; text-align: left; border-bottom: 2px solid #dee2e6;">Course Name</th>
                        <th style="padding: 12px; text-align: center; border-bottom: 2px solid #dee2e6;">Credits</th>
                        <th style="padding: 12px; text-align: center; border-bottom: 2px solid #dee2e6;">Grade</th>
                        <th style="padding: 12px; text-align: center; border-bottom: 2px solid #dee2e6;">Points</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $yearCredits = 0;
                        $yearPoints = 0;
                    @endphp
                    @foreach($enrollments as $enrollment)
                        @php
                            $avg = $enrollment->averageGrade() ?? 0;
                            $letterGrade = $avg >= 90 ? 'A' : ($avg >= 80 ? 'B' : ($avg >= 70 ? 'C' : ($avg >= 60 ? 'D' : 'F')));
                            $gradePoint = $letterGrade === 'A' ? 4.0 : ($letterGrade === 'B' ? 3.0 : ($letterGrade === 'C' ? 2.0 : ($letterGrade === 'D' ? 1.0 : 0.0)));
                            $credits = $enrollment->schoolClass->subject->credits;
                            $yearCredits += $credits;
                            $yearPoints += $gradePoint * $credits;
                        @endphp
                        <tr style="border-bottom: 1px solid #dee2e6;">
                            <td style="padding: 12px;">{{ $enrollment->schoolClass->subject->code }}</td>
                            <td style="padding: 12px;">{{ $enrollment->schoolClass->subject->name }}</td>
                            <td style="padding: 12px; text-align: center;">{{ $credits }}</td>
                            <td style="padding: 12px; text-align: center;">
                                <strong style="font-size: 16px;">{{ $letterGrade }}</strong>
                                <span style="color: #666;">({{ round($avg, 1) }}%)</span>
                            </td>
                            <td style="padding: 12px; text-align: center;">{{ number_format($gradePoint, 2) }}</td>
                        </tr>
                    @endforeach
                    <tr style="background: #f8f9fa; font-weight: bold;">
                        <td colspan="2" style="padding: 12px; text-align: right;">Year Total:</td>
                        <td style="padding: 12px; text-align: center;">{{ $yearCredits }}</td>
                        <td style="padding: 12px; text-align: center;">GPA:</td>
                        <td style="padding: 12px; text-align: center;">{{ $yearCredits > 0 ? number_format($yearPoints / $yearCredits, 2) : '0.00' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    @endforeach

    <!-- Grading Scale -->
    <div style="background: white; padding: 25px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-bottom: 20px;">
        <h3 style="margin-top: 0; padding-bottom: 15px; border-bottom: 2px solid #17a2b8;">Grading Scale</h3>
        
        <div style="display: grid; grid-template-columns: repeat(5, 1fr); gap: 15px; margin-top: 20px;">
            <div style="text-align: center; padding: 15px; background: #28a745; color: white; border-radius: 8px;">
                <div style="font-size: 24px; font-weight: bold;">A</div>
                <div style="margin-top: 5px;">90-100%</div>
                <div style="margin-top: 5px;">4.0 Points</div>
            </div>
            <div style="text-align: center; padding: 15px; background: #17a2b8; color: white; border-radius: 8px;">
                <div style="font-size: 24px; font-weight: bold;">B</div>
                <div style="margin-top: 5px;">80-89%</div>
                <div style="margin-top: 5px;">3.0 Points</div>
            </div>
            <div style="text-align: center; padding: 15px; background: #ffc107; color: white; border-radius: 8px;">
                <div style="font-size: 24px; font-weight: bold;">C</div>
                <div style="margin-top: 5px;">70-79%</div>
                <div style="margin-top: 5px;">2.0 Points</div>
            </div>
            <div style="text-align: center; padding: 15px; background: #fd7e14; color: white; border-radius: 8px;">
                <div style="font-size: 24px; font-weight: bold;">D</div>
                <div style="margin-top: 5px;">60-69%</div>
                <div style="margin-top: 5px;">1.0 Points</div>
            </div>
            <div style="text-align: center; padding: 15px; background: #dc3545; color: white; border-radius: 8px;">
                <div style="font-size: 24px; font-weight: bold;">F</div>
                <div style="margin-top: 5px;">Below 60%</div>
                <div style="margin-top: 5px;">0.0 Points</div>
            </div>
        </div>
    </div>

    <!-- Official Seal -->
    <div style="margin-top: 30px; padding: 20px; background: white; border: 2px solid #007bff; border-radius: 8px; text-align: center;">
        <p style="margin: 0; font-weight: bold;">This is an official transcript</p>
        <p style="margin: 10px 0 0 0; color: #666;">Issued on {{ date('F d, Y') }}</p>
        <div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid #dee2e6;">
            <p style="margin: 0; color: #666; font-size: 14px;">School Administrator Signature: _______________________</p>
        </div>
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
