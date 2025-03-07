<?php

namespace App\Http\Controllers;

use App\Models\EmployerProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EmployerProfileController extends Controller
{
    public function show()
    {
        if (Auth::user()->role !== 'employer') {
            abort(403, 'Unauthorized access.');
        }

        $profile = EmployerProfile::where('user_id', Auth::id())->first();

        if (!$profile) {
            return redirect()->route('employer.profile.edit')->with('error', 'Please complete your profile.');
        }

        return view('employer_profiles.show', compact('profile'));
    }

    public function edit()
    {
        if (Auth::user()->role !== 'employer') {
            abort(403, 'Unauthorized access.');
        }

        $profile = EmployerProfile::where('user_id', Auth::id())->first();

        if (!$profile) {
            $profile = EmployerProfile::create(['user_id' => Auth::id()]);
            return redirect()->route('employer.profile.edit')->with('success', 'Profile created. Please complete your details.');
        }

        return view('employer_profiles.edit', compact('profile'));
    }

    public function update(Request $request)
    {
        $profile = EmployerProfile::where('user_id', Auth::id())->first();

        if (!$profile) {
            return redirect()->route('employer.profile.edit')->with('error', 'Please create a profile first.');
        }

        // Validation
        $request->validate([
            'company_name' => 'required|string|max:255',
            'business_email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'company_logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Update basic details
        $profile->update([
            'company_name' => $request->company_name,
            'industry' => $request->industry,
            'organization_type' => $request->organization_type,
            'establishment_year' => $request->establishment_year,
            'about' => $request->about,
            'vision' => $request->vision,
            'company_location' => $request->company_location,
            'team_size' => $request->team_size,
            'phone' => $request->phone,
            'business_email' => $request->business_email,
            'company_website' => $request->company_website,
            'social_media' => json_encode($request->social_media),
        ]);

        // Handle Company Logo Upload
        if ($request->hasFile('company_logo')) {
            if ($profile->company_logo) {
                Storage::delete('public/' . $profile->company_logo);
            }
            $path = $request->file('company_logo')->store('company_logos', 'public');
            $profile->company_logo = $path;
            $profile->save();
        }
        return redirect()->route('employer.profile.show')
            ->with('success', 'Profile updated successfully.');
    }
}
