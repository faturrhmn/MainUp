<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

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

        try {
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
                $photo = $request->file('profile_photo');
                
                // Log file information
                Log::info('Uploading profile photo', [
                    'original_name' => $photo->getClientOriginalName(),
                    'size' => $photo->getSize(),
                    'mime_type' => $photo->getMimeType()
                ]);

                // Create directory if it doesn't exist
                $uploadPath = public_path('assets/profile-photos');
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }

                // Delete old photo if exists
                if ($user->profile_photo) {
                    $oldPhotoPath = public_path('assets/profile-photos/' . $user->profile_photo);
                    if (file_exists($oldPhotoPath)) {
                        unlink($oldPhotoPath);
                        Log::info('Deleted old profile photo', ['path' => $oldPhotoPath]);
                    }
                }

                // Generate unique filename
                $photoName = time() . '_' . uniqid() . '.' . $photo->getClientOriginalExtension();
                
                // Move the file
                try {
                    $photo->move($uploadPath, $photoName);
                    Log::info('Profile photo uploaded successfully', ['new_path' => $uploadPath . '/' . $photoName]);
                    
                    // Update database only if file was moved successfully
                    $user->profile_photo = $photoName;
                } catch (\Exception $e) {
                    Log::error('Failed to move profile photo', [
                        'error' => $e->getMessage(),
                        'target_path' => $uploadPath . '/' . $photoName
                    ]);
                    return redirect()->back()->with('error', 'Gagal mengupload foto profil. Silakan coba lagi.');
                }
            }

            $user->save();
            Log::info('User profile updated successfully', ['user_id' => $user->id]);

            return redirect()->back()->with('success', 'Profile berhasil diperbarui');
        } catch (\Exception $e) {
            Log::error('Failed to update profile', [
                'error' => $e->getMessage(),
                'user_id' => $user->id
            ]);
            return redirect()->back()->with('error', 'Gagal memperbarui profile. Silakan coba lagi.');
        }
    }

    public function deletePhoto()
    {
        try {
            $user = Auth::user();
            
            if ($user->profile_photo) {
                $photoPath = public_path('assets/profile-photos/' . $user->profile_photo);
                if (file_exists($photoPath)) {
                    unlink($photoPath);
                    Log::info('Profile photo deleted', ['path' => $photoPath]);
                }
                
                $user->profile_photo = null;
                $user->save();
            }

            return redirect()->back()->with('success', 'Foto profil berhasil dihapus');
        } catch (\Exception $e) {
            Log::error('Failed to delete profile photo', [
                'error' => $e->getMessage(),
                'user_id' => $user->id ?? null
            ]);
            return redirect()->back()->with('error', 'Gagal menghapus foto profil. Silakan coba lagi.');
        }
    }
} 