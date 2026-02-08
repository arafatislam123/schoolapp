# Quick Start Guide

## Start the Application

1. **Start the development server:**
```bash
php artisan serve
```

2. **Visit:** http://localhost:8000

## Default Login Credentials

**Admin Account:**
- Email: `admin@school.com`
- Password: `password`

## Available Routes

- **Home:** http://localhost:8000
- **Login:** http://localhost:8000/login
- **Register:** http://localhost:8000/register
- **Admin Dashboard:** http://localhost:8000/admin/dashboard
- **Teacher Dashboard:** http://localhost:8000/teacher/dashboard
- **Student Dashboard:** http://localhost:8000/student/dashboard
- **Parent Dashboard:** http://localhost:8000/parent/dashboard

## User Roles

| Role | Slug | Access Level |
|------|------|--------------|
| Admin | admin | Full system access |
| Teacher | teacher | Class and student management |
| Student | student | View classes and grades |
| Parent | parent | View children's information |

## What's Been Set Up

✅ Database migrations for users and roles
✅ Role-based access control (RBAC)
✅ Authentication (login/register/logout)
✅ Role middleware for route protection
✅ User model with role helper methods
✅ Role-specific dashboards
✅ Default admin user seeded

## Testing the System

1. Login as admin (admin@school.com / password)
2. Register a new student or parent account
3. Test role-based access by trying to access different dashboards
4. Logout and login with different accounts

## Next Development Steps

- Create Class, Subject, Grade, Attendance models
- Build admin panel for user management
- Implement teacher class assignments
- Create student enrollment system
- Add parent-student relationships
