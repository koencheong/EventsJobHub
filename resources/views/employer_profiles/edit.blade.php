<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">{{ __('Edit Employer Profile') }}</h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl rounded-2xl p-8 border border-gray-100">
                <form action="{{ route('employer.profile.update', $profile->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')

                    <!-- Company Name -->
                    <div class="mb-6">
                        <label class="block text-gray-700 font-semibold mb-2">Company Name</label>
                        <input type="text" name="company_name" value="{{ $profile->company_name }}" class="border border-gray-300 rounded-lg p-2 w-full" required>
                    </div>

                    <!-- Industry -->
                    <div class="mb-6">
                        <label class="block text-gray-700 font-semibold mb-2">Industry</label>
                        <input type="text" name="industry" value="{{ $profile->industry }}" class="border border-gray-300 rounded-lg p-2 w-full">
                    </div>

                    <!-- Company Details -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <!-- Phone -->
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Phone</label>
                            <input type="text" name="phone" value="{{ $profile->phone }}" class="border border-gray-300 rounded-lg p-2 w-full">
                        </div>
                        <!-- Business Email -->
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Business Email</label>
                            <input type="email" name="business_email" value="{{ $profile->business_email }}" class="border border-gray-300 rounded-lg p-2 w-full">
                        </div>
                        <!-- Website -->
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Website</label>
                            <input type="url" name="company_website" value="{{ $profile->company_website }}" class="border border-gray-300 rounded-lg p-2 w-full">
                        </div>
                    </div>

                    <!-- Company Location -->
                    <div class="mb-6">
                        <label class="block text-gray-700 font-semibold mb-2">Company Location</label>
                        <input type="text" name="company_location" value="{{ $profile->company_location }}" class="border border-gray-300 rounded-lg p-2 w-full">
                    </div>

                    <!-- Social Media Links -->
                    <div class="mb-6">
                        <label class="block text-gray-700 font-semibold mb-2">Social Media Links</label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @php
                                $socialMedia = json_decode($profile->social_media, true) ?? [];
                            @endphp
                            @foreach (['facebook', 'linkedin', 'instagram'] as $platform)
                                <div>
                                    <label class="block text-gray-700 font-semibold capitalize">{{ ucfirst($platform) }}</label>
                                    <input type="url" name="social_media[{{ $platform }}]" value="{{ $socialMedia[$platform] ?? '' }}" class="border border-gray-300 rounded-lg p-2 w-full">
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="mt-6 flex justify-between items-center gap-4">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-5 rounded-xl shadow-md transition duration-200 w-full sm:w-auto">
                            Save Changes
                        </button>
                        <a href="{{ route('employer.profile.show') }}"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-5 rounded-xl shadow-md transition duration-200 w-full sm:w-auto">
                            Back to Profile
                        </a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>
