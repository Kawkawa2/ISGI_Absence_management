<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function showLoginForm()
    {
        return view('authentification.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (empty($credentials['email']) || empty($credentials['password'])) {
            return redirect()->back()->withErrors([
                'email' => 'Email address is required',
                'password' => 'Password is required',
            ])->withInput();
        }

        $user = User::where('email', $credentials['email'])->first();
        if (!$user) {
            return redirect()->back()->withErrors([
                'email' => 'Invalid email address',
            ])->withInput();
        }

        if (!Hash::check($credentials['password'], $user->password)) {
            return redirect()->back()->withErrors([
                'password' => 'Invalid password',
            ])->withInput();
        }

        // Authentication successful
        Auth::login($user);
        return redirect()->intended('/Dash');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function logout()
    {
        Auth::logout();

        return redirect('/auth/login');
    }
}
