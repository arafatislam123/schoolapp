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

**Teacher Account:**
- Email: `teacher@school.com`
- Password: `password`

**Student Account:**
- Email: `student@school.com`
- Password: `password`

**Parent Account:**
- Email: `parent@school.com`
- Password: `password`

## Available Routes

- **Home:** http://localhost:8000
- **Login:** http://localhost:8000/login
- **Register:** http://localhost:8000/register (Student/Parent only)
- **Admin Dashboard:** http://localhost:8000/admin/dashboard
- **Manage Users:** http://localhost:8000/admin/users
- **Teacher Dashboard:** http://localhost:8000/teacher/dashboard
- **Student Dashboard:** http://localhost:8000/student/dashboard
- **Parent Dashboard:** http://localhost:8000/parent/dashboard

## How Teachers Login

Teachers cannot self-register. They must be created by an admin:

### Option 1: Use the Admin Panel (Recommended)
1. Login as admin (admin@school.com / password)
2. Go to "Manage Users" or visit: http://localhost:8000/admin/users
3. Click "Add New User"
4. Fill in the teacher's details and select "Teacher" role
5. The teacher can now login with their email and password

### Option 2: Use Sample Teacher Account
- Email: teacher@school.com
- Password: password

## User Roles

| Role | Slug | Access Level | Can Self-Register? |
|------|------|--------------|-------------------|
| Admin | admin | Full system access | No (created by seeder) |
| Teacher | teacher | Class and student management | No (created by admin) |
| Student | student | View classes and grades | Yes |
| Parent | parent | View children's information | Yes |

## What's Been Set Up

✅ Database migrations for users and roles
✅ Role-based access control (RBAC)
✅ Authentication (login/register/logout)
✅ Role middleware for route protection
✅ User model with role helper methods
✅ Role-specific dashboards
✅ Admin user management panel
✅ Sample users for all roles seeded

## Testing the System

1. Login as admin (admin@school.com / password)
2. Create a new teacher from the admin panel
3. Logout and login as the teacher
4. Test different role dashboards
5. Try creating students/parents via registration

## Next Development Steps

- Create Class, Subject, Grade, Attendance models
- Build admin panel for class management
- Implement teacher class assignments
- Create student enrollment system
- Add parent-student relationships
