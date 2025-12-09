<?php
require_once '../../config.php';

// --- PERBAIKAN: Robust Data Loading ---
// 1. Coba load menggunakan fungsi config
$alumni_data = readJSON('alumni');

// 2. Fallback Manual: Jika gagal (null), load langsung dari path absolut
if (!$alumni_data) {
    $path_alumni = __DIR__ . '/../../data/alumni.json';
    if (file_exists($path_alumni)) {
        $json_content = file_get_contents($path_alumni);
        $alumni_data = json_decode($json_content, true);
    }
}

// Validasi Data: Pastikan variabel ini selalu Array
$alumni_list = (isset($alumni_data) && isset($alumni_data['alumni'])) ? $alumni_data['alumni'] : [];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumni Success Stories - SIEGA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body class="bg-slate-900 text-white">
    <?php include '../../components/navbar.php'; ?>
    
    <!-- Hero Section -->
    <section class="pt-32 pb-12 bg-gradient-to-br from-green-900 via-slate-900 to-slate-900">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center">
                <div class="text-6xl mb-6">🎓</div>
                <h1 class="text-5xl md:text-6xl font-bold mb-6">Alumni Success Stories</h1>
                <p class="text-xl text-slate-300">Kisah inspiratif para alumni SIEGA yang sukses berkarir di berbagai industri</p>
            </div>
        </div>
    </section>

    <!-- Stats -->
    <section class="py-12 bg-slate-800 border-y border-slate-700">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                <div>
                    <div class="text-3xl font-bold text-green-400 mb-1">1000+</div>
                    <div class="text-sm text-slate-400">Alumni Tersebar</div>
                </div>
                <div>
                    <div class="text-3xl font-bold text-green-400 mb-1">90%</div>
                    <div class="text-sm text-slate-400">Kerja < 3 Bulan</div>
                </div>
                <div>
                    <div class="text-3xl font-bold text-green-400 mb-1">50+</div>
                    <div class="text-sm text-slate-400">Startup Founder</div>
                </div>
                <div>
                    <div class="text-3xl font-bold text-green-400 mb-1">Global</div>
                    <div class="text-sm text-slate-400">Karir Internasional</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Alumni List -->
    <section class="py-20 bg-slate-900">
        <div class="container mx-auto px-4">
            <?php if (empty($alumni_list)): ?>
                <!-- Tampilan jika data kosong -->
                <div class="text-center py-20 border border-dashed border-slate-700 rounded-xl">
                    <div class="text-4xl mb-4">📭</div>
                    <h3 class="text-2xl font-bold text-slate-400">Belum ada data alumni</h3>
                    <p class="text-slate-500 mt-2">Data alumni sedang dalam proses pembaruan.</p>
                </div>
            <?php else: ?>
                <div class="grid gap-8">
                    <?php foreach ($alumni_list as $a): ?>
                    <div class="bg-slate-800 rounded-2xl p-8 border border-slate-700 hover:border-green-500/50 transition flex flex-col md:flex-row gap-8 items-start">
                        <!-- Profile Photo -->
                        <div class="w-full md:w-1/3 lg:w-1/4 flex-shrink-0">
                            <div class="aspect-square rounded-xl overflow-hidden bg-slate-700 mb-4 relative group">
                                <?php if(!empty($a['foto'])): ?>
                                    <img src="<?= htmlspecialchars($a['foto']) ?>" 
                                         alt="<?= htmlspecialchars($a['nama']) ?>" 
                                         class="w-full h-full object-cover group-hover:scale-110 transition duration-500"
                                         onerror="this.src='https://placehold.co/400x400/1e293b/cbd5e1?text=Alumni+Photo'">
                                <?php else: ?>
                                    <div class="w-full h-full flex items-center justify-center text-slate-500 text-6xl">👤</div>
                                <?php endif; ?>
                                
                                <div class="absolute bottom-0 left-0 w-full p-4 bg-gradient-to-t from-slate-900/90 to-transparent">
                                    <div class="flex gap-2 justify-center">
                                        <?php if(isset($a['linkedin'])): ?>
                                        <a href="<?= htmlspecialchars($a['linkedin']) ?>" target="_blank" class="p-2 bg-blue-600 rounded-full hover:bg-blue-700 transition" title="LinkedIn">
                                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                                        </a>
                                        <?php endif; ?>
                                        <?php if(isset($a['artstation'])): ?>
                                        <a href="<?= htmlspecialchars($a['artstation']) ?>" target="_blank" class="p-2 bg-slate-600 rounded-full hover:bg-slate-500 transition" title="Portfolio">
                                            🎨
                                        </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="flex-grow w-full">
                            <div class="flex flex-wrap justify-between items-start gap-4 mb-4">
                                <div>
                                    <h3 class="text-2xl font-bold mb-1"><?= htmlspecialchars($a['nama']) ?></h3>
                                    <p class="text-green-400 font-semibold text-lg">
                                        <?= htmlspecialchars($a['posisi_saat_ini']) ?> at <?= htmlspecialchars($a['perusahaan']) ?>
                                    </p>
                                    <div class="text-sm text-slate-400 mt-1 flex items-center gap-2">
                                        <span>📍 <?= htmlspecialchars($a['lokasi']) ?></span>
                                        <span>•</span>
                                        <span>🎓 Angkatan <?= htmlspecialchars($a['angkatan']) ?> (Lulus <?= htmlspecialchars($a['tahun_lulus']) ?>)</span>
                                    </div>
                                </div>
                                <span class="px-4 py-2 bg-slate-700 rounded-lg text-sm font-semibold border border-slate-600">
                                    Konsentrasi: <?= htmlspecialchars($a['konsentrasi']) ?>
                                </span>
                            </div>

                            <div class="bg-slate-900/50 p-6 rounded-xl mb-6 relative">
                                <span class="absolute top-4 left-4 text-4xl text-slate-700">"</span>
                                <p class="text-slate-300 italic relative z-10 pl-6">
                                    <?= htmlspecialchars($a['testimony']) ?>
                                </p>
                            </div>

                            <div class="grid md:grid-cols-2 gap-6">
                                <div>
                                    <h4 class="text-sm font-bold text-slate-500 uppercase mb-3">Prestasi & Pencapaian</h4>
                                    <ul class="space-y-2">
                                        <?php foreach($a['prestasi'] as $p): ?>
                                        <li class="flex items-start gap-2 text-sm text-slate-300">
                                            <span class="text-green-500 mt-1">🏆</span>
                                            <span><?= htmlspecialchars($p) ?></span>
                                        </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-slate-500 uppercase mb-3">Career Journey</h4>
                                    <div class="text-sm text-slate-300 pl-4 border-l-2 border-slate-700 relative">
                                        <span class="absolute -left-[5px] top-0 w-2 h-2 rounded-full bg-slate-500"></span>
                                        <?= htmlspecialchars($a['career_journey']) ?>
                                    </div>
                                    
                                    <?php if(isset($a['tips'])): ?>
                                    <div class="mt-4 pt-4 border-t border-slate-700/50">
                                        <h4 class="text-xs font-bold text-green-500 uppercase mb-1">💡 Tips untuk Mahasiswa:</h4>
                                        <p class="text-sm text-slate-400 italic">"<?= htmlspecialchars($a['tips']) ?>"</p>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Career Stats (Pie Chart Placeholder) -->
    <section class="py-20 bg-slate-800">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12">Distribusi Karir Alumni</h2>
            <div class="grid md:grid-cols-3 gap-8 max-w-5xl mx-auto text-center">
                <div class="bg-slate-900 rounded-xl p-6">
                    <h3 class="font-bold mb-4 text-purple-400">Technology Sector</h3>
                    <div class="text-4xl font-bold mb-2">45%</div>
                    <p class="text-sm text-slate-400">Software houses, startups, tech companies</p>
                </div>
                <div class="bg-slate-900 rounded-xl p-6">
                    <h3 class="font-bold mb-4 text-cyan-400">Banking & Finance</h3>
                    <div class="text-4xl font-bold mb-2">30%</div>
                    <p class="text-sm text-slate-400">Banks, fintech, insurance companies</p>
                </div>
                <div class="bg-slate-900 rounded-xl p-6">
                    <h3 class="font-bold mb-4 text-pink-400">Other Industries</h3>
                    <div class="text-4xl font-bold mb-2">25%</div>
                    <p class="text-sm text-slate-400">Consulting, retail, manufacturing, etc</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="py-20 bg-gradient-to-r from-green-600 to-teal-600">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-4xl font-bold mb-6">Jadilah Bagian dari Success Story!</h2>
            <p class="text-xl mb-8">Bergabunglah dengan SIEGA dan mulai perjalanan karirmu</p>
            <a href="kontak.php" class="inline-block px-8 py-4 bg-white text-green-700 rounded-lg font-semibold hover:bg-slate-100 transition">
                Daftar Sekarang
            </a>
        </div>
    </section>

    <?php include '../../components/footer.php'; ?>
    <script src="../../assets/js/main.js"></script>
</body>
</html>