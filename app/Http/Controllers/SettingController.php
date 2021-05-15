<?php

namespace App\Http\Controllers;

use App\Http\Requests\SettingRequest;
use App\Models\Setting;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::first();

        return view('admin-area.settings', compact('settings'));
    }

    public function update(SettingRequest $request)
    {
        $setting = app()->make(Setting::class);
        $setting->fill($request->all());
        $setting->save();
        if ($request->forum_image) {
            $setting->forum_image = $request->file('forum_image')->store('uploads', 'public');
            $setting->save();
        }

        return redirect()->route('home')->withStatus( __('Settings successfully updated.'));
    }
}
