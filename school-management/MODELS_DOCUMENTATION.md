# School Management System - Models Documentation

## Overview
This document describes all the models and their relationships in the school management system.

## Entity Relationship Diagram

```
User (1) ----< (1) Student (M) ----< (M) Enrollment (M) ----< (M) SchoolClass
                    |                        |                        |
                    |                        |                        |
                    v                        v                        v
                 Parent                  Attendance                Teacher
                                         Grades                   Subject
```

## Models

### 1. User
**Purpose:** Base authentication model for all system users

**Fields:**
- `id`: Primary key
- `name`: Full name
- `email`: Unique email address
- `password`: Hashed password
- `role_id`: Foreign key to roles table
- `phone`: Contact number
- `address`: Physical address
- `date_of_birth`: Date of birth
- `status`: active, inactive, suspended

**Relationships:**
- `belongsTo` Role
- `hasOne` Student (if user is a student)
- `hasOne` Teacher (if user is a teacher)
- `hasMany` Student as children (if user is a parent)

**Helper Methods:**
- `hasRole($role)`: Check if user has specific role
- `isAdmin()`, `isTeacher()`, `isStudent()`, `isParent()`: Role checkers

---

### 2. Student
**Purpose:** Extended profile for student users

**Fields:**
- `id`: Primary key
- `user_id`: Foreign key to users table
- `student_id`: Unique student identifier
- `grade_level`: Current grade (e.g., "Grade 10")
- `section`: Class section (e.g., "A", "B")
- `parent_id`: Foreign key to users table (parent)
- `admission_date`: Date of admission
- `medical_info`: Medical conditions/allergies
- `emergency_contact`: Emergency contact details
- `status`: active, inactive, graduated, transferred

**Relationships:**
- `belongsTo` User
- `belongsTo` User as parent
- `hasMany` Enrollment
- `belongsToMany` SchoolClass through enrollments
- `hasManyThrough` Attendance
- `hasManyThrough` Grade

---

### 3. Teacher
**Purpose:** Extended profile for teacher users

**Fields:**
- `id`: Primary key
- `user_id`: Foreign key to users table
- `employee_id`: Unique employee identifier
- `specialization`: Subject specialization
- `qualification`: Educational qualifications
- `hire_date`: Date of hiring
- `salary`: Monthly salary
- `experience`: Years of experience
- `status`: active, inactive, on_leave

**Relationships:**
- `belongsTo` User
- `hasMany` SchoolClass

---

### 4. Subject
**Purpose:** Academic subjects offered by the school

**Fields:**
- `id`: Primary key
- `name`: Subject name (e.g., "Mathematics")
- `code`: Unique subject code (e.g., "MATH101")
- `description`: Subject description
- `credits`: Credit hours
- `grade_level`: Target grade level
- `status`: active, inactive

**Relationships:**
- `hasMany` SchoolClass

---

### 5. SchoolClass
**Purpose:** Represents a class/course taught by a teacher

**Fields:**
- `id`: Primary key
- `name`: Class name
- `subject_id`: Foreign key to subjects table
- `teacher_id`: Foreign key to teachers table
- `grade_level`: Grade level
- `section`: Section identifier
- `room_number`: Classroom number
- `schedule`: Class schedule (e.g., "Mon/Wed 9:00-10:30")
- `max_students`: Maximum enrollment capacity
- `description`: Class description
- `status`: active, inactive, completed

**Relationships:**
- `belongsTo` Subject
- `belongsTo` Teacher
- `hasMany` Enrollment
- `belongsToMany` Student through enrollments
- `hasManyThrough` Attendance
- `hasManyThrough` Grade

**Helper Methods:**
- `enrollmentCount()`: Get current enrollment count
- `isFull()`: Check if class is at capacity

---

### 6. Enrollment
**Purpose:** Links students to classes they're enrolled in

**Fields:**
- `id`: Primary key
- `student_id`: Foreign key to students table
- `school_class_id`: Foreign key to school_classes table
- `enrollment_date`: Date of enrollment
- `status`: active, dropped, completed

**Relationships:**
- `belongsTo` Student
- `belongsTo` SchoolClass
- `hasMany` Attendance
- `hasMany` Grade

**Helper Methods:**
- `attendancePercentage()`: Calculate attendance percentage
- `averageGrade()`: Calculate average grade

**Constraints:**
- Unique combination of student_id and school_class_id

---

### 7. Grade
**Purpose:** Stores assessment scores and grades

**Fields:**
- `id`: Primary key
- `enrollment_id`: Foreign key to enrollments table
- `assessment_type`: Type (quiz, exam, assignment, project)
- `assessment_name`: Name of assessment
- `score`: Points earned
- `max_score`: Maximum possible points
- `percentage`: Calculated percentage
- `letter_grade`: Letter grade (A, B, C, D, F)
- `remarks`: Teacher comments
- `assessment_date`: Date of assessment

**Relationships:**
- `belongsTo` Enrollment

**Auto-Calculations:**
- Percentage is automatically calculated from score/max_score
- Letter grade is automatically assigned based on percentage

**Grading Scale:**
- A: 90-100%
- B: 80-89%
- C: 70-79%
- D: 60-69%
- F: Below 60%

---

### 8. Attendance
**Purpose:** Tracks daily attendance for enrolled students

**Fields:**
- `id`: Primary key
- `enrollment_id`: Foreign key to enrollments table
- `date`: Attendance date
- `status`: present, absent, late, excused
- `remarks`: Additional notes

**Relationships:**
- `belongsTo` Enrollment

**Scopes:**
- `present()`: Filter present records
- `absent()`: Filter absent records
- `dateRange($start, $end)`: Filter by date range

**Constraints:**
- Unique combination of enrollment_id and date

---

## Usage Examples

### Creating a Student Profile
```php
$student = Student::create([
    'user_id' => $user->id,
    'student_id' => 'STU2024001',
    'grade_level' => 'Grade 10',
    'section' => 'A',
    'parent_id' => $parent->id,
    'admission_date' => now(),
    'status' => 'active',
]);
```

### Enrolling a Student in a Class
```php
$enrollment = Enrollment::create([
    'student_id' => $student->id,
    'school_class_id' => $class->id,
    'enrollment_date' => now(),
    'status' => 'active',
]);
```

### Recording Attendance
```php
$attendance = Attendance::create([
    'enrollment_id' => $enrollment->id,
    'date' => today(),
    'status' => 'present',
]);
```

### Adding a Grade
```php
$grade = Grade::create([
    'enrollment_id' => $enrollment->id,
    'assessment_type' => 'exam',
    'assessment_name' => 'Midterm Exam',
    'score' => 85,
    'max_score' => 100,
    'assessment_date' => today(),
]);
// percentage and letter_grade are calculated automatically
```

### Querying Relationships
```php
// Get all classes for a student
$classes = $student->classes;

// Get all students in a class
$students = $class->students;

// Get a student's grades
$grades = $student->grades;

// Get attendance for a specific date range
$attendance = $enrollment->attendances()
    ->dateRange('2024-01-01', '2024-01-31')
    ->get();

// Calculate student's average in a class
$average = $enrollment->averageGrade();

// Check attendance percentage
$percentage = $enrollment->attendancePercentage();
```

## Database Constraints

1. **Foreign Keys:** All relationships use foreign key constraints with appropriate cascade actions
2. **Unique Constraints:**
   - Student ID must be unique
   - Teacher employee ID must be unique
   - Subject code must be unique
   - Student can only enroll once per class
   - Only one attendance record per student per day per class
3. **Enum Constraints:** Status fields are restricted to predefined values

## Next Steps

1. Create seeders for sample data
2. Build controllers for CRUD operations
3. Create views for managing each entity
4. Implement validation rules
5. Add API endpoints if needed
