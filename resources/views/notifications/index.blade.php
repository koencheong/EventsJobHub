<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">{{ __('Notifications') }}</h2>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-r from-blue-50 via-purple-50 to-pink-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-xl p-8 border border-gray-100">
                <!-- Unread Notifications Section -->
                <h3 class="text-2xl font-semibold text-blue-700 mb-6">Unread Notifications</h3>

                @if(auth()->user()->unreadNotifications->isEmpty())
                    <p class="text-gray-500 text-center">No new notifications.</p>
                @else
                    <ul class="space-y-4">
                        @foreach (auth()->user()->unreadNotifications as $notification)
                            <li class="p-4 border border-blue-200 rounded-xl bg-blue-50 hover:bg-blue-100 transition duration-150 flex justify-between items-center">
                                <div>
                                    <p class="text-gray-700">
                                        {{ $notification->data['message'] }} 
                                        @if(isset($notification->data['url']))
                                            - <a href="{{ $notification->data['url'] }}" class="text-blue-600 underline hover:text-blue-700">
                                                <strong>
                                                    {{ $notification->data['job_title'] ?? 'View Details' }}
                                                </strong>
                                            </a>
                                        @elseif(isset($notification->data['job_title']))
                                            - <strong>{{ $notification->data['job_title'] }}</strong>
                                        @endif
                                    </p>
                                    <span class="text-sm text-gray-500">{{ $notification->created_at->diffForHumans() }}</span>
                                </div>
                                <form action="{{ route('notifications.markAsRead', $notification->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" 
                                            class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded-md text-sm transition duration-200">
                                        Mark as Read
                                    </button>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
