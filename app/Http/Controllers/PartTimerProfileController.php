<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\PartTimerProfile; // Use Eloquent instead of DB::table
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
        }

        return view('part-timers.profile.edit', compact('profile'));
    }

    public function update(Request $request)
    {
        $profile = auth()->user()->profile;
        if (!$profile) {
            return redirect()->route('profile.create')->with('error', 'Please create a profile first.');
        }

        // Update text fields
        $profile->update([
            'full_name' => $request->full_name,
            'bio' => $request->bio,
            'phone' => $request->phone,
            'location' => $request->location,
            'work_experience' => $request->work_experience,
        ]);

        // Handle photo removal
        $existingPhotos = is_array($profile->work_photos) ? $profile->work_photos : json_decode($profile->work_photos, true) ?? [];

        if ($request->has('remove_photos')) {
            foreach ($request->remove_photos as $photo) {
                Storage::delete('public/' . $photo); // Delete from storage
                $existingPhotos = array_diff($existingPhotos, [$photo]); // Remove from array
            }
        }

        // Handle new photo uploads
        if ($request->hasFile('work_photos')) {
            foreach ($request->file('work_photos') as $photo) {
                $path = $photo->store('work_photos', 'public'); // Store file in storage/app/public/work_photos
                $existingPhotos[] = $path; // Add new photo to array
            }
        }

        // Save updated photo list
        $profile->work_photos = json_encode(array_values($existingPhotos)); // Ensure array format
        $profile->save();

        return redirect()->route('public-profile.show', ['id' => $profile->id])->with('success', 'Profile updated successfully.');
    }

}
