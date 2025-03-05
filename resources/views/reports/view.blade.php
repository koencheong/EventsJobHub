<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800">
            Report Details
        </h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <h3 class="text-xl font-semibold mb-4">Report Information</h3>

        <div class="mb-4">
            <p><strong>ID:</strong> {{ $report->id }}</p>
            <p><strong>User:</strong> {{ $report->user->name }}</p>
            <p><strong>Subject:</strong> {{ $report->subject }}</p>
            <p><strong>Message:</strong> {{ $report->message }}</p>
            <p><strong>Submitted At:</strong> {{ $report->created_at->format('d M Y, h:i A') }}</p>
        </div>

        <div class="flex space-x-4">
            <a href="{{ route('admin.reports') }}" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition">
                Back to Reports
            </a>

            <form action="{{ route('admin.reports.delete', $report->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 transition">
                    Delete Report
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
