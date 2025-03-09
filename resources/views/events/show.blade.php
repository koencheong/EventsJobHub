<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800"> {{ __('Event Details') }} </h2>
        </div>
    </x-slot>

    <div class="py-12 bg-blue-50 min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <!-- Event Details Card -->
            <div class="bg-white shadow-xl rounded-lg p-8">
                <!-- Event Name -->
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-3xl font-bold text-gray-900">{{ $event->name }}</h1>

                    <!-- View Employer Button -->
                    <a href="{{ route('part-timers.viewEmployer', ['userId' => $event->company_id]) }}" 
                    class="px-6 py-3 bg-purple-500 text-white font-semibold rounded-lg shadow-md 
                            hover:bg-purple-600 transition duration-300 ease-in-out inline-block">
                        View Employer
                    </a>
                </div>


                <!-- Event Details Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <!-- Job Type -->
                    <div class="p-6 bg-gray-100 rounded-lg shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex items-center space-x-4">
                            <div class="text-2xl text-indigo-600">
                                <i class="bi bi-briefcase"></i> <!-- Bootstrap Job Type Icon -->
                            </div>
                            <div>
                                <p class="text-gray-600 font-semibold">Job Type</p>
                                <p class="text-gray-900 text-lg">
                                    {{ $event->job_type === 'Others' ? $event->other_job_type : $event->job_type }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Location -->
                    <div class="p-6 bg-gray-100 rounded-lg shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex items-center space-x-4">
                            <div class="text-2xl text-blue-600">
                                <i class="bi bi-geo-alt"></i> <!-- Bootstrap Location Icon -->
                            </div>
                            <div>
                                <p class="text-gray-600 font-semibold">Location</p>
                                <p class="text-gray-900 text-lg">{{ $event->location }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Date -->
                    <div class="p-6 bg-gray-100 rounded-lg shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex items-center space-x-4">
                            <div class="text-2xl text-purple-600">
                                <i class="bi bi-calendar-event"></i> <!-- Bootstrap Date Icon -->
                            </div>
                            <div>
                                <p class="text-gray-600 font-semibold">Date</p>
                                <p class="text-gray-900 text-lg">
                                    @if ($event->start_date == $event->end_date)
                                        {{ \Carbon\Carbon::parse($event->start_date)->format('F j, Y') }}
                                    @else
                                        {{ \Carbon\Carbon::parse($event->start_date)->format('F j, Y') }} - 
                                        {{ \Carbon\Carbon::parse($event->end_date)->format('F j, Y') }}
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Time -->
                    <div class="p-6 bg-gray-100 rounded-lg shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex items-center space-x-4">
                            <div class="text-2xl text-pink-600">
                                <i class="bi bi-clock"></i> <!-- Bootstrap Time Icon -->
                            </div>
                            <div>
                                <p class="text-gray-600 font-semibold">Time</p>
                                <p class="text-gray-900 text-lg">
                                    {{ \Carbon\Carbon::parse($event->start_time)->format('g:i A') }} - 
                                    {{ \Carbon\Carbon::parse($event->end_time)->format('g:i A') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Payment -->
                    <div class="p-6 bg-gray-100 rounded-lg shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex items-center space-x-4">
                            <div class="text-2xl text-green-600">
                                <i class="bi bi-currency-dollar"></i> <!-- Bootstrap Payment Icon -->
                            </div>
                            <div>
                                <p class="text-gray-600 font-semibold">Payment</p>
                                <p class="text-gray-900 text-lg">RM {{ $event->payment_amount }} / Day</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div class="mt-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Description</h3>
                    <p class="text-gray-700 leading-relaxed">{{ $event->description }}</p>
                </div>

                <!-- Job Photos (If Available) -->
                <div class="mt-8">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Job Photos</h3>
                    
                    @php
                        $photos = is_array($event->job_photos) ? $event->job_photos : json_decode($event->job_photos, true);
                    @endphp

                    @if (!empty($photos) && is_array($photos) && count($photos) > 0)
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            @foreach ($photos as $photo)
                                <div class="relative overflow-hidden rounded-lg shadow-md hover:shadow-lg transition-shadow">
                                    <img src="{{ asset('storage/' . $photo) }}" alt="Job Photo" class="w-full h-48 object-cover">
                                    <div class="absolute inset-0 bg-black bg-opacity-0 hover:bg-opacity-20 transition"></div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-600 italic">No job photos available.</p>
                    @endif
                </div>

                <!-- Google Maps Section -->
                <div class="mt-8">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Event Location on Map</h3>
                    <div id="map" class="w-full h-96 rounded-lg shadow-md overflow-hidden"></div>
                    <p id="map-error" class="text-red-500 mt-2" style="display: none;">Unable to load the map. Please check the address.</p>
                </div>

            <!-- Buttons: Back on Left, Message on Right -->
            <div class="mt-8 flex justify-between">
                @if (auth()->check())
                    @if (auth()->user()->role === 'part-timer')
                        <a href="{{ route('part-timers.dashboard') }}" 
                        class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow-md 
                                hover:bg-blue-700 transition duration-300 ease-in-out inline-block">
                            Back to Dashboard
                        </a>

                        <!-- Message Employer Button -->
                        <a href="{{ url('/chatify/' . $event->company_id) }}" 
                        class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow-md 
                                hover:bg-blue-700 transition duration-300 ease-in-out inline-block">
                            ✉️ Send a Message
                        </a>
                    @elseif (auth()->user()->role === 'admin')
                        <a href="{{ route('admin.jobs') }}" 
                        class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow-md 
                                hover:bg-blue-700 transition duration-300 ease-in-out inline-block">
                            Back
                        </a>
                        <!-- Message Employer Button -->
                        <a href="{{ url('/chatify/' . $event->company_id) }}" 
                        class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow-md 
                                hover:bg-blue-700 transition duration-300 ease-in-out inline-block">
                            ✉️ Send a Message
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}" 
                        class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow-md 
                                hover:bg-blue-700 transition duration-300 ease-in-out inline-block">
                            Back
                        </a>
                    @endif
                @endif
            </div>
        </div>
    </div>

    <!-- Google Maps Script -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAS6LJUe32nG4zgJ8_FDo78Zd3w4Df8o80"></script>
    <script>
        let map;

        // Initialize and display the map
        function initMap(location) {
            const geocoder = new google.maps.Geocoder();
            geocoder.geocode({ address: location }, (results, status) => {
                if (status === "OK") {
                    // Hide the error message
                    document.getElementById("map-error").style.display = "none";

                    // Initialize the map
                    const map = new google.maps.Map(document.getElementById("map"), {
                        zoom: 15,
                        center: results[0].geometry.location,
                    });

                    // Add a marker for the event location
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

        // Load the map after the Google Maps script is loaded
        window.addEventListener('load', () => {
            const eventLocation = "{{ $event->location }}"; // Get the event location from the backend
            initMap(eventLocation); // Initialize the map with the event location
        });
    </script>

    <!-- Include Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
</x-app-layout>