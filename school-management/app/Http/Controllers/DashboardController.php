<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = auth()->user();
        
        // Redirect to role-specific dashboard
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->isTeacher()) {
            return redirect()->route('teacher.dashboard');
        } elseif ($user->isStudent()) {
            return redirect()->route('student.dashboard');
        } elseif ($user->isParent()) {
            return redirect()->route('parent.dashboard');
        }

        return view('dashboard', compact('user'));
    }

    public function adminDashboard()
    {
        return view('dashboards.admin');
    }

    public function teacherDashboard()
    {
        return view('dashboards.teacher');
    }

    public function studentDashboard()
    {
        return view('dashboards.student');
    }

    public function parentDashboard()
    {
        return view('dashboards.parent');
    }
}
