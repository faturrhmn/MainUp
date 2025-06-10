<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('content.pages.pages-account-settings-profile', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => ['nullable', 'string', 'max:255'],
            'username' => ['nullable', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'current_password' => ['nullable', 'current_password'],
            'new_password' => ['nullable', 'min:8', 'confirmed'],
            'profile_photo' => ['nullable', 'image', 'max:2048'], // max 2MB
        ]);

        // Update basic info
        if ($request->has('name')) {
            $user->name = $request->name;
        }
        if ($request->has('username')) {
            $user->username = $request->username;
        }

        // Update password if provided
        if ($request->filled('new_password')) {
            $user->password = Hash::make($request->new_password);
        }

        // Handle profile photo upload
        if ($request->hasFile('profile_photo')) {
            // Delete old photo if exists
            if ($user->profile_photo && Storage::exists('public/profile-photos/' . $user->profile_photo)) {
                Storage::delete('public/profile-photos/' . $user->profile_photo);
            }

            // Store new photo
            $photoName = time() . '_' . $request->file('profile_photo')->getClientOriginalName();
            $request->file('profile_photo')->storeAs('public/profile-photos', $photoName);
            $user->profile_photo = $photoName;
        }

        $user->save();

        return redirect()->back()->with('success', 'Profile berhasil diperbarui');
    }

    public function deletePhoto()
    {
        $user = Auth::user();
        
        if ($user->profile_photo && Storage::exists('public/profile-photos/' . $user->profile_photo)) {
            Storage::delete('public/profile-photos/' . $user->profile_photo);
            $user->profile_photo = null;
            $user->save();
        }

        return redirect()->back()->with('success', 'Foto profil berhasil dihapus');
    }
} 