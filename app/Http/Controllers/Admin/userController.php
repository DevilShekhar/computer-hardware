<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->get();
        return view('admin.users.index', compact('users'));
    }
    public function create()
    {
        return view('admin.users.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'gender' => 'nullable|string|max:20',
            'birth_date' => 'nullable|date',
            'profile' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'password' => 'required|string|min:8|confirmed',
        ]);
        $profile = null;
        if ($request->hasFile('profile')) {
            $profile = $request->file('profile')->store('users', 'public');
        }
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'birth_date' => $request->birth_date,
            'profile' => $profile,
            'status' => 1,
            'password' => bcrypt($request->password),
        ]);
        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }

    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'gender' => 'nullable|string|max:20',
            'birth_date' => 'nullable|date',
            'profile' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status' => 'required|boolean',
        ]);
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'birth_date' => $request->birth_date,
            'status' => $request->status,
        ];
        if ($request->hasFile('profile')) {
            $data['profile'] = $request->file('profile')
                ->store('users', 'public');
        }       
        $user->update($data);
        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }
    public function destroy(User $user)
    {
        $user->update(['status' => 0,]);
        return redirect()->route('admin.users.index')->with('success', 'User deactivated successfully.');
    }
}