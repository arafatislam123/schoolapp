<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'school_class_id',
        'enrollment_date',
        'status',
    ];

    protected $casts = [
        'enrollment_date' => 'date',
    ];

    /**
     * Get the student for this enrollment.
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Get the class for this enrollment.
     */
    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class);
    }

    /**
     * Get the attendances for this enrollment.
     */
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    /**
     * Get the grades for this enrollment.
     */
    public function grades()
    {
        return $this->hasMany(Grade::class);
    }

    /**
     * Calculate attendance percentage.
     */
    public function attendancePercentage()
    {
        $total = $this->attendances()->count();
        if ($total === 0) return 0;
        
        $present = $this->attendances()->where('status', 'present')->count();
        return round(($present / $total) * 100, 2);
    }

    /**
     * Calculate average grade.
     */
    public function averageGrade()
    {
        return $this->grades()->avg('percentage');
    }

    /**
     * Calculate GPA (4.0 scale).
     */
    public function calculateGPA()
    {
        $grades = $this->grades;
        if ($grades->isEmpty()) return 0;

        $totalPoints = 0;
        $totalCredits = 0;

        foreach ($grades as $grade) {
            $enrollment = $grade->enrollment;
            $class = $enrollment->schoolClass;
            $subject = $class->subject;
            
            $gradePoint = $this->letterToGradePoint($grade->letter_grade);
            $credits = $subject->credits ?? 1;
            
            $totalPoints += $gradePoint * $credits;
            $totalCredits += $credits;
        }

        return $totalCredits > 0 ? round($totalPoints / $totalCredits, 2) : 0;
    }

    /**
     * Convert letter grade to grade point.
     */
    private function letterToGradePoint($letter)
    {
        $gradePoints = [
            'A' => 4.0,
            'B' => 3.0,
            'C' => 2.0,
            'D' => 1.0,
            'F' => 0.0,
        ];

        return $gradePoints[$letter] ?? 0;
    }

    /**
     * Get overall attendance percentage.
     */
    public function overallAttendancePercentage()
    {
        $totalAttendances = $this->attendances()->count();
        if ($totalAttendances === 0) return 0;

        $presentCount = $this->attendances()->where('status', 'present')->count();
        return round(($presentCount / $totalAttendances) * 100, 2);
    }

    /**
     * Get academic performance summary.
     */
    public function academicSummary()
    {
        return [
            'gpa' => $this->calculateGPA(),
            'average_grade' => round($this->averageGrade() ?? 0, 2),
            'total_credits' => $this->enrollments->sum(function($enrollment) {
                return $enrollment->schoolClass->subject->credits ?? 1;
            }),
            'completed_courses' => $this->enrollments()->where('status', 'completed')->count(),
            'active_courses' => $this->enrollments()->where('status', 'active')->count(),
            'attendance_percentage' => $this->overallAttendancePercentage(),
            'total_grades' => $this->grades()->count(),
        ];
    }

    /**
     * Get grade distribution.
     */
    public function gradeDistribution()
    {
        $grades = $this->grades;
        $distribution = [
            'A' => 0,
            'B' => 0,
            'C' => 0,
            'D' => 0,
            'F' => 0,
        ];

        foreach ($grades as $grade) {
            if (isset($distribution[$grade->letter_grade])) {
                $distribution[$grade->letter_grade]++;
            }
        }

        return $distribution;
    }

    /**
     * Check if student is on honor roll (GPA >= 3.5).
     */
    public function isOnHonorRoll()
    {
        return $this->calculateGPA() >= 3.5;
    }

    /**
     * Get class rank (placeholder - needs full implementation).
     */
    public function getClassRank()
    {
        // Get all students in same grade
        $studentsInGrade = Student::where('grade_level', $this->grade_level)
            ->where('status', 'active')
            ->get();

        // Calculate GPA for each and sort
        $rankings = $studentsInGrade->map(function($student) {
            return [
                'student_id' => $student->id,
                'gpa' => $student->calculateGPA(),
            ];
        })->sortByDesc('gpa')->values();

        // Find this student's rank
        $rank = $rankings->search(function($item) {
            return $item['student_id'] === $this->id;
        });

        return [
            'rank' => $rank !== false ? $rank + 1 : null,
            'total' => $studentsInGrade->count(),
        ];
    }
}
