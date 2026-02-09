@extends('layouts.app')

@section('content')
<div style="max-width: 900px; margin: 30px auto; padding: 20px;">
    <h2>Add New Student</h2>
    <p style="color: #666; margin-bottom: 20px;">Complete student registration with all required information</p>

    @if($errors->any())
        <div style="padding: 10px; background: #f8d7da; color: #721c24; margin-bottom: 20px; border-radius: 4px;">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.students.store') }}" style="background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
        @csrf

        <!-- Personal Information -->
        <h3 style="margin-top: 0; padding-bottom: 10px; border-bottom: 2px solid #007bff;">Personal Information</h3>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            <div>
                <label for="name">Full Name *</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; margin-top: 5px;">
            </div>

            <div>
                <label for="date_of_birth">Date of Birth *</label>
                <input type="date" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; margin-top: 5px;">
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            <div>
                <label for="email">Email Address *</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; margin-top: 5px;">
            </div>

            <div>
                <label for="phone">Phone Number</label>
                <input type="text" id="phone" name="phone" value="{{ old('phone') }}" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; margin-top: 5px;">
            </div>
        </div>

        <div style="margin-bottom: 20px;">
            <label for="address">Address</label>
            <textarea id="address" name="address" rows="2" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; margin-top: 5px;">{{ old('address') }}</textarea>
        </div>

        <!-- Account Information -->
        <h3 style="margin-top: 30px; padding-bottom: 10px; border-bottom: 2px solid #007bff;">Account Information</h3>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            <div>
                <label for="password">Password *</label>
                <input type="password" id="password" name="password" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; margin-top: 5px;">
                <small style="color: #666;">Minimum 8 characters</small>
            </div>

            <div>
                <label for="password_confirmation">Confirm Password *</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; margin-top: 5px;">
            </div>
        </div>

        <!-- Student Information -->
        <h3 style="margin-top: 30px; padding-bottom: 10px; border-bottom: 2px solid #007bff;">Student Information</h3>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            <div>
                <label for="student_id">Student ID *</label>
                <div style="display: flex; gap: 10px;">
                    <input type="text" id="student_id" name="student_id" value="{{ old('student_id') }}" required style="flex: 1; padding: 10px; border: 1px solid #ddd; border-radius: 4px; margin-top: 5px;">
                    <button type="button" onclick="generateStudentId()" style="padding: 10px 15px; background: #6c757d; color: white; border: none; border-radius: 4px; cursor: pointer; margin-top: 5px;">
                        Generate
                    </button>
                </div>
                <small style="color: #666;">Format: STU2024XXXX</small>
            </div>

            <div>
                <label for="admission_date">Admission Date *</label>
                <input type="date" id="admission_date" name="admission_date" value="{{ old('admission_date', date('Y-m-d')) }}" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; margin-top: 5px;">
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            <div>
                <label for="grade_level">Grade Level *</label>
                <select id="grade_level" name="grade_level" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; margin-top: 5px;">
                    <option value="">Select Grade</option>
                    <option value="Grade 1" {{ old('grade_level') == 'Grade 1' ? 'selected' : '' }}>Grade 1</option>
                    <option value="Grade 2" {{ old('grade_level') == 'Grade 2' ? 'selected' : '' }}>Grade 2</option>
                    <option value="Grade 3" {{ old('grade_level') == 'Grade 3' ? 'selected' : '' }}>Grade 3</option>
                    <option value="Grade 4" {{ old('grade_level') == 'Grade 4' ? 'selected' : '' }}>Grade 4</option>
                    <option value="Grade 5" {{ old('grade_level') == 'Grade 5' ? 'selected' : '' }}>Grade 5</option>
                    <option value="Grade 6" {{ old('grade_level') == 'Grade 6' ? 'selected' : '' }}>Grade 6</option>
                    <option value="Grade 7" {{ old('grade_level') == 'Grade 7' ? 'selected' : '' }}>Grade 7</option>
                    <option value="Grade 8" {{ old('grade_level') == 'Grade 8' ? 'selected' : '' }}>Grade 8</option>
                    <option value="Grade 9" {{ old('grade_level') == 'Grade 9' ? 'selected' : '' }}>Grade 9</option>
                    <option value="Grade 10" {{ old('grade_level') == 'Grade 10' ? 'selected' : '' }}>Grade 10</option>
                    <option value="Grade 11" {{ old('grade_level') == 'Grade 11' ? 'selected' : '' }}>Grade 11</option>
                    <option value="Grade 12" {{ old('grade_level') == 'Grade 12' ? 'selected' : '' }}>Grade 12</option>
                </select>
            </div>

            <div>
                <label for="section">Section</label>
                <input type="text" id="section" name="section" value="{{ old('section') }}" placeholder="e.g., A, B, C" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; margin-top: 5px;">
            </div>

            <div>
                <label for="status">Status *</label>
                <select id="status" name="status" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; margin-top: 5px;">
                    <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    <option value="graduated" {{ old('status') == 'graduated' ? 'selected' : '' }}>Graduated</option>
                    <option value="transferred" {{ old('status') == 'transferred' ? 'selected' : '' }}>Transferred</option>
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
                    <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>
                        {{ $parent->name }} ({{ $parent->email }})
                    </option>
                @endforeach
            </select>
            <small style="color: #666;">Parents must be registered first in the system</small>
        </div>

        <!-- Medical & Emergency Information -->
        <h3 style="margin-top: 30px; padding-bottom: 10px; border-bottom: 2px solid #007bff;">Medical & Emergency Information</h3>
        
        <div style="margin-bottom: 20px;">
            <label for="medical_info">Medical Information</label>
            <textarea id="medical_info" name="medical_info" rows="3" placeholder="Allergies, medical conditions, medications, etc." style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; margin-top: 5px;">{{ old('medical_info') }}</textarea>
        </div>

        <div style="margin-bottom: 20px;">
            <label for="emergency_contact">Emergency Contact</label>
            <textarea id="emergency_contact" name="emergency_contact" rows="3" placeholder="Emergency contact name, relationship, phone number, etc." style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; margin-top: 5px;">{{ old('emergency_contact') }}</textarea>
        </div>

        <!-- Submit Buttons -->
        <div style="display: flex; gap: 10px; margin-top: 30px; padding-top: 20px; border-top: 1px solid #ddd;">
            <button type="submit" style="padding: 12px 30px; background: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 16px;">
                Create Student
            </button>
            <a href="{{ route('admin.students.index') }}" style="padding: 12px 30px; background: #6c757d; color: white; text-decoration: none; border-radius: 4px; display: inline-block;">
                Cancel
            </a>
        </div>
    </form>
</div>

<script>
function generateStudentId() {
    fetch('{{ route('admin.generate-student-id') }}')
        .then(response => response.json())
        .then(data => {
            document.getElementById('student_id').value = data.student_id;
        })
        .catch(error => console.error('Error:', error));
}
</script>
@endsection
