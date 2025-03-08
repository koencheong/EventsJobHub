<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800">
            Employer Details
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto bg-white p-8 rounded-xl shadow-lg">
            <h3 class="text-2xl font-bold text-gray-800 mb-6">Employer Information</h3>

            <div class="grid grid-cols-2 gap-6">
                <div class="text-gray-700">
                    <strong>Name:</strong> {{ $employer->name }}
                </div>
                <div class="text-gray-700">
                    <strong>Email:</strong> {{ $employer->employerProfile->business_email }}
                </div>
                <div class="text-gray-700">
                    <strong>Phone:</strong> {{ $employer->employerProfile->phone }}
                </div>
                <div class="text-gray-700">
                    <strong>Website:</strong> <a href="{{ $employer->employerProfile->company_website }}" target="_blank" class="text-blue-500">{{ $employer->website }}</a>
                </div>
                <div class="text-gray-700">
                    <strong>Location:</strong> {{ $employer->employerProfile->company_location }}
                </div>
                <div class="text-gray-700">
                    <strong>Industry:</strong> {{ $employer->employerProfile->industry }}
                </div>
            </div>

            <div class="mt-6">
                <a href="{{ route('admin.employers') }}" 
                   class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">
                    Back
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
