<style>
    @keyframes typing {
        0% {
            width: 0;
        }

        50% {
            width: 100%;
        }

        70% {
            width: 100%;
        }

        /* Pause before deleting */
        100% {
            width: 0;
        }
    }

    @keyframes blink {
        50% {
            border-color: transparent;
        }
    }

    .animate-typing {
        display: inline-block;
        overflow: hidden;
        white-space: nowrap;
        border-right: 3px solid var(--primary-color);
        animation: typing 4s steps(45, end) infinite, blink 0.75s step-end infinite;
        color: var(--primary-color);
        font-weight: 500;
    }




    .hero-title {
        font-family: var(--font-secondary, 'Poppins', sans-serif);
        letter-spacing: -0.02em;
        font-weight: 800;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
    }

    .hero-section {
        height: 100vh;
        min-height: 700px;
        position: relative;
        overflow: hidden;
        /* background: linear-gradient(45deg, #0f0c29, #302b63, #24243e); */
        background: linear-gradient(-45deg, #0f172a, #1e293b, #334155, #0f172a);
        background-size: 400% 400%;
        animation: gradientBG 25s ease infinite;
    }

    @keyframes gradientBG {
        0% {
            background-position: 0% 50%;
        }

        50% {
            background-position: 100% 50%;
        }

        100% {
            background-position: 0% 50%;
        }
    }

    .hero-content {
        position: relative;
        z-index: 10;
    }

    .hero-bg {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-size: cover;
        background-position: center;
        transition: opacity 1.5s cubic-bezier(0.4, 0, 0.2, 1), transform 1.5s cubic-bezier(0.4, 0, 0.2, 1);
        /* Smoother transition */
        opacity: 0;
        transform: scale(1.05);
        /* Slight zoom out for inactive */
    }

    .hero-bg.active {
        opacity: 1;
        transform: scale(1);
        /* Normal scale for active */
    }

    .hero-overlay {
        background: rgba(17, 24, 39, 0.8);
        /* Darker overlay: Gray-900 with opacity */
    }

    .hero-pagination {
        position: absolute;
        bottom: 2.5rem;
        /* Slightly higher */
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        gap: 1rem;
        z-index: 20;
    }

    .hero-pagination-dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.3);
        cursor: pointer;
        transition: all 0.4s ease;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .hero-pagination-dot.active {
        background: var(--primary-color);
        transform: scale(1.3);
        box-shadow: 0 0 10px var(--primary-color);
    }

    .floating {
        animation: floating 3.5s ease-in-out infinite;
    }

    @keyframes floating {
        0% {
            transform: translateY(0px);
        }

        50% {
            transform: translateY(-12px);
        }

        /* Reduced floating height */
        100% {
            transform: translateY(0px);
        }
    }

    .btn-primary {
        background-color: var(--primary-color);
        color: #ffffff;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px -5px var(--primary-color);
    }

    .btn-primary:hover {
        background-color: var(--primary-hover-color);
        transform: translateY(-2px) scale(1.03);
        box-shadow: 0 6px 20px -5px var(--primary-color);
    }

    .btn-secondary {
        border-color: rgba(255, 255, 255, 0.7);
        color: var(--text-light);
        transition: all 0.3s ease;
    }

    .btn-secondary:hover {
        background-color: rgba(255, 255, 255, 0.9);
        color: var(--dark-bg);
        border-color: transparent;
        transform: translateY(-2px);
    }



    .section-title {
        color: var(--text-light);
        border-bottom: 2px solid var(--primary-color);
        padding-bottom: 0.5rem;
        display: inline-block;
    }
</style>
<!-- Hero Section -->
<div class="hero-section">
    <!-- Background Images (handled by JS) -->
    <div class="hero-bg active" style="background-image: url('https://images.unsplash.com/photo-1499750310107-5fef28a66643?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80')"></div>
    <div class="hero-bg" style="background-image: url('https://images.unsplash.com/photo-1517694712202-14dd9538aa97?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80')"></div>
    <div class="hero-bg" style="background-image: url('https://images.unsplash.com/photo-1555066931-4365d14bab8c?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80')"></div>

    <!-- Overlay -->
    <div class="absolute inset-0 hero-overlay"></div>
    <!-- Content -->
    <div class="relative h-full flex items-center">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
            <div class="text-center hero-content">
                <h1 class="hero-title text-5xl font-extrabold tracking-tight text-white sm:text-6xl lg:text-7xl">
                    <span class="block">Bee IT Club</span>
                    <span class="block text-amber-400 mt-3">Knowledge Hive</span>
                </h1>
                <p class="mt-8 max-w-2xl mx-auto text-xl text-gray-300 sm:text-2xl">
                    <span class="animate-typing">Chia sẻ, học hỏi, và cùng nhau phát triển trong cộng đồng IT.</span>
                </p>
                <div class="mt-12 flex flex-col sm:flex-row justify-center gap-4 sm:gap-6">
                    <a href="{{ route('questions.create') }}"
                        class="btn-primary inline-flex items-center justify-center px-8 py-3 sm:px-10 sm:py-4 border border-transparent text-base sm:text-lg font-medium rounded-lg floating">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.755 4 3.92C16 13.09 14.828 15 12 15c-.102 0-.203-.004-.304-.011C10.998 16.03 9.503 17 8 17c-.828 0-1.54-.342-2.074-.882l.005-.005A7.933 7.933 0 014 13.92C4 11.755 5.79 10 8 10c.228 0 .449.02.669.056l-.003-.002zM12 15c1.828 0 3.098-1.91 3.098-3.08C15.098 10.755 13.31 9 11.098 9c-1.74 0-3.222.835-3.772 2" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6V7M12 17V18" />
                        </svg>
                        Đặt câu hỏi
                    </a>
                    <a href="{{ route('blog') }}"
                        class="btn-secondary inline-flex items-center justify-center px-8 py-3 sm:px-10 sm:py-4 border text-base sm:text-lg font-medium rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v11.494m0 0L7.5 12.5m4.5 5.247L16.5 12.5" />
                        </svg>
                        Khám phá Blog
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <div class="hero-pagination">
        <div class="hero-pagination-dot active" data-index="0"></div>
        <div class="hero-pagination-dot" data-index="1"></div>
        <div class="hero-pagination-dot" data-index="2"></div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const backgrounds = document.querySelectorAll('.hero-bg');
        const dots = document.querySelectorAll('.hero-pagination-dot');
        let currentIndex = 0;
        let intervalId = null;

        function showSlide(index) {
            backgrounds.forEach((bg, i) => {
                if (i === index) {
                    bg.classList.add('active');
                } else {
                    bg.classList.remove('active');
                }
            });
            dots.forEach((dot, i) => {
                if (i === index) {
                    dot.classList.add('active');
                } else {
                    dot.classList.remove('active');
                }
            });
        }

        function nextSlide() {
            currentIndex = (currentIndex + 1) % backgrounds.length;
            showSlide(currentIndex);
        }

        function startSlider() {
            stopSlider(); // Clear existing interval if any
            showSlide(currentIndex); // Show initial slide
            intervalId = setInterval(nextSlide, 5000); // Auto slide every 5 seconds
        }

        function stopSlider() {
            clearInterval(intervalId);
        }

        // Click handlers for dots
        dots.forEach((dot, index) => {
            dot.addEventListener('click', () => {
                currentIndex = index;
                showSlide(currentIndex);
                startSlider(); // Restart interval on manual navigation
            });
        });

        // Initialize slider
        if (backgrounds.length > 0 && dots.length > 0) {
            startSlider();
        }

        // Optional: Pause slider on hover over hero section
        const heroSection = document.querySelector('.hero-section');
        if (heroSection) {
            heroSection.addEventListener('mouseenter', stopSlider);
            heroSection.addEventListener('mouseleave', startSlider);
        }
    });
</script>