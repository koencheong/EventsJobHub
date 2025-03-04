<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\PartTimerProfile;
use Illuminate\Support\Facades\Auth;

class PartTimerProfileController extends Controller
{
    public function show()
    {
        if (Auth::user()->role !== 'part-timer') {
            abort(403, 'Unauthorized access.');
        }

        $profile = PartTimerProfile::where('user_id', Auth::id())->first();

        if (!$profile) {
            return redirect()->route('profile.edit')->with('error', 'Please complete your profile.');
        }

        return view('part-timers.profile.show', compact('profile'));
    }

    public function edit()
    {
        if (Auth::user()->role !== 'part-timer') {
            abort(403, 'Unauthorized access.');
        }

        $profile = PartTimerProfile::where('user_id', Auth::id())->first();

        if (!$profile) {
            $profile = PartTimerProfile::create(['user_id' => Auth::id()]);
            return redirect()->route('profile.edit')->with('success', 'Profile created. Please complete your details.');
        }

        return view('part-timers.profile.edit', compact('profile'));
    }

    public function update(Request $request)
    {
        $profile = PartTimerProfile::where('user_id', Auth::id())->first();

        if (!$profile) {
            return redirect()->route('profile.edit')->with('error', 'Please create a profile first.');
        }

        // Update text fields
        $profile->update([
            'full_name' => $request->full_name,
            'bio' => $request->bio,
            'phone' => $request->phone,
            'location' => $request->location,
            'work_experience' => $request->work_experience,
        ]);

        // Decode existing photos safely
        $existingPhotos = is_string($profile->work_photos) 
            ? json_decode($profile->work_photos, true) ?? [] 
            : [];

        // Handle photo removal
        if ($request->has('remove_photos')) {
            foreach ($request->remove_photos as $photo) {
                Storage::delete('public/' . $photo); // Delete from storage
                $existingPhotos = array_diff($existingPhotos, [$photo]); // Remove from array
            }
        }

        // Handle new photo uploads
        if ($request->hasFile('work_photos')) {
            foreach ($request->file('work_photos') as $photo) {
                $path = $photo->store('work_photos', 'public');
                $existingPhotos[] = $path;
            }
        }

        // Save updated photo list
        $profile->work_photos = json_encode(array_values($existingPhotos));
        $profile->save();

        return redirect()->route('public-profile.show', ['id' => $profile->id])
            ->with('success', 'Profile updated successfully.');
    }
}
