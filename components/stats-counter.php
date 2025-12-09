<?php
/**
 * SIEGA Live Stats Counter Component
 * Animated statistics showcase with counter effect
 */
?>

<section class="py-20 bg-gradient-to-br from-slate-900 to-slate-800 relative overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-5">
        <div class="absolute inset-0" style="background-image: radial-gradient(circle at 1px 1px, white 1px, transparent 0); background-size: 40px 40px;"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">
                SIEGA dalam Angka
            </h2>
            <p class="text-slate-400 max-w-2xl mx-auto">
                Prestasi dan capaian yang membanggakan dari Program Studi Sistem Informasi
            </p>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Stat Card 1: Konsentrasi -->
            <div class="group bg-gradient-to-br from-slate-800 to-slate-900 rounded-2xl p-8 border border-slate-700 hover:border-indigo-500 transition-all duration-300 hover:shadow-2xl hover:shadow-indigo-500/20 hover:-translate-y-2">
                <div class="flex flex-col items-center text-center space-y-4">
                    <div class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="text-5xl font-bold bg-gradient-to-r from-indigo-400 to-indigo-600 bg-clip-text text-transparent" data-target="4">
                            0
                        </div>
                        <p class="text-slate-400 mt-2 font-medium">Konsentrasi Unggulan</p>
                        <p class="text-xs text-slate-500 mt-1">Pilihan Spesialisasi</p>
                    </div>
                </div>
            </div>

            <!-- Stat Card 2: Mahasiswa -->
            <div class="group bg-gradient-to-br from-slate-800 to-slate-900 rounded-2xl p-8 border border-slate-700 hover:border-cyan-500 transition-all duration-300 hover:shadow-2xl hover:shadow-cyan-500/20 hover:-translate-y-2">
                <div class="flex flex-col items-center text-center space-y-4">
                    <div class="w-16 h-16 bg-gradient-to-br from-cyan-500 to-cyan-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="text-5xl font-bold bg-gradient-to-r from-cyan-400 to-cyan-600 bg-clip-text text-transparent" data-target="500">
                            0
                        </div>
                        <p class="text-slate-400 mt-2 font-medium">Alumni Tersebar</p>
                        <p class="text-xs text-slate-500 mt-1">Di Berbagai Industri</p>
                    </div>
                </div>
            </div>

            <!-- Stat Card 3: Employment Rate -->
            <div class="group bg-gradient-to-br from-slate-800 to-slate-900 rounded-2xl p-8 border border-slate-700 hover:border-pink-500 transition-all duration-300 hover:shadow-2xl hover:shadow-pink-500/20 hover:-translate-y-2">
                <div class="flex flex-col items-center text-center space-y-4">
                    <div class="w-16 h-16 bg-gradient-to-br from-pink-500 to-pink-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="flex items-center justify-center">
                            <span class="text-5xl font-bold bg-gradient-to-r from-pink-400 to-pink-600 bg-clip-text text-transparent" data-target="95">0</span>
                            <span class="text-3xl font-bold text-pink-500 ml-1">%</span>
                        </div>
                        <p class="text-slate-400 mt-2 font-medium">Terserap Kerja</p>
                        <p class="text-xs text-slate-500 mt-1">Dalam 6 Bulan Lulus</p>
                    </div>
                </div>
            </div>

            <!-- Stat Card 4: Prestasi -->
            <div class="group bg-gradient-to-br from-slate-800 to-slate-900 rounded-2xl p-8 border border-slate-700 hover:border-orange-500 transition-all duration-300 hover:shadow-2xl hover:shadow-orange-500/20 hover:-translate-y-2">
                <div class="flex flex-col items-center text-center space-y-4">
                    <div class="w-16 h-16 bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="text-5xl font-bold bg-gradient-to-r from-orange-400 to-orange-600 bg-clip-text text-transparent" data-target="50">
                            0
                        </div>
                        <p class="text-slate-400 mt-2 font-medium">Prestasi Raih</p>
                        <p class="text-xs text-slate-500 mt-1">Nasional & Internasional</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Info Cards -->
        <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-slate-800/50 backdrop-blur-sm rounded-xl p-6 border border-slate-700 hover:border-slate-600 transition-colors">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-indigo-500/20 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-white font-semibold">Akreditasi Baik Sekali</p>
                        <p class="text-sm text-slate-400">BAN-PT Nilai 338</p>
                    </div>
                </div>
            </div>

            <div class="bg-slate-800/50 backdrop-blur-sm rounded-xl p-6 border border-slate-700 hover:border-slate-600 transition-colors">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-cyan-500/20 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-white font-semibold">Perusahaan Partner</p>
                        <p class="text-sm text-slate-400">Gojek, Tokopedia, Agate</p>
                    </div>
                </div>
            </div>

            <div class="bg-slate-800/50 backdrop-blur-sm rounded-xl p-6 border border-slate-700 hover:border-slate-600 transition-colors">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-pink-500/20 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-white font-semibold">Salary Range Alumni</p>
                        <p class="text-sm text-slate-400">7-30 Juta per Bulan</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
// Counter Animation
function animateCounter(element, target, duration = 2000) {
    const start = 0;
    const increment = target / (duration / 16);
    let current = start;

    const timer = setInterval(() => {
        current += increment;
        if (current >= target) {
            element.textContent = target;
            clearInterval(timer);
        } else {
            element.textContent = Math.floor(current);
        }
    }, 16);
}

// Intersection Observer for triggering animation
const observerOptions = {
    threshold: 0.5,
    rootMargin: '0px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            const counters = entry.target.querySelectorAll('[data-target]');
            counters.forEach(counter => {
                const target = parseInt(counter.getAttribute('data-target'));
                animateCounter(counter, target);
            });
            observer.unobserve(entry.target);
        }
    });
}, observerOptions);

// Observe the stats section
document.addEventListener('DOMContentLoaded', () => {
    const statsSection = document.querySelector('[data-target]')?.closest('section');
    if (statsSection) {
        observer.observe(statsSection);
    }
});
</script>