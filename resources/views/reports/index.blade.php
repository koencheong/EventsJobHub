<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800">
            Manage Reports
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto bg-white p-6 rounded-lg shadow-lg">
            <h3 class="text-2xl font-semibold text-gray-800 mb-4">Reported Issues</h3>

            @if ($reports->isEmpty())
                <p class="text-gray-500 text-center py-4">No reports found.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full mt-4 border-collapse border border-gray-300 shadow-sm">
                        <thead>
                            <tr class="bg-gray-100 text-gray-700">
                                <th class="border border-gray-300 p-3 text-left">ID</th>
                                <th class="border border-gray-300 p-3 text-left">User</th>
                                <th class="border border-gray-300 p-3 text-left">Subject</th>
                                <th class="border border-gray-300 p-3 text-left">Message</th>
                                <th class="border border-gray-300 p-3 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reports as $report)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="border border-gray-300 p-3">{{ $report->id }}</td>
                                    <td class="border border-gray-300 p-3">{{ $report->user->name }}</td>
                                    <td class="border border-gray-300 p-3">{{ $report->subject }}</td>
                                    <td class="border border-gray-300 p-3">{{ Str::limit($report->message, 50) }}</td>
                                    <td class="border border-gray-300 p-3 text-center space-x-2">
                                        <!-- View Button -->
                                        <a href="{{ route('admin.reports.view', $report->id) }}" 
                                           class="inline-flex items-center justify-center px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition w-24">
                                            View
                                        </a>

                                        <!-- Delete Button (Opens Modal) -->
                                        <button onclick="openModal('deleteModal-{{ $report->id }}')" 
                                                class="inline-flex items-center justify-center px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition w-24">
                                            Delete
                                        </button>

                                        <!-- Delete Confirmation Modal -->
                                        <div id="deleteModal-{{ $report->id }}" 
                                             class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-black bg-opacity-50">
                                            <div class="bg-white rounded-xl shadow-lg w-full max-w-md p-6">
                                                <h3 class="text-xl font-bold text-gray-800 mb-4">Confirm Delete</h3>
                                                <p class="text-gray-600 mb-4">Are you sure you want to delete this report?</p>
                                                <form action="{{ route('admin.reports.delete', $report->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <div class="flex justify-end space-x-2">
                                                        <button type="button" onclick="closeModal('deleteModal-{{ $report->id }}')" 
                                                                class="inline-flex items-center justify-center px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition w-24">
                                                            Cancel
                                                        </button>
                                                        <button type="submit" 
                                                                class="inline-flex items-center justify-center px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition w-24">
                                                            Delete
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
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