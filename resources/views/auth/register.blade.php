<x-guest-layout>
    <!-- Full-page background container with carousel -->
    <div class="min-h-screen flex flex-col items-center justify-center p-6 relative overflow-hidden">
        <!-- Background Images -->
        <div class="absolute inset-0 z-0">
            <div id="hero-carousel" class="relative w-full h-full">
                <div class="absolute inset-0 transition-opacity duration-1000 ease-in-out opacity-100" data-carousel-item>
                    <img src="{{ asset('images/img1.jpg') }}" alt="Event 1" class="w-full h-full object-cover">
                </div>
                <div class="absolute inset-0 transition-opacity duration-1000 ease-in-out opacity-0" data-carousel-item>
                    <img src="{{ asset('images/img2.jpg') }}" alt="Event 2" class="w-full h-full object-cover">
                </div>
                <div class="absolute inset-0 transition-opacity duration-1000 ease-in-out opacity-0" data-carousel-item>
                    <img src="{{ asset('images/img3.jpg') }}" alt="Event 3" class="w-full h-full object-cover">
                </div>
            </div>
            <div class="absolute inset-0 bg-black bg-opacity-50"></div>
        </div>

        <!-- Website Name at Top Middle -->
        <div class="text-2xl font-bold text-white mb-4 z-10">
            Event Jobs Hub
        </div>

        <!-- Main content box -->
        <div class="w-full max-w-md bg-white rounded-xl shadow-2xl p-8 z-10">
            <!-- Register Message -->
            <div class="text-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Create Your Account</h2>
                <p class="text-gray-600 mt-2">Join us today as a part-timer or employer and start exploring event opportunities!</p>
            </div>

            <!-- Validation Errors -->
            <x-validation-errors class="mb-4" />

            <!-- Registration Form -->
            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf

                <!-- Name Input -->
                <div>
                    <x-label for="name" value="{{ __('Name') }}" class="block text-sm font-medium text-gray-700" />
                    <x-input id="name" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                </div>

                <!-- Email Input -->
                <div>
                    <x-label for="email" value="{{ __('Email') }}" class="block text-sm font-medium text-gray-700" />
                    <x-input id="email" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" type="email" name="email" :value="old('email')" required autocomplete="username" />
                </div>

                <!-- Role Selection -->
                <div>
                    <x-label for="role" value="{{ __('Register As') }}" class="block text-sm font-medium text-gray-700" />
                    <select id="role" name="role" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <option value="part-timer">Part-Timer</option>
                        <option value="employer">Employer</option>
                    </select>
                </div>

                <!-- Password Input -->
                <div>
                    <x-label for="password" value="{{ __('Password') }}" class="block text-sm font-medium text-gray-700" />
                    <x-input id="password" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" type="password" name="password" required autocomplete="new-password" />
                </div>

                <!-- Confirm Password Input -->
                <div>
                    <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" class="block text-sm font-medium text-gray-700" />
                    <x-input id="password_confirmation" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" type="password" name="password_confirmation" required autocomplete="new-password" />
                </div>

                <!-- Terms and Conditions -->
                @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                    <div class="mt-4">
                        <x-label for="terms">
                            <div class="flex items-center">
                                <x-checkbox name="terms" id="terms" required class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" />

                                <div class="ms-2">
                                    {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                            'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-blue-600 hover:text-blue-500 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">'.__('Terms of Service').'</a>',
                                            'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-blue-600 hover:text-blue-500 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">'.__('Privacy Policy').'</a>',
                                    ]) !!}
                                </div>
                            </div>
                        </x-label>
                    </div>
                @endif

                <!-- Register Button -->
                <div class="flex items-center justify-end mt-4">
                    <a class="text-sm text-blue-600 hover:text-blue-500" href="{{ route('login') }}">
                        {{ __('Already registered?') }}
                    </a>

                    <button type="submit" class="ml-4 flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        {{ __('Register') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- JavaScript for Hero Carousel -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const slides = document.querySelectorAll('[data-carousel-item]');
            let currentIndex = 0;

            function changeSlide() {
                slides[currentIndex].classList.remove('opacity-100');
                slides[currentIndex].classList.add('opacity-0');

                currentIndex = (currentIndex + 1) % slides.length;

                slides[currentIndex].classList.remove('opacity-0');
                slides[currentIndex].classList.add('opacity-100');
            }

            setInterval(changeSlide, 4000); // Change image every 4 seconds
        });
    </script>
</x-guest-layout>