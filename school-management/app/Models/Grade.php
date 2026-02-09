<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;

    protected $fillable = [
        'enrollment_id',
        'assessment_type',
        'assessment_name',
        'score',
        'max_score',
        'percentage',
        'letter_grade',
        'remarks',
        'assessment_date',
    ];

    protected $casts = [
        'score' => 'decimal:2',
        'max_score' => 'decimal:2',
        'percentage' => 'decimal:2',
        'assessment_date' => 'date',
    ];

    /**
     * Get the enrollment for this grade.
     */
    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class);
    }

    /**
     * Calculate percentage automatically.
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($grade) {
            if ($grade->max_score > 0) {
                $grade->percentage = ($grade->score / $grade->max_score) * 100;
                $grade->letter_grade = self::calculateLetterGrade($grade->percentage);
            }
        });
    }

    /**
     * Calculate letter grade from percentage.
     */
    public static function calculateLetterGrade($percentage)
    {
        if ($percentage >= 90) return 'A';
        if ($percentage >= 80) return 'B';
        if ($percentage >= 70) return 'C';
        if ($percentage >= 60) return 'D';
        return 'F';
    }
}
