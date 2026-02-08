@extends('layouts.app')

@section('content')
<div style="padding: 20px;">
    <h1>Admin Dashboard</h1>
    <p>Welcome, {{ auth()->user()->name }}!</p>
    
    <div style="margin-top: 30px;">
        <h2>Admin Features</h2>
        <ul>
            <li>Manage all users (Teachers, Students, Parents)</li>
            <li>Manage classes and subjects</li>
            <li>View system reports</li>
            <li>Configure system settings</li>
        </ul>
    </div>
</div>
@endsection
