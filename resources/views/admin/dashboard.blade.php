<x-app-layout>
    <!-- Hero Section (Overview) -->
    <div class="relative py-20 bg-gradient-to-r from-blue-700 to-indigo-800 text-center">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-5xl font-bold text-white mb-6">Welcome to the Admin Dashboard</h1>
            <p class="text-xl text-blue-100 max-w-2xl mx-auto">
                Streamline your workflow and manage employers, part-timers, jobs, and reports with ease.
            </p>
        </div>
    </div>

    <!-- Admin Management Sections -->
    <div class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Manage Employers -->
                <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-shadow duration-300 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-center w-16 h-16 bg-blue-50 rounded-full mb-6">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-4">Employers</h3>
                        <p class="text-gray-600">View and manage all employers in the system.</p>
                    </div>
                    <a href="{{ route('admin.employers') }}" 
                       class="mt-8 inline-block w-full text-center bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition duration-300">
                        Manage Employers
                    </a>
                </div>

                <!-- Manage Part-Timers -->
                <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-shadow duration-300 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-center w-16 h-16 bg-blue-50 rounded-full mb-6">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-4">Part-Timers</h3>
                        <p class="text-gray-600">View and manage part-timer accounts.</p>
                    </div>
                    <a href="{{ route('admin.partTimers') }}" 
                       class="mt-8 inline-block w-full text-center bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition duration-300">
                        Manage Part-Timers
                    </a>
                </div>

                <!-- Manage Jobs -->
                <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-shadow duration-300 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-center w-16 h-16 bg-blue-50 rounded-full mb-6">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-4">Jobs</h3>
                        <p class="text-gray-600">Approve or reject job postings.</p>
                    </div>
                    <a href="{{ route('admin.jobs') }}" 
                       class="mt-8 inline-block w-full text-center bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition duration-300">
                        Manage Jobs
                    </a>
                </div>

                <!-- Manage Reports -->
                <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-shadow duration-300 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-center w-16 h-16 bg-blue-50 rounded-full mb-6">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-4">Reports</h3>
                        <p class="text-gray-600">View and manage reported issues.</p>
                    </div>
                    <a href="{{ route('admin.reports') }}" 
                       class="mt-8 inline-block w-full text-center bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition duration-300">
                        Manage Reports
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>