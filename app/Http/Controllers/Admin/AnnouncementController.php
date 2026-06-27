<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Dorm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::with('targetDorm')->latest()->paginate(10);

        return view('admin.announcements.index', compact('announcements'));
    }

    public function create()
    {
        $dorms = Dorm::orderBy('name')->get();

        return view('admin.announcements.create', compact('dorms'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
            'target_audience' => ['required', 'in:all,specific_dorm'],
            'target_dorm_id' => ['nullable', 'exists:dorms,id'],
            'publish_date' => ['nullable', 'date'],
            'expiry_date' => ['nullable', 'date', 'after_or_equal:publish_date'],
        ]);

        Announcement::create(array_merge($data, [
            'admin_id' => Auth::guard('admin')->id(),
            'publish_date' => $data['publish_date'] ?? now()->toDateString(),
        ]));

        return redirect()->route('admin.announcements.index')->with('status', 'Announcement published.');
    }

    public function show(Announcement $announcement)
    {
        return redirect()->route('admin.announcements.edit', $announcement);
    }

    public function edit(Announcement $announcement)
    {
        $dorms = Dorm::orderBy('name')->get();

        return view('admin.announcements.edit', compact('announcement', 'dorms'));
    }

    public function update(Request $request, Announcement $announcement)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
            'target_audience' => ['required', 'in:all,specific_dorm'],
            'target_dorm_id' => ['nullable', 'exists:dorms,id'],
            'publish_date' => ['nullable', 'date'],
            'expiry_date' => ['nullable', 'date'],
        ]);

        $announcement->update($data);

        return redirect()->route('admin.announcements.index')->with('status', 'Announcement updated.');
    }

    public function destroy(Announcement $announcement)
    {
        $announcement->delete();

        return redirect()->route('admin.announcements.index')->with('status', 'Announcement removed.');
    }
}
