<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{
    public function create(Request $request)
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'max:255'],
        ]);

        if (!Auth::attempt($credentials)) {
            return back()->withErrors([
                'password' => 'We could not verify your credentials. Please try again.',
            ])->withInput();
        }

        $request->session()->regenerate();

        return redirect()->intended('/')->with('success', 'You have been logged in successfully');

    }

    public function destroy(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->intended(route('idea.index'))->with('success', 'You have been logged out successfully');
    }
}
