<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key')->toArray();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'restaurant_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:500',
            'whatsapp' => 'nullable|string|max:50',
            'opening_hours' => 'nullable|string',
            'facebook' => 'nullable|string|max:255',
            'instagram' => 'nullable|string|max:255',
        ]);

        $keys = ['restaurant_name', 'phone', 'email', 'address', 'whatsapp', 'opening_hours', 'facebook', 'instagram'];

        foreach ($keys as $key) {
            if ($request->has($key)) {
                Setting::updateOrCreate(['key' => $key], ['value' => $request->input($key)]);
            }
        }

        return redirect()->back()->with('success', 'Settings updated successfully.');
    }
}
