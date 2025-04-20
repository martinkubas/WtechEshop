<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\User;



class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login'); 
    }
    public function showSignupForm()
    {
        return view('signup'); 
    }

    public function signup(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255|unique:users,username',
            'fullName' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|confirmed', 
        ]);

        $user = User::create([
            'username' => $request->username,
            'full_name' => $request->fullName,
            'email' => $request->email,
            'password' => $request->password,
            'member_since' => now(), 
        ]);

        session(['user_id' => $user->id]);

        return redirect()->route('profile');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || $request->password !== $user->password) {
            return back()->withErrors(['email' => 'Invalid credentials'])->withInput();
        }

        session(['user_id' => $user->id]);

        return redirect()->route('profile');
    }


    public function profile()
    {
        $user = User::with('orders.products')->find(session('user_id'));

        if (!$user) {
            return redirect()->route('login');
        }

        return view('profile', compact('user'));
    }

    public function logout()
    {
        session()->forget('user_id');
        return redirect()->route('home');
    }
}
