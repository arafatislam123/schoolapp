@extends('layouts.app')

@section('content')
<div style="padding: 20px;">
    <h1>Student Dashboard</h1>
    <p>Welcome, {{ auth()->user()->name }}!</p>
    
    <div style="margin-top: 30px;">
        <h2>Student Features</h2>
        <ul>
            <li>View enrolled classes</li>
            <li>Check grades and report cards</li>
            <li>View assignments</li>
            <li>Check attendance record</li>
        </ul>
    </div>
</div>
@endsection
