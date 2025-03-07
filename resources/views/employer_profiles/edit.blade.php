{{-- resources/views/employers/profile/edit.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-3xl text-gray-800 leading-tight">
            {{ __('Edit Employer Profile') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl rounded-lg p-8">
                <form action="{{ route('employer.profile.update', $profile->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-gray-700">Company Name</label>
                            <input type="text" name="company_name" value="{{ old('company_name', $profile->company_name) }}" class="w-full px-4 py-2 border rounded-lg" required>
                        </div>
                        <div>
                            <label class="block text-gray-700">Business Email</label>
                            <input type="email" name="business_email" value="{{ old('business_email', $profile->business_email) }}" class="w-full px-4 py-2 border rounded-lg">
                        </div>
                        <div>
                            <label class="block text-gray-700">Phone</label>
                            <input type="text" name="phone" value="{{ old('phone', $profile->phone) }}" class="w-full px-4 py-2 border rounded-lg">
                        </div>
                        <div>
                            <label class="block text-gray-700">Industry</label>
                            <input type="text" name="industry" value="{{ old('industry', $profile->industry) }}" class="w-full px-4 py-2 border rounded-lg">
                        </div>
                        <div>
                            <label class="block text-gray-700">Organization Type</label>
                            <input type="text" name="organization_type" value="{{ old('organization_type', $profile->organization_type) }}" class="w-full px-4 py-2 border rounded-lg">
                        </div>
                        <div>
                            <label class="block text-gray-700">Establishment Year</label>
                            <input type="text" name="establishment_year" value="{{ old('establishment_year', $profile->establishment_year) }}" class="w-full px-4 py-2 border rounded-lg">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-gray-700">About</label>
                            <textarea name="about" class="w-full px-4 py-2 border rounded-lg">{{ old('about', $profile->about) }}</textarea>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-gray-700">Vision</label>
                            <textarea name="vision" class="w-full px-4 py-2 border rounded-lg">{{ old('vision', $profile->vision) }}</textarea>
                        </div>
                        <div>
                            <label class="block text-gray-700">Company Location</label>
                            <input type="text" name="company_location" value="{{ old('company_location', $profile->company_location) }}" class="w-full px-4 py-2 border rounded-lg">
                        </div>
                        <div>
                            <label class="block text-gray-700">Team Size</label>
                            <input type="text" name="team_size" value="{{ old('team_size', $profile->team_size) }}" class="w-full px-4 py-2 border rounded-lg">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-gray-700">Company Website</label>
                            <input type="text" name="company_website" value="{{ old('company_website', $profile->company_website) }}" class="w-full px-4 py-2 border rounded-lg">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-gray-700">Social Media Links (JSON Format)</label>
                            <textarea name="social_media" class="w-full px-4 py-2 border rounded-lg">{{ old('social_media', $profile->social_media) }}</textarea>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-gray-700">Company Logo</label>
                            <input type="file" name="company_logo" class="w-full px-4 py-2 border rounded-lg">
                            @if ($profile->company_logo)
                                <img src="{{ asset('storage/' . $profile->company_logo) }}" class="w-32 h-32 mt-4">
                            @endif
                        </div>
                    </div>
                    <div class="mt-8 text-center">
                        <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
