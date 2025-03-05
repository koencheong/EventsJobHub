<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800">
            Manage Reports
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <h3 class="text-xl font-semibold">Reported Issues</h3>

        <table class="w-full mt-4 border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border border-gray-300 p-2">ID</th>
                    <th class="border border-gray-300 p-2">User</th>
                    <th class="border border-gray-300 p-2">Subject</th>
                    <th class="border border-gray-300 p-2">Message</th>
                    <th class="border border-gray-300 p-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reports as $report)
                    <tr>
                        <td class="border border-gray-300 p-2">{{ $report->id }}</td>
                        <td class="border border-gray-300 p-2">{{ $report->user->name }}</td>
                        <td class="border border-gray-300 p-2">{{ $report->subject }}</td>
                        <td class="border border-gray-300 p-2">{{ Str::limit($report->message, 50) }}</td>
                        <td class="border border-gray-300 p-2">
                            <a href="{{ route('admin.reports.view', $report->id) }}" class="text-blue-600">View</a>
                            <form action="{{ route('admin.reports.delete', $report->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 ml-2">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
