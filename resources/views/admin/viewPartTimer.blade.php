<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800">
            Part Timer Details
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto bg-white p-8 rounded-xl shadow-lg">
            <h3 class="text-2xl font-bold text-gray-800 mb-6">Part Timer Information</h3>
            <div class="grid grid-cols-2 gap-6">
                <div class="text-gray-700">
                    <strong>Name:</strong> {{ $partTimer->name }}
                </div>
                <div class="text-gray-700">
                    <strong>Phone:</strong> {{ $partTimer->partTimerProfile->phone }}
                </div>
                <div class="text-gray-700">
                    <strong>Location:</strong> {{  $partTimer->partTimerProfile->location }}
                </div>
                <div class="text-gray-700">
                    <strong>Bio:</strong> {{  $partTimer->partTimerProfile->bio }}
                </div>
                <div class="text-gray-700">
                    <strong>Work Experience:</strong> {{  $partTimer->partTimerProfile->work_experience }}
                </div>
            </div>

            <div class="mt-6">
                <a href="{{ route('admin.partTimers') }}" 
                   class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">
                    Back
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
