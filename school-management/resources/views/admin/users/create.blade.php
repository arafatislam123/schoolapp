@extends('layouts.app')

@section('content')
<div style="max-width: 600px; margin: 50px auto; padding: 20px; border: 1px solid #ccc;">
    <h2>Create New User</h2>

    <form method="POST" action="{{ route('admin.users.store') }}">
        @csrf

        <div style="margin-bottom: 15px;">
            <label for="name">Full Name *</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required style="width: 100%; padding: 8px;">
            @error('name')
                <span style="color: red;">{{ $message }}</span>
            @enderror
        </div>

        <div style="margin-bottom: 15px;">
            <label for="email">Email *</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required style="width: 100%; padding: 8px;">
            @error('email')
                <span style="color: red;">{{ $message }}</span>
            @enderror
        </div>

        <div style="margin-bottom: 15px;">
            <label for="password">Password *</label>
            <input type="password" id="password" name="password" required style="width: 100%; padding: 8px;">
            @error('password')
                <span style="color: red;">{{ $message }}</span>
            @enderror
        </div>

        <div style="margin-bottom: 15px;">
            <label for="password_confirmation">Confirm Password *</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required style="width: 100%; padding: 8px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label for="role_id">Role *</label>
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
            <label for="status">Status *</label>
            <select id="status" name="status" required style="width: 100%; padding: 8px;">
                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                <option value="suspended" {{ old('status') == 'suspended' ? 'selected' : '' }}>Suspended</option>
            </select>
            @error('status')
                <span style="color: red;">{{ $message }}</span>
            @enderror
        </div>

        <div style="margin-bottom: 15px;">
            <label for="phone">Phone</label>
            <input type="text" id="phone" name="phone" value="{{ old('phone') }}" style="width: 100%; padding: 8px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label for="date_of_birth">Date of Birth</label>
            <input type="date" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}" style="width: 100%; padding: 8px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label for="address">Address</label>
            <textarea id="address" name="address" rows="3" style="width: 100%; padding: 8px;">{{ old('address') }}</textarea>
        </div>

        <div style="display: flex; gap: 10px;">
            <button type="submit" style="padding: 10px 20px; background: #28a745; color: white; border: none; cursor: pointer;">
                Create User
            </button>
            <a href="{{ route('admin.users.index') }}" style="padding: 10px 20px; background: #6c757d; color: white; text-decoration: none; display: inline-block;">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
