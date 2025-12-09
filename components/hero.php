<?php
/**
 * SIEGA Hero Section
 */

// LOGIKA PENENTUAN PATH (Standard)
$current_script = $_SERVER['PHP_SELF'];
$path = "./";
if (strpos($current_script, '/pages/user/konsentrasi/') !== false) {
    $path = "../../../";
} elseif (strpos($current_script, '/pages/user/') !== false) {
    $path = "../../";
}
?>

<section class="relative min-h-screen flex items-center overflow-hidden bg-gradient-to-br from-slate-900 via-indigo-900 to-slate-900">
    <!-- Grid Pattern Overlay -->
    <div class="absolute inset-0 bg-grid-pattern opacity-10"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-0">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            
            <!-- Text Content -->
            <div class="space-y-8 z-10">
                <div class="inline-block px-4 py-2 rounded-full bg-indigo-500/10 border border-indigo-500/20 backdrop-blur-sm">
                    <span class="text-indigo-400 font-semibold text-sm">🚀 Penerimaan Mahasiswa Baru Dibuka</span>
                </div>
                
                <h1 class="text-5xl md:text-6xl lg:text-7xl font-bold text-white leading-tight">
                    Harvest Your <br/>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-indigo-500">Future Here</span>
                </h1>
                
                <p class="text-lg text-slate-300 max-w-xl leading-relaxed">
                    Bergabunglah dengan program studi Sistem Informasi terbaik yang memadukan Teknologi, Bisnis, dan Kreativitas.
                </p>

                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="https://pmb.unika.ac.id" target="_blank" class="px-8 py-4 bg-gradient-to-r from-indigo-600 to-cyan-600 rounded-xl text-white font-bold shadow-lg shadow-indigo-500/30 hover:shadow-indigo-500/50 hover:scale-105 transition-all text-center">
                        Daftar Sekarang
                    </a>
                    <a href="<?= $path ?>pages/user/about.php" class="px-8 py-4 bg-slate-800/50 border border-slate-700 rounded-xl text-white font-semibold hover:bg-slate-800 hover:border-slate-600 transition-all text-center backdrop-blur-sm">
                        Pelajari Lebih Lanjut
                    </a>
                </div>
            </div>

            <!-- Image/Illustration -->
            <div class="relative hidden lg:block">
                <!-- Fallback ke URL online jika gambar lokal tidak ketemu, atau gunakan $path . 'assets/...' -->
                <div class="relative w-full aspect-square rounded-full bg-gradient-to-tr from-indigo-500/20 to-cyan-500/20 backdrop-blur-3xl animate-pulse"></div>
                <img src="<?= $path ?>assets/images/hero/hero-illustration.png" 
                     onerror="this.style.display='none'"
                     alt="SIEGA Student" 
                     class="relative z-10 w-full h-auto drop-shadow-2xl animate-float">
            </div>
        </div>
    </div>
</section>

<style>
@keyframes float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-20px); }
}
.animate-float {
    animation: float 6s ease-in-out infinite;
}
</style>