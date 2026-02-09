@extends('layouts.app')

@section('content')
<div style="padding: 20px;">
    <h1>Admin Dashboard</h1>
    <p>Welcome, {{ auth()->user()->name }}!</p>
    
    <div style="margin-top: 30px;">
        <h2>Quick Actions</h2>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-top: 15px;">
            <a href="{{ route('admin.users.index') }}" style="padding: 20px; background: #007bff; color: white; text-decoration: none; border-radius: 8px; text-align: center; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <div style="font-size: 24px; margin-bottom: 10px;">👥</div>
                <div style="font-weight: bold;">Manage Users</div>
            </a>
            <a href="{{ route('admin.students.index') }}" style="padding: 20px; background: #28a745; color: white; text-decoration: none; border-radius: 8px; text-align: center; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <div style="font-size: 24px; margin-bottom: 10px;">👨‍🎓</div>
                <div style="font-weight: bold;">Manage Students</div>
            </a>
            <a href="{{ route('admin.users.create') }}" style="padding: 20px; background: #17a2b8; color: white; text-decoration: none; border-radius: 8px; text-align: center; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <div style="font-size: 24px; margin-bottom: 10px;">➕</div>
                <div style="font-weight: bold;">Add New User</div>
            </a>
            <a href="{{ route('admin.students.create') }}" style="padding: 20px; background: #ffc107; color: white; text-decoration: none; border-radius: 8px; text-align: center; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <div style="font-size: 24px; margin-bottom: 10px;">📝</div>
                <div style="font-weight: bold;">Add New Student</div>
            </a>
        </div>
    </div>

    <div style="margin-top: 30px;">
        <h2>System Features</h2>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 15px;">
            <div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <h3 style="margin-top: 0; color: #007bff;">✅ Implemented Features</h3>
                <ul style="line-height: 1.8;">
                    <li>User Management (Create, Edit, Delete)</li>
                    <li>Role-based Access Control</li>
                    <li>Student Management (Full CRUD)</li>
                    <li>Student Profile with Medical Info</li>
                    <li>Parent-Student Linking</li>
                    <li>Auto Student ID Generation</li>
                    <li>Search & Filter Students</li>
                    <li>Teacher Management</li>
                    <li>Class & Subject Management</li>
                    <li>Enrollment System</li>
                    <li>Grade Management</li>
                    <li>Attendance Tracking</li>
                </ul>
            </div>
            <div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <h3 style="margin-top: 0; color: #28a745;">🚀 Coming Soon</h3>
                <ul style="line-height: 1.8;">
                    <li>Fee Management</li>
                    <li>Exam Management</li>
                    <li>Report Cards & Transcripts</li>
                    <li>Communication System</li>
                    <li>Academic Calendar</li>
                    <li>Timetable Management</li>
                    <li>Library Management</li>
                    <li>Transport Management</li>
                    <li>Analytics & Reports</li>
                    <li>Mobile Apps</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
