@extends('layouts.app')

@section('content')
<div style="padding: 20px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h1>Manage Users</h1>
        <a href="{{ route('admin.users.create') }}" style="padding: 10px 20px; background: #28a745; color: white; text-decoration: none; border-radius: 4px;">
            Add New User
        </a>
    </div>

    @if(session('success'))
        <div style="padding: 10px; background: #d4edda; color: #155724; margin-bottom: 20px; border-radius: 4px;">
            {{ session('success') }}
        </div>
    @endif

    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background: #f8f9fa;">
                <th style="padding: 12px; text-align: left; border: 1px solid #dee2e6;">Name</th>
                <th style="padding: 12px; text-align: left; border: 1px solid #dee2e6;">Email</th>
                <th style="padding: 12px; text-align: left; border: 1px solid #dee2e6;">Role</th>
                <th style="padding: 12px; text-align: left; border: 1px solid #dee2e6;">Status</th>
                <th style="padding: 12px; text-align: left; border: 1px solid #dee2e6;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td style="padding: 12px; border: 1px solid #dee2e6;">{{ $user->name }}</td>
                <td style="padding: 12px; border: 1px solid #dee2e6;">{{ $user->email }}</td>
                <td style="padding: 12px; border: 1px solid #dee2e6;">
                    <span style="padding: 4px 8px; background: #007bff; color: white; border-radius: 4px; font-size: 12px;">
                        {{ $user->role->name }}
                    </span>
                </td>
                <td style="padding: 12px; border: 1px solid #dee2e6;">
                    <span style="padding: 4px 8px; background: {{ $user->status === 'active' ? '#28a745' : '#dc3545' }}; color: white; border-radius: 4px; font-size: 12px;">
                        {{ ucfirst($user->status) }}
                    </span>
                </td>
                <td style="padding: 12px; border: 1px solid #dee2e6;">
                    <a href="{{ route('admin.users.edit', $user) }}" style="color: #007bff; margin-right: 10px;">Edit</a>
                    @if($user->id !== auth()->id())
                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Are you sure?')" style="color: #dc3545; background: none; border: none; cursor: pointer;">
                            Delete
                        </button>
                    </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top: 20px;">
        {{ $users->links() }}
    </div>
</div>
@endsection
