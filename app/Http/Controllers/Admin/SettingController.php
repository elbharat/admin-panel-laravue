<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class SettingController extends Controller
{
    /**
     * Display the website settings page.
     */
    public function index()
    {
        $settings = Setting::all()->keyBy('key');
        
        return Inertia::render('Admin/Settings/Index', [
            'settings' => $settings,
            'websiteTitle' => Setting::get('website_title', config('app.name')),
            'websiteSubtitle' => Setting::get('website_subtitle', ''),
            'websiteLogo' => Setting::get('website_logo', ''),
            'websiteFavicon' => Setting::get('website_favicon', ''),
            'websiteThumbnail' => Setting::get('website_thumbnail', ''),
            'footerCopyright' => Setting::get('footer_copyright', '© ' . date('Y') . ' ' . config('app.name')),
        ]);
    }

    /**
     * Update the website settings.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'website_title' => 'required|string|max:255',
            'website_subtitle' => 'nullable|string|max:255',
            'website_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'website_favicon' => 'nullable|image|mimes:ico,png|max:1024',
            'website_thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'footer_copyright' => 'nullable|string|max:255',
        ]);

        // Handle text settings
        Setting::set('website_title', $validated['website_title'], 'website', 'text', 'Website title');
        Setting::set('website_subtitle', $validated['website_subtitle'] ?? '', 'website', 'text', 'Website subtitle');
        Setting::set('footer_copyright', $validated['footer_copyright'] ?? ('© ' . date('Y') . ' ' . config('app.name')), 'website', 'text', 'Footer copyright text');

        // Handle file uploads
        $this->handleFileUpload($request, 'website_logo', 'website', 'image', 'Website logo');
        $this->handleFileUpload($request, 'website_favicon', 'website', 'image', 'Website favicon');
        $this->handleFileUpload($request, 'website_thumbnail', 'website', 'image', 'Website thumbnail/og image');

        return redirect()->back()->with('success', 'Pengaturan website berhasil diperbarui.');
    }

    /**
     * Handle file upload for settings
     */
    private function handleFileUpload(Request $request, string $key, string $group, string $type, string $description)
    {
        if ($request->hasFile($key) && $request->file($key)->isValid()) {
            // Delete old file if exists
            $oldValue = Setting::get($key);
            if ($oldValue && Storage::disk('public')->exists($oldValue)) {
                Storage::disk('public')->delete($oldValue);
            }

            // Store new file
            $path = $request->file($key)->store('settings', 'public');
            Setting::set($key, $path, $group, $type, $description);
        }
    }
}
