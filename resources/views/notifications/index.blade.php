<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Notifications</h2>
    </x-slot>

    <div class="max-w-4xl mx-auto py-6">
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-semibold mb-4">Unread Notifications</h3>
            
            @if(auth()->user()->unreadNotifications->isEmpty())
                <p class="text-gray-500">No new notifications.</p>
            @else
                <ul>
                    @foreach (auth()->user()->unreadNotifications as $notification)
                        <li class="mb-2 p-3 border rounded flex justify-between items-center">
                            <div>
                                <p class="text-gray-700">
                                    {{ $notification->data['message'] }} - 
                                    @if(isset($notification->data['url']))
                                        <a href="{{ $notification->data['url'] }}" class="text-blue-500 underline">
                                            <strong>{{ $notification->data['job_title'] }}</strong>
                                        </a>
                                    @else
                                        <strong>{{ $notification->data['job_title'] }}</strong>
                                    @endif
                                </p>
                                <span class="text-sm text-gray-500">{{ $notification->created_at->diffForHumans() }}</span>
                            </div>
                            <form action="{{ route('notifications.markAsRead', $notification->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded">Mark as Read</button>
                            </form>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</x-app-layout>
