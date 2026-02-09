<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolClass extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'subject_id',
        'teacher_id',
        'grade_level',
        'section',
        'room_number',
        'schedule',
        'max_students',
        'description',
        'status',
    ];

    /**
     * Get the subject for this class.
     */
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    /**
     * Get the teacher for this class.
     */
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    /**
     * Get the enrollments for this class.
     */
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    /**
     * Get the students enrolled in this class.
     */
    public function students()
    {
        return $this->belongsToMany(Student::class, 'enrollments')
            ->withPivot('enrollment_date', 'status')
            ->withTimestamps();
    }

    /**
     * Get all attendances for this class.
     */
    public function attendances()
    {
        return $this->hasManyThrough(Attendance::class, Enrollment::class);
    }

    /**
     * Get all grades for this class.
     */
    public function grades()
    {
        return $this->hasManyThrough(Grade::class, Enrollment::class);
    }

    /**
     * Get the current enrollment count.
     */
    public function enrollmentCount()
    {
        return $this->enrollments()->where('status', 'active')->count();
    }

    /**
     * Check if class is full.
     */
    public function isFull()
    {
        return $this->enrollmentCount() >= $this->max_students;
    }
}
