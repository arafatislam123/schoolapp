<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompleteSchoolDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Teachers
        $teacher1User = \App\Models\User::create([
            'name' => 'Sarah Johnson',
            'email' => 'sarah.johnson@school.com',
            'password' => bcrypt('password'),
            'role_id' => 2, // Teacher
            'phone' => '555-0101',
            'date_of_birth' => '1985-05-15',
            'status' => 'active',
        ]);

        $teacher1 = \App\Models\Teacher::create([
            'user_id' => $teacher1User->id,
            'employee_id' => 'TCH20240001',
            'specialization' => 'Mathematics',
            'qualification' => 'Master of Science in Mathematics',
            'hire_date' => '2020-08-01',
            'salary' => 55000,
            'status' => 'active',
        ]);

        $teacher2User = \App\Models\User::create([
            'name' => 'Michael Chen',
            'email' => 'michael.chen@school.com',
            'password' => bcrypt('password'),
            'role_id' => 2,
            'phone' => '555-0102',
            'date_of_birth' => '1988-09-20',
            'status' => 'active',
        ]);

        $teacher2 = \App\Models\Teacher::create([
            'user_id' => $teacher2User->id,
            'employee_id' => 'TCH20240002',
            'specialization' => 'English Literature',
            'qualification' => 'Master of Arts in English',
            'hire_date' => '2019-08-01',
            'salary' => 52000,
            'status' => 'active',
        ]);

        $teacher3User = \App\Models\User::create([
            'name' => 'Dr. Emily Rodriguez',
            'email' => 'emily.rodriguez@school.com',
            'password' => bcrypt('password'),
            'role_id' => 2,
            'phone' => '555-0103',
            'date_of_birth' => '1982-03-10',
            'status' => 'active',
        ]);

        $teacher3 = \App\Models\Teacher::create([
            'user_id' => $teacher3User->id,
            'employee_id' => 'TCH20240003',
            'specialization' => 'Science',
            'qualification' => 'PhD in Biology',
            'hire_date' => '2018-08-01',
            'salary' => 60000,
            'status' => 'active',
        ]);

        // Create Subjects
        $mathSubject = \App\Models\Subject::create([
            'name' => 'Mathematics',
            'code' => 'MATH101',
            'description' => 'Algebra and Geometry',
            'credits' => 4,
            'grade_level' => 'Grade 10',
            'status' => 'active',
        ]);

        $englishSubject = \App\Models\Subject::create([
            'name' => 'English Literature',
            'code' => 'ENG101',
            'description' => 'Reading and Writing',
            'credits' => 3,
            'grade_level' => 'Grade 10',
            'status' => 'active',
        ]);

        $scienceSubject = \App\Models\Subject::create([
            'name' => 'Biology',
            'code' => 'SCI101',
            'description' => 'Life Sciences',
            'credits' => 4,
            'grade_level' => 'Grade 10',
            'status' => 'active',
        ]);

        $historySubject = \App\Models\Subject::create([
            'name' => 'World History',
            'code' => 'HIST101',
            'description' => 'Ancient to Modern History',
            'credits' => 3,
            'grade_level' => 'Grade 10',
            'status' => 'active',
        ]);

        // Create Classes
        $mathClass = \App\Models\SchoolClass::create([
            'name' => 'Mathematics 101 - Section A',
            'subject_id' => $mathSubject->id,
            'teacher_id' => $teacher1->id,
            'grade_level' => 'Grade 10',
            'section' => 'A',
            'room_number' => '201',
            'schedule' => 'Mon/Wed/Fri 9:00-10:30',
            'max_students' => 30,
            'status' => 'active',
        ]);

        $englishClass = \App\Models\SchoolClass::create([
            'name' => 'English Literature 101 - Section A',
            'subject_id' => $englishSubject->id,
            'teacher_id' => $teacher2->id,
            'grade_level' => 'Grade 10',
            'section' => 'A',
            'room_number' => '105',
            'schedule' => 'Tue/Thu 10:00-11:30',
            'max_students' => 30,
            'status' => 'active',
        ]);

        $scienceClass = \App\Models\SchoolClass::create([
            'name' => 'Biology 101 - Section A',
            'subject_id' => $scienceSubject->id,
            'teacher_id' => $teacher3->id,
            'grade_level' => 'Grade 10',
            'section' => 'A',
            'room_number' => '301',
            'schedule' => 'Mon/Wed 11:00-12:30',
            'max_students' => 25,
            'status' => 'active',
        ]);

        // Create Parent
        $parentUser = \App\Models\User::create([
            'name' => 'Robert Smith',
            'email' => 'robert.smith@email.com',
            'password' => bcrypt('password'),
            'role_id' => 4, // Parent
            'phone' => '555-0201',
            'address' => '123 Main Street, City, State 12345',
            'date_of_birth' => '1975-06-20',
            'status' => 'active',
        ]);

        // Create Student with complete data
        $studentUser = \App\Models\User::create([
            'name' => 'Emma Smith',
            'email' => 'emma.smith@school.com',
            'password' => bcrypt('password'),
            'role_id' => 3, // Student
            'phone' => '555-0301',
            'address' => '123 Main Street, City, State 12345',
            'date_of_birth' => '2008-04-15',
            'status' => 'active',
        ]);

        $student = \App\Models\Student::create([
            'user_id' => $studentUser->id,
            'student_id' => 'STU20240001',
            'grade_level' => 'Grade 10',
            'section' => 'A',
            'parent_id' => $parentUser->id,
            'admission_date' => '2023-08-15',
            'medical_info' => 'Allergic to peanuts. Asthma - carries inhaler.',
            'emergency_contact' => 'Robert Smith (Father) - 555-0201, Mary Smith (Mother) - 555-0202',
            'status' => 'active',
        ]);

        // Enroll student in classes
        $mathEnrollment = \App\Models\Enrollment::create([
            'student_id' => $student->id,
            'school_class_id' => $mathClass->id,
            'enrollment_date' => '2023-08-15',
            'status' => 'active',
        ]);

        $englishEnrollment = \App\Models\Enrollment::create([
            'student_id' => $student->id,
            'school_class_id' => $englishClass->id,
            'enrollment_date' => '2023-08-15',
            'status' => 'active',
        ]);

        $scienceEnrollment = \App\Models\Enrollment::create([
            'student_id' => $student->id,
            'school_class_id' => $scienceClass->id,
            'enrollment_date' => '2023-08-15',
            'status' => 'active',
        ]);

        // Add grades for Math (Excellent performance)
        \App\Models\Grade::create([
            'enrollment_id' => $mathEnrollment->id,
            'assessment_type' => 'quiz',
            'assessment_name' => 'Algebra Quiz 1',
            'score' => 95,
            'max_score' => 100,
            'assessment_date' => now()->subDays(45),
            'remarks' => 'Excellent understanding of algebraic concepts!',
        ]);

        \App\Models\Grade::create([
            'enrollment_id' => $mathEnrollment->id,
            'assessment_type' => 'exam',
            'assessment_name' => 'Midterm Exam',
            'score' => 92,
            'max_score' => 100,
            'assessment_date' => now()->subDays(30),
            'remarks' => 'Strong performance on midterm.',
        ]);

        \App\Models\Grade::create([
            'enrollment_id' => $mathEnrollment->id,
            'assessment_type' => 'assignment',
            'assessment_name' => 'Geometry Project',
            'score' => 88,
            'max_score' => 100,
            'assessment_date' => now()->subDays(15),
            'remarks' => 'Creative approach to problem-solving.',
        ]);

        \App\Models\Grade::create([
            'enrollment_id' => $mathEnrollment->id,
            'assessment_type' => 'quiz',
            'assessment_name' => 'Geometry Quiz',
            'score' => 94,
            'max_score' => 100,
            'assessment_date' => now()->subDays(5),
            'remarks' => 'Excellent work!',
        ]);

        // Add grades for English (Good performance)
        \App\Models\Grade::create([
            'enrollment_id' => $englishEnrollment->id,
            'assessment_type' => 'essay',
            'assessment_name' => 'Literary Analysis Essay',
            'score' => 85,
            'max_score' => 100,
            'assessment_date' => now()->subDays(40),
            'remarks' => 'Good analysis, work on thesis development.',
        ]);

        \App\Models\Grade::create([
            'enrollment_id' => $englishEnrollment->id,
            'assessment_type' => 'exam',
            'assessment_name' => 'Midterm Exam',
            'score' => 88,
            'max_score' => 100,
            'assessment_date' => now()->subDays(28),
            'remarks' => 'Strong comprehension skills.',
        ]);

        \App\Models\Grade::create([
            'enrollment_id' => $englishEnrollment->id,
            'assessment_type' => 'project',
            'assessment_name' => 'Poetry Analysis',
            'score' => 90,
            'max_score' => 100,
            'assessment_date' => now()->subDays(10),
            'remarks' => 'Excellent interpretation!',
        ]);

        // Add grades for Science (Very good performance)
        \App\Models\Grade::create([
            'enrollment_id' => $scienceEnrollment->id,
            'assessment_type' => 'lab',
            'assessment_name' => 'Cell Structure Lab',
            'score' => 92,
            'max_score' => 100,
            'assessment_date' => now()->subDays(35),
            'remarks' => 'Excellent lab technique and observations.',
        ]);

        \App\Models\Grade::create([
            'enrollment_id' => $scienceEnrollment->id,
            'assessment_type' => 'exam',
            'assessment_name' => 'Biology Midterm',
            'score' => 89,
            'max_score' => 100,
            'assessment_date' => now()->subDays(25),
            'remarks' => 'Good understanding of biological concepts.',
        ]);

        \App\Models\Grade::create([
            'enrollment_id' => $scienceEnrollment->id,
            'assessment_type' => 'project',
            'assessment_name' => 'Ecosystem Project',
            'score' => 95,
            'max_score' => 100,
            'assessment_date' => now()->subDays(8),
            'remarks' => 'Outstanding research and presentation!',
        ]);

        // Add attendance records (excellent attendance)
        for ($i = 1; $i <= 60; $i++) {
            $date = now()->subDays($i);
            
            // Skip weekends
            if ($date->isWeekend()) continue;

            // Math class attendance (98% present)
            \App\Models\Attendance::create([
                'enrollment_id' => $mathEnrollment->id,
                'date' => $date,
                'status' => $i % 50 == 0 ? 'absent' : 'present',
            ]);

            // English class attendance (96% present)
            \App\Models\Attendance::create([
                'enrollment_id' => $englishEnrollment->id,
                'date' => $date,
                'status' => $i % 25 == 0 ? 'late' : 'present',
            ]);

            // Science class attendance (100% present)
            \App\Models\Attendance::create([
                'enrollment_id' => $scienceEnrollment->id,
                'date' => $date,
                'status' => 'present',
            ]);
        }

        echo "\n✅ Sample data created successfully!\n";
        echo "📊 Student: Emma Smith (STU20240001)\n";
        echo "📧 Login: emma.smith@school.com / password\n";
        echo "🎓 GPA: ~3.7 (Honor Roll Student!)\n";
        echo "📈 Average: ~91%\n";
        echo "✓ Attendance: ~98%\n";
        echo "\n🔗 View Reports:\n";
        echo "   Report Card: /admin/reports/student/{$student->id}/report-card\n";
        echo "   Transcript: /admin/reports/student/{$student->id}/transcript\n";
        echo "   Analytics: /admin/reports/student/{$student->id}/analytics\n";
        echo "   Progress: /admin/reports/student/{$student->id}/progress-report\n";
    }
}
