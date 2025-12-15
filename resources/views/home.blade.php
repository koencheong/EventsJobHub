<x-app-layout>
    <!-- Hero Section with Rotating Background Images -->
    <div class="relative py-16 bg-gradient-to-r from-blue-100 via-indigo-200 to-purple-300 text-center">
        <!-- Background Images -->
        <div class="absolute inset-0 z-0">
            <div id="hero-carousel" class="relative w-full h-full">
                <div class="absolute inset-0 transition-opacity duration-1000 ease-in-out opacity-100" data-carousel-item>
                    <img src="{{ asset('images/img1.jpg') }}" alt="Event 2" class="w-full h-full object-cover">
                </div>
                <div class="absolute inset-0 transition-opacity duration-1000 ease-in-out opacity-0" data-carousel-item>
                    <img src="{{ asset('images/img2.jpg') }}" alt="Event 3" class="w-full h-full object-cover">
                </div>
                <div class="absolute inset-0 transition-opacity duration-1000 ease-in-out opacity-0" data-carousel-item>
                    <img src="{{ asset('images/img3.jpg') }}" alt="Event 3" class="w-full h-full object-cover">
                </div>
            </div>
            <div class="absolute inset-0 bg-black bg-opacity-50"></div>
        </div>

        <!-- Hero Content -->
        <div class="relative text-white px-4">
            <h1 class="text-5xl font-bold mb-6">Welcome to Event Jobs Hub</h1>
            <p class="text-lg max-w-2xl mx-auto mb-8">Find the perfect part-time event jobs with ease and start earning today!</p>
            <!-- Search Form -->
            <div class="flex bg-white rounded-full shadow-lg p-2 max-w-lg mx-auto">
                <input type="text" id="search-input" class="w-full p-3 text-gray-800 border-none focus:ring-0 focus:outline-none rounded-l-full" placeholder="Search for events...">
                <button type="button" id="clear-search" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-r-full transition duration-300">
                    Clear
                </button>
            </div>
        </div>

        <!-- Carousel Navigation Buttons -->
        <!-- <button id="prev-button" class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-3 rounded-full z-20 hover:bg-opacity-70 transition duration-300">
            &#10094;
        </button>
        <button id="next-button" class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-3 rounded-full z-20 hover:bg-opacity-70 transition duration-300">
            &#10095;
        </button>-->
    </div>

    <!-- Main Content -->
    <div class="py-12 bg-gray-100">
        <div class="max-w-8xl mx-auto px-10">
            <div class="bg-gray-50 p-10 shadow-xl rounded-xl flex gap-10">
                <!-- Filtering Sidebar -->
                <div class="w-1/4 bg-white p-6 shadow-lg rounded-xl border border-gray-200">
                    <h3 class="text-xl font-bold mb-4">Filter Jobs</h3>
                    <div>
                        <!-- Job Type -->
                        <label class="block text-gray-700 font-semibold">Job Type</label>
                        <select id="job-type-filter" class="w-full p-2 border rounded-lg mb-5">
                            <option value="">All</option>
                            <option value="Cashier">Cashier</option>
                            <option value="Promoter">Promoter</option>
                            <option value="Model">Model</option>
                            <option value="Waiter/Waitress">Waiter/Waitress</option>
                            <option value="Event Crew">Event Crew</option>
                            <option value="Food Crew">Food Crew</option>
                            <option value="Sales Assistant">Sales Assistant</option>
                            <option value="Others">Others</option>
                        </select>
                        <!-- Payment Range -->
                        <label class="block text-gray-700 font-semibold">Payment Range (RM)</label>
                        <input type="number" id="min-payment" class="w-full p-2 border rounded-lg mb-2" placeholder="Min">
                        <input type="number" id="max-payment" class="w-full p-2 border rounded-lg mb-5" placeholder="Max">
                        <!-- Date Range Filter -->
                        <label class="block text-gray-700 font-semibold">Date Range</label>
                        <input type="date" id="start-date" class="w-full p-2 border rounded-lg mb-2">
                        <input type="date" id="end-date" class="w-full p-2 border rounded-lg mb-5">
                        <button type="button" id="clear-filters" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg w-full mb-2">
                            Clear Filters
                        </button>
                    </div>
                </div>

                <!-- Event Listings -->
                <div class="w-3/4">
                    <h2 class="text-3xl font-bold text-gray-800 mb-8 text-center">Available Event Jobs</h2>

                    @if ($events->isEmpty())
                        <p class="text-center text-gray-500 text-lg">No event jobs available at the moment. Please check back later!</p>
                    @else
                    <div id="event-listings" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach ($events as $event)
                            <div class="event-card bg-white shadow-xl rounded-xl overflow-hidden transition transform hover:shadow-2xl hover:-translate-y-1 duration-300 p-6 h-full flex flex-col justify-between" 
                                data-name="{{ $event->name }}" 
                                data-job-type="{{ $event->job_type === 'Others' ? $event->other_job_type : $event->job_type }}" 
                                data-payment="{{ $event->payment_amount }}" 
                                data-start-date="{{ $event->start_date }}" 
                                data-end-date="{{ $event->end_date }}"
                                data-start-time="{{ $event->start_time }}"
                                data-end-time="{{ $event->end_time }}"
                                data-location="{{ $event->location}}">
                                
                                @php
                                    $photos = !empty($event->job_photos) ? json_decode($event->job_photos, true) : [];
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
                                @else
                                    <!-- Default Placeholder Image -->
                                    <img src="{{ asset('images/default-placeholder.png') }}" 
                                        alt="Default Placeholder" 
                                        class="w-full h-48 object-cover">
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
                                    <p class="text-gray-600 mt-2">
                                        <strong>Time:</strong>
                                        {{ \Carbon\Carbon::parse($event->start_time)->format('g:i A') }} - {{ \Carbon\Carbon::parse($event->end_time)->format('g:i A') }}
                                    <p class="text-gray-600 mt-2"><strong>Payment:</strong> RM {{ $event->payment_amount }}</p>
                                </div>

                                <!-- Button (Sticks to Bottom) -->
                                <div class="mt-4">
                                    <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-300 w-full" onclick="openSidePanel({{ $event->id }})">
                                        View Details
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Side Panel (hidden by default) -->
    <div id="sidePanel" class="fixed inset-y-0 right-0 w-[40rem] bg-white shadow-xl transform transition-transform duration-300 translate-x-full overflow-y-auto">
        <div class="p-7">
            <button type="button" class="absolute top-4 right-4 text-gray-500 hover:text-gray-800" onclick="closeSidePanel()">&times;</button>
            
            <h2 id="sidePanelTitle" class="text-2xl font-bold text-gray-800"></h2>
            <p id="sidePanelJobType" class="text-gray-600 mt-2"></p>
            <p id="sidePanelLocation" class="text-gray-600 mt-2">
                <i class="bi bi-geo-alt text-blue-600 mr-2"></i> <strong>Location:</strong> <span id="locationText"></span>
            </p>
            <p id="sidePanelDate" class="text-gray-600 mt-2">
                <i class="bi bi-calendar-event text-purple-600 mr-2"></i> <strong>Date:</strong> <span id="dateText"></span>
            </p>
            <p id="sidePanelTime" class="text-gray-600 mt-2">
                <i class="bi bi-clock text-yellow-600 mr-2"></i> 
                <strong>Time:</strong> <span id="startTimeText"></span> - <span id="endTimeText"></span>
            </p>
            <p id="sidePanelPayment" class="text-gray-600 mt-2">
                <i class="bi bi-currency-dollar text-green-600 mr-2"></i> <strong>Payment Rate:</strong> <span id="paymentText"></span>
            </p>

            <p id="sidePanelDescription" class="text-gray-600 mt-4"></p>    
            <!-- View Employer Button  -->
            <div class="flex justify-end mt-4">
                <a href="{{ route('part-timers.viewEmployer', ['userId' => $event->company_id]) }}" 
                    class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow-md 
                            hover:bg-blue-700 transition duration-300 ease-in-out inline-block whitespace-nowrap">
                    View Employer
                </a>
            </div>  

            <!-- Google Maps Section -->
            <div class="mt-6">
                <h3 class="text-xl font-bold text-gray-800">Event Location on Map</h3>
                <div id="map" style="height: 300px; width: 100%; margin-top: 20px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);"></div>
                <p id="map-error" class="text-red-500 mt-2" style="display: none;">Unable to load the map. Please check the address.</p>
            </div>

            <!-- Side Panel buttons -->
            <div class="flex justify-between mt-6">
                <button type="button" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded" onclick="closeSidePanel()">Close</button>
                <button id="applyButton" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Apply</button>
            </div>
        </div>
    </div>

    <!-- Custom Modal for Confirmation -->
    <div id="confirmationModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full flex flex-col items-center text-center">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Confirm Application</h3>
            <p class="text-gray-600 mb-6">Are you sure you want to apply for this job?</p>
            <div class="flex justify-center gap-4">
                <button id="cancelButton" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded">Cancel</button>
                <button id="confirmButton" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-6 rounded">Confirm</button>
            </div>
        </div>
    </div>

    <!-- Custom Modal for Success -->
    <div id="successModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full flex flex-col items-center text-center">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Application Successful!</h3>
            <p class="text-gray-600 mb-6">Your application has been submitted successfully.</p>
            <div class="flex justify-center">
                <button id="closeSuccessButton" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-6 rounded">Close</button>
            </div>
        </div>
    </div>

    <!-- Custom Modal for Already Applied -->
    <div id="alreadyAppliedModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full flex flex-col items-center text-center">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Already Applied</h3>
            <p class="text-gray-600 mb-6">You have already applied for this job.</p>
            <div class="flex justify-center">
                <button id="closeAlreadyAppliedButton" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-6 rounded">Close</button>
            </div>
        </div>
    </div>

    <!-- Custom Modal for Not a Part-Timer -->
    <div id="notPartTimerModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full flex flex-col items-center text-center">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Not a Part-Timer</h3>
            <p class="text-gray-600 mb-6">You must be logged in as a part-timer to apply for this job.</p>
            <div class="flex justify-center">
                <button id="closeNotPartTimerButton" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-6 rounded">Close</button>
            </div>
        </div>
    </div>

    <!-- JavaScript for Hero Carousel -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const slides = document.querySelectorAll('[data-carousel-item]');
            let currentIndex = 0;

            function changeSlide() {
                slides[currentIndex].classList.remove('opacity-100');
                slides[currentIndex].classList.add('opacity-0');

                currentIndex = (currentIndex + 1) % slides.length;

                slides[currentIndex].classList.remove('opacity-0');
                slides[currentIndex].classList.add('opacity-100');
            }

            setInterval(changeSlide, 4000); // Change image every 4 seconds
        });
    </script>
    
    <!-- JavaScript for Frontend Filtering -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
        const eventCards = document.querySelectorAll('.event-card');
        const searchInput = document.getElementById('search-input');
        const jobTypeFilter = document.getElementById('job-type-filter');
        const minPayment = document.getElementById('min-payment');
        const maxPayment = document.getElementById('max-payment');
        const startDate = document.getElementById('start-date');
        const endDate = document.getElementById('end-date');

        // Define the clear buttons
        const clearSearchButton = document.getElementById('clear-search');  // Add your button ID
        const clearFiltersButton = document.getElementById('clear-filters');  // Add your button ID

        // Function to filter events
        function filterEvents() {
            const searchTerm = searchInput.value.toLowerCase();  // Search term in lowercase
            const selectedJobType = jobTypeFilter.value;  // Job type filter (no toLowerCase())
            const minPaymentValue = parseFloat(minPayment.value) || 0;
            const maxPaymentValue = parseFloat(maxPayment.value) || Infinity;
            const startDateValue = startDate.value;
            const endDateValue = endDate.value;

            eventCards.forEach(card => {
                const name = card.getAttribute('data-name').toLowerCase();  // Event name in lowercase for search comparison
                const jobType = card.getAttribute('data-job-type');  // Job type (no toLowerCase() for filter)
                const payment = parseFloat(card.getAttribute('data-payment'));
                const eventStartDate = card.getAttribute('data-start-date');
                const eventEndDate = card.getAttribute('data-end-date');
                const location = card.getAttribute('data-location').toLowerCase();

                // Check if the event name or job type match the search term
                const matchesSearch = name.includes(searchTerm) || location.includes(searchTerm);  // Check both name and location
                const matchesJobType = selectedJobType === '' || jobType === selectedJobType;  // Filter by selected job type
                const matchesPayment = payment >= minPaymentValue && payment <= maxPaymentValue;
                const matchesDate = (!startDateValue || eventStartDate >= startDateValue) && 
                                    (!endDateValue || eventEndDate <= endDateValue);

                // Show or hide the event card based on the filters
                if (matchesSearch && matchesJobType && matchesPayment && matchesDate) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        // Function to clear search input
        function clearSearch() {
            searchInput.value = '';
            filterEvents(); // Reapply filters after clearing search
        }

        // Function to clear all filters
        function clearFilters() {
            jobTypeFilter.value = '';
            minPayment.value = '';
            maxPayment.value = '';
            startDate.value = '';
            endDate.value = '';
            filterEvents(); // Reapply filters after clearing
        }

        // Add event listeners
        searchInput.addEventListener('input', filterEvents);
        clearSearchButton.addEventListener('click', clearSearch);
        jobTypeFilter.addEventListener('change', filterEvents);
        minPayment.addEventListener('input', filterEvents);
        maxPayment.addEventListener('input', filterEvents);
        startDate.addEventListener('change', filterEvents);
        endDate.addEventListener('change', filterEvents);
        clearFiltersButton.addEventListener('click', clearFilters);
    });


    </script>

    <!-- JavaScript for Custom Modals and Application Logic -->
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

                 // Convert start_time and end_time to AM/PM format
                let startTime = formatTime(eventData.start_time);
                let endTime = formatTime(eventData.end_time);
                document.getElementById('sidePanelTime').innerText = "Time: " + startTime + " - " + endTime;
        
                document.getElementById('sidePanelPayment').innerText = "Payment Rate: RM " + eventData.payment_amount;
                document.getElementById('sidePanelDescription').innerText = eventData.description;
                document.getElementById('sidePanel').classList.remove('translate-x-full');

                // Initialize the map
                initMap(eventData.location);

                // Set the apply button event
                document.getElementById('applyButton').onclick = function() {
                    showConfirmationModal(eventId);
                };
            } else {
                console.error("Event not found:", eventId);
            }
        }

        function formatTime(timeString) {
            if (!timeString) return "N/A"; // Handle empty values

            let time = new Date("1970-01-01T" + timeString); // Convert to Date object
            let hours = time.getHours();
            let minutes = time.getMinutes();
            
            let ampm = hours >= 12 ? "PM" : "AM";
            hours = hours % 12 || 12; // Convert 24h to 12h format
            minutes = minutes.toString().padStart(2, "0"); // Ensure two-digit minutes

            return `${hours}:${minutes} ${ampm}`;
        }

        // Function to show the custom confirmation modal
        function showConfirmationModal(eventId) {
            if (!isPartTimer) {
                // Show the "not a part-timer" modal
                const notPartTimerModal = document.getElementById('notPartTimerModal');
                notPartTimerModal.classList.remove('hidden');

                // Close the modal when the close button is clicked
                document.getElementById('closeNotPartTimerButton').onclick = function() {
                    notPartTimerModal.classList.add('hidden');
                };
                return;
            }

            // Show the confirmation modal
            const modal = document.getElementById('confirmationModal');
            modal.classList.remove('hidden');

            // Set up the confirm button
            document.getElementById('confirmButton').onclick = function() {
                applyForJob(eventId);
                modal.classList.add('hidden');
            };

            // Set up the cancel button
            document.getElementById('cancelButton').onclick = function() {
                modal.classList.add('hidden');
            };
        }

        // Function to apply for a job
        function applyForJob(eventId) {
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
                    // Show the "already applied" modal
                    const alreadyAppliedModal = document.getElementById('alreadyAppliedModal');
                    alreadyAppliedModal.classList.remove('hidden');

                    // Close the modal when the close button is clicked
                    document.getElementById('closeAlreadyAppliedButton').onclick = function() {
                        alreadyAppliedModal.classList.add('hidden');
                    };
                } else {
                    submitApplication(eventId);
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
                // Show the success modal
                const successModal = document.getElementById('successModal');
                successModal.classList.remove('hidden');

                // Close the success modal when the close button is clicked
                document.getElementById('closeSuccessButton').onclick = function() {
                    successModal.classList.add('hidden');
                    closeSidePanel();
                };
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            });
        }
    </script>

    <!-- Google Maps Script -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCDjjO4wOmqmu5iS5MWFoaG-ZFZZGiWr88&callback=initMap" async defer></script>
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
    </script>
</x-app-layout>