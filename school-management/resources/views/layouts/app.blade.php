<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'School Management') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <nav>
        <div>
            <a href="{{ url('/') }}">{{ config('app.name', 'School Management') }}</a>
            
            @auth
                <span>{{ auth()->user()->name }} ({{ auth()->user()->role->name }})</span>
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}">Login</a>
                <a href="{{ route('register') }}">Register</a>
            @endauth
        </div>
    </nav>

    <main>
        @if(session('success'))
            <div style="color: green;">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div style="color: red;">{{ session('error') }}</div>
        @endif

        @yield('content')
    </main>
</body>
</html>
