<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Enrollment;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminReportCardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin,teacher']);
    }

    /**
     * Show report card for a student.
     */
    public function show(Student $student)
    {
        $student->load([
            'user',
            'parent',
            'enrollments.schoolClass.subject',
            'enrollments.schoolClass.teacher.user',
            'enrollments.grades',
            'enrollments.attendances'
        ]);

        $academicSummary = $student->academicSummary();
        $gradeDistribution = $student->gradeDistribution();
        $classRank = $student->getClassRank();

        return view('admin.reports.report-card', compact(
            'student',
            'academicSummary',
            'gradeDistribution',
            'classRank'
        ));
    }

    /**
     * Generate transcript for a student.
     */
    public function transcript(Student $student)
    {
        $student->load([
            'user',
            'enrollments.schoolClass.subject',
            'enrollments.schoolClass.teacher.user',
            'enrollments.grades'
        ]);

        $academicSummary = $student->academicSummary();
        $enrollmentsByYear = $student->enrollments()
            ->with(['schoolClass.subject', 'grades'])
            ->get()
            ->groupBy(function($enrollment) {
                return $enrollment->enrollment_date->format('Y');
            });

        return view('admin.reports.transcript', compact(
            'student',
            'academicSummary',
            'enrollmentsByYear'
        ));
    }

    /**
     * Generate progress report.
     */
    public function progressReport(Student $student)
    {
        $student->load([
            'user',
            'enrollments.schoolClass.subject',
            'enrollments.schoolClass.teacher.user',
            'enrollments.grades',
            'enrollments.attendances'
        ]);

        $academicSummary = $student->academicSummary();
        
        // Get recent grades (last 30 days)
        $recentGrades = $student->grades()
            ->where('assessment_date', '>=', now()->subDays(30))
            ->with('enrollment.schoolClass.subject')
            ->get();

        // Get recent attendance (last 30 days)
        $recentAttendance = $student->attendances()
            ->where('date', '>=', now()->subDays(30))
            ->with('enrollment.schoolClass')
            ->get();

        return view('admin.reports.progress-report', compact(
            'student',
            'academicSummary',
            'recentGrades',
            'recentAttendance'
        ));
    }

    /**
     * Academic performance analytics.
     */
    public function analytics(Student $student)
    {
        $student->load([
            'user',
            'enrollments.schoolClass.subject',
            'enrollments.grades',
            'enrollments.attendances'
        ]);

        $academicSummary = $student->academicSummary();
        $gradeDistribution = $student->gradeDistribution();
        $classRank = $student->getClassRank();

        // Performance by subject
        $performanceBySubject = $student->enrollments->map(function($enrollment) {
            $grades = $enrollment->grades;
            return [
                'subject' => $enrollment->schoolClass->subject->name,
                'average' => $grades->avg('percentage'),
                'highest' => $grades->max('percentage'),
                'lowest' => $grades->min('percentage'),
                'count' => $grades->count(),
                'attendance' => $enrollment->attendancePercentage(),
            ];
        });

        // Grade trend (last 6 months)
        $gradeTrend = $student->grades()
            ->where('assessment_date', '>=', now()->subMonths(6))
            ->orderBy('assessment_date')
            ->get()
            ->groupBy(function($grade) {
                return $grade->assessment_date->format('Y-m');
            })
            ->map(function($grades) {
                return round($grades->avg('percentage'), 2);
            });

        return view('admin.reports.analytics', compact(
            'student',
            'academicSummary',
            'gradeDistribution',
            'classRank',
            'performanceBySubject',
            'gradeTrend'
        ));
    }

    /**
     * Download report card as PDF.
     */
    public function downloadReportCard(Student $student)
    {
        $student->load([
            'user',
            'parent',
            'enrollments.schoolClass.subject',
            'enrollments.schoolClass.teacher.user',
            'enrollments.grades',
            'enrollments.attendances'
        ]);

        $academicSummary = $student->academicSummary();
        $gradeDistribution = $student->gradeDistribution();
        $classRank = $student->getClassRank();

        $pdf = Pdf::loadView('admin.reports.report-card-pdf', compact(
            'student',
            'academicSummary',
            'gradeDistribution',
            'classRank'
        ));

        return $pdf->download("report-card-{$student->student_id}.pdf");
    }

    /**
     * Download transcript as PDF.
     */
    public function downloadTranscript(Student $student)
    {
        $student->load([
            'user',
            'enrollments.schoolClass.subject',
            'enrollments.grades'
        ]);

        $academicSummary = $student->academicSummary();
        $enrollmentsByYear = $student->enrollments()
            ->with(['schoolClass.subject', 'grades'])
            ->get()
            ->groupBy(function($enrollment) {
                return $enrollment->enrollment_date->format('Y');
            });

        $pdf = Pdf::loadView('admin.reports.transcript-pdf', compact(
            'student',
            'academicSummary',
            'enrollmentsByYear'
        ));

        return $pdf->download("transcript-{$student->student_id}.pdf");
    }
}
