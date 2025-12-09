<?php
require_once '../../config.php';

// --- PERBAIKAN: Robust Data Loading ---
// 1. Coba load menggunakan fungsi bawaan config
$dosen_data = readJSON('dosen');

// 2. Fallback Manual: Jika readJSON gagal (return null), kita load paksa dari path absolut
// Ini mengatasi masalah path jika script dijalankan dari folder yang dalam
if (!$dosen_data) {
    $path_dosen = __DIR__ . '/../../data/dosen.json';
    if (file_exists($path_dosen)) {
        $json_content = file_get_contents($path_dosen);
        $dosen_data = json_decode($json_content, true);
    }
}

// PERBAIKAN: Validasi sebelum akses array
// Jika $dosen_data null atau tidak punya key 'dosen', gunakan array kosong
$list_dosen = (isset($dosen_data) && isset($dosen_data['dosen'])) ? $dosen_data['dosen'] : [];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dosen - SIEGA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body class="bg-slate-900 text-white">
    <?php include '../../components/navbar.php'; ?>
    
    <!-- Hero Section -->
    <section class="pt-32 pb-12 bg-gradient-to-br from-indigo-900 via-slate-900 to-slate-900">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center">
                <div class="text-6xl mb-6">👨‍🏫</div>
                <h1 class="text-5xl md:text-6xl font-bold mb-6">Dosen SIEGA</h1>
                <p class="text-xl text-slate-300">Tim pengajar berpengalaman dengan expertise di berbagai bidang teknologi informasi</p>
            </div>
        </div>
    </section>

    <!-- Dosen Grid -->
    <section class="py-20 bg-slate-900">
        <div class="container mx-auto px-4">
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php if (empty($list_dosen)): ?>
                    <!-- Tampilkan pesan ramah jika data gagal dimuat -->
                    <div class="col-span-full text-center py-20">
                        <div class="text-6xl mb-4">⚠️</div>
                        <h3 class="text-2xl font-bold text-slate-400 mb-2">Data Belum Tersedia</h3>
                        <p class="text-slate-500">Terjadi kesalahan saat memuat data dosen atau file database tidak ditemukan.</p>
                        <p class="text-xs text-slate-600 mt-4">Debug path: <?= htmlspecialchars(__DIR__ . '/../../data/dosen.json') ?></p>
                    </div>
                <?php else: ?>
                    <?php foreach ($list_dosen as $dosen): ?>
                    <div class="bg-slate-800 rounded-xl overflow-hidden hover:transform hover:scale-105 transition border border-slate-700 hover:border-indigo-500/50">
                        <div class="h-64 bg-gradient-to-br from-indigo-600 to-purple-600 flex items-center justify-center relative group">
                            <div class="text-8xl transform group-hover:scale-110 transition">👨‍🏫</div>
                            <div class="absolute bottom-0 left-0 w-full p-4 bg-gradient-to-t from-slate-900 to-transparent">
                                <span class="px-3 py-1 bg-indigo-500 text-white text-xs rounded-full shadow">
                                    NIDN: <?= htmlspecialchars($dosen['nidn'] ?? '-') ?>
                                </span>
                            </div>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold mb-2 min-h-[3.5rem]"><?= htmlspecialchars($dosen['nama']) ?></h3>
                            <p class="text-indigo-400 font-semibold mb-4 text-sm"><?= htmlspecialchars($dosen['posisi']) ?></p>
                            
                            <div class="mb-4">
                                <div class="text-xs uppercase tracking-wider text-slate-500 mb-2 font-bold">Pendidikan Terakhir</div>
                                <!-- Validasi: Tampilkan pendidikan terakhir (S3/S2) -->
                                <?php 
                                    if (is_array($dosen['pendidikan']) && count($dosen['pendidikan']) > 0) {
                                        $last_edu = $dosen['pendidikan'][0]; // Ambil pendidikan paling atas
                                        echo '<p class="text-sm text-slate-300">'.htmlspecialchars($last_edu['jenjang'] . ' - ' . $last_edu['universitas']).'</p>';
                                    } else {
                                        echo '<p class="text-sm text-slate-300">'.htmlspecialchars(is_string($dosen['pendidikan']) ? $dosen['pendidikan'] : '-').'</p>';
                                    }
                                ?>
                            </div>
                            
                            <div class="mb-4">
                                <div class="text-xs uppercase tracking-wider text-slate-500 mb-2 font-bold">Expertise</div>
                                <div class="flex flex-wrap gap-2">
                                    <?php if(isset($dosen['expertise']) && is_array($dosen['expertise'])): ?>
                                        <?php foreach (array_slice($dosen['expertise'], 0, 3) as $exp): ?>
                                        <span class="px-2 py-1 bg-indigo-900/30 border border-indigo-500/30 text-indigo-300 rounded text-xs">
                                            <?= htmlspecialchars($exp) ?>
                                        </span>
                                        <?php endforeach; ?>
                                        <?php if(count($dosen['expertise']) > 3): ?>
                                            <span class="px-2 py-1 text-slate-500 text-xs">+<?= count($dosen['expertise']) - 3 ?> lainnya</span>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <?php if (isset($dosen['kontak']['email'])): ?>
                            <div class="pt-4 border-t border-slate-700 mt-4">
                                <a href="mailto:<?= htmlspecialchars($dosen['kontak']['email']) ?>" class="flex items-center gap-2 text-sm text-slate-400 hover:text-indigo-400 transition">
                                    ✉️ Hubungi Dosen
                                </a>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Academic Credentials -->
    <section class="py-20 bg-slate-800">
        <div class="container mx-auto px-4">
            <h2 class="text-4xl font-bold text-center mb-12">🎓 Academic Excellence</h2>
            <div class="grid md:grid-cols-4 gap-6 max-w-5xl mx-auto">
                <div class="bg-slate-900 rounded-xl p-6 text-center border border-slate-700">
                    <div class="text-4xl font-bold text-indigo-400 mb-2">100%</div>
                    <p class="text-slate-400">Dosen S2/S3</p>
                </div>
                <div class="bg-slate-900 rounded-xl p-6 text-center border border-slate-700">
                    <div class="text-4xl font-bold text-cyan-400 mb-2">50+</div>
                    <p class="text-slate-400">Publikasi Jurnal</p>
                </div>
                <div class="bg-slate-900 rounded-xl p-6 text-center border border-slate-700">
                    <div class="text-4xl font-bold text-pink-400 mb-2">10+</div>
                    <p class="text-slate-400">Years Experience</p>
                </div>
                <div class="bg-slate-900 rounded-xl p-6 text-center border border-slate-700">
                    <div class="text-4xl font-bold text-orange-400 mb-2">20+</div>
                    <p class="text-slate-400">Industry Partners</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Research Areas -->
    <section class="py-20 bg-slate-900">
        <div class="container mx-auto px-4">
            <h2 class="text-4xl font-bold text-center mb-12">🔬 Research Areas</h2>
            <div class="grid md:grid-cols-3 gap-6 max-w-5xl mx-auto">
                <div class="bg-slate-800 rounded-xl p-6 border border-slate-700 hover:border-indigo-500 transition">
                    <div class="text-4xl mb-4">🤖</div>
                    <h3 class="text-xl font-bold mb-3">Artificial Intelligence</h3>
                    <p class="text-slate-400 text-sm">Machine Learning, Deep Learning, Computer Vision</p>
                </div>
                <div class="bg-slate-800 rounded-xl p-6 border border-slate-700 hover:border-indigo-500 transition">
                    <div class="text-4xl mb-4">💼</div>
                    <h3 class="text-xl font-bold mb-3">Business Intelligence</h3>
                    <p class="text-slate-400 text-sm">Data Analytics, Big Data, Decision Support Systems</p>
                </div>
                <div class="bg-slate-800 rounded-xl p-6 border border-slate-700 hover:border-indigo-500 transition">
                    <div class="text-4xl mb-4">🎮</div>
                    <h3 class="text-xl font-bold mb-3">Interactive Media</h3>
                    <p class="text-slate-400 text-sm">Game Development, VR/AR, Multimedia</p>
                </div>
                <div class="bg-slate-800 rounded-xl p-6 border border-slate-700 hover:border-indigo-500 transition">
                    <div class="text-4xl mb-4">🌐</div>
                    <h3 class="text-xl font-bold mb-3">E-Commerce</h3>
                    <p class="text-slate-400 text-sm">Digital Marketing, Online Business, Social Commerce</p>
                </div>
                <div class="bg-slate-800 rounded-xl p-6 border border-slate-700 hover:border-indigo-500 transition">
                    <div class="text-4xl mb-4">🔒</div>
                    <h3 class="text-xl font-bold mb-3">Cyber Security</h3>
                    <p class="text-slate-400 text-sm">Information Security, Network Security, Cryptography</p>
                </div>
                <div class="bg-slate-800 rounded-xl p-6 border border-slate-700 hover:border-indigo-500 transition">
                    <div class="text-4xl mb-4">📱</div>
                    <h3 class="text-xl font-bold mb-3">Mobile Technology</h3>
                    <p class="text-slate-400 text-sm">Mobile Apps, Cross-platform Development, IoT</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="py-20 bg-gradient-to-r from-indigo-600 to-purple-600">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-4xl font-bold mb-6">Belajar dari yang Terbaik!</h2>
            <p class="text-xl mb-8">Bergabunglah dengan SIEGA dan dapatkan bimbingan dari dosen berpengalaman</p>
            <a href="kontak.php" class="inline-block px-8 py-4 bg-white text-indigo-600 rounded-lg font-semibold hover:bg-slate-100 transition">
                Hubungi Kami
            </a>
        </div>
    </section>

    <?php include '../../components/footer.php'; ?>
    <script src="../../assets/js/main.js"></script>
</body>
</html>