<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class ProfileController extends Controller
{
    public function show()
    {
        $admin = Auth::guard('admin')->user();

        return view('admin.profile.show', compact('admin'));
    }

    public function update(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        $data = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        if (! $request->filled('password')) {
            unset($data['password']);
        }

        $admin->update($data);

        return back()->with('status', 'Profile updated successfully.');
    }
}
