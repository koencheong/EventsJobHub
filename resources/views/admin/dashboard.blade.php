<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800">
            Admin Dashboard
        </h2>
    </x-slot>

    <!-- Admin Overview Section -->
    <div class="py-6">
        <div class="max-w-7xl mx-auto bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-xl font-semibold">Overview</h3>
            <p class="text-gray-600 mt-2">Manage Employers, Part-Timers, and Job Listings.</p>
        </div>
    </div>

    <!-- Admin Management Sections -->
    <div class="py-6 grid grid-cols-1 md:grid-cols-3 gap-6 max-w-7xl mx-auto">
        <!-- Manage Employers -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-lg font-semibold">Employers</h3>
            <p class="text-gray-600 mt-2">View and manage all employers.</p>
            <a href="{{ route('admin.employers') }}" 
               class="mt-3 inline-block bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition">
                Manage Employers
            </a>
        </div>

        <!-- Manage Part-Timers -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-lg font-semibold">Part-Timers</h3>
            <p class="text-gray-600 mt-2">View and manage part-timer accounts.</p>
            <a href="{{ route('admin.partTimers') }}" 
               class="mt-3 inline-block bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition">
                Manage Part-Timers
            </a>
        </div>

        <!-- Manage Jobs -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-lg font-semibold">Jobs</h3>
            <p class="text-gray-600 mt-2">Approve or reject job postings.</p>
            <a href="{{ route('admin.jobs') }}" 
               class="mt-3 inline-block bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition">
                Manage Jobs
            </a>
        </div>
    </div>
</x-app-layout>
