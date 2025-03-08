<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">{{ __('Employer Profile') }}</h2>
            @if (Auth::check() && Auth::id() === $profile->user_id)
            <a href="{{ route('employer.profile.edit') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-5 rounded-xl shadow-md transition duration-200">
                Edit Profile
            </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl rounded-2xl p-8 border border-gray-100">
                <!-- Profile Header -->
                <div class="flex items-center space-x-6 mb-12 border-b border-gray-200 pb-6">
                    <!-- Company Logo -->
                    @if ($profile->company_logo)
                        <div class="w-28 h-28 overflow-hidden rounded-full shadow-lg border-2 border-gray-200">
                            <img src="{{ asset('storage/' . $profile->company_logo) }}"
                                 alt="{{ $profile->company_name }} Logo"
                                 class="w-full h-full object-cover">
                        </div>
                    @else
                        <div class="w-28 h-28 overflow-hidden rounded-full shadow-lg bg-blue-50 flex items-center justify-center border-2 border-gray-200">
                            <span class="text-black-500 text-xl font-semibold">No Logo</span>
                        </div>
                    @endif

                    <!-- Company Name and Basic Info -->
                    <div>
                        <h1 class="text-4xl font-bold text-black-800">{{ $profile->company_name }}</h1>
                        <p class="text-black-600 mt-2 text-lg">{{ $profile->industry }} - {{ $profile->organization_type }}</p>
                        <p class="text-gray-500 text-sm mt-1">Established: {{ $profile->establishment_year ?? 'Not specified' }}</p>
                    </div>
                </div>

                <!-- About Section -->
                <div class="mb-12">
                    <h2 class="text-2xl font-semibold text-black-700 mb-4">About</h2>
                    <p class="text-gray-700 leading-relaxed">{{ $profile->about ?? 'No about information provided.' }}</p>
                </div>

                <!-- Vision Section -->
                <div class="mb-12">
                    <h2 class="text-2xl font-semibold text-black-700 mb-4">Vision</h2>
                    <p class="text-gray-700 leading-relaxed">{{ $profile->vision ?? 'No vision statement provided.' }}</p>
                </div>

                <!-- Company Details -->
                <div class="mb-12">
                    <h2 class="text-2xl font-semibold text-black-700 mb-6">Company Details</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Team Size -->
                        <div class="p-6 bg-white rounded-xl shadow-md border border-gray-100 hover:shadow-lg transition-shadow duration-200">
                            <h3 class="text-lg font-semibold text-black-600">Team Size</h3>
                            <p class="text-gray-800 mt-2">{{ $profile->team_size ?? 'Not specified' }}</p>
                        </div>
                        <!-- Phone -->
                        <div class="p-6 bg-white rounded-xl shadow-md border border-gray-100 hover:shadow-lg transition-shadow duration-200">
                            <h3 class="text-lg font-semibold text-black-600">Phone</h3>
                            <p class="text-gray-800 mt-2">{{ $profile->phone ?? 'Not specified' }}</p>
                        </div>
                        <!-- Business Email -->
                        <div class="p-6 bg-white rounded-xl shadow-md border border-gray-100 hover:shadow-lg transition-shadow duration-200">
                            <h3 class="text-lg font-semibold text-black-600">Business Email</h3>
                            <p class="text-gray-800 mt-2">{{ $profile->business_email ?? 'Not specified' }}</p>
                        </div>
                        <!-- Company Website -->
                        <div class="p-6 bg-white rounded-xl shadow-md border border-gray-100 hover:shadow-lg transition-shadow duration-200">
                            <h3 class="text-lg font-semibold text-black-600">Website</h3>
                            <p class="text-gray-800 mt-2">
                                @if ($profile->company_website)
                                    <a href="{{ $profile->company_website }}" class="text-black-600 hover:text-black-800 transition duration-200" target="_blank">{{ $profile->company_website }}</a>
                                @else
                                    Not specified
                                @endif
                            </p>
                        </div>
                        <!-- Company Location -->
                        <div class="p-6 bg-white rounded-xl shadow-md border border-gray-100 hover:shadow-lg transition-shadow duration-200">
                            <h3 class="text-lg font-semibold text-black-600">Location</h3>
                            <p class="text-gray-800 mt-2">{{ $profile->company_location ?? 'Not specified' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Social Media Links -->
                <div class="mb-12">
                    <h2 class="text-2xl font-semibold text-black-700 mb-6">Social Media</h2>
                    <div class="p-6 bg-white rounded-xl shadow-md border border-gray-100 hover:shadow-lg transition-shadow duration-200">
                        @php
                            $socialMedia = json_decode($profile->social_media, true) ?? [];
                            $hasSocialMedia = !empty(array_filter($socialMedia));
                        @endphp
                        @if ($hasSocialMedia)
                            @foreach ($socialMedia as $platform => $link)
                                @if (!empty($link))
                                    <div class="flex items-center gap-4 mb-4">
                                        <span class="text-black-600 font-semibold capitalize w-24">{{ $platform }}</span>
                                        <a href="{{ $link }}" class="text-black-600 hover:text-black-800 transition duration-200" target="_blank">{{ $link }}</a>
                                    </div>
                                @endif
                            @endforeach
                        @else
                            <p class="text-gray-700">No social media links provided.</p>
                        @endif
                    </div>
                </div>

                <!-- Google Maps Section -->
                <div class="mb-12">
                    <h2 class="text-2xl font-semibold text-black-700 mb-6">Company Location</h2>
                    <div class="bg-white shadow-md rounded-xl p-6 border border-gray-100">
                        <div id="map" class="w-full h-80 rounded-lg"></div>
                        <p id="map-error" class="text-red-500 mt-2 hidden">Unable to load the map. Please check the address.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Google Maps Script -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAS6LJUe32nG4zgJ8_FDo78Zd3w4Df8o80&callback=initMap" async defer></script>
    <script>
        function initMap() {
            const companyLocation = "{{ $profile->company_location }}";
            const geocoder = new google.maps.Geocoder();
            geocoder.geocode({ address: companyLocation }, (results, status) => {
                if (status === "OK") {
                    const map = new google.maps.Map(document.getElementById("map"), {
                        zoom: 15,
                        center: results[0].geometry.location,
                        styles: [
                            { featureType: "all", elementType: "all", stylers: [{ hue: "#3B82F6" }] }, // Blue tint
                            { featureType: "road", elementType: "geometry", stylers: [{ lightness: 30 }] }
                        ]
                    });
                    new google.maps.Marker({
                        map: map,
                        position: results[0].geometry.location,
                        title: "{{ $profile->company_name }}",
                        icon: {
                            url: "http://maps.google.com/mapfiles/ms/icons/blue-dot.png" // Blue marker
                        }
                    });
                } else {
                    console.error("Geocode failed: " + status);
                    document.getElementById("map-error").classList.remove('hidden');
                }
            });
        }
    </script>
</x-app-layout>