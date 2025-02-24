<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Home') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h1 class="text-3xl font-bold mb-4">Welcome to Events Job Hub</h1>
                <p class="text-lg mb-6">Find the perfect part-time event jobs with ease!</p>

                <!-- Show login/register prompt for guests -->
                @guest
                    <div class="p-4 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 rounded-lg mb-6">
                        <p class="text-lg font-semibold">Join us to apply for event jobs!</p>
                        <div class="mt-2">
                            <a href="{{ route('register') }}" class="text-blue-600 hover:underline">Register</a> 
                            or 
                            <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Login</a> 
                            to apply.
                        </div>
                    </div>
                @endguest

                <!-- Search Form -->
                <div class="mb-6">
                    <form method="GET" action="{{ route('home') }}" class="flex items-center space-x-4">
                        <input type="text" name="search" class="w-full p-3 border border-gray-300 rounded-md" placeholder="Search for events..." value="{{ request()->get('search') }}">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded">
                            Search
                        </button>
                    </form>
                </div>

                <!-- Display events for part-timers -->
                <div>
                    <!-- Check if events are available -->
                    @if($events->isEmpty())
                        <p class="text-gray-600">No upcoming events at the moment. Check back later!</p>
                    @else
                        <!-- Use a grid layout to display events in 3 columns -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach ($events as $event)
                                <div class="bg-white shadow-md rounded-lg p-6">
                                    <h3 class="text-xl font-semibold text-gray-800">{{ $event->name }}</h3>
                                    <p class="text-gray-600 mt-2">Job Type: {{ $event->job_type }}</p>
                                    <p class="text-gray-600 mt-2">Location: {{ $event->location }}</p>
                                    <p class="text-gray-600 mt-2">Date: {{ \Carbon\Carbon::parse($event->date)->format('F j, Y') }}</p>
                                    <p class="text-gray-600 mt-2">{{ $event->description }}</p>

                                    <!-- Apply button (you can later implement this functionality) -->
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
