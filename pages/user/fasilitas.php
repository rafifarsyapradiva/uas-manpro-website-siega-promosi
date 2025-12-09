<?php
require_once '../../config.php';

// --- PERBAIKAN: Robust Data Loading ---
// 1. Coba load menggunakan fungsi config
$fasilitas_data = readJSON('fasilitas');

// 2. Fallback Manual: Jika gagal (null), load langsung dari path absolut
if (!$fasilitas_data) {
    $path_fasilitas = __DIR__ . '/../../data/fasilitas.json';
    if (file_exists($path_fasilitas)) {
        $json_content = file_get_contents($path_fasilitas);
        $fasilitas_data = json_decode($json_content, true);
    }
}

// Validasi Data: Pastikan variabel ini selalu Array
$list_fasilitas = (isset($fasilitas_data) && isset($fasilitas_data['fasilitas'])) ? $fasilitas_data['fasilitas'] : [];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fasilitas - SIEGA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body class="bg-slate-900 text-white">
    <?php include '../../components/navbar.php'; ?>
    
    <!-- Hero Section -->
    <section class="pt-32 pb-12 bg-gradient-to-br from-cyan-900 via-slate-900 to-slate-900">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center">
                <div class="text-6xl mb-6">🏢</div>
                <h1 class="text-5xl md:text-6xl font-bold mb-6">Fasilitas Kampus</h1>
                <p class="text-xl text-slate-300">Sarana prasarana modern untuk mendukung pembelajaran kreatif dan inovatif</p>
            </div>
        </div>
    </section>

    <!-- Fasilitas Grid -->
    <section class="py-20 bg-slate-900">
        <div class="container mx-auto px-4">
            <?php if (empty($list_fasilitas)): ?>
                <!-- Tampilan jika data kosong -->
                <div class="text-center py-20 border border-dashed border-slate-700 rounded-xl">
                    <div class="text-4xl mb-4">🚧</div>
                    <h3 class="text-2xl font-bold text-slate-400">Belum ada data fasilitas</h3>
                    <p class="text-slate-500 mt-2">Data fasilitas sedang dalam proses update.</p>
                </div>
            <?php else: ?>
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <?php foreach ($list_fasilitas as $f): ?>
                    <div class="bg-slate-800 rounded-xl overflow-hidden hover:transform hover:-translate-y-2 transition duration-300 shadow-lg border border-slate-700 hover:border-cyan-500/50 flex flex-col h-full group">
                        <!-- Image Area -->
                        <div class="relative h-56 bg-slate-700 overflow-hidden">
                            <?php if(!empty($f['gambar'])): ?>
                                <img src="<?= htmlspecialchars($f['gambar']) ?>" 
                                     alt="<?= htmlspecialchars($f['nama']) ?>" 
                                     class="w-full h-full object-cover group-hover:scale-110 transition duration-500"
                                     onerror="this.src='https://placehold.co/600x400/1e293b/cbd5e1?text=Fasilitas+SIEGA'">
                            <?php else: ?>
                                <div class="w-full h-full flex items-center justify-center text-slate-500">
                                    <span class="text-6xl">🏢</span>
                                </div>
                            <?php endif; ?>
                            
                            <div class="absolute top-4 right-4">
                                <span class="px-3 py-1 bg-cyan-600/90 text-white text-xs font-bold rounded-full backdrop-blur-sm shadow-lg uppercase tracking-wider">
                                    <?= htmlspecialchars($f['kategori']) ?>
                                </span>
                            </div>
                        </div>
                        
                        <!-- Content Area -->
                        <div class="p-6 flex flex-col flex-grow">
                            <h3 class="text-2xl font-bold mb-3 group-hover:text-cyan-400 transition">
                                <?= htmlspecialchars($f['nama']) ?>
                            </h3>
                            
                            <div class="flex flex-wrap gap-4 text-sm text-slate-400 mb-4 border-b border-slate-700 pb-4">
                                <div class="flex items-center gap-1">
                                    📍 <?= htmlspecialchars($f['lokasi']) ?>
                                </div>
                                <div class="flex items-center gap-1">
                                    👥 <?= htmlspecialchars($f['kapasitas']) ?>
                                </div>
                            </div>
                            
                            <p class="text-slate-300 text-sm mb-6 leading-relaxed flex-grow">
                                <?= htmlspecialchars($f['deskripsi']) ?>
                            </p>

                            <!-- Features List (Software/Hardware/Fasilitas) -->
                            <?php 
                                // Gabungkan list fitur yang ada (software/hardware/fasilitas umum)
                                $features = $f['fasilitas'] ?? [];
                                if (empty($features) && isset($f['hardware'])) $features = $f['hardware'];
                                if (empty($features) && isset($f['software'])) $features = $f['software'];
                            ?>

                            <?php if (!empty($features)): ?>
                            <div class="bg-slate-900/50 p-4 rounded-lg mt-auto">
                                <div class="text-xs font-bold text-slate-500 uppercase mb-2">Kelengkapan Utama:</div>
                                <ul class="space-y-1">
                                    <?php foreach (array_slice($features, 0, 3) as $feature): ?>
                                    <li class="flex items-start gap-2 text-xs text-slate-300">
                                        <span class="text-cyan-500 mt-0.5">✓</span>
                                        <span><?= htmlspecialchars($feature) ?></span>
                                    </li>
                                    <?php endforeach; ?>
                                    <?php if (count($features) > 3): ?>
                                    <li class="text-xs text-slate-500 pl-4 italic">+<?= count($features) - 3 ?> lainnya</li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Virtual Tour CTA -->
    <section class="py-20 bg-slate-800 border-t border-slate-700">
        <div class="container mx-auto px-4 text-center">
            <div class="max-w-3xl mx-auto">
                <h2 class="text-4xl font-bold mb-4">Virtual Campus Tour</h2>
                <p class="text-xl text-slate-300 mb-8">Jelajahi setiap sudut kampus SIEGA secara virtual dari mana saja</p>
                <div class="aspect-video bg-slate-900 rounded-2xl border border-slate-700 flex items-center justify-center mb-8 relative group cursor-pointer overflow-hidden">
                    <div class="absolute inset-0 bg-cover bg-center opacity-50 group-hover:scale-105 transition duration-700" style="background-image: url('https://placehold.co/1280x720/1e293b/cbd5e1?text=Campus+View');"></div>
                    <button class="relative z-10 px-8 py-4 bg-white/10 backdrop-blur-md border border-white/30 text-white rounded-full font-bold hover:bg-white hover:text-cyan-900 transition transform hover:scale-105 flex items-center gap-2">
                        <span>🔍</span> Mulai Virtual Tour 360°
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Visit Us -->
    <section class="py-20 bg-gradient-to-r from-cyan-600 to-blue-600">
        <div class="container mx-auto px-4">
            <div class="max-w-3xl mx-auto text-center">
                <h2 class="text-4xl font-bold mb-6">Ingin Lihat Langsung?</h2>
                <p class="text-xl text-white/90 mb-8">Jadwalkan kunjungan kampus (Campus Visit) untuk melihat fasilitas kami secara langsung</p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="kontak.php" class="px-8 py-4 bg-white text-cyan-700 rounded-lg font-bold hover:bg-slate-100 transition shadow-lg">
                        📅 Jadwalkan Kunjungan
                    </a>
                    <a href="https://maps.google.com/?q=Unika+Soegijapranata" target="_blank" 
                       class="px-8 py-4 bg-cyan-800/50 backdrop-blur border border-white/30 text-white rounded-lg font-bold hover:bg-cyan-800 transition">
                        🗺️ Lokasi Kampus
                    </a>
                </div>
            </div>
        </div>
    </section>

    <?php include '../../components/footer.php'; ?>
    <script src="../../assets/js/main.js"></script>
</body>
</html>