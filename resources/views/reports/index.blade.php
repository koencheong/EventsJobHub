<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">{{ __('Manage Reports') }}</h2>
        </div>
    </x-slot>

    <div class="py-12 bg-blue-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-xl p-8 border border-gray-100">
                <!-- Reported Issues Section -->
                <h3 class="text-2xl font-semibold text-blue-700 mb-6">Reported Issues</h3>

                @if ($reports->isEmpty())
                    <p class="text-gray-500 text-center py-4">No reports found.</p>
                @else
                    <div class="overflow-x-auto rounded-xl shadow-sm border border-blue-200">
                        <table class="min-w-full bg-white">
                            <thead class="bg-blue-50 text-blue-800 uppercase text-xs font-semibold">
                                <tr>
                                    <th class="py-3 px-6 text-left">ID</th>
                                    <th class="py-3 px-6 text-left">User</th>
                                    <th class="py-3 px-6 text-left">Subject</th>
                                    <th class="py-3 px-6 text-left">Message</th>
                                    <th class="py-3 px-6 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-blue-100">
                                @foreach($reports as $report)
                                    <tr class="hover:bg-blue-50 transition duration-150">
                                        <td class="py-4 px-6 text-gray-800">{{ $report->id }}</td>
                                        <td class="py-4 px-6 text-gray-800">{{ $report->user->name }}</td>
                                        <td class="py-4 px-6 text-gray-800">{{ $report->subject }}</td>
                                        <td class="py-4 px-6 text-gray-800">{{ Str::limit($report->message, 50) }}</td>
                                        <td class="py-4 px-6 text-center space-x-2">
                                            <!-- View Button -->
                                            <a href="{{ route('admin.reports.view', $report->id) }}" 
                                               class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded-md text-sm transition duration-200">
                                                View
                                            </a>

                                            <!-- Delete Button (Opens Modal) -->
                                            <button onclick="openModal('deleteModal-{{ $report->id }}')" 
                                                    class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-md text-sm transition duration-200">
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
                                                                    class="bg-gray-500 hover:bg-gray-600 text-white px-3 py-1 rounded-md text-sm transition duration-200">
                                                                Cancel
                                                            </button>
                                                            <button type="submit" 
                                                                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-md text-sm transition duration-200">
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