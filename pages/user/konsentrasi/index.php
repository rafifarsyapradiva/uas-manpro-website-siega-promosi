<?php
require_once '../../../config.php';

// Mengambil data
$konsentrasi_data = readJSON('konsentrasi');

// PERBAIKAN: Fallback Loading
// Jika readJSON gagal (biasanya karena masalah path relatif di sub-folder),
// kita coba load file secara manual menggunakan path absolut berdasarkan lokasi file ini.
if (!$konsentrasi_data) {
    $manual_path = __DIR__ . '/../../../data/konsentrasi.json';
    if (file_exists($manual_path)) {
        $json_content = file_get_contents($manual_path);
        $konsentrasi_data = json_decode($json_content, true);
    }
}

// Validasi akhir: Jika masih gagal atau struktur salah, set array kosong agar tidak error
if (!$konsentrasi_data || !isset($konsentrasi_data['konsentrasi'])) {
    $konsentrasi_data = ['konsentrasi' => []];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konsentrasi - SIEGA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../../../assets/css/style.css">
</head>
<body class="bg-slate-900 text-white">
    <?php include '../../../components/navbar.php'; ?>
    
    <!-- Hero Section -->
    <section class="pt-32 pb-20 bg-gradient-to-br from-indigo-900 via-slate-900 to-slate-900">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center">
                <h1 class="text-5xl md:text-6xl font-bold mb-6">4 Konsentrasi Unggulan</h1>
                <p class="text-xl text-slate-300 mb-8">
                    Pilih jalur karir yang sesuai dengan passion dan minat Anda. 
                    Setiap konsentrasi dirancang untuk mempersiapkan lulusan yang siap kerja di industri.
                </p>
            </div>
        </div>
    </section>

    <!-- Konsentrasi Grid -->
    <section class="py-20 bg-slate-900">
        <div class="container mx-auto px-4">
            <!-- Pesan Error (Hanya muncul jika data benar-benar tidak terbaca setelah fallback) -->
            <?php if (empty($konsentrasi_data['konsentrasi'])): ?>
                <div class="text-center text-slate-400 py-10">
                    <p class="text-xl font-bold text-red-400">Gagal Memuat Data</p>
                    <p class="mt-2">File data/konsentrasi.json ada, tetapi tidak terbaca.</p>
                    <p class="text-sm mt-1">Debug Path: <?= __DIR__ . '/../../../data/konsentrasi.json' ?></p>
                </div>
            <?php else: ?>
            
            <div class="grid md:grid-cols-2 gap-8">
                <?php foreach ($konsentrasi_data['konsentrasi'] as $k): ?>
                <a href="<?= isset($k['id']) ? $k['id'] : '#' ?>.php" 
                   class="group relative bg-slate-800 rounded-2xl p-8 hover:bg-slate-700 transition duration-300 overflow-hidden">
                    <!-- Background Gradient -->
                    <div class="absolute top-0 right-0 w-64 h-64 opacity-10 rounded-full blur-3xl" 
                         style="background: <?= isset($k['color']) ? $k['color'] : '#4f46e5' ?>"></div>
                    
                    <div class="relative z-10">
                        <!-- Icon -->
                        <div class="text-6xl mb-6">
                            <?php 
                            $icons = [
                                'database' => '🖥️',
                                'shopping-cart' => '🛒',
                                'gamepad' => '🎮',
                                'calculator' => '💼'
                            ];
                            echo $icons[$k['icon'] ?? ''] ?? '📊';
                            ?>
                        </div>
                        
                        <!-- Title -->
                        <h2 class="text-3xl font-bold mb-3 group-hover:text-indigo-400 transition">
                            <?= isset($k['nama']) ? $k['nama'] : 'Nama Konsentrasi' ?>
                        </h2>
                        <p class="text-slate-400 mb-4 text-lg"><?= isset($k['nama_inggris']) ? $k['nama_inggris'] : '' ?></p>
                        
                        <!-- Description -->
                        <p class="text-slate-300 mb-6 leading-relaxed">
                            <?= isset($k['deskripsi_singkat']) ? $k['deskripsi_singkat'] : '' ?>
                        </p>
                        
                        <!-- Keunggulan Preview -->
                        <div class="space-y-2 mb-6">
                            <?php 
                            if (isset($k['keunggulan']) && is_array($k['keunggulan'])):
                                foreach (array_slice($k['keunggulan'], 0, 3) as $keunggulan): 
                            ?>
                            <div class="flex items-start text-sm text-slate-400">
                                <span class="text-green-400 mr-2">✓</span>
                                <span><?= $keunggulan ?></span>
                            </div>
                            <?php 
                                endforeach; 
                            endif;
                            ?>
                        </div>
                        
                        <!-- Career Preview -->
                        <div class="mb-6">
                            <div class="text-sm text-slate-500 mb-2">Career Paths:</div>
                            <div class="flex flex-wrap gap-2">
                                <?php 
                                if (isset($k['career_paths']) && is_array($k['career_paths'])):
                                    foreach (array_slice($k['career_paths'], 0, 3) as $career): 
                                ?>
                                <span class="px-3 py-1 bg-slate-700 rounded-full text-xs">
                                    <?= isset($career['title']) ? $career['title'] : '' ?>
                                </span>
                                <?php 
                                    endforeach;
                                endif; 
                                ?>
                            </div>
                        </div>
                        
                        <!-- CTA -->
                        <div class="flex items-center text-indigo-400 font-semibold group-hover:gap-3 transition-all">
                            Selengkapnya 
                            <svg class="w-5 h-5 ml-2 group-hover:translate-x-2 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Comparison Table -->
    <?php if (!empty($konsentrasi_data['konsentrasi'])): ?>
    <section class="py-20 bg-slate-800">
        <div class="container mx-auto px-4">
            <h2 class="text-4xl font-bold text-center mb-12">Perbandingan Konsentrasi</h2>
            <div class="overflow-x-auto">
                <table class="w-full bg-slate-900 rounded-xl overflow-hidden">
                    <thead class="bg-slate-700">
                        <tr>
                            <th class="px-6 py-4 text-left">Aspek</th>
                            <?php foreach ($konsentrasi_data['konsentrasi'] as $k): ?>
                            <th class="px-6 py-4 text-center"><?= isset($k['nama']) ? $k['nama'] : '' ?></th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800">
                        <tr>
                            <td class="px-6 py-4 font-semibold">Focus Area</td>
                            <td class="px-6 py-4 text-center text-sm">Business & IT</td>
                            <td class="px-6 py-4 text-center text-sm">Digital Business</td>
                            <td class="px-6 py-4 text-center text-sm">Game & Multimedia</td>
                            <td class="px-6 py-4 text-center text-sm">Accounting & IT</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 font-semibold">Durasi</td>
                            <td class="px-6 py-4 text-center">4 Tahun</td>
                            <td class="px-6 py-4 text-center">4 Tahun</td>
                            <td class="px-6 py-4 text-center">4 Tahun</td>
                            <td class="px-6 py-4 text-center text-orange-400 font-bold">4.5 Tahun</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 font-semibold">Gelar</td>
                            <td class="px-6 py-4 text-center">S.Kom</td>
                            <td class="px-6 py-4 text-center">S.Kom</td>
                            <td class="px-6 py-4 text-center">S.Kom</td>
                            <td class="px-6 py-4 text-center text-orange-400 font-bold">S.Kom + S.Ak</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 font-semibold">Starting Salary</td>
                            <td class="px-6 py-4 text-center">8-15 jt</td>
                            <td class="px-6 py-4 text-center">7-14 jt</td>
                            <td class="px-6 py-4 text-center">8-16 jt</td>
                            <td class="px-6 py-4 text-center">12-25 jt</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- FAQ -->
    <section class="py-20 bg-slate-900">
        <div class="container mx-auto px-4">
            <h2 class="text-4xl font-bold text-center mb-12">Pertanyaan Umum</h2>
            <div class="max-w-3xl mx-auto space-y-4">
                <div class="bg-slate-800 rounded-xl p-6">
                    <h3 class="font-bold mb-2">Kapan saya harus memilih konsentrasi?</h3>
                    <p class="text-slate-400">Mahasiswa memilih konsentrasi di semester 3 setelah menyelesaikan mata kuliah dasar.</p>
                </div>
                <div class="bg-slate-800 rounded-xl p-6">
                    <h3 class="font-bold mb-2">Apakah bisa pindah konsentrasi?</h3>
                    <p class="text-slate-400">Ya, mahasiswa dapat pindah konsentrasi maksimal di semester 4 dengan persetujuan program studi.</p>
                </div>
                <div class="bg-slate-800 rounded-xl p-6">
                    <h3 class="font-bold mb-2">Apa keuntungan program double degree?</h3>
                    <p class="text-slate-400">Program Akuntansi-SI memberikan 2 gelar (S.Kom + S.Ak) sehingga lulusan memiliki kompetensi ganda dan peluang karir lebih luas.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="py-20 bg-gradient-to-r from-indigo-600 to-cyan-600">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-4xl font-bold mb-6">Masih Bingung Pilih Konsentrasi?</h2>
            <p class="text-xl mb-8">Konsultasi dengan kami atau coba quiz interaktif untuk menemukan konsentrasi yang cocok</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="../kontak.php" class="px-8 py-4 bg-white text-indigo-600 rounded-lg font-semibold text-lg hover:bg-slate-100 transition">
                    Konsultasi Sekarang
                </a>
                <a href="../quiz.php" class="px-8 py-4 bg-transparent border-2 border-white rounded-lg font-semibold text-lg hover:bg-white hover:text-indigo-600 transition">
                    Coba Quiz
                </a>
            </div>
        </div>
    </section>

    <?php include '../../../components/footer.php'; ?>
    <script src="../../../assets/js/main.js"></script>
</body>
</html>