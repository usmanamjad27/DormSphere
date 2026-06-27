<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Services\GooglePlaceImageService;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showRegistrationForm()
    {
        return view('student.auth.register');
    }

    public function showLoginForm(GooglePlaceImageService $googleImages)
    {
        $bgImage = Cache::remember('student_login_bg_image', now()->addDays(3), function () use ($googleImages) {
            return $googleImages->heroImage();
        });

        return view('student.auth.login', compact('bgImage'));
    }

    public function showForgotPasswordForm(GooglePlaceImageService $googleImages)
    {
        $bgImage = Cache::remember('student_password_forgot_bg', now()->addDays(3), function () use ($googleImages) {
            return $googleImages->heroImage();
        });

        return view('student.auth.passwords.email', compact('bgImage'));
    }

    public function sendPasswordResetLink(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:students,email'],
        ]);

        $status = Password::broker('students')->sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    }

    public function showResetForm(Request $request, string $token, GooglePlaceImageService $googleImages)
    {
        $bgImage = Cache::remember('student_password_reset_bg', now()->addDays(3), function () use ($googleImages) {
            return $googleImages->heroImage();
        });

        return view('student.auth.passwords.reset', [
            'token' => $token,
            'email' => $request->email,
            'bgImage' => $bgImage,
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email', 'exists:students,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $status = Password::broker('students')->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (Student $student, string $password) {
                $student->forceFill([
                    'password' => $password,
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($student));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('student.login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:students,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $student = Student::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        Auth::guard('student')->login($student);
        return redirect()->route('student.dashboard');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('student')->attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('student.dashboard'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::guard('student')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('student.login');
    }
}
