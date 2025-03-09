<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">{{ __('Employer Details') }}</h2>
        </div>
    </x-slot>

    <div class="py-12 bg-blue-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl rounded-2xl p-8 border border-gray-100">
                <!-- Employer Information Header -->
                <div class="flex items-center justify-between space-x-6 mb-12 border-b border-gray-200 pb-6">
                    <div class="flex items-center space-x-6">
                        <!-- Employer Avatar (Optional) -->
                        <div class="w-20 h-20 rounded-full bg-blue-100 flex items-center justify-center">
                            <span class="text-2xl font-bold text-blue-600">{{ substr($profile->company_name, 0, 1) }}</span>
                        </div>
                        <!-- Employer Name and Industry -->
                        <div>
                            <h1 class="text-4xl font-bold text-gray-800">{{ $profile->company_name }}</h1>
                            <p class="text-gray-600 mt-2 text-lg">{{ $profile->industry }}</p>
                        </div>
                    </div>
                    <!-- View Ratings Button -->
                    <a href="{{ route('ratings.show', ['userId' => $profile->id]) }}" 
                       class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-5 rounded-xl shadow-md transition duration-200">
                        View Ratings
                    </a>
                </div>

                <!-- Employer Details -->
                <div class="mb-12">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Employer Information</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Name -->
                        <div class="p-6 bg-gray-50 rounded-lg shadow-sm hover:shadow-md transition-shadow">
                            <div class="flex items-center space-x-4">
                                <div class="text-2xl text-blue-600">
                                    <i class="bi bi-person"></i> <!-- Bootstrap Person Icon -->
                                </div>
                                <div>
                                    <h4 class="text-gray-700 font-semibold">Name</h4>
                                    <p class="text-gray-900 text-lg">{{ $profile->company_name }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="p-6 bg-gray-50 rounded-lg shadow-sm hover:shadow-md transition-shadow">
                            <div class="flex items-center space-x-4">
                                <div class="text-2xl text-purple-600">
                                    <i class="bi bi-envelope"></i> <!-- Bootstrap Email Icon -->
                                </div>
                                <div>
                                    <h4 class="text-gray-700 font-semibold">Email</h4>
                                    <p class="text-gray-900 text-lg">{{ $profile->business_email }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Phone -->
                        <div class="p-6 bg-gray-50 rounded-lg shadow-sm hover:shadow-md transition-shadow">
                            <div class="flex items-center space-x-4">
                                <div class="text-2xl text-green-600">
                                    <i class="bi bi-telephone"></i> <!-- Bootstrap Phone Icon -->
                                </div>
                                <div>
                                    <h4 class="text-gray-700 font-semibold">Phone</h4>
                                    <p class="text-gray-900 text-lg">{{ $profile->phone }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Website -->
                        <div class="p-6 bg-gray-50 rounded-lg shadow-sm hover:shadow-md transition-shadow">
                            <div class="flex items-center space-x-4">
                                <div class="text-2xl text-blue-600">
                                    <i class="bi bi-globe"></i> <!-- Bootstrap Website Icon -->
                                </div>
                                <div>
                                    <h4 class="text-gray-700 font-semibold">Website</h4>
                                    <p class="text-gray-900 text-lg">
                                        <a href="{{ $profile->company_website }}" 
                                           class="text-blue-600 hover:text-blue-700 transition duration-200" 
                                           target="_blank">{{ $profile->company_website }}</a>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Location -->
                        <div class="p-6 bg-gray-50 rounded-lg shadow-sm hover:shadow-md transition-shadow">
                            <div class="flex items-center space-x-4">
                                <div class="text-2xl text-purple-600">
                                    <i class="bi bi-geo-alt"></i> <!-- Bootstrap Location Icon -->
                                </div>
                                <div>
                                    <h4 class="text-gray-700 font-semibold">Location</h4>
                                    <p class="text-gray-900 text-lg">{{ $profile->company_location }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Industry -->
                        <div class="p-6 bg-gray-50 rounded-lg shadow-sm hover:shadow-md transition-shadow">
                            <div class="flex items-center space-x-4">
                                <div class="text-2xl text-green-600">
                                    <i class="bi bi-briefcase"></i> <!-- Bootstrap Briefcase Icon -->
                                </div>
                                <div>
                                    <h4 class="text-gray-700 font-semibold">Industry</h4>
                                    <p class="text-gray-900 text-lg">{{ $profile->industry }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

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

                <!-- Back Button -->
                <div class="mt-6 text-center">
                    <a href="{{ route('admin.employers') }}" 
                    class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-5 rounded-xl shadow-md transition duration-200">
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