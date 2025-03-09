<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800"> {{ __('Employer Profile') }} </h2>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-r from-blue-50 via-purple-50 to-pink-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl rounded-2xl p-8 border border-gray-100">
                <!-- Profile Header -->
                <div class="flex items-center justify-between space-x-6 mb-12 border-b border-gray-200 pb-6">
                    <div class="flex items-center space-x-6">
                        <img class="w-20 h-20 rounded-full object-cover" 
                             src="{{ Auth::user()->profile_photo_url }}" 
                             alt="{{ Auth::user()->name }}" />

                        <!-- Company Name and Basic Info -->
                        <div>
                            <h1 class="text-4xl font-bold text-gray-800">{{ $profile->company_name }}</h1>
                            <p class="text-gray-600 mt-2 text-lg">{{ $profile->industry }}</p>
                        </div>
                    </div>
                    <!-- View Ratings Button -->
                    <a href="{{ route('ratings.show', ['userId' => $profile->user_id]) }}" 
                       class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-5 rounded-xl shadow-md transition duration-200">
                        View Ratings
                    </a>
                </div>

                <!-- Company Details -->
                <div class="mb-12">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Company Details</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Phone -->
                        <div class="p-6 bg-gray-50 rounded-lg shadow-sm hover:shadow-md transition-shadow">
                            <div class="flex items-center space-x-4">
                                <div class="text-2xl text-blue-600">
                                    <i class="bi bi-telephone"></i> <!-- Bootstrap Phone Icon -->
                                </div>
                                <div>
                                    <h4 class="text-gray-700 font-semibold">Phone</h4>
                                    <p class="text-gray-900 text-lg">{{ $profile->phone ?? 'Not specified' }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Business Email -->
                        <div class="p-6 bg-gray-50 rounded-lg shadow-sm hover:shadow-md transition-shadow">
                            <div class="flex items-center space-x-4">
                                <div class="text-2xl text-purple-600">
                                    <i class="bi bi-envelope"></i> <!-- Bootstrap Email Icon -->
                                </div>
                                <div>
                                    <h4 class="text-gray-700 font-semibold">Business Email</h4>
                                    <p class="text-gray-900 text-lg">{{ $profile->business_email ?? 'Not specified' }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Company Website -->
                        <div class="p-6 bg-gray-50 rounded-lg shadow-sm hover:shadow-md transition-shadow">
                            <div class="flex items-center space-x-4">
                                <div class="text-2xl text-green-600">
                                    <i class="bi bi-globe"></i> <!-- Bootstrap Website Icon -->
                                </div>
                                <div>
                                    <h4 class="text-gray-700 font-semibold">Website</h4>
                                    <p class="text-gray-900 text-lg">
                                        @if ($profile->company_website)
                                            <a href="{{ $profile->company_website }}" class="text-blue-600 hover:text-blue-700 transition duration-200" target="_blank">{{ $profile->company_website }}</a>
                                        @else
                                            Not specified
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Social Media Links (Optional) -->
                @if (!empty($profile->social_media))
                <div class="mb-12">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Social Media</h2>
                    <div class="p-6 bg-gray-50 rounded-xl shadow-md border border-gray-200 hover:shadow-xl transition-shadow duration-200">
                        @php
                            $socialMediaLinks = json_decode($profile->social_media, true);
                        @endphp
                        <div class="space-y-4">
                            @if (!empty($socialMediaLinks['facebook']))
                                <div class="flex items-center gap-4">
                                    <i class="bi bi-facebook text-3xl text-blue-600"></i> <!-- Facebook Logo -->
                                    <a href="{{ $socialMediaLinks['facebook'] }}" target="_blank" class="text-blue-600 hover:text-blue-700 transition duration-200">
                                        {{ $socialMediaLinks['facebook'] }}
                                    </a>
                                </div>
                            @endif
                            @if (!empty($socialMediaLinks['instagram']))
                                <div class="flex items-center gap-4">
                                    <i class="bi bi-instagram text-3xl text-pink-600"></i> <!-- Instagram Logo -->
                                    <a href="{{ $socialMediaLinks['instagram'] }}" target="_blank" class="text-pink-600 hover:text-pink-700 transition duration-200">
                                        {{ $socialMediaLinks['instagram'] }}
                                    </a>
                                </div>
                            @endif
                            @if (!empty($socialMediaLinks['linkedin']))
                                <div class="flex items-center gap-4">
                                    <i class="bi bi-linkedin text-3xl text-blue-500"></i> <!-- LinkedIn Logo -->
                                    <a href="{{ $socialMediaLinks['linkedin'] }}" target="_blank" class="text-blue-500 hover:text-blue-600 transition duration-200">
                                        {{ $socialMediaLinks['linkedin'] }}
                                    </a>
                                </div>
                            @endif
                            @if (!empty($socialMediaLinks['twitter']))
                                <div class="flex items-center gap-4">
                                    <i class="bi bi-twitter text-3xl text-blue-400"></i> <!-- Twitter Logo -->
                                    <a href="{{ $socialMediaLinks['twitter'] }}" target="_blank" class="text-blue-400 hover:text-blue-500 transition duration-200">
                                        {{ $socialMediaLinks['twitter'] }}
                                    </a>
                                </div>
                            @endif
                            @if (!empty($socialMediaLinks['youtube']))
                                <div class="flex items-center gap-4">
                                    <i class="bi bi-youtube text-3xl text-red-600"></i> <!-- YouTube Logo -->
                                    <a href="{{ $socialMediaLinks['youtube'] }}" target="_blank" class="text-red-600 hover:text-red-700 transition duration-200">
                                        {{ $socialMediaLinks['youtube'] }}
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endif

                <!-- Company Location with Google Maps -->
                <div class="mb-12">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Company Location</h2>
                    <div class="bg-white shadow-md rounded-xl p-6 border border-gray-200">
                        @if (!empty($profile->company_location))
                            <div class="flex items-center gap-4 mb-6">
                                <i class="bi bi-geo-alt text-3xl text-blue-600"></i> <!-- Location Icon -->
                                <p class="text-gray-900 text-lg">{{ $profile->company_location }}</p>
                            </div>
                            <!-- Google Maps Container -->
                            <div id="map" style="height: 300px; width: 100%; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);"></div>
                            <p id="map-error" class="text-red-500 mt-2" style="display: none;">Unable to load the map. Please check the address.</p>
                        @else
                            <p class="text-gray-600">No location specified.</p>
                        @endif
                    </div>
                </div>

				@php
					$previousUrl = url()->previous();
					$ratingsUrl = route('ratings.show', ['userId' => $profile->user_id]);
					
					// If coming from the ratings page, set a fallback to employer list
					if ($previousUrl === $ratingsUrl) {
						$previousUrl = route('part-timers.dashboard');
					}
				@endphp		
				<div class="mt-6 text-center">
					<a href="{{ $previousUrl }}"
					class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-5 rounded-xl shadow-md transition duration-200 w-full sm:w-auto">
						Back
					</a>
            	</div>
            </div>
        </div>
    </div>

    <!-- Include Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">

    <!-- Google Maps Script -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAS6LJUe32nG4zgJ8_FDo78Zd3w4Df8o80&callback=initMap" async defer></script>
    <script>
        let map;

        // Initialize and display the map
        function initMap() {
            const location = "{{ $profile->company_location }}"; // Get the company location from the profile
            const geocoder = new google.maps.Geocoder();

            geocoder.geocode({ address: location }, (results, status) => {
                if (status === "OK") {
                    // Hide the error message
                    document.getElementById("map-error").style.display = "none";

                    // Initialize the map
                    map = new google.maps.Map(document.getElementById("map"), {
                        zoom: 15,
                        center: results[0].geometry.location,
                    });

                    // Add a marker for the company location
                    new google.maps.Marker({
                        map: map,
                        position: results[0].geometry.location,
                        title: location,
                    });
                } else {
                    console.error("Geocode was not successful for the following reason: " + status);
                    // Show the error message
                    document.getElementById("map-error").style.display = "block";
                }
            });
        }
    </script>
</x-app-layout>