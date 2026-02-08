@extends('layouts.app')

@section('content')
<div style="max-width: 400px; margin: 50px auto; padding: 20px; border: 1px solid #ccc;">
    <h2>Login</h2>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div style="margin-bottom: 15px;">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus style="width: 100%; padding: 8px;">
            @error('email')
                <span style="color: red;">{{ $message }}</span>
            @enderror
        </div>

        <div style="margin-bottom: 15px;">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required style="width: 100%; padding: 8px;">
            @error('password')
                <span style="color: red;">{{ $message }}</span>
            @enderror
        </div>

        <div style="margin-bottom: 15px;">
            <label>
                <input type="checkbox" name="remember"> Remember Me
            </label>
        </div>

        <button type="submit" style="padding: 10px 20px; background: #007bff; color: white; border: none; cursor: pointer;">
            Login
        </button>

        <p style="margin-top: 15px;">
            Don't have an account? <a href="{{ route('register') }}">Register here</a>
        </p>
    </form>
</div>
@endsection
