<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800">
            Report Details
        </h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-2xl font-bold text-gray-800 mb-6">Report Information</h3>

            <div class="mb-6 space-y-2 text-gray-700">
                <p><strong>ID:</strong> {{ $report->id }}</p>
                <p><strong>User:</strong> {{ $report->user->name }}</p>
                <p><strong>Email:</strong> {{ $report->user->email }}</p>
                <p><strong>Subject:</strong> {{ $report->subject }}</p>
                <p><strong>Message:</strong> {{ $report->message }}</p>
                <p><strong>Submitted At:</strong> {{ $report->created_at->format('d M Y, h:i A') }}</p>
            </div>

            <div class="flex justify-between items-center mt-6">
            <!-- Back to Reports (Left) -->
            <a href="{{ route('admin.reports') }}" 
            class="w-40 px-4 py-3 bg-gray-500 text-white font-semibold rounded-lg shadow-md 
                    hover:bg-gray-600 transition duration-300 ease-in-out text-center">
                Back to Reports
            </a>

            
            <!-- Message Employer (Right) -->
            <!-- <a href="{{ url('/chatify/' . $report->user->id) }}" 
            class="w-40 px-4 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow-md 
                    hover:bg-blue-700 transition duration-300 ease-in-out text-center">
                Send a Message
            </a> -->

            <!-- Delete Report (Center) -->
            <button onclick="openModal('deleteReportModal')" 
                    class="w-40 px-4 py-3 bg-red-500 text-white font-semibold rounded-lg shadow-md 
                        hover:bg-red-600 transition duration-300 ease-in-out text-center">
                Delete Report
            </button>
        </div>

    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteReportModal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-black bg-opacity-50">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md">
            <div class="p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-4">Confirm Delete</h3>
                <p class="text-gray-600 mb-4">Are you sure you want to delete this report?</p>
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeModal('deleteReportModal')" 
                            class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition">
                        Cancel
                    </button>
                    <form action="{{ route('admin.reports.delete', $report->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 transition">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for Modal -->
    <script>
        function openModal(modalId) {
            document.getElementById(modalId).classList.remove('hidden');
        }
        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }
    </script>
</x-app-layout>
