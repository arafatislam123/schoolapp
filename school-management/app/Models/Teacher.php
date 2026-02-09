<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'employee_id',
        'specialization',
        'qualification',
        'hire_date',
        'salary',
        'experience',
        'status',
    ];

    protected $casts = [
        'hire_date' => 'date',
        'salary' => 'decimal:2',
    ];

    /**
     * Get the user associated with the teacher.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the classes taught by the teacher.
     */
    public function classes()
    {
        return $this->hasMany(SchoolClass::class);
    }

    /**
     * Get all students through classes and enrollments.
     */
    public function students()
    {
        return $this->hasManyThrough(
            Student::class,
            SchoolClass::class,
            'teacher_id',
            'id',
            'id',
            'id'
        )->join('enrollments', 'school_classes.id', '=', 'enrollments.school_class_id');
    }
}
