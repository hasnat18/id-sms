<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SystemSetting;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SystemSettingsController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:settings-list|settings-create|settings-edit|settings-delete', ['only' => ['index','store']]);
        $this->middleware('permission:settings-create', ['only' => ['create','store']]);
        $this->middleware('permission:settings-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:settings-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $site_settings = SystemSetting::select(['key', 'value'])
            ->whereNotIn('key', ['_token'])
            ->get()
            ->keyBy('key');
        return view('settings.index', compact('site_settings'));
    }

    public function update(Request $request)
    {
        $imagePath = null;
        
        // Get the current site logo path from the database
        $currentImagePath = SystemSetting::where('key', 'site_logo')->value('value');
        $img = null;
        // Check if a new logo has been uploaded
        if ($request->hasFile('site_logo')) {

            $imagePath = time().'.' . $request->site_logo->getClientOriginalExtension();
            \Image::make($request->site_logo)->save(public_path('uploads/logo/').$imagePath);
        } else {
            // If no new logo was uploaded, use the current logo path
            $imagePath = $currentImagePath;
        }

        // Update all other system settings except for the logo
        foreach ($request->except(['_token','_method', 'site_logo']) as $key => $value) {
            SystemSetting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        // Update or create the system setting for the logo with the new path
        SystemSetting::updateOrCreate(
            ['key' => 'site_logo'],
            ['value' => $imagePath]
        );

        // Redirect back to the settings page with a success message
        return redirect()->back()->with('success', 'Site settings have been updated successfully!');
    }



}
