<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).



# 🎓 School Management System

A comprehensive Laravel-based school management system with complete features for administrators, teachers, students, and parents.

## ✨ Features Implemented

### 🔐 Authentication & User Management
- ✅ Complete authentication system (login, register, logout)
- ✅ Role-based access control (Admin, Teacher, Student, Parent)
- ✅ User management (CRUD operations)
- ✅ Role-specific dashboards

### 👨‍🎓 Student Management
- ✅ Student registration with auto-generated IDs (STU{YEAR}{NUMBER})
- ✅ Student profiles with personal information
- ✅ Grade level & section assignment
- ✅ Parent/guardian linking
- ✅ Medical information & emergency contacts
- ✅ Status management (active, inactive, graduated, transferred)
- ✅ Search and filter functionality

### 📚 Academic Records
- ✅ Class enrollments tracking
- ✅ Complete grade history
- ✅ Attendance records
- ✅ Professional report cards with GPA (4.0 scale)
- ✅ Official transcripts
- ✅ Academic performance analytics with charts
- ✅ Progress reports with recommendations
- ✅ Automatic GPA calculation and honor roll detection
- ✅ Print-friendly formats

### 👨‍🏫 Teacher Features (COMPLETE!)
- ✅ Teacher dashboard with statistics and activity feed
- ✅ Class management (view all classes and student rosters)
- ✅ Grade entry system:
  - Bulk grade entry for entire class
  - Multiple assessment types (quiz, exam, assignment, project, lab, essay)
  - Automatic percentage and letter grade calculation
  - Edit/delete individual grades
  - Student grade summaries
- ✅ Attendance management:
  - Mark attendance for entire class
  - Four status options (present, absent, late, excused)
  - Quick actions (mark all present/absent)
  - Edit attendance for any date
  - 30-day attendance history
  - Comprehensive attendance reports
  - Print-friendly reports
- ✅ Class statistics and performance tracking

## 🚀 Quick Start

### Installation
```bash
# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Configure database in .env
# Then run migrations and seeders
php artisan migrate --seed

# Start the server
php artisan serve
```

### Test Accounts

**Admin:**
- Email: `admin@school.com`
- Password: `password`

**Teacher:**
- Email: `teacher@school.com`
- Password: `password`

**Student:**
- Email: `student@school.com`
- Password: `password`

**Parent:**
- Email: `parent@school.com`
- Password: `password`

## 📖 Documentation

- **[COMPLETE_FEATURES_LIST.md](COMPLETE_FEATURES_LIST.md)** - Full list of all features
- **[TEACHER_FEATURES_COMPLETE.md](TEACHER_FEATURES_COMPLETE.md)** - Complete teacher features guide
- **[TEST_TEACHER_FEATURES.md](TEST_TEACHER_FEATURES.md)** - Testing guide for teacher features
- **[ACADEMIC_FEATURES_COMPLETE.md](ACADEMIC_FEATURES_COMPLETE.md)** - Academic records documentation
- **[STUDENT_MANAGEMENT_GUIDE.md](STUDENT_MANAGEMENT_GUIDE.md)** - Student management guide
- **[MODELS_DOCUMENTATION.md](MODELS_DOCUMENTATION.md)** - Database models documentation
- **[QUICK_START.md](QUICK_START.md)** - Quick start guide

## 🎯 Usage

### For Administrators:
1. Login at `/login`
2. Access admin dashboard at `/admin/dashboard`
3. Manage users, students, and view reports
4. Generate report cards, transcripts, and analytics

### For Teachers:
1. Login at `/login`
2. Access teacher dashboard at `/teacher/dashboard`
3. View your classes and student rosters
4. Enter grades and mark attendance
5. View class statistics and reports

### For Students:
1. Login at `/login`
2. Access student dashboard at `/student/dashboard`
3. View your classes, grades, and attendance
4. Check your academic progress

### For Parents:
1. Login at `/login`
2. Access parent dashboard at `/parent/dashboard`
3. Monitor your children's academic progress

## 🛠️ Technology Stack

- **Framework:** Laravel 10.x
- **Frontend:** Blade Templates, Tailwind CSS
- **Database:** MySQL/PostgreSQL
- **Authentication:** Laravel Sanctum
- **Charts:** Chart.js (for analytics)

## 📊 Database Models

- User (with role-based access)
- Role (Admin, Teacher, Student, Parent)
- Student (with auto-generated IDs)
- Teacher
- Subject
- SchoolClass
- Enrollment
- Grade (with automatic calculations)
- Attendance (with percentage tracking)

## 🔒 Security Features

- Role-based access control
- CSRF protection
- Input validation
- Secure password hashing
- Middleware authentication
- Authorization checks

## 🎨 UI Features

- Responsive design
- Clean, modern interface
- Color-coded status indicators
- Print-friendly reports
- Interactive charts and graphs
- Quick action buttons
- Success/error notifications

## 📝 License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## 🎉 Status

**All core features are complete and ready to use!**

The system includes:
- ✅ Complete authentication
- ✅ User & role management
- ✅ Student management
- ✅ Academic records & reports
- ✅ Teacher dashboard & features
- ✅ Grade management
- ✅ Attendance tracking
- ✅ Analytics & reporting

**Ready for production use or further customization!**




