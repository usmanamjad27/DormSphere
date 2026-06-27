<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HouseRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HouseRuleController extends Controller
{
    public function index()
    {
        $rules = HouseRule::orderBy('sort_order')->paginate(15);

        return view('admin.house-rules.index', compact('rules'));
    }

    public function create()
    {
        return view('admin.house-rules.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'section_title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['boolean'],
        ]);

        HouseRule::create(array_merge($data, [
            'admin_id' => Auth::guard('admin')->id(),
            'is_active' => $request->boolean('is_active', true),
            'sort_order' => $data['sort_order'] ?? 0,
        ]));

        return redirect()->route('admin.house-rules.index')->with('status', 'House rule added.');
    }

    public function show(HouseRule $house_rule)
    {
        return redirect()->route('admin.house-rules.edit', $house_rule);
    }

    public function edit(HouseRule $house_rule)
    {
        return view('admin.house-rules.edit', ['rule' => $house_rule]);
    }

    public function update(Request $request, HouseRule $house_rule)
    {
        $data = $request->validate([
            'section_title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['boolean'],
        ]);

        $house_rule->update(array_merge($data, [
            'is_active' => $request->boolean('is_active'),
        ]));

        return redirect()->route('admin.house-rules.index')->with('status', 'House rule updated.');
    }

    public function destroy(HouseRule $house_rule)
    {
        $house_rule->delete();

        return redirect()->route('admin.house-rules.index')->with('status', 'House rule removed.');
    }
}
