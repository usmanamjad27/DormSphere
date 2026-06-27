<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Allocation;

class ResidentController extends Controller
{
    public function index()
    {
        $residents = Allocation::with(['student', 'room.dorm'])
            ->where('status', 'active')
            ->latest()
            ->paginate(12);

        return view('admin.residents.index', compact('residents'));
    }

    public function show(Allocation $resident)
    {
        $resident->load(['student', 'room.dorm', 'application']);

        return view('admin.residents.show', ['allocation' => $resident]);
    }

    public function create()
    {
        return redirect()->route('admin.residents.index');
    }

    public function store()
    {
        return redirect()->route('admin.residents.index');
    }

    public function edit()
    {
        return redirect()->route('admin.residents.index');
    }

    public function update()
    {
        return redirect()->route('admin.residents.index');
    }

    public function destroy()
    {
        return redirect()->route('admin.residents.index');
    }
}
