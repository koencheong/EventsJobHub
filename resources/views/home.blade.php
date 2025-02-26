<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-3xl text-gray-800 leading-tight">
            {{ __('Home') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gradient-to-r from-blue-100 via-indigo-200 to-purple-300">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl sm:rounded-lg p-8 rounded-xl overflow-hidden">
                <h1 class="text-4xl font-extrabold text-gray-800 mb-4">Welcome to Events Job Hub</h1>
                <p class="text-lg text-gray-600 mb-6">Find the perfect part-time event jobs with ease and start earning today!</p>

                <!-- Show login/register prompt for guests -->
                @guest
                    <div class="p-4 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 rounded-lg mb-6">
                        <p class="text-lg font-semibold">Join us to apply for event jobs!</p>
                        <div class="mt-2">
                            <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-800 transition duration-300">Register</a> 
                            or 
                            <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800 transition duration-300">Login</a> 
                            to apply.
                        </div>
                    </div>
                @endguest

                <!-- Search Form -->
                <div class="mb-8">
                    <form method="GET" action="{{ route('home') }}" class="flex items-center space-x-4 bg-white rounded-lg shadow-md p-4">
                        <input type="text" name="search" class="w-full p-3 border border-gray-300 rounded-md text-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Search for events..." value="{{ request()->get('search') }}">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded transition duration-300 ease-in-out">
                            Search
                        </button>
                    </form>
                </div>

                <!-- Display events for part-timers -->
                <div>
                    <!-- Check if events are available -->
                    @if(isset($events) && $events->isEmpty())
                        <p class="text-gray-600 text-lg font-medium">No upcoming events at the moment. Check back later!</p>
                    @else
                        <!-- Use a grid layout to display events in 3 columns -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach ($events as $event)
                                <div class="bg-white shadow-lg rounded-lg p-6 hover:shadow-2xl transition duration-300 ease-in-out">
                                    <h3 class="text-xl font-semibold text-gray-800">{{ $event->name }}</h3>
                                    <p class="text-gray-600 mt-2">Job Type: {{ $event->job_type }}</p>
                                    <p class="text-gray-600 mt-2">Location: {{ $event->location }}</p>
                                    <p class="text-gray-600 mt-2">Date: {{ \Carbon\Carbon::parse($event->date)->format('F j, Y') }}</p>
                                    <p class="text-gray-600 mt-2">Payment Rate: RM {{ $event->payment_amount }}</p>


                                    <!-- Button to open modal with the event's ID -->
                                    <div class="mt-4">
                                        <button type="button" class="text-blue-600 hover:text-blue-800 transition duration-300" onclick="openModal({{ $event->id }})">
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

        // Function to apply for a job
        function applyForJob(eventId) {
        if (isPartTimer) {
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
                if (data.message === 'Application successful!') {
                    alert('You have successfully applied for this job!');
                    closeModal();
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            });
        } else {
            alert('You must be logged in as a part-timer to apply.');
        }
    }

    </script>
</x-app-layout>
