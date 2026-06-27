<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class ProfileController extends Controller
{
    public function show()
    {
        $student = Auth::guard('student')->user();

        return view('student.profile.show', compact('student'));
    }

    public function update(Request $request)
    {
        $student = Auth::guard('student')->user();

        $data = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'date_of_birth' => ['nullable', 'date'],
            'gender' => ['nullable', 'in:male,female,prefer_not_to_say'],
            'nationality' => ['nullable', 'string', 'max:100'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        if (! $request->filled('password')) {
            unset($data['password']);
        }

        $student->update($data);

        return back()->with('status', 'Profile updated successfully.');
    }
}
