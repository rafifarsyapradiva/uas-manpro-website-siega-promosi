<?php
require_once '../../../config.php';

// 1. Coba baca data menggunakan fungsi bawaan
$konsentrasi_data = readJSON('konsentrasi');

// 2. ERROR HANDLING: Jika readJSON gagal (null), coba load manual dari path standar
if (!$konsentrasi_data) {
    $manual_path = '../../../data/konsentrasi.json'; 
    if (file_exists($manual_path)) {
        $json_content = file_get_contents($manual_path);
        $konsentrasi_data = json_decode($json_content, true);
    }
}

// 3. Validasi Data: Pastikan data benar-benar ada sebelum diproses
if (!$konsentrasi_data || !isset($konsentrasi_data['konsentrasi'])) {
    die("Error Fatal: Gagal memuat data 'konsentrasi.json'. Pastikan file ada di folder 'data' atau konfigurasi path benar.");
}

// 4. Proses Filter Data
$filtered = array_filter($konsentrasi_data['konsentrasi'], fn($x) => $x['id'] == 'game-technology');

// Cek apakah data ditemukan
if (empty($filtered)) {
    die("Error: Data dengan ID 'game-technology' tidak ditemukan di dalam JSON.");
}

// 5. Reset index array agar aman diakses dengan [0]
$k = array_values($filtered)[0];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $k['nama'] ?> - SIEGA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../../../assets/css/style.css">
</head>
<body class="bg-slate-900 text-white">
    <?php include '../../../components/navbar.php'; ?>
    
    <!-- Hero Section -->
    <section class="pt-32 pb-20 bg-gradient-to-br from-pink-900 via-slate-900 to-slate-900 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-20 left-20 w-96 h-96 bg-pink-500 rounded-full blur-3xl"></div>
            <div class="absolute bottom-20 right-20 w-96 h-96 bg-purple-500 rounded-full blur-3xl"></div>
        </div>
        <div class="container mx-auto px-4 relative z-10">
            <div class="max-w-4xl mx-auto text-center">
                <div class="text-7xl mb-6">🎮</div>
                <h1 class="text-5xl md:text-6xl font-bold mb-6"><?= $k['nama'] ?></h1>
                <p class="text-2xl text-pink-300 mb-6"><?= $k['nama_inggris'] ?></p>
                <p class="text-xl text-slate-300 leading-relaxed max-w-3xl mx-auto">
                    <?= $k['deskripsi_lengkap'] ?>
                </p>
            </div>
        </div>
    </section>

    <!-- Keunggulan -->
    <section class="py-20 bg-slate-900">
        <div class="container mx-auto px-4">
            <h2 class="text-4xl font-bold text-center mb-12">🌟 Keunggulan</h2>
            <div class="grid md:grid-cols-2 gap-6 max-w-4xl mx-auto">
                <?php foreach ($k['keunggulan'] as $keunggulan): ?>
                <div class="bg-slate-800 rounded-xl p-6 hover:bg-slate-750 transition flex items-start gap-4">
                    <span class="text-2xl flex-shrink-0 text-pink-400">✓</span>
                    <p class="text-slate-300"><?= $keunggulan ?></p>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Mata Kuliah Unggulan -->
    <section class="py-20 bg-slate-800">
        <div class="container mx-auto px-4">
            <h2 class="text-4xl font-bold text-center mb-12">📚 Mata Kuliah Unggulan</h2>
            <div class="grid md:grid-cols-4 gap-4 max-w-5xl mx-auto">
                <?php foreach ($k['mata_kuliah_unggulan'] as $mk): ?>
                <div class="bg-slate-900 rounded-lg p-4 hover:bg-pink-900/30 transition text-center">
                    <div class="text-3xl mb-2">📖</div>
                    <p class="text-sm font-semibold"><?= $mk ?></p>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Career Paths -->
    <section class="py-20 bg-slate-900">
        <div class="container mx-auto px-4">
            <h2 class="text-4xl font-bold text-center mb-12">💼 Prospek Karir</h2>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 max-w-6xl mx-auto">
                <?php foreach ($k['career_paths'] as $career): ?>
                <div class="bg-slate-800 rounded-xl p-6 hover:scale-105 transition">
                    <h3 class="text-xl font-bold mb-3 text-pink-400"><?= $career['title'] ?></h3>
                    <div class="mb-4">
                        <div class="text-sm text-slate-500 mb-1">Salary Range</div>
                        <div class="text-2xl font-bold text-green-400">Rp <?= $career['salary_range'] ?></div>
                    </div>
                    <div>
                        <div class="text-sm text-slate-500 mb-2">Target Companies:</div>
                        <div class="flex flex-wrap gap-2">
                            <?php foreach ($career['companies'] as $company): ?>
                            <span class="px-2 py-1 bg-slate-700 rounded text-xs"><?= $company ?></span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Game Tech Specific -->
    <section class="py-20 bg-slate-800">
        <div class="container mx-auto px-4">
            <h2 class="text-4xl font-bold text-center mb-12">🎮 Game Tech Ecosystem</h2>
            <div class="grid md:grid-cols-3 gap-6 max-w-5xl mx-auto">
                <div class="bg-slate-900 rounded-xl p-6 text-center">
                    <div class="text-5xl mb-4">👾</div>
                    <h3 class="font-bold mb-2">Game Engines</h3>
                    <p class="text-sm text-slate-400">Unity, Unreal Engine, Godot, Construct</p>
                </div>
                <div class="bg-slate-900 rounded-xl p-6 text-center">
                    <div class="text-5xl mb-4">🎨</div>
                    <h3 class="font-bold mb-2">Art & Design</h3>
                    <p class="text-sm text-slate-400">Blender, Maya, Photoshop, Illustrator</p>
                </div>
                <div class="bg-slate-900 rounded-xl p-6 text-center">
                    <div class="text-5xl mb-4">📱</div>
                    <h3 class="font-bold mb-2">Platforms</h3>
                    <p class="text-sm text-slate-400">PC, Mobile (Android/iOS), Console, WebGL</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Alumni Success -->
    <section class="py-20 bg-slate-900">
        <div class="container mx-auto px-4">
            <h2 class="text-4xl font-bold text-center mb-12">🎓 Alumni Sukses</h2>
            <div class="max-w-4xl mx-auto">
                <?php foreach ($k['alumni_success'] as $alumni): ?>
                <div class="bg-slate-800 rounded-xl p-8">
                    <div class="flex items-start gap-6">
                        <div class="w-20 h-20 bg-gradient-to-br from-pink-600 to-purple-600 rounded-full flex items-center justify-center text-3xl flex-shrink-0">
                            👤
                        </div>
                        <div class="flex-1">
                            <h3 class="text-2xl font-bold mb-2"><?= $alumni['nama'] ?></h3>
                            <p class="text-pink-400 font-semibold mb-1"><?= $alumni['posisi'] ?></p>
                            <p class="text-slate-400 mb-4"><?= $alumni['perusahaan'] ?> • Angkatan <?= $alumni['angkatan'] ?></p>
                            <blockquote class="border-l-4 border-pink-500 pl-4 italic text-slate-300">
                                "<?= $alumni['testimony'] ?>"
                            </blockquote>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="py-20 bg-gradient-to-r from-pink-600 to-purple-600">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-4xl font-bold mb-6">Level Up Your Career!</h2>
            <p class="text-xl mb-8">Wujudkan impian jadi Game Developer profesional</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="../kontak.php" class="px-8 py-4 bg-white text-pink-600 rounded-lg font-semibold hover:bg-slate-100 transition">
                    Hubungi Kami
                </a>
                <a href="index.php" class="px-8 py-4 bg-transparent border-2 border-white rounded-lg font-semibold hover:bg-white hover:text-pink-600 transition">
                    Lihat Konsentrasi Lain
                </a>
            </div>
        </div>
    </section>

    <?php include '../../../components/footer.php'; ?>
    <script src="../../../assets/js/main.js"></script>
</body>
</html>