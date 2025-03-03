<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Events List') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8">
                <h3 class="text-2xl font-semibold text-gray-800 mb-6">All Events</h3>

                <!-- Display success message if any -->
                @if(session('success'))
                    <div class="bg-green-200 text-green-800 p-4 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Table of events -->
                <table class="min-w-full bg-white border border-gray-300">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b">Event Name</th>
                            <th class="py-2 px-4 border-b">Job Type</th>
                            <th class="py-2 px-4 border-b">Location</th>
                            <th class="py-2 px-4 border-b">Date</th>
                            <th class="py-2 px-4 border-b">Payment Amount</th>
                            <th class="py-2 px-4 border-b">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($events as $event)
                            <tr>
                                <td class="py-2 px-4 border-b">{{ $event->name }}</td>
                                <td class="py-2 px-4 border-b">
                                    {{ $event->job_type === 'Others' ? $event->other_job_type : $event->job_type }}
                                </td>
                                <td class="py-2 px-4 border-b">{{ $event->location }}</td>
                                <td class="py-2 px-4 border-b">
                                    @if ($event->start_date == $event->end_date)
                                        {{ \Carbon\Carbon::parse($event->start_date)->format('F j, Y') }}
                                    @else
                                        {{ \Carbon\Carbon::parse($event->start_date)->format('F j, Y') }} - {{ \Carbon\Carbon::parse($event->end_date)->format('F j, Y') }}
                                    @endif
                                </td>
                                <td class="py-2 px-4 border-b">RM {{ $event->payment_amount }}</td>
                                <td class="py-2 px-4 border-b">
                                    <a href="{{ route('events.edit', $event) }}" class="text-blue-600 hover:text-blue-800">Edit</a>
                                    <form action="{{ route('events.destroy', $event) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Button to create new event -->
                <div class="mt-6">
                    <a href="{{ route('events.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Post New Job
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>