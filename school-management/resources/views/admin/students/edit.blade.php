@extends('layouts.app')

@section('content')
<div style="max-width: 900px; margin: 30px auto; padding: 20px;">
    <h2>Edit Student: {{ $student->user->name }}</h2>
    <p style="color: #666; margin-bottom: 20px;">Update student information</p>

    @if($errors->any())
        <div style="padding: 10px; background: #f8d7da; color: #721c24; margin-bottom: 20px; border-radius: 4px;">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.students.update', $student) }}" style="background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
        @csrf
        @method('PUT')

        <!-- Personal Information -->
        <h3 style="margin-top: 0; padding-bottom: 10px; border-bottom: 2px solid #007bff;">Personal Information</h3>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            <div>
                <label for="name">Full Name *</label>
                <input type="text" id="name" name="name" value="{{ old('name', $student->user->name) }}" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; margin-top: 5px;">
            </div>

            <div>
                <label for="date_of_birth">Date of Birth *</label>
                <input type="date" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth', $student->user->date_of_birth?->format('Y-m-d')) }}" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; margin-top: 5px;">
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            <div>
                <label for="email">Email Address *</label>
                <input type="email" id="email" name="email" value="{{ old('email', $student->user->email) }}" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; margin-top: 5px;">
            </div>

            <div>
                <label for="phone">Phone Number</label>
                <input type="text" id="phone" name="phone" value="{{ old('phone', $student->user->phone) }}" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; margin-top: 5px;">
            </div>
        </div>

        <div style="margin-bottom: 20px;">
            <label for="address">Address</label>
            <textarea id="address" name="address" rows="2" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; margin-top: 5px;">{{ old('address', $student->user->address) }}</textarea>
        </div>

        <!-- Account Information -->
        <h3 style="margin-top: 30px; padding-bottom: 10px; border-bottom: 2px solid #007bff;">Account Information</h3>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            <div>
                <label for="password">New Password (leave blank to keep current)</label>
                <input type="password" id="password" name="password" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; margin-top: 5px;">
            </div>

            <div>
                <label for="password_confirmation">Confirm New Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; margin-top: 5px;">
            </div>
        </div>

        <!-- Student Information -->
        <h3 style="margin-top: 30px; padding-bottom: 10px; border-bottom: 2px solid #007bff;">Student Information</h3>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            <div>
                <label for="student_id">Student ID *</label>
                <input type="text" id="student_id" name="student_id" value="{{ old('student_id', $student->student_id) }}" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; margin-top: 5px;">
            </div>

            <div>
                <label for="admission_date">Admission Date *</label>
                <input type="date" id="admission_date" name="admission_date" value="{{ old('admission_date', $student->admission_date->format('Y-m-d')) }}" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; margin-top: 5px;">
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            <div>
                <label for="grade_level">Grade Level *</label>
                <select id="grade_level" name="grade_level" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; margin-top: 5px;">
                    <option value="">Select Grade</option>
                    @for($i = 1; $i <= 12; $i++)
                        <option value="Grade {{ $i }}" {{ old('grade_level', $student->grade_level) == "Grade $i" ? 'selected' : '' }}>Grade {{ $i }}</option>
                    @endfor
                </select>
            </div>

            <div>
                <label for="section">Section</label>
                <input type="text" id="section" name="section" value="{{ old('section', $student->section) }}" placeholder="e.g., A, B, C" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; margin-top: 5px;">
            </div>

            <div>
                <label for="status">Status *</label>
                <select id="status" name="status" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; margin-top: 5px;">
                    <option value="active" {{ old('status', $student->status) == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status', $student->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    <option value="graduated" {{ old('status', $student->status) == 'graduated' ? 'selected' : '' }}>Graduated</option>
                    <option value="transferred" {{ old('status', $student->status) == 'transferred' ? 'selected' : '' }}>Transferred</option>
                </select>
            </div>
        </div>

        <!-- Parent/Guardian Information -->
        <h3 style="margin-top: 30px; padding-bottom: 10px; border-bottom: 2px solid #007bff;">Parent/Guardian Information</h3>
        
        <div style="margin-bottom: 20px;">
            <label for="parent_id">Select Parent/Guardian</label>
            <select id="parent_id" name="parent_id" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; margin-top: 5px;">
                <option value="">No parent assigned</option>
                @foreach($parents as $parent)
                    <option value="{{ $parent->id }}" {{ old('parent_id', $student->parent_id) == $parent->id ? 'selected' : '' }}>
                        {{ $parent->name }} ({{ $parent->email }})
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Medical & Emergency Information -->
        <h3 style="margin-top: 30px; padding-bottom: 10px; border-bottom: 2px solid #007bff;">Medical & Emergency Information</h3>
        
        <div style="margin-bottom: 20px;">
            <label for="medical_info">Medical Information</label>
            <textarea id="medical_info" name="medical_info" rows="3" placeholder="Allergies, medical conditions, medications, etc." style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; margin-top: 5px;">{{ old('medical_info', $student->medical_info) }}</textarea>
        </div>

        <div style="margin-bottom: 20px;">
            <label for="emergency_contact">Emergency Contact</label>
            <textarea id="emergency_contact" name="emergency_contact" rows="3" placeholder="Emergency contact name, relationship, phone number, etc." style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; margin-top: 5px;">{{ old('emergency_contact', $student->emergency_contact) }}</textarea>
        </div>

        <!-- Submit Buttons -->
        <div style="display: flex; gap: 10px; margin-top: 30px; padding-top: 20px; border-top: 1px solid #ddd;">
            <button type="submit" style="padding: 12px 30px; background: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 16px;">
                Update Student
            </button>
            <a href="{{ route('admin.students.index') }}" style="padding: 12px 30px; background: #6c757d; color: white; text-decoration: none; border-radius: 4px; display: inline-block;">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
