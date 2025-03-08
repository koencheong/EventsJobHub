<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800">
            Manage Part-Timers
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-xl font-semibold mb-4">Part-Timers List</h3>

            @if ($partTimers->isEmpty())
                <p class="text-gray-500">No registered part-timers.</p>
            @else
                <table class="w-full border-collapse border border-gray-300 text-left">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border p-3">Name</th>
                            <th class="border p-3">Email</th>
                            <th class="border p-3 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($partTimers as $partTimer)
                            <tr class="hover:bg-gray-50">
                                <td class="border p-3">{{ $partTimer->name }}</td>
                                <td class="border p-3">{{ $partTimer->email }}</td>
                                <td class="border p-3 text-center">
                                    <div class="flex justify-center space-x-2">
                                        <!-- View Button -->
                                        <a href="{{ route('admin.partTimer.view', ['id' => $partTimer->id]) }}" 
                                           class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition shadow min-w-[90px]">
                                            View
                                        </a>

                                        <!-- Delete Button (Opens Modal) -->
                                        <button onclick="openModal('deleteModal-{{ $partTimer->id }}')" 
                                                class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition shadow min-w-[90px]">
                                            Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <!-- Delete Confirmation Modal -->
                            <div id="deleteModal-{{ $partTimer->id }}" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-black bg-opacity-50">
                                <div class="bg-white rounded-xl shadow-lg w-full max-w-md">
                                    <div class="p-6">
                                        <h3 class="text-xl font-bold text-gray-800 mb-4">Confirm Delete</h3>
                                        <p class="text-gray-600 mb-4">Are you sure you want to delete <strong>{{ $partTimer->name }}</strong>?</p>
                                        <div class="flex justify-end">
                                            <button type="button" onclick="closeModal('deleteModal-{{ $partTimer->id }}')" 
                                                    class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition mr-2">
                                                Cancel
                                            </button>
                                            <form action="{{ route('admin.partTimer.delete', $partTimer->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        @endforeach
                    </tbody>
                </table>
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
