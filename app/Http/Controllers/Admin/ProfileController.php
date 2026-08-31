<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Display profile page.
     */
    public function index()
    {
        $user = auth()->user();
        return view('admin.profile.index', compact('user'));
    }

    /**
     * Update profile.
     */
    public function update(Request $request)
    {
        $user = auth()->user();
        $validated = $request->validate([
            'name' => ['required','string','max:255',],
            'email' => ['required','email','max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'phone' => ['nullable','string','max:20',],
            'gender' => ['nullable','string','max:20',],
            'birth_date' => ['nullable','date',],
            'profile' => ['nullable','image','mimes:jpg,jpeg,png,webp','max:2048',],
        ]);
        if ($request->hasFile('profile')) {
            // Delete old profile image
            if ($user->profile && Storage::disk('public')->exists($user->profile)) {
                Storage::disk('public')->delete($user->profile);
            }
            // Upload new profile image
            $validated['profile'] = $request->file('profile')->store('profiles', 'public');
        }
        $user->update($validated);
        return redirect()->route('profile')->with('success', 'Profile updated successfully.');
    }
    /**
     * Show old password page.
     */
    public function changePassword()
    {
        return view('admin.profile.password.index');
    }

    /*
    |--------------------------------------------------------------------------
    | Change Password - Step 2
    |--------------------------------------------------------------------------
    */

    /**
     * Verify old password.
     */
    public function verifyOldPassword(Request $request)
    {
        $request->validate([
            'old_password' => [
                'required',
                'string',
            ],
        ]);

        $user = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | Check Old Password
        |--------------------------------------------------------------------------
        */

        if (!Hash::check($request->old_password, $user->password)) {

            return back()
                ->withErrors([
                    'old_password' => 'The old password is incorrect.',
                ])
                ->withInput();
        }

        /*
        |--------------------------------------------------------------------------
        | Store Temporary Verification
        |--------------------------------------------------------------------------
        */

        session([
            'password_verified' => true,
        ]);

        return redirect()
            ->route('password.new');
    }


    /*
    |--------------------------------------------------------------------------
    | Change Password - Step 3
    |--------------------------------------------------------------------------
    */

    /**
     * Show new password page.
     */
    public function newPassword()
    {
        /*
        |--------------------------------------------------------------------------
        | Check Old Password Verification
        |--------------------------------------------------------------------------
        */

        if (!session('password_verified')) {

            return redirect()
                ->route('password.index')
                ->withErrors([
                    'old_password' => 'Please verify your old password first.',
                ]);
        }

        return view('admin.profile.password.new');
    }


    /*
    |--------------------------------------------------------------------------
    | Change Password - Step 4
    |--------------------------------------------------------------------------
    */

    /**
     * Update new password.
     */
    public function updatePassword(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Check Verification
        |--------------------------------------------------------------------------
        */

        if (!session('password_verified')) {

            return redirect()
                ->route('password.index')
                ->withErrors([
                    'old_password' => 'Please verify your old password first.',
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Validate New Password
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],
        ]);

        $user = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | Update Password
        |--------------------------------------------------------------------------
        */

        $user->password = $validated['password'];

        /*
        |--------------------------------------------------------------------------
        | User Model has password => hashed
        |--------------------------------------------------------------------------
        */

        $user->save();

        /*
        |--------------------------------------------------------------------------
        | Remove Password Verification
        |--------------------------------------------------------------------------
        */

        session()->forget('password_verified');

        /*
        |--------------------------------------------------------------------------
        | Redirect
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('profile')
            ->with('success', 'Password changed successfully.');
    }
}