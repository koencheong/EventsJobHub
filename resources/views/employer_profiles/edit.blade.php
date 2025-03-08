<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">{{ __('Edit Employer Profile') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl rounded-2xl p-8 border border-gray-100">
                <form action="{{ route('employer.profile.update', $profile->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')

                    <!-- Company Logo -->
                    <div class="mb-6">
                        <label class="block text-black-600 font-semibold mb-2">Company Logo</label>
                        <input type="file" name="company_logo" class="border border-gray-300 rounded-lg p-2 w-full">
                    </div>

                    <!-- Company Name -->
                    <div class="mb-6">
                        <label class="block text-black-600 font-semibold mb-2">Company Name</label>
                        <input type="text" name="company_name" value="{{ $profile->company_name }}" class="border border-gray-300 rounded-lg p-2 w-full" required>
                    </div>

                    <!-- Industry -->
                    <div class="mb-6">
                        <label class="block text-black-600 font-semibold mb-2">Industry</label>
                        <input type="text" name="industry" value="{{ $profile->industry }}" class="border border-gray-300 rounded-lg p-2 w-full">
                    </div>

                    <!-- Organization Type -->
                    <div class="mb-6">
                        <label class="block text-black-600 font-semibold mb-2">Organization Type</label>
                        <input type="text" name="organization_type" value="{{ $profile->organization_type }}" class="border border-gray-300 rounded-lg p-2 w-full">
                    </div>

                    <!-- About -->
                    <div class="mb-6">
                        <label class="block text-black-600 font-semibold mb-2">About</label>
                        <textarea name="about" class="border border-gray-300 rounded-lg p-2 w-full" rows="4">{{ $profile->about }}</textarea>
                    </div>

                    <!-- Vision -->
                    <div class="mb-6">
                        <label class="block text-black-600 font-semibold mb-2">Vision</label>
                        <textarea name="vision" class="border border-gray-300 rounded-lg p-2 w-full" rows="4">{{ $profile->vision }}</textarea>
                    </div>

                    <!-- Company Details -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <div>
                            <label class="block text-black-600 font-semibold mb-2">Team Size</label>
                            <input type="number" name="team_size" value="{{ $profile->team_size }}" class="border border-gray-300 rounded-lg p-2 w-full">
                        </div>
                        <div>
                            <label class="block text-black-600 font-semibold mb-2">Phone</label>
                            <input type="text" name="phone" value="{{ $profile->phone }}" class="border border-gray-300 rounded-lg p-2 w-full">
                        </div>
                        <div>
                            <label class="block text-black-600 font-semibold mb-2">Business Email</label>
                            <input type="email" name="business_email" value="{{ $profile->business_email }}" class="border border-gray-300 rounded-lg p-2 w-full">
                        </div>
                    </div>

                    <!-- Website & Location -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-black-600 font-semibold mb-2">Company Website</label>
                            <input type="url" name="company_website" value="{{ $profile->company_website }}" class="border border-gray-300 rounded-lg p-2 w-full">
                        </div>
                        <div>
                            <label class="block text-black-600 font-semibold mb-2">Company Location</label>
                            <input type="text" name="company_location" value="{{ $profile->company_location }}" class="border border-gray-300 rounded-lg p-2 w-full">
                        </div>
                    </div>

                    <!-- Social Media Links -->
                    @php $socialMedia = json_decode($profile->social_media, true) ?? []; @endphp
                    <div class="mb-6">
                        <label class="block text-black-600 font-semibold mb-2">Social Media Links</label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach (['facebook', 'twitter', 'linkedin', 'instagram'] as $platform)
                                <div>
                                    <label class="block text-black-600 font-semibold capitalize">{{ ucfirst($platform) }}</label>
                                    <input type="url" name="social_media[{{ $platform }}]" value="{{ $socialMedia[$platform] ?? '' }}" class="border border-gray-300 rounded-lg p-2 w-full">
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="mt-6">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-5 rounded-xl shadow-md transition duration-200">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>