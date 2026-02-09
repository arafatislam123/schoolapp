@extends('layouts.app')

@section('content')
<div style="padding: 20px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h1>Student Management</h1>
        <a href="{{ route('admin.students.create') }}" style="padding: 10px 20px; background: #28a745; color: white; text-decoration: none; border-radius: 4px;">
            Add New Student
        </a>
    </div>

    @if(session('success'))
        <div style="padding: 10px; background: #d4edda; color: #155724; margin-bottom: 20px; border-radius: 4px;">
            {{ session('success') }}
        </div>
    @endif

    <!-- Search and Filter -->
    <form method="GET" action="{{ route('admin.students.index') }}" style="margin-bottom: 20px; padding: 15px; background: #f8f9fa; border-radius: 4px;">
        <div style="display: grid; grid-template-columns: 2fr 1fr 1fr auto; gap: 10px;">
            <input type="text" name="search" placeholder="Search by name, email, or student ID..." value="{{ request('search') }}" style="padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
            
            <select name="grade_level" style="padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                <option value="">All Grades</option>
                @foreach($gradeLevels as $grade)
                    <option value="{{ $grade }}" {{ request('grade_level') == $grade ? 'selected' : '' }}>{{ $grade }}</option>
                @endforeach
            </select>
            
            <select name="status" style="padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                <option value="">All Status</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                <option value="graduated" {{ request('status') == 'graduated' ? 'selected' : '' }}>Graduated</option>
                <option value="transferred" {{ request('status') == 'transferred' ? 'selected' : '' }}>Transferred</option>
            </select>
            
            <button type="submit" style="padding: 8px 20px; background: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer;">
                Search
            </button>
        </div>
    </form>

    <div style="background: white; border-radius: 4px; overflow: hidden; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f8f9fa;">
                    <th style="padding: 12px; text-align: left; border-bottom: 2px solid #dee2e6;">Student ID</th>
                    <th style="padding: 12px; text-align: left; border-bottom: 2px solid #dee2e6;">Name</th>
                    <th style="padding: 12px; text-align: left; border-bottom: 2px solid #dee2e6;">Email</th>
                    <th style="padding: 12px; text-align: left; border-bottom: 2px solid #dee2e6;">Grade/Section</th>
                    <th style="padding: 12px; text-align: left; border-bottom: 2px solid #dee2e6;">Parent</th>
                    <th style="padding: 12px; text-align: left; border-bottom: 2px solid #dee2e6;">Status</th>
                    <th style="padding: 12px; text-align: left; border-bottom: 2px solid #dee2e6;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($students as $student)
                <tr style="border-bottom: 1px solid #dee2e6;">
                    <td style="padding: 12px;">
                        <strong>{{ $student->student_id }}</strong>
                    </td>
                    <td style="padding: 12px;">{{ $student->user->name }}</td>
                    <td style="padding: 12px;">{{ $student->user->email }}</td>
                    <td style="padding: 12px;">
                        {{ $student->grade_level }}
                        @if($student->section)
                            - {{ $student->section }}
                        @endif
                    </td>
                    <td style="padding: 12px;">
                        @if($student->parent)
                            {{ $student->parent->name }}
                        @else
                            <span style="color: #999;">No parent assigned</span>
                        @endif
                    </td>
                    <td style="padding: 12px;">
                        <span style="padding: 4px 8px; background: {{ $student->status === 'active' ? '#28a745' : ($student->status === 'graduated' ? '#007bff' : '#dc3545') }}; color: white; border-radius: 4px; font-size: 12px;">
                            {{ ucfirst($student->status) }}
                        </span>
                    </td>
                    <td style="padding: 12px;">
                        <a href="{{ route('admin.students.show', $student) }}" style="color: #17a2b8; margin-right: 10px;">View</a>
                        <a href="{{ route('admin.students.edit', $student) }}" style="color: #007bff; margin-right: 10px;">Edit</a>
                        <form method="POST" action="{{ route('admin.students.destroy', $student) }}" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Are you sure? This will delete the student and their user account.')" style="color: #dc3545; background: none; border: none; cursor: pointer;">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="padding: 20px; text-align: center; color: #999;">
                        No students found. <a href="{{ route('admin.students.create') }}">Add your first student</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 20px;">
        {{ $students->links() }}
    </div>
</div>
@endsection
