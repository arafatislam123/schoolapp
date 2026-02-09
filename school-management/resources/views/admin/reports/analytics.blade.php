@extends('layouts.app')

@section('content')
<div style="max-width: 1400px; margin: 30px auto; padding: 20px;">
    <!-- Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <div>
            <h1 style="margin: 0;">Academic Performance Analytics</h1>
            <p style="margin: 5px 0 0 0; color: #666;">{{ $student->user->name }} - {{ $student->student_id }}</p>
        </div>
        <a href="{{ route('admin.students.show', $student) }}" style="padding: 10px 20px; background: #6c757d; color: white; text-decoration: none; border-radius: 4px;">
            ← Back to Profile
        </a>
    </div>

    <!-- Key Metrics -->
    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 30px;">
        <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
            <div style="font-size: 14px; opacity: 0.9;">Cumulative GPA</div>
            <div style="font-size: 48px; font-weight: bold; margin: 10px 0;">{{ $academicSummary['gpa'] }}</div>
            <div style="font-size: 14px; opacity: 0.9;">
                @if($student->isOnHonorRoll())
                    🏆 Honor Roll Student
                @else
                    4.0 Scale
                @endif
            </div>
        </div>

        <div style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
            <div style="font-size: 14px; opacity: 0.9;">Average Grade</div>
            <div style="font-size: 48px; font-weight: bold; margin: 10px 0;">{{ $academicSummary['average_grade'] }}%</div>
            <div style="font-size: 14px; opacity: 0.9;">Overall Performance</div>
        </div>

        <div style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
            <div style="font-size: 14px; opacity: 0.9;">Attendance Rate</div>
            <div style="font-size: 48px; font-weight: bold; margin: 10px 0;">{{ $academicSummary['attendance_percentage'] }}%</div>
            <div style="font-size: 14px; opacity: 0.9;">
                @if($academicSummary['attendance_percentage'] >= 95)
                    ✓ Excellent
                @elseif($academicSummary['attendance_percentage'] >= 85)
                    Good
                @else
                    Needs Improvement
                @endif
            </div>
        </div>

        <div style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); color: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
            <div style="font-size: 14px; opacity: 0.9;">Class Rank</div>
            <div style="font-size: 48px; font-weight: bold; margin: 10px 0;">{{ $classRank['rank'] ?? 'N/A' }}</div>
            <div style="font-size: 14px; opacity: 0.9;">Out of {{ $classRank['total'] }} students</div>
        </div>
    </div>

    <!-- Grade Distribution Chart -->
    <div style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-bottom: 30px;">
        <h3 style="margin-top: 0; padding-bottom: 15px; border-bottom: 2px solid #007bff;">Grade Distribution</h3>
        
        <div style="display: flex; align-items: flex-end; justify-content: space-around; height: 300px; margin-top: 30px; padding: 20px; background: #f8f9fa; border-radius: 8px;">
            @php
                $maxCount = max(array_values($gradeDistribution->toArray()));
                $maxHeight = 250;
            @endphp
            @foreach($gradeDistribution as $grade => $count)
                @php
                    $height = $maxCount > 0 ? ($count / $maxCount) * $maxHeight : 0;
                    $gradeColor = $grade === 'A' ? '#28a745' : ($grade === 'B' ? '#17a2b8' : ($grade === 'C' ? '#ffc107' : ($grade === 'D' ? '#fd7e14' : '#dc3545')));
                @endphp
                <div style="text-align: center; flex: 1; margin: 0 10px;">
                    <div style="display: flex; flex-direction: column; align-items: center; justify-content: flex-end; height: {{ $maxHeight }}px;">
                        <div style="font-weight: bold; margin-bottom: 10px; color: #666;">{{ $count }}</div>
                        <div style="width: 80px; height: {{ $height }}px; background: {{ $gradeColor }}; border-radius: 8px 8px 0 0; transition: all 0.3s;"></div>
                    </div>
                    <div style="margin-top: 10px; font-size: 24px; font-weight: bold; color: {{ $gradeColor }};">{{ $grade }}</div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Performance by Subject -->
    <div style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-bottom: 30px;">
        <h3 style="margin-top: 0; padding-bottom: 15px; border-bottom: 2px solid #28a745;">Performance by Subject</h3>
        
        <div style="margin-top: 20px;">
            @foreach($performanceBySubject as $performance)
                <div style="margin-bottom: 25px; padding: 20px; background: #f8f9fa; border-radius: 8px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                        <h4 style="margin: 0; color: #007bff;">{{ $performance['subject'] }}</h4>
                        <div style="display: flex; gap: 20px;">
                            <div style="text-align: center;">
                                <div style="font-size: 12px; color: #666;">Average</div>
                                <div style="font-size: 20px; font-weight: bold; color: #007bff;">{{ round($performance['average'] ?? 0, 1) }}%</div>
                            </div>
                            <div style="text-align: center;">
                                <div style="font-size: 12px; color: #666;">Attendance</div>
                                <div style="font-size: 20px; font-weight: bold; color: #28a745;">{{ $performance['attendance'] }}%</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Progress Bar -->
                    <div style="background: #dee2e6; height: 30px; border-radius: 15px; overflow: hidden; position: relative;">
                        <div style="background: linear-gradient(90deg, #667eea 0%, #764ba2 100%); height: 100%; width: {{ $performance['average'] ?? 0 }}%; transition: width 0.5s; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold;">
                            {{ round($performance['average'] ?? 0, 1) }}%
                        </div>
                    </div>
                    
                    <div style="display: flex; justify-content: space-between; margin-top: 10px; font-size: 12px; color: #666;">
                        <span>Lowest: {{ round($performance['lowest'] ?? 0, 1) }}%</span>
                        <span>Highest: {{ round($performance['highest'] ?? 0, 1) }}%</span>
                        <span>{{ $performance['count'] }} assessments</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Grade Trend (Last 6 Months) -->
    <div style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-bottom: 30px;">
        <h3 style="margin-top: 0; padding-bottom: 15px; border-bottom: 2px solid #17a2b8;">Grade Trend (Last 6 Months)</h3>
        
        @if($gradeTrend->count() > 0)
            <div style="display: flex; align-items: flex-end; justify-content: space-around; height: 300px; margin-top: 30px; padding: 20px; background: #f8f9fa; border-radius: 8px;">
                @php
                    $maxGrade = $gradeTrend->max();
                    $maxHeight = 250;
                @endphp
                @foreach($gradeTrend as $month => $average)
                    @php
                        $height = $maxGrade > 0 ? ($average / 100) * $maxHeight : 0;
                        $color = $average >= 90 ? '#28a745' : ($average >= 80 ? '#17a2b8' : ($average >= 70 ? '#ffc107' : '#dc3545'));
                    @endphp
                    <div style="text-align: center; flex: 1; margin: 0 5px;">
                        <div style="display: flex; flex-direction: column; align-items: center; justify-content: flex-end; height: {{ $maxHeight }}px;">
                            <div style="font-weight: bold; margin-bottom: 10px; color: #666;">{{ round($average, 1) }}%</div>
                            <div style="width: 60px; height: {{ $height }}px; background: {{ $color }}; border-radius: 8px 8px 0 0;"></div>
                        </div>
                        <div style="margin-top: 10px; font-size: 12px; color: #666;">{{ date('M', strtotime($month . '-01')) }}</div>
                    </div>
                @endforeach
            </div>
        @else
            <p style="text-align: center; color: #999; padding: 40px;">No grade data available for the last 6 months</p>
        @endif
    </div>

    <!-- Academic Insights -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
        <!-- Strengths -->
        <div style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            <h3 style="margin-top: 0; padding-bottom: 15px; border-bottom: 2px solid #28a745; color: #28a745;">💪 Strengths</h3>
            <ul style="list-style: none; padding: 0; margin-top: 20px;">
                @if($academicSummary['gpa'] >= 3.5)
                    <li style="padding: 10px; margin-bottom: 10px; background: #d4edda; border-left: 4px solid #28a745; border-radius: 4px;">
                        ✓ Excellent GPA ({{ $academicSummary['gpa'] }})
                    </li>
                @endif
                @if($academicSummary['attendance_percentage'] >= 95)
                    <li style="padding: 10px; margin-bottom: 10px; background: #d4edda; border-left: 4px solid #28a745; border-radius: 4px;">
                        ✓ Outstanding Attendance ({{ $academicSummary['attendance_percentage'] }}%)
                    </li>
                @endif
                @if($gradeDistribution['A'] > 0)
                    <li style="padding: 10px; margin-bottom: 10px; background: #d4edda; border-left: 4px solid #28a745; border-radius: 4px;">
                        ✓ {{ $gradeDistribution['A'] }} A grade{{ $gradeDistribution['A'] > 1 ? 's' : '' }}
                    </li>
                @endif
                @if($academicSummary['average_grade'] >= 85)
                    <li style="padding: 10px; margin-bottom: 10px; background: #d4edda; border-left: 4px solid #28a745; border-radius: 4px;">
                        ✓ Strong Overall Performance ({{ $academicSummary['average_grade'] }}%)
                    </li>
                @endif
            </ul>
        </div>

        <!-- Areas for Improvement -->
        <div style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            <h3 style="margin-top: 0; padding-bottom: 15px; border-bottom: 2px solid #ffc107; color: #ffc107;">📈 Areas for Improvement</h3>
            <ul style="list-style: none; padding: 0; margin-top: 20px;">
                @if($academicSummary['attendance_percentage'] < 85)
                    <li style="padding: 10px; margin-bottom: 10px; background: #fff3cd; border-left: 4px solid #ffc107; border-radius: 4px;">
                        ⚠ Improve Attendance ({{ $academicSummary['attendance_percentage'] }}%)
                    </li>
                @endif
                @if($gradeDistribution['D'] > 0 || $gradeDistribution['F'] > 0)
                    <li style="padding: 10px; margin-bottom: 10px; background: #fff3cd; border-left: 4px solid #ffc107; border-radius: 4px;">
                        ⚠ Focus on struggling subjects
                    </li>
                @endif
                @if($academicSummary['gpa'] < 2.5)
                    <li style="padding: 10px; margin-bottom: 10px; background: #fff3cd; border-left: 4px solid #ffc107; border-radius: 4px;">
                        ⚠ Work on raising GPA
                    </li>
                @endif
                @php
                    $lowPerformance = $performanceBySubject->filter(function($p) {
                        return ($p['average'] ?? 0) < 70;
                    });
                @endphp
                @if($lowPerformance->count() > 0)
                    <li style="padding: 10px; margin-bottom: 10px; background: #fff3cd; border-left: 4px solid #ffc107; border-radius: 4px;">
                        ⚠ {{ $lowPerformance->count() }} subject(s) need attention
                    </li>
                @endif
            </ul>
        </div>
    </div>
</div>
@endsection
