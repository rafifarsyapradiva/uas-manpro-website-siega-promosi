<?php
/**
 * SIEGA Career Path Visualizer Component
 * Interactive career path flowchart for each concentration
 */
?>

<section class="py-20 bg-slate-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">
                Career Path Opportunities
            </h2>
            <p class="text-slate-400 max-w-2xl mx-auto">
                Jelajahi berbagai peluang karir cemerlang setelah lulus dari setiap konsentrasi
            </p>
        </div>

        <!-- Career Path Tabs -->
        <div class="flex flex-wrap justify-center gap-3 mb-12">
            <button class="career-tab active px-6 py-3 bg-indigo-500 hover:bg-indigo-600 text-white rounded-lg font-semibold transition-all" data-tab="si">
                💻 Sistem Informasi
            </button>
            <button class="career-tab px-6 py-3 bg-slate-800 hover:bg-slate-700 text-slate-300 hover:text-white rounded-lg font-semibold transition-all" data-tab="ec">
                🛒 E-Commerce
            </button>
            <button class="career-tab px-6 py-3 bg-slate-800 hover:bg-slate-700 text-slate-300 hover:text-white rounded-lg font-semibold transition-all" data-tab="gt">
                🎮 Game Technology
            </button>
            <button class="career-tab px-6 py-3 bg-slate-800 hover:bg-slate-700 text-slate-300 hover:text-white rounded-lg font-semibold transition-all" data-tab="ak">
                💼 Akuntansi-SI
            </button>
        </div>

        <!-- Career Path Content -->
        <div class="career-content">
            <!-- Sistem Informasi Path -->
            <div id="career-si" class="career-panel active">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="bg-gradient-to-br from-indigo-900/50 to-slate-800 rounded-xl p-6 border border-indigo-500/30 hover:border-indigo-500 transition-all hover:shadow-xl hover:shadow-indigo-500/20 group">
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-indigo-500/20 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-white font-bold text-lg mb-2">Business Analyst</h3>
                                <p class="text-sm text-slate-400 mb-3">Menganalisis kebutuhan bisnis dan merancang solusi IT</p>
                                <div class="flex items-center justify-between">
                                    <span class="text-indigo-400 font-semibold text-sm">Rp 8-15 juta</span>
                                    <span class="text-xs text-slate-500">Entry-Mid</span>
                                </div>
                                <div class="mt-3 flex flex-wrap gap-2">
                                    <span class="px-2 py-1 bg-indigo-500/20 text-indigo-300 text-xs rounded">Gojek</span>
                                    <span class="px-2 py-1 bg-indigo-500/20 text-indigo-300 text-xs rounded">Tokopedia</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-indigo-900/50 to-slate-800 rounded-xl p-6 border border-indigo-500/30 hover:border-indigo-500 transition-all hover:shadow-xl hover:shadow-indigo-500/20 group">
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-indigo-500/20 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-white font-bold text-lg mb-2">System Analyst</h3>
                                <p class="text-sm text-slate-400 mb-3">Merancang arsitektur sistem informasi enterprise</p>
                                <div class="flex items-center justify-between">
                                    <span class="text-indigo-400 font-semibold text-sm">Rp 10-18 juta</span>
                                    <span class="text-xs text-slate-500">Mid-Senior</span>
                                </div>
                                <div class="mt-3 flex flex-wrap gap-2">
                                    <span class="px-2 py-1 bg-indigo-500/20 text-indigo-300 text-xs rounded">Bank BCA</span>
                                    <span class="px-2 py-1 bg-indigo-500/20 text-indigo-300 text-xs rounded">Mandiri</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-indigo-900/50 to-slate-800 rounded-xl p-6 border border-indigo-500/30 hover:border-indigo-500 transition-all hover:shadow-xl hover:shadow-indigo-500/20 group">
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-indigo-500/20 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-white font-bold text-lg mb-2">IT Consultant</h3>
                                <p class="text-sm text-slate-400 mb-3">Memberikan konsultasi solusi IT untuk perusahaan</p>
                                <div class="flex items-center justify-between">
                                    <span class="text-indigo-400 font-semibold text-sm">Rp 12-25 juta</span>
                                    <span class="text-xs text-slate-500">Senior</span>
                                </div>
                                <div class="mt-3 flex flex-wrap gap-2">
                                    <span class="px-2 py-1 bg-indigo-500/20 text-indigo-300 text-xs rounded">Deloitte</span>
                                    <span class="px-2 py-1 bg-indigo-500/20 text-indigo-300 text-xs rounded">Accenture</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-indigo-900/50 to-slate-800 rounded-xl p-6 border border-indigo-500/30 hover:border-indigo-500 transition-all hover:shadow-xl hover:shadow-indigo-500/20 group">
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-indigo-500/20 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-white font-bold text-lg mb-2">ERP Specialist</h3>
                                <p class="text-sm text-slate-400 mb-3">Implementasi dan kustomisasi sistem ERP</p>
                                <div class="flex items-center justify-between">
                                    <span class="text-indigo-400 font-semibold text-sm">Rp 15-30 juta</span>
                                    <span class="text-xs text-slate-500">Senior</span>
                                </div>
                                <div class="mt-3 flex flex-wrap gap-2">
                                    <span class="px-2 py-1 bg-indigo-500/20 text-indigo-300 text-xs rounded">SAP</span>
                                    <span class="px-2 py-1 bg-indigo-500/20 text-indigo-300 text-xs rounded">Oracle</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-indigo-900/50 to-slate-800 rounded-xl p-6 border border-indigo-500/30 hover:border-indigo-500 transition-all hover:shadow-xl hover:shadow-indigo-500/20 group">
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-indigo-500/20 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-white font-bold text-lg mb-2">Data Analyst</h3>
                                <p class="text-sm text-slate-400 mb-3">Menganalisis data untuk insight bisnis</p>
                                <div class="flex items-center justify-between">
                                    <span class="text-indigo-400 font-semibold text-sm">Rp 9-16 juta</span>
                                    <span class="text-xs text-slate-500">Entry-Mid</span>
                                </div>
                                <div class="mt-3 flex flex-wrap gap-2">
                                    <span class="px-2 py-1 bg-indigo-500/20 text-indigo-300 text-xs rounded">Bukalapak</span>
                                    <span class="px-2 py-1 bg-indigo-500/20 text-indigo-300 text-xs rounded">Shopee</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-indigo-900/50 to-slate-800 rounded-xl p-6 border border-indigo-500/30 hover:border-indigo-500 transition-all hover:shadow-xl hover:shadow-indigo-500/20 group">
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-indigo-500/20 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-white font-bold text-lg mb-2">IT Project Manager</h3>
                                <p class="text-sm text-slate-400 mb-3">Mengelola project IT dari planning hingga deployment</p>
                                <div class="flex items-center justify-between">
                                    <span class="text-indigo-400 font-semibold text-sm">Rp 18-35 juta</span>
                                    <span class="text-xs text-slate-500">Senior-Lead</span>
                                </div>
                                <div class="mt-3 flex flex-wrap gap-2">
                                    <span class="px-2 py-1 bg-indigo-500/20 text-indigo-300 text-xs rounded">Unicorn</span>
                                    <span class="px-2 py-1 bg-indigo-500/20 text-indigo-300 text-xs rounded">Tech Giants</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- E-Commerce Path (hidden by default) -->
            <div id="career-ec" class="career-panel hidden">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="bg-gradient-to-br from-cyan-900/50 to-slate-800 rounded-xl p-6 border border-cyan-500/30 hover:border-cyan-500 transition-all hover:shadow-xl hover:shadow-cyan-500/20 group">
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-cyan-500/20 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-white font-bold text-lg mb-2">Digital Marketing Specialist</h3>
                                <p class="text-sm text-slate-400 mb-3">Strategi marketing digital dan campaign management</p>
                                <div class="flex items-center justify-between">
                                    <span class="text-cyan-400 font-semibold text-sm">Rp 7-14 juta</span>
                                    <span class="text-xs text-slate-500">Entry-Mid</span>
                                </div>
                                <div class="mt-3 flex flex-wrap gap-2">
                                    <span class="px-2 py-1 bg-cyan-500/20 text-cyan-300 text-xs rounded">Tokopedia</span>
                                    <span class="px-2 py-1 bg-cyan-500/20 text-cyan-300 text-xs rounded">Shopee</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-cyan-900/50 to-slate-800 rounded-xl p-6 border border-cyan-500/30 hover:border-cyan-500 transition-all hover:shadow-xl hover:shadow-cyan-500/20 group">
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-cyan-500/20 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-white font-bold text-lg mb-2">E-Commerce Manager</h3>
                                <p class="text-sm text-slate-400 mb-3">Mengelola operasional e-commerce end-to-end</p>
                                <div class="flex items-center justify-between">
                                    <span class="text-cyan-400 font-semibold text-sm">Rp 10-20 juta</span>
                                    <span class="text-xs text-slate-500">Mid-Senior</span>
                                </div>
                                <div class="mt-3 flex flex-wrap gap-2">
                                    <span class="px-2 py-1 bg-cyan-500/20 text-cyan-300 text-xs rounded">Unilever</span>
                                    <span class="px-2 py-1 bg-cyan-500/20 text-cyan-300 text-xs rounded">P&G</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-cyan-900/50 to-slate-800 rounded-xl p-6 border border-cyan-500/30 hover:border-cyan-500 transition-all hover:shadow-xl hover:shadow-cyan-500/20 group">
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-cyan-500/20 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-white font-bold text-lg mb-2">Online Entrepreneur</h3>
                                <p class="text-sm text-slate-400 mb-3">Membangun dan mengembangkan bisnis online sendiri</p>
                                <div class="flex items-center justify-between">
                                    <span class="text-cyan-400 font-semibold text-sm">Rp 10-50 juta+</span>
                                    <span class="text-xs text-slate-500">Varies</span>
                                </div>
                                <div class="mt-3 flex flex-wrap gap-2">
                                    <span class="px-2 py-1 bg-cyan-500/20 text-cyan-300 text-xs rounded">Own Business</span>
                                    <span class="px-2 py-1 bg-cyan-500/20 text-cyan-300 text-xs rounded">Startup</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Note: Add similar structures for Game Tech and Akuntansi-SI -->
            <!-- Placeholder panels -->
            <div id="career-gt" class="career-panel hidden">
                <p class="text-center text-slate-400">Game Technology career paths loading...</p>
            </div>
            <div id="career-ak" class="career-panel hidden">
                <p class="text-center text-slate-400">Akuntansi-SI career paths loading...</p>
            </div>
        </div>
    </div>
</section>

<script>
// Career Path Tabs
const careerTabs = document.querySelectorAll('.career-tab');
const careerPanels = document.querySelectorAll('.career-panel');

careerTabs.forEach(tab => {
    tab.addEventListener('click', () => {
        const target = tab.getAttribute('data-tab');
        
        // Update tabs
        careerTabs.forEach(t => {
            t.classList.remove('active', 'bg-indigo-500', 'bg-cyan-500', 'bg-pink-500', 'bg-orange-500');
            t.classList.add('bg-slate-800', 'text-slate-300');
        });
        
        tab.classList.remove('bg-slate-800', 'text-slate-300');
        tab.classList.add('active', 'text-white');
        
        // Add appropriate color based on tab
        if (target === 'si') tab.classList.add('bg-indigo-500');
        else if (target === 'ec') tab.classList.add('bg-cyan-500');
        else if (target === 'gt') tab.classList.add('bg-pink-500');
        else if (target === 'ak') tab.classList.add('bg-orange-500');
        
        // Update panels
        careerPanels.forEach(panel => {
            panel.classList.add('hidden');
            panel.classList.remove('active');
        });
        
        const targetPanel = document.getElementById(`career-${target}`);
        if (targetPanel) {
            targetPanel.classList.remove('hidden');
            targetPanel.classList.add('active');
        }
    });
});
</script>