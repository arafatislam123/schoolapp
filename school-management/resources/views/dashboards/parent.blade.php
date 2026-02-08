@extends('layouts.app')

@section('content')
<div style="padding: 20px;">
    <h1>Parent Dashboard</h1>
    <p>Welcome, {{ auth()->user()->name }}!</p>
    
    <div style="margin-top: 30px;">
        <h2>Parent Features</h2>
        <ul>
            <li>View children's information</li>
            <li>Check children's grades</li>
            <li>View attendance records</li>
            <li>Communicate with teachers</li>
        </ul>
    </div>
</div>
@endsection
