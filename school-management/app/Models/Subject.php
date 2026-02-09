<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'description',
        'credits',
        'grade_level',
        'status',
    ];

    /**
     * Get the classes for this subject.
     */
    public function classes()
    {
        return $this->hasMany(SchoolClass::class);
    }
}
