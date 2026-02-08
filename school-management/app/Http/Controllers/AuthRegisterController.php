<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class AuthRegisterController extends Controller
{
    public function showRegistrationForm()
    {
        $roles = Role::whereIn('slug', ['student', 'parent'])->get();
        return view('auth.register', compact('roles'));
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role_id' => 'required|exists:roles,id',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'date_of_birth' => 'nullable|date',
        ]);

        // Only allow student and parent registration
        $role = Role::find($validated['role_id']);
        if (!in_array($role->slug, ['student', 'parent'])) {
            return back()->withErrors([
                'role_id' => 'Invalid role selected.',
            ]);
        }

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role_id' => $validated['role_id'],
            'phone' => $validated['phone'] ?? null,
            'address' => $validated['address'] ?? null,
            'date_of_birth' => $validated['date_of_birth'] ?? null,
            'status' => 'active',
        ]);

        auth()->login($user);

        return redirect()->route('dashboard');
    }
}
