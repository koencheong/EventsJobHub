<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-3xl text-gray-800 leading-tight">
            {{ __('My Job Applications') }}
        </h2>
    </x-slot>
    
    <div class="py-12 bg-gradient-to-r from-blue-100 via-indigo-200 to-purple-300">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl sm:rounded-lg p-8 rounded-xl overflow-hidden">
                @if (isset($applications) && $applications->isEmpty())
                    <p class="text-gray-600 text-lg font-medium">You have not applied for any jobs yet.</p>
                @elseif(isset($applications))
                    <table class="min-w-full border-collapse">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 border">Event</th>
                                <th class="py-2 px-4 border">Status</th>
                                <th class="py-2 px-4 border">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($applications as $application)
                                <tr>
                                    <td class="py-2 px-4 border">{{ $application->event->name ?? 'N/A' }}</td>
                                    <td class="py-2 px-4 border">{{ ucfirst($application->status) }}</td>
                                    <td class="py-2 px-4 border">
                                        <!-- Add buttons or links for actions -->
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-gray-600 text-lg font-medium">No data available.</p>
                @endif
            </div>
        </div>
    </div>
</div>

</x-app-layout>
