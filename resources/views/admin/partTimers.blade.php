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
                                    <a href="{{ route('admin.partTimer.view', ['id' => $partTimer->id]) }}" 
                                       class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition">
                                        View
                                    </a>
                                    <form action="{{ route('admin.partTimer.delete', $partTimer->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 transition">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</x-app-layout>
