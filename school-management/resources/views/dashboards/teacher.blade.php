@extends('layouts.app')

@section('content')
<div style="padding: 20px;">
    <h1>Teacher Dashboard</h1>
    <p>Welcome, {{ auth()->user()->name }}!</p>
    
    <div style="margin-top: 30px;">
        <h2>Teacher Features</h2>
        <ul>
            <li>View assigned classes</li>
            <li>Manage student grades</li>
            <li>Take attendance</li>
            <li>Create assignments</li>
        </ul>
    </div>
</div>
@endsection
