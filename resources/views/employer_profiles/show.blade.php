<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-3xl text-gray-800 leading-tight">
            {{ __('Employer Profile') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl rounded-lg p-8">
                
                <!-- Company Logo -->
                @if ($profile->company_logo)
                    <div class="mb-6 text-center">
                        <img src="{{ asset('storage/' . $profile->company_logo) }}" class="w-32 h-32 mx-auto">
                    </div>
                @endif
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-700">Company Name</h3>
                        <p class="text-gray-600">{{ $profile->company_name }}</p>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-gray-700">Business Email</h3>
                        <p class="text-gray-600">{{ $profile->business_email ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-gray-700">Phone</h3>
                        <p class="text-gray-600">{{ $profile->phone ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-gray-700">Industry</h3>
                        <p class="text-gray-600">{{ $profile->industry ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-gray-700">Organization Type</h3>
                        <p class="text-gray-600">{{ $profile->organization_type ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-gray-700">Establishment Year</h3>
                        <p class="text-gray-600">{{ $profile->establishment_year ?? 'N/A' }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <h3 class="text-xl font-semibold text-gray-700">About</h3>
                        <p class="text-gray-600">{{ $profile->about ?? 'N/A' }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <h3 class="text-xl font-semibold text-gray-700">Vision</h3>
                        <p class="text-gray-600">{{ $profile->vision ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-gray-700">Company Location</h3>
                        <p class="text-gray-600">{{ $profile->company_location ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-gray-700">Team Size</h3>
                        <p class="text-gray-600">{{ $profile->team_size ?? 'N/A' }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <h3 class="text-xl font-semibold text-gray-700">Company Website</h3>
                        <p class="text-gray-600">
                            <a href="{{ $profile->company_website }}" class="text-blue-500 underline" target="_blank">
                                {{ $profile->company_website ?? 'N/A' }}
                            </a>
                        </p>
                    </div>
                    <div class="md:col-span-2">
                        <h3 class="text-xl font-semibold text-gray-700">Social Media</h3>
                        <p class="text-gray-600">
                            @php $socials = json_decode($profile->social_media, true); @endphp
                            @if ($socials && is_array($socials))
                                @foreach ($socials as $platform => $link)
                                    <a href="{{ $link }}" class="text-blue-500 underline" target="_blank">{{ ucfirst($platform) }}</a>
                                    <br>
                                @endforeach
                            @else
                                N/A
                            @endif
                        </p>
                    </div>
                </div>

                @if (Auth::check() && Auth::id() === $profile->user_id)
                    <div class="mt-8 text-center">
                        <a href="{{ route('employer.profile.edit', $profile->id) }}"
                           class="bg-blue-600 text-white px-6 py-3 rounded-lg">
                            Edit Profile
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
