# School Models - Quick Reference

## Models Created ✅

1. **Student** - Student profiles with academic info
2. **Teacher** - Teacher profiles with employment details
3. **Subject** - Academic subjects (Math, Science, etc.)
4. **SchoolClass** - Classes taught by teachers
5. **Enrollment** - Student-Class relationship
6. **Grade** - Assessment scores and grades
7. **Attendance** - Daily attendance tracking

## Key Relationships

```
User → Student → Enrollment → SchoolClass → Teacher
                     ↓              ↓
                 Attendance      Subject
                 Grades
```

## Database Tables

All migrations have been run successfully:
- ✅ students
- ✅ teachers
- ✅ subjects
- ✅ school_classes
- ✅ enrollments
- ✅ grades
- ✅ attendances

## Features

### Student Model
- Links to User account
- Has parent relationship
- Tracks enrollments, grades, attendance
- Status: active, inactive, graduated, transferred

### Teacher Model
- Links to User account
- Manages multiple classes
- Tracks employment details
- Status: active, inactive, on_leave

### SchoolClass Model
- Taught by one teacher
- Belongs to one subject
- Has multiple enrolled students
- Auto-calculates if class is full
- Status: active, inactive, completed

### Enrollment Model
- Links student to class
- Tracks enrollment date and status
- Calculates attendance percentage
- Calculates average grade

### Grade Model
- Multiple assessment types (quiz, exam, assignment, project)
- Auto-calculates percentage and letter grade
- Grading scale: A (90+), B (80+), C (70+), D (60+), F (<60)

### Attendance Model
- Daily tracking per enrollment
- Status: present, absent, late, excused
- Unique per student per day per class

## Quick Commands

```bash
# Run migrations
php artisan migrate

# Fresh migration with seed
php artisan migrate:fresh --seed

# Create sample data (coming soon)
php artisan db:seed --class=SchoolDataSeeder
```

## What's Next?

1. Create controllers for each model
2. Build admin interfaces for management
3. Create teacher interfaces for grading/attendance
4. Build student/parent views
5. Add sample data seeders
6. Implement reports and analytics
