<x-app-layout>
    <div class="bg-gray-100 min-h-screen">
        <!-- Hero Section with Rotating Background Images -->
        <div class="relative py-16 text-white text-center">
            <!-- Background Image Slideshow -->
            <div class="absolute inset-0 z-0">
                <div id="hero-carousel" class="relative w-full h-full">
                    <div class="absolute inset-0 transition-opacity duration-1000 ease-in-out opacity-100" data-carousel-item>
                        <img src="{{ asset('images/img1.jpg') }}" alt="Event 2" class="w-full h-full object-cover">
                    </div>
                    <div class="absolute inset-0 transition-opacity duration-1000 ease-in-out opacity-0" data-carousel-item>
                        <img src="{{ asset('images/img2.jpg') }}" alt="Event 3" class="w-full h-full object-cover">
                    </div>
                    <div class="absolute inset-0 transition-opacity duration-1000 ease-in-out opacity-0" data-carousel-item>
                        <img src="{{ asset('images/img3.jpg') }}" alt="Event 3" class="w-full h-full object-cover">
                    </div>
                </div>
                <div class="absolute inset-0 bg-black bg-opacity-50"></div>
            </div>

            <div class="relative z-10 max-w-5xl mx-auto">
                <h1 class="text-4xl font-extrabold">Hire Part-Timers for Your Events Effortlessly</h1>
                <p class="mt-4 text-lg">Post jobs, review applications, and hire the best candidates — all in one place.</p>
                <a href="{{ route('events.create') }}" class="mt-6 inline-block bg-white text-blue-600 font-bold py-3 px-6 rounded-full shadow-md hover:bg-gray-200 transition">
                    Post Job Now!
                </a>
            </div>
        </div>

        <!-- Why Choose Us Section -->
        <div class="max-w-6xl mx-auto px-6 py-16">
            <h2 class="text-3xl font-bold text-gray-800 text-center">Why Choose Us?</h2>
            <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white shadow-lg rounded-lg p-6 text-center hover:shadow-xl transition">
                    <h3 class="text-xl font-bold text-gray-800">🚀 Fast & Easy Job Posting</h3>
                    <p class="text-gray-600 mt-2"><p class="text-gray-600 mt-2">Simply fill out the job details and post it in a few clicks. Once submitted, your job listing will undergo a quick review and approval by our admin team. After approval, your job will be instantly visible to potential applicants, allowing you to find the right candidates efficiently.</p>
                </div>
                <div class="bg-white shadow-lg rounded-lg p-6 text-center hover:shadow-xl transition">
                    <h3 class="text-xl font-bold text-gray-800">🎯 Access a Talent Pool</h3>
                    <p class="text-gray-600 mt-2">Gain access to a pool of talented part-timers with diverse skills and experiences. Whether you need event crews, promoters, cashiers, security personnel, or food crews, our platform offers a wide variety of applicants suited to your event's needs.</p>
                </div>
                <div class="bg-white shadow-lg rounded-lg p-6 text-center hover:shadow-xl transition">
                    <h3 class="text-xl font-bold text-gray-800">✅ Seamless Hiring Process</h3>
                    <p class="text-gray-600 mt-2">The hiring process is streamlined to ensure a smooth experience for both employers and part-timers. You can easily review applications and finalize your hires without the hassle of managing separate communication platforms or emails.</p>
                </div>
            </div>
        </div>

        <!-- How It Works Section -->
        <div class="bg-white py-16">
            <div class="max-w-5xl mx-auto text-center">
                <h2 class="text-3xl font-bold text-gray-800">How It Works</h2>
                <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="p-6">
                        <div class="text-blue-600 text-5xl">📌</div>
                        <h3 class="text-xl font-bold text-gray-800 mt-4">Post a Job</h3>
                        <p class="text-gray-600 mt-2">Simply list your event job details, including the job title, description, pay rate, and event date. Our user-friendly interface allows you to create job posts in minutes and make them visible to potential applicants immediately.</p>
                    </div>
                    <div class="p-6">
                        <div class="text-blue-600 text-5xl">👀</div>
                        <h3 class="text-xl font-bold text-gray-800 mt-4">Review Applicants</h3>
                        <p class="text-gray-600 mt-2">Once applicants start applying, you can easily review their profiles, past experiences, and ratings from previous employers. The dashboard offers a clear view of each applicant's qualifications, helping you make informed decisions quickly.</p>
                    </div>
                    <div class="p-6">
                        <div class="text-blue-600 text-5xl">✅</div>
                        <h3 class="text-xl font-bold text-gray-800 mt-4">Hire & Confirm</h3>
                        <p class="text-gray-600 mt-2">After reviewing the applicants, you can approve the ones that best fit your event requirements. The platform also supports a smooth payment process, enabling you to finalize the hiring and confirm your part-timers in just a few steps.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- FAQs Section -->
        <div class="max-w-5xl mx-auto px-6 py-16">
            <h2 class="text-3xl font-bold text-gray-800 text-center">Frequently Asked Questions</h2>
            <div class="mt-8 space-y-6">
                <div class="bg-white shadow-md rounded-lg p-4">
                    <h3 class="text-lg font-bold text-gray-800">How do I post a job?</h3>
                    <p class="text-gray-600 mt-2">Simply click on the "Post Job Now!" button located on the homepage. Then, fill in all necessary job details such as job title, event description, date, and pay rate. After submitting, your job listing will be visible to part-timers immediately.</p>
                </div>
                <div class="bg-white shadow-md rounded-lg p-4">
                    <h3 class="text-lg font-bold text-gray-800">How do I review applicants?</h3>
                    <p class="text-gray-600 mt-2">After posting your job, applicants will start submitting their applications. You can review each application through your dashboard, where you can view their profile, experience, and ratings from past employers to make a well-informed decision.</p>
                </div>
                <div class="bg-white shadow-md rounded-lg p-4">
                    <h3 class="text-lg font-bold text-gray-800">How do I approve and hire a part-timer?</h3>
                    <p class="text-gray-600 mt-2">Once you've reviewed the applications, simply approve the ones you want to hire. After approval, the system allows you to finalize payment and confirm the hiring process, ensuring everything is handled securely and efficiently.</p>
                </div>
            </div>
        </div>

        <!-- Final Call to Action -->
        <div class="bg-blue-600 py-12 text-center text-white">
            <h2 class="text-2xl font-bold">Start Hiring Now</h2>
            <p class="text-lg mt-2">Find part-timers for your event today. It's quick, easy, and seamless. Join thousands of employers who trust our platform for their event staffing needs.</p>
            <a href="{{ route('events.create') }}" class="mt-4 inline-block bg-white text-blue-600 font-bold py-3 px-6 rounded-full shadow-md transition">
                Post Job Now!
            </a>
        </div>
    </div>

    <!-- JavaScript for Image Slideshow -->
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

            setInterval(changeSlide, 3000); // Change image every 3 seconds
        });
    </script>
</x-app-layout>
