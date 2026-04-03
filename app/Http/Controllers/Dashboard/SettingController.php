<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Gate::authorize('settings.view');

        $settings = Setting::first();
        return view('dashboard.settings.index', compact('settings'));
    }

    // public function create()
    // {
    // Gate::authorize('settings.create');
    //     $setting = Setting::first();
    //     return view('dashboard.settings.create', compact('setting'));
    // }

    // public function store(Request $request)
    // {
    // Gate::authorize('settings.create');

    //     $validatedData = $request->validate([
    //         'name' => 'required|string|max:255',
    //         'currency' => 'required|string|max:255',
    //         'phone' => 'required|string|max:255',
    //         'email' => 'nullable|email|max:255',
    //         'tax_number' => 'nullable|string|max:255',
    //         'website_logo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    //         'epilogue_logo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    //         'tab_logo' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
    //         'qr_code' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    //         'invoice_stamp' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    //     ]);

    //     $imagePaths = [];
    //     foreach (['website_logo', 'epilogue_logo', 'tab_logo', 'qr_code', 'invoice_stamp'] as $field) {
    //         if ($request->hasFile($field)) {
    //             $path = $request->file($field)->store('settings', [
    //                 'disk' => 'public'
    //             ]);
    //             $imagePaths[$field] = $path;
    //         }
    //     }

    //     $settings = new Setting($validatedData);
    //     $settings->fill($imagePaths);
    //     $settings->save();

    //     return redirect()->route('dashboard.setting.index')->with('success', 'Settings saved successfully!');

    // }

    public function edit($id)
    {
        Gate::authorize('settings.update');

        $setting = Setting::findOrFail($id);
        return view('dashboard.settings.edit', compact('setting'));
    }

    public function update(Request $request, $id)
    {
        Gate::authorize('settings.update');

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'currency' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'tax_number' => 'nullable|string|max:255',
            'website_logo' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
            'epilogue_logo' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
            'tab_logo' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
            'qr_code' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
            'invoice_stamp' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
        ]);

        $setting = Setting::findOrFail($id);

        $imagePaths = [];
        foreach (['website_logo', 'epilogue_logo', 'tab_logo', 'qr_code', 'invoice_stamp'] as $field) {
            if ($request->hasFile($field)) {
                if ($setting->$field && Storage::disk('public')->exists($setting->$field)) {
                    Storage::disk('public')->delete($setting->$field);
                }
                $path = $request->file($field)->store('settings', [
                    'disk' => 'public'
                ]);
                $imagePaths[$field] = $path;
            }
        }

        $setting->fill(array_merge($validatedData, $imagePaths));
        $setting->save();

        return redirect()->route('dashboard.setting.index')->with('success', 'Settings updated successfully!');
    }
}
