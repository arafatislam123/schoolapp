<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'student_id',
        'grade_level',
        'section',
        'parent_id',
        'admission_date',
        'medical_info',
        'emergency_contact',
        'status',
    ];

    protected $casts = [
        'admission_date' => 'date',
    ];

    /**
     * Get the user associated with the student.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the parent of the student.
     */
    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_id');
    }

    /**
     * Get the enrollments for the student.
     */
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    /**
     * Get the classes the student is enrolled in.
     */
    public function classes()
    {
        return $this->belongsToMany(SchoolClass::class, 'enrollments')
            ->withPivot('enrollment_date', 'status')
            ->withTimestamps();
    }

    /**
     * Get all attendances through enrollments.
     */
    public function attendances()
    {
        return $this->hasManyThrough(Attendance::class, Enrollment::class);
    }

    /**
     * Get all grades through enrollments.
     */
    public function grades()
    {
        return $this->hasManyThrough(Grade::class, Enrollment::class);
    }
}
