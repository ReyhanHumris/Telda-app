<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => ['required', 'string', 'max:50'],
            'password' => ['required', 'string'],
        ]);

        $throttleKey = Str::lower($request->input('username')).'|'.$request->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            throw ValidationException::withMessages([
                'username' => ['Terlalu banyak percobaan login. Coba lagi nanti.'],
            ]);
        }

        $ok = Auth::attempt(
            ['username' => $request->string('username')->toString(), 'password' => $request->string('password')->toString()],
            $request->boolean('remember')
        );

        if (! $ok) {
            RateLimiter::hit($throttleKey, 60);

            throw ValidationException::withMessages([
                'username' => ['Username atau password salah.'],
            ]);
        }

        RateLimiter::clear($throttleKey);
        $request->session()->regenerate();

        return redirect()->route('dashboard');
    }
}

