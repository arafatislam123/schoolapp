# Authentication & Role-Based Access Control Setup

## Overview
This school management system includes a complete authentication system with role-based access control (RBAC) for four user types: Admin, Teacher, Student, and Parent.

## Database Setup

### 1. Run Migrations
```bash
php artisan migrate
```

### 2. Seed Roles and Default Admin
```bash
php artisan db:seed
```

This will create:
- 4 roles: Admin, Teacher, Student, Parent
- Default admin user:
  - Email: admin@school.com
  - Password: password

## User Roles

### Admin
- Full system access
- Can manage all users, classes, and settings
- Access: `/admin/dashboard`

### Teacher
- Manage assigned classes
- Grade students and take attendance
- Access: `/teacher/dashboard`

### Student
- View enrolled classes and grades
- Submit assignments
- Access: `/student/dashboard`

### Parent
- View children's information
- Monitor grades and attendance
- Access: `/parent/dashboard`

## Features Implemented

### 1. User Model Enhancements
- Added `role_id`, `phone`, `address`, `date_of_birth`, `status` fields
- Role relationship
- Helper methods: `hasRole()`, `isAdmin()`, `isTeacher()`, `isStudent()`, `isParent()`

### 2. Role Model
- Manages user roles
- Fields: `name`, `slug`, `description`

### 3. Authentication Controllers
- **AuthLoginController**: Handles login/logout with role-based redirects
- **AuthRegisterController**: Public registration (Student/Parent only)
- **DashboardController**: Role-specific dashboard routing

### 4. Middleware
- **CheckRole**: Protects routes based on user roles
- Usage: `Route::middleware('role:admin,teacher')`

### 5. Routes
- Public: `/login`, `/register`
- Protected: `/dashboard`, `/admin/dashboard`, `/teacher/dashboard`, `/student/dashboard`, `/parent/dashboard`

## Usage Examples

### Protect Routes by Role
```php
// Single role
Route::middleware('role:admin')->group(function () {
    // Admin only routes
});

// Multiple roles
Route::middleware('role:admin,teacher')->group(function () {
    // Admin and Teacher routes
});
```

### Check User Role in Controllers
```php
if (auth()->user()->isAdmin()) {
    // Admin logic
}

if (auth()->user()->hasRole('teacher')) {
    // Teacher logic
}

if (auth()->user()->hasAnyRole(['admin', 'teacher'])) {
    // Admin or Teacher logic
}
```

### Check User Role in Views
```blade
@if(auth()->user()->isAdmin())
    <p>Admin content</p>
@endif

@if(auth()->user()->hasRole('teacher'))
    <p>Teacher content</p>
@endif
```

## Security Features

1. **Status Check**: Users must have 'active' status to login
2. **Role Validation**: Registration limited to Student/Parent roles
3. **CSRF Protection**: All forms include CSRF tokens
4. **Password Hashing**: Automatic password hashing
5. **Session Management**: Proper session regeneration on login/logout

## Next Steps

1. Create additional models (Class, Subject, Grade, Attendance, etc.)
2. Build CRUD interfaces for each role
3. Implement parent-student relationships
4. Add email verification
5. Create password reset functionality
6. Add profile management
7. Implement notifications system

## Testing

Login with default admin:
- URL: http://localhost:8000/login
- Email: admin@school.com
- Password: password

Register new users:
- URL: http://localhost:8000/register
- Available roles: Student, Parent
