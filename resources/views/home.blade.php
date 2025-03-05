<x-app-layout>
    <!-- Hero Section -->
    <div class="py-12 bg-gradient-to-r from-blue-100 via-indigo-200 to-purple-300 text-black py-16 text-center">
        <h1 class="text-5xl font-bold">Welcome to Events Job Hub</h1>
        <p class="text-lg mt-4 max-w-2xl mx-auto">Find the perfect part-time event jobs with ease and start earning today!</p>
        
        <!-- Search Form -->
        <div class="mt-6 max-w-lg mx-auto">
            <form method="GET" action="{{ route('home') }}" class="flex bg-white rounded-full shadow-lg p-2">
                <input type="text" name="search" class="w-full p-3 text-gray-800 border-none focus:ring-0 focus:outline-none rounded-l-full" placeholder="Search for events..." value="{{ request()->get('search') }}">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-r-full transition duration-300">
                    Search
                </button>
            </form>
        </div>
    </div>

    <!-- Main Content -->
    <div class="py-12 bg-gray-100">
        <div class="max-w-8xl mx-auto px-10">
            <div class="bg-gray-50 p-10 shadow-xl rounded-xl flex gap-10">
                <!-- Filtering Sidebar -->
                <div class="w-1/4 bg-white p-6 shadow-lg rounded-xl border border-gray-200">
                    <h3 class="text-xl font-bold mb-4">Filter Jobs</h3>
                    <form method="GET" action="{{ route('home') }}">
                        <!-- Job Type -->
                        <label class="block text-gray-700 font-semibold">Job Type</label>
                        <select name="job_type" class="w-full p-2 border rounded-lg mb-5">
                            <option value="">All</option>
                            <option value="Cashier">Cashier</option>
                            <option value="Promoter">Promoter</option>
                            <option value="Waiter/Waitress">Waiter/Waitress</option>
                            <option value="Event Crew">Event Crew</option>
                            <option value="Food Crew">Food Crew</option>
                            <option value="Sales Assistant">Sales Assistant</option>
                            <option value="Others">Others</option>
                        </select>
                        <!-- Payment Range -->
                        <label class="block text-gray-700 font-semibold">Payment Range (RM)</label>
                        <input type="number" name="min_payment" class="w-full p-2 border rounded-lg mb-2" placeholder="Min">
                        <input type="number" name="max_payment" class="w-full p-2 border rounded-lg mb-5" placeholder="Max">
                        <!-- Date Range Filter -->
                        <label class="block text-gray-700 font-semibold">Date Range</label>
                        <input type="date" name="start_date" class="w-full p-2 border rounded-lg mb-2">
                        <input type="date" name="end_date" class="w-full p-2 border rounded-lg mb-5">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg w-full">Apply Filters</button>
                    </form>
                </div>

                <!-- Event Listings -->
                <div class="w-3/4">
                    <h2 class="text-3xl font-bold text-gray-800 mb-8 text-center">Available Event Jobs</h2>
                    @if(isset($events) && $events->isEmpty())
                        <p class="text-center text-gray-600 text-lg">No upcoming events at the moment. Check back later!</p>
                    @else
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                            @foreach ($events as $event)
                                <div class="bg-white shadow-xl rounded-xl overflow-hidden transition transform hover:shadow-2xl hover:-translate-y-1 duration-300 p-6 h-full flex flex-col justify-between">
                                    @php
                                        $photos = is_string($event->job_photos) ? json_decode($event->job_photos, true) : [];
                                    @endphp

                                    @if (!empty($photos) && is_array($photos) && count($photos) > 0)
                                        <div x-data="{
                                                currentIndex: 0, 
                                                images: {{ Illuminate\Support\Js::from($photos) }}
                                            }" 
                                            class="relative w-full h-48 bg-gray-200 flex justify-center items-center overflow-hidden rounded-lg">

                                            <!-- Image Display -->
                                            <div class="relative w-full h-full">
                                                <template x-for="(photo, index) in images" :key="index">
                                                    <img x-show="currentIndex === index" 
                                                        :src="`{{ asset('storage') }}/${photo}`" 
                                                        alt="Event Photo" 
                                                        class="absolute inset-0 w-full h-full object-cover transition-opacity duration-500">
                                                </template>
                                            </div>

                                            <!-- Navigation Arrows (Hidden if Only One Photo) -->
                                            <button x-show="images.length > 1" 
                                                @click="currentIndex = (currentIndex > 0) ? currentIndex - 1 : images.length - 1"
                                                class="absolute left-2 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-2 rounded-full z-10">
                                                &#10094;
                                            </button>
                                            <button x-show="images.length > 1" 
                                                @click="currentIndex = (currentIndex < images.length - 1) ? currentIndex + 1 : 0"
                                                class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-2 rounded-full z-10">
                                                &#10095;
                                            </button>

                                            <!-- Pagination Dots -->
                                            <div x-show="images.length > 1" class="absolute bottom-2 left-1/2 transform -translate-x-1/2 flex space-x-1">
                                                <template x-for="(photo, index) in images" :key="index">
                                                    <div @click="currentIndex = index"
                                                        class="w-2.5 h-2.5 rounded-full cursor-pointer"
                                                        :class="currentIndex === index ? 'bg-white' : 'bg-gray-400 opacity-50'">
                                                    </div>
                                                </template>
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Event Details -->
                                    <div class="mt-4">
                                        <h3 class="text-xl font-semibold text-gray-800">{{ $event->name }}</h3>
                                        <p class="text-gray-600 mt-2"><strong>Job Type:</strong> {{ $event->job_type === 'Others' ? $event->other_job_type : $event->job_type }}</p>
                                        <p class="text-gray-600 mt-2"><strong>Location:</strong> {{ $event->location }}</p>
                                        <p class="text-gray-600 mt-2">
                                            <strong>Date:</strong>
                                            @if ($event->start_date == $event->end_date)
                                                {{ \Carbon\Carbon::parse($event->start_date)->format('F j, Y') }}
                                            @else
                                                {{ \Carbon\Carbon::parse($event->start_date)->format('F j, Y') }} - {{ \Carbon\Carbon::parse($event->end_date)->format('F j, Y') }}
                                            @endif
                                        </p>
                                        <p class="text-gray-600 mt-2"><strong>Payment:</strong> RM {{ $event->payment_amount }}</p>
                                    </div>

                                    <!-- Button (Sticks to Bottom) -->
                                    <div class="mt-4">
                                        <button class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition duration-300 w-full" onclick="openSidePanel({{ $event->id }})">
                                            View Details
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Side Panel (hidden by default) -->
    <div id="sidePanel" class="fixed inset-y-0 right-0 w-96 bg-white shadow-xl transform transition-transform duration-300 translate-x-full">
        <div class="p-6">
            <button type="button" class="absolute top-4 right-4 text-gray-500 hover:text-gray-800" onclick="closeSidePanel()">&times;</button>
            <h2 id="sidePanelTitle" class="text-2xl font-bold text-gray-800"></h2>
            <p id="sidePanelJobType" class="text-gray-600 mt-2"></p>
            <p id="sidePanelLocation" class="text-gray-600 mt-2"></p>
            <p id="sidePanelDate" class="text-gray-600 mt-2"></p>
            <p id="sidePanelPayment" class="text-gray-600 mt-2"></p>
            <p id="sidePanelDescription" class="text-gray-600 mt-4"></p>

            <!-- Side Panel buttons -->
            <div class="flex justify-between mt-6">
                <button type="button" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded" onclick="closeSidePanel()">Close</button>
                <button id="applyButton" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Apply</button>
            </div>
        </div>
    </div>

    <script>
        // Function to close the side panel
        function closeSidePanel() {
            document.getElementById('sidePanel').classList.add('translate-x-full');
        }

        @if (Auth::check())
        // Only access the user's role if authenticated
        var role = @json(Auth::user()->role).trim().toLowerCase();

        // Check if the user is a part-timer
        var isPartTimer = (role === 'part-timer');
        @else
            var isPartTimer = false;  // If not authenticated, set isPartTimer to false
        @endif
        
        let currentEventId = null;

        // Function to open the side panel and load event data
        function openSidePanel(eventId) {
            const eventsArray = @json($events).data; // Fix: Access 'data' array
            const eventData = eventsArray.find(event => event.id === eventId);

            if (eventData) {
                document.getElementById('sidePanelTitle').innerText = eventData.name;
                document.getElementById('sidePanelJobType').innerText = "Job Type: " + eventData.job_type;
                document.getElementById('sidePanelLocation').innerText = "Location: " + eventData.location;
                document.getElementById('sidePanelDate').innerText = "Date: " + eventData.start_date;
                document.getElementById('sidePanelPayment').innerText = "Payment Rate: RM " + eventData.payment_amount;
                document.getElementById('sidePanelDescription').innerText = eventData.description;
                document.getElementById('sidePanel').classList.remove('translate-x-full');

                // Set the apply button event
                document.getElementById('applyButton').onclick = function() {
                    applyForJob(eventId);
                };
            } else {
                console.error("Event not found:", eventId);
            }
        }

        // Function to apply for a job with confirmation
        function applyForJob(eventId) {
            if (!isPartTimer) {
                alert('You must be logged in as a part-timer to apply.');
                return;
            }

            // Check if the user has already applied
            fetch(`/check-application/${eventId}`, {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.alreadyApplied) {
                    alert('You have already applied for this job.');
                } else {
                    // Confirm before applying
                    if (confirm('Are you sure you want to apply for this job?')) {
                        submitApplication(eventId);
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while checking your application status.');
            });
        }

        // Function to submit the application
        function submitApplication(eventId) {
            fetch(`/apply/${eventId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ event_id: eventId })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`Server Error: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                alert(data.message);
                closeSidePanel();
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            });
        }
    </script>
    
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let today = new Date().toISOString().split('T')[0];
            document.querySelector('input[name="start_date"]').setAttribute("min", today);
            document.querySelector('input[name="end_date"]').setAttribute("min", today);
        });
    </script>
</x-app-layout>