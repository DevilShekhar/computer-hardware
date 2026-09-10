<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }
    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            $user = User::where('google_id', $googleUser->id)->first();
            if (!$user) {
                $user = User::where('email', $googleUser->email)->first();
            }
            if (!$user) {
                $customerRoleId = DB::table('roles')
                    ->where('name', 'customer')
                    ->where('guard_name', 'web')
                    ->value('id');
                if (!$customerRoleId) {
                    return redirect()
                        ->route('login')
                        ->with(
                            'error',
                            'Customer role not found. Please contact administrator.'
                        );
                }
                $user = User::create([
                    'role_id'   => $customerRoleId,
                    'name'      => $googleUser->name,
                    'email'     => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'password'  => Str::random(32),
                    'status'    => true,
                ]);
            }
            else {
                if (!$user->google_id) {
                    $user->update([
                        'google_id' => $googleUser->id,
                    ]);
                }
            }
            Auth::login($user, true);
            return redirect()->intended(route('dashboard'));
        } catch (\Exception $e) {
            return redirect()
                ->route('login')
                ->with(
                    'error',
                    'Google authentication failed. Please try again.'
                );
        }
    }
}