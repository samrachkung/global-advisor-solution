<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // After login, go to admin dashboard. Role middleware will handle access.
    protected $redirectTo = '/admin/dashboard';

    protected function authenticated($request, $user)
    {
        return redirect()->intended(route('admin.dashboard'));
    }

    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $remember = $request->filled('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            // IMPORTANT: remove the is_admin gate below.
            // Old code caused your banner:
            // if (Auth::user()->is_admin) { ... } else { logout + error }

            // New: always go to dashboard; role middleware controls access thereafter.
            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput($request->only('email'));
    }
}
