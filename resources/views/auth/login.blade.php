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
            <!-- Welcome Message -->
            <div class="text-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Welcome Back!</h2>
                <p class="text-gray-600 mt-2">Log in to access your account and continue your journey.</p>
            </div>

            <!-- Validation Errors -->
            <x-validation-errors class="mb-4" />

            <!-- Session Status -->
            @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ session('status') }}
                </div>
            @endif

            <!-- Login Form -->
            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <!-- Email Input -->
                <div>
                    <x-label for="email" value="{{ __('Email') }}" class="block text-sm font-medium text-gray-700" />
                    <x-input id="email" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                </div>

                <!-- Password Input -->
                <div>
                    <x-label for="password" value="{{ __('Password') }}" class="block text-sm font-medium text-gray-700" />
                    <x-input id="password" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" type="password" name="password" required autocomplete="current-password" />
                </div>

                <!-- Remember Me Checkbox -->
                <div class="flex items-center justify-between">
                    <label for="remember_me" class="flex items-center">
                        <x-checkbox id="remember_me" name="remember" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" />
                        <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                    </label>

                    <!-- Forgot Password Link -->
                    @if (Route::has('password.request'))
                        <a class="text-sm text-blue-600 hover:text-blue-500" href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif
                </div>

                <!-- Login Button -->
                <div>
                    <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        {{ __('Log in') }}
                    </button>
                </div>
            </form>

            <!-- Registration Link -->
            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    Don't have an account?
                    <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-500">
                        {{ __('Register here') }}
                    </a>
                </p>
            </div>
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