<x-app-layout>
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
                        <label class="block text-gray-700 font-semibold">Job Type</label>
                        <select name="job_type" class="w-full p-2 border rounded-lg mb-5">
                            <option value="">All</option>
                            <option value="Cashier">Cashier</option>
                            <option value="Promoter">Promoter</option>
                        </select>
                        <label class="block text-gray-700 font-semibold">Payment Range (RM)</label>
                        <input type="number" name="min_payment" class="w-full p-2 border rounded-lg mb-2" placeholder="Min">
                        <input type="number" name="max_payment" class="w-full p-2 border rounded-lg mb-5" placeholder="Max">
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
                                <div class="bg-white shadow-xl rounded-xl overflow-hidden transition transform hover:shadow-2xl hover:-translate-y-1 duration-300 p-6">
                                    <h3 class="text-xl font-semibold text-gray-800">{{ $event->name }}</h3>
                                    <p class="text-gray-600 mt-2"><strong>Job Type:</strong> {{ $event->job_type }}</p>
                                    <p class="text-gray-600 mt-2"><strong>Location:</strong> {{ $event->location }}</p>
                                    <p class="text-gray-600 mt-2"><strong>Date:</strong> {{ \Carbon\Carbon::parse($event->date)->format('F j, Y') }}</p>
                                    <p class="text-gray-600 mt-2"><strong>Payment:</strong> RM {{ $event->payment_amount }}</p>
                                    <div class="mt-4">
                                        <button class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition duration-300" onclick="openModal({{ $event->id }})">
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

    <!-- Modal structure (hidden by default) -->
    <div id="eventModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center hidden">
        <div class="bg-white p-8 rounded-lg shadow-lg max-w-2xl w-full">
            <button type="button" class="absolute top-4 right-4 text-gray-500 hover:text-gray-800" onclick="closeModal()">&times;</button>
            <h2 id="eventModalTitle" class="text-2xl font-bold text-gray-800"></h2>
            <p id="eventModalJobType" class="text-gray-600 mt-2"></p>
            <p id="eventModalLocation" class="text-gray-600 mt-2"></p>
            <p id="eventModalDate" class="text-gray-600 mt-2"></p>
            <p id="eventModalDescription" class="text-gray-600 mt-4"></p>
            <p id="eventModalPayment" class="text-gray-600 mt-2"></p>

            <!-- Modal buttons -->
            <div class="flex justify-between mt-6">
                <button type="button" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded" onclick="closeModal()">Close</button>
                <button id="applyButton" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Apply</button>
            </div>
        </div>
    </div>

    <script>
        // Function to close the modal
        function closeModal() {
            document.getElementById('eventModal').classList.add('hidden');
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

        // Function to open the modal and load event data
        function openModal(eventId) {
            const eventData = @json($events).find(event => event.id === eventId);
            currentEventId = eventId; // Store the current event ID for applying

            if (eventData) {
                document.getElementById('eventModalTitle').innerText = eventData.name;
                document.getElementById('eventModalJobType').innerText = "Job Type: " + eventData.job_type;
                document.getElementById('eventModalLocation').innerText = "Location: " + eventData.location;
                document.getElementById('eventModalDate').innerText = "Date: " + new Date(eventData.date).toLocaleDateString();
                document.getElementById('eventModalDescription').innerText = eventData.description;
                document.getElementById('eventModalPayment').innerText = "Payment Rate: RM " + eventData.payment_amount + " per hour";
                document.getElementById('eventModal').classList.remove('hidden');

                // Set the apply button event
                document.getElementById('applyButton').onclick = function() {
                    applyForJob(currentEventId);
                };
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
                closeModal();
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            });
        }


    </script>
</x-app-layout>
