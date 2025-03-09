<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">{{ __('Manage Employers') }}</h2>
        </div>
    </x-slot>

    <div class="py-12 bg-blue-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-xl p-8 border border-gray-100">
                <!-- Employers List Section -->
                <div class="mb-10">
                    <h3 class="text-2xl font-semibold text-blue-700 mb-4">Employers List</h3>
                    @if ($employers->isEmpty())
                        <p class="text-gray-500 text-center">No registered employers.</p>
                    @else
                        <div class="overflow-x-auto rounded-xl shadow-sm border border-blue-200">
                            <table class="min-w-full bg-white">
                                <thead class="bg-blue-50 text-blue-800 uppercase text-xs font-semibold">
                                    <tr>
                                        <th class="py-3 px-6 text-left">Name</th>
                                        <th class="py-3 px-6 text-left">Email</th>
                                        <th class="py-3 px-6 text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-blue-100">
                                    @foreach ($employers as $employer)
                                        <tr class="hover:bg-blue-50 transition duration-150">
                                            <td class="py-4 px-6 text-gray-800">{{ $employer->name }}</td>
                                            <td class="py-4 px-6 text-gray-800">{{ $employer->email }}</td>
                                            <td class="py-4 px-6 text-center">
                                                <div class="flex justify-center space-x-2">
                                                    <!-- View Button -->
                                                    <a href="{{ route('admin.employer.view', ['id' => $employer->id]) }}" 
                                                       class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-md text-sm transition duration-200">
                                                        View
                                                    </a>
                                                    <!-- Delete Button -->
                                                    <button onclick="openModal('deleteModal-{{ $employer->id }}')" 
                                                            class="bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded-md text-sm transition duration-200">
                                                        Delete
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- Delete Confirmation Modal -->
                                        <div id="deleteModal-{{ $employer->id }}" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-black bg-opacity-50">
                                            <div class="bg-white rounded-xl shadow-lg w-full max-w-md">
                                                <div class="p-6">
                                                    <h3 class="text-xl font-bold text-gray-800 mb-4">Confirm Delete</h3>
                                                    <p class="text-gray-600 mb-4">Are you sure you want to delete <strong>{{ $employer->name }}</strong>?</p>
                                                    <div class="flex justify-end">
                                                        <button type="button" onclick="closeModal('deleteModal-{{ $employer->id }}')" 
                                                                class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition mr-2">
                                                            Cancel
                                                        </button>
                                                        <form action="{{ route('admin.employer.delete', $employer->id) }}" method="POST">
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
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for Modal functionality -->
    <script>
        // Open the modal
        function openModal(modalId) {
            document.getElementById(modalId).classList.remove('hidden');
        }

        // Close the modal
        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }
    </script>
</x-app-layout>