<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-3xl text-gray-800 leading-tight">
            {{ __('Edit Portfolio') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gradient-to-r from-blue-100 via-indigo-200 to-purple-300">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl sm:rounded-lg p-8 rounded-xl overflow-hidden">
                @if (session('success'))
                    <div class="mb-4 p-4 bg-green-500 text-white rounded">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('portfolio.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label class="block font-medium">Full Name *</label>
                        <input type="text" name="full_name" value="{{ old('full_name', $portfolio->full_name) }}"
                            class="form-input w-full border rounded-lg p-2" required>
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium">Phone *</label>
                        <input type="text" name="phone" value="{{ old('phone', $portfolio->phone) }}"
                            class="form-input w-full border rounded-lg p-2" required>
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium">Location</label>
                        <input type="text" name="location" value="{{ old('location', $portfolio->location) }}"
                            class="form-input w-full border rounded-lg p-2">
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium">Bio</label>
                        <textarea name="bio" class="form-input w-full border rounded-lg p-2"
                            placeholder="Write something about yourself...">{{ old('bio', $portfolio->bio) }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium">Work Experience</label>
                        <textarea name="work_experience" class="form-input w-full border rounded-lg p-2"
                            placeholder="Describe your work experience...">{{ old('work_experience', $portfolio->work_experience) }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium">Previous Work Photos</label>
                        <input type="file" name="work_photos[]" multiple accept="image/*" class="form-input w-full border rounded-lg p-2">
                    </div>

                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg shadow">Update Portfolio</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
