<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-3xl text-gray-800 leading-tight">
            {{ __('Event Details') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gradient-to-r from-blue-100 via-indigo-200 to-purple-300 min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl rounded-lg p-8">
                
                <!-- Event Name -->
                <h1 class="text-2xl font-bold text-gray-900">{{ $event->name }}</h1>

                <!-- Job Type -->
                <p class="text-gray-700 mt-2"><strong>Job Type:</strong> 
                    {{ $event->job_type === 'Others' ? $event->other_job_type : $event->job_type }}
                </p>

                <!-- Location -->
                <p class="text-gray-700 mt-2"><strong>Location:</strong> {{ $event->location }}</p>

                <!-- Date -->
                <p class="text-gray-700 mt-2">
                    <strong>Date:</strong> 
                    @if ($event->start_date == $event->end_date)
                        {{ \Carbon\Carbon::parse($event->start_date)->format('F j, Y') }}
                    @else
                        {{ \Carbon\Carbon::parse($event->start_date)->format('F j, Y') }} - {{ \Carbon\Carbon::parse($event->end_date)->format('F j, Y') }}
                    @endif
                </p>

                <!-- Payment -->
                <p class="text-gray-700 mt-2"><strong>Payment:</strong> RM {{ $event->payment_amount }} / Day</p>

                <!-- Description -->
                <p class="text-gray-800 mt-4">{{ $event->description }}</p>

                <!-- Job Photos (If Available) -->
                <div class="mt-6">
                    <h3 class="text-lg font-semibold">Job Photos</h3>
                    
                    @php
                        $photos = is_array($event->job_photos) ? $event->job_photos : json_decode($event->job_photos, true);
                    @endphp

                    @if (!empty($photos) && is_array($photos) && count($photos) > 0)
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mt-2">
                            @foreach ($photos as $photo)
                                <img src="{{ asset('storage/' . $photo) }}" alt="Job Photo" class="rounded-lg shadow-md w-full">
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-600 mt-2 italic">No job photos available.</p>
                    @endif
                </div>

                <!-- Google Maps Section -->
                <div class="mt-6">
                    <h3 class="text-lg font-semibold">Event Location on Map</h3>
                    <div id="map" style="height: 300px; width: 100%; margin-top: 10px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);"></div>
                    <p id="map-error" class="text-red-500 mt-2" style="display: none;">Unable to load the map. Please check the address.</p>
                </div>

                <!-- Back Button -->
                <div class="mt-8">
                    @if (auth()->user()->role === 'part-timer')
                        <a href="{{ route('part-timers.dashboard') }}" 
                        class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow-md 
                                hover:bg-blue-700 transition duration-300 ease-in-out inline-block">
                            Back to Dashboard
                        </a>
                    @elseif (auth()->user()->role === 'admin')
                        <a href="{{ route('admin.jobs') }}" 
                        class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow-md 
                                hover:bg-blue-700 transition duration-300 ease-in-out inline-block">
                            Back
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}" 
                        class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow-md 
                                hover:bg-blue-700 transition duration-300 ease-in-out inline-block">
                            Back
                        </a>
                    @endif
                </div>
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
</x-app-layout>