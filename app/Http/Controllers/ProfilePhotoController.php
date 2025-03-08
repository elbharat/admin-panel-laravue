<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\File;
use Illuminate\Validation\Rule;

class ProfilePhotoController extends Controller
{
    /**
     * Update the user's profile photo.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $request->validate([
            'photo' => [
                'required',
                File::image()
                    ->max(1024 * 1024), // 1MB
            ],
        ]);

        $user = $request->user();

        // Hapus foto lama jika ada
        if ($user->profile_photo_path) {
            Storage::disk('public')->delete($user->profile_photo_path);
        }

        // Simpan foto baru
        $path = $request->file('photo')->storePublicly(
            'profile-photos', 'public'
        );

        // Update path foto di database
        $user->profile_photo_path = $path;
        $user->save();

        return back()->with('status', 'profile-photo-updated');
    }

    /**
     * Delete the user's profile photo.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        $user = $request->user();

        // Hapus foto dari storage
        if ($user->profile_photo_path) {
            Storage::disk('public')->delete($user->profile_photo_path);
        }

        // Hapus path foto dari database
        $user->profile_photo_path = null;
        $user->save();

        return back()->with('status', 'profile-photo-deleted');
    }
}
