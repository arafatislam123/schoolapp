@extends('layouts.app')

@section('content')
<div style="max-width: 500px; margin: 50px auto; padding: 20px; border: 1px solid #ccc;">
    <h2>Register</h2>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div style="margin-bottom: 15px;">
            <label for="name">Full Name</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required style="width: 100%; padding: 8px;">
            @error('name')
                <span style="color: red;">{{ $message }}</span>
            @enderror
        </div>

        <div style="margin-bottom: 15px;">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required style="width: 100%; padding: 8px;">
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
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required style="width: 100%; padding: 8px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label for="role_id">Register As</label>
            <select id="role_id" name="role_id" required style="width: 100%; padding: 8px;">
                <option value="">Select Role</option>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                        {{ $role->name }}
                    </option>
                @endforeach
            </select>
            @error('role_id')
                <span style="color: red;">{{ $message }}</span>
            @enderror
        </div>

        <div style="margin-bottom: 15px;">
            <label for="phone">Phone (Optional)</label>
            <input type="text" id="phone" name="phone" value="{{ old('phone') }}" style="width: 100%; padding: 8px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label for="date_of_birth">Date of Birth (Optional)</label>
            <input type="date" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}" style="width: 100%; padding: 8px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label for="address">Address (Optional)</label>
            <textarea id="address" name="address" rows="3" style="width: 100%; padding: 8px;">{{ old('address') }}</textarea>
        </div>

        <button type="submit" style="padding: 10px 20px; background: #28a745; color: white; border: none; cursor: pointer;">
            Register
        </button>

        <p style="margin-top: 15px;">
            Already have an account? <a href="{{ route('login') }}">Login here</a>
        </p>
    </form>
</div>
@endsection
