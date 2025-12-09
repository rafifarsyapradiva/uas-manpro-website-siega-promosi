<?php
require_once '../../config.php';

// --- PERBAIKAN 1: Robust Data Loading ---
// Coba load pakai fungsi config
$biaya_data = readJSON('biaya_kuliah');

// Fallback: Jika gagal, load manual pakai path absolut direktori
if (!$biaya_data) {
    $path_biaya = __DIR__ . '/../../data/biaya_kuliah.json';
    if (file_exists($path_biaya)) {
        $json_content = file_get_contents($path_biaya);
        $biaya_data = json_decode($json_content, true);
    }
}

// PERBAIKAN 2 (Line 4): Cegah akses array offset on null
// Jika data kosong, inisialisasi sebagai array kosong
$biaya = (isset($biaya_data) && isset($biaya_data['biaya_kuliah'])) ? $biaya_data['biaya_kuliah'] : [];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biaya Kuliah - SIEGA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body class="bg-slate-900 text-white">
    <?php include '../../components/navbar.php'; ?>
    
    <!-- Hero Section -->
    <section class="pt-32 pb-12 bg-gradient-to-br from-orange-900 via-slate-900 to-slate-900">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center">
                <div class="text-6xl mb-6">💰</div>
                <h1 class="text-5xl md:text-6xl font-bold mb-6">Biaya Kuliah</h1>
                <p class="text-xl text-slate-300">Informasi lengkap biaya pendidikan di Program Studi SIEGA</p>
                <!-- PERBAIKAN LINE 27: Gunakan Null Coalescing Operator (??) -->
                <div class="mt-6 inline-block px-6 py-3 bg-orange-600/20 border border-orange-500 rounded-lg text-orange-300">
                    Tahun Akademik <?= htmlspecialchars($biaya['tahun_akademik'] ?? 'TBA') ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Info Box -->
    <section class="py-8 bg-slate-800 -mt-8 relative z-10 mx-4 md:mx-auto max-w-4xl rounded-xl shadow-xl border border-slate-700">
        <div class="grid md:grid-cols-3 gap-6 p-6 text-center">
            <!-- PERBAIKAN LINE 41-52: Cek dulu apakah key 'kontak_info' ada -->
            <div>
                <div class="text-2xl mb-2">🏢</div>
                <h3 class="font-bold text-slate-300">Bagian</h3>
                <p class="text-sm text-slate-400">
                    <?= htmlspecialchars($biaya['kontak_info']['bagian'] ?? 'Bagian Keuangan') ?>
                </p>
            </div>
            <div>
                <div class="text-2xl mb-2">📞</div>
                <h3 class="font-bold text-slate-300">Telepon</h3>
                <p class="text-sm text-slate-400">
                    <?= htmlspecialchars($biaya['kontak_info']['telepon'] ?? '-') ?>
                </p>
            </div>
            <div>
                <div class="text-2xl mb-2">💬</div>
                <h3 class="font-bold text-slate-300">WhatsApp</h3>
                <p class="text-sm text-slate-400">
                    <?= htmlspecialchars($biaya['kontak_info']['whatsapp'] ?? '-') ?>
                </p>
            </div>
        </div>
    </section>

    <!-- Biaya Awal -->
    <section class="py-20 bg-slate-900">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold mb-12 text-center text-orange-400">Biaya Awal Masuk</h2>
            
            <?php if (empty($biaya)): ?>
                <div class="text-center text-slate-500">Data biaya kuliah belum tersedia.</div>
            <?php else: ?>
                <div class="grid md:grid-cols-3 gap-8 max-w-6xl mx-auto">
                    <!-- PERBAIKAN LINE 66: Cek isset sebelum foreach -->
                    <?php if (isset($biaya['biaya_pendaftaran']) && is_array($biaya['biaya_pendaftaran'])): ?>
                        <?php foreach ($biaya['biaya_pendaftaran'] as $item): ?>
                        <div class="bg-slate-800 rounded-xl p-8 border border-slate-700 hover:border-orange-500 transition relative overflow-hidden group">
                            <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition text-6xl">
                                📝
                            </div>
                            <h3 class="text-xl font-bold mb-4 text-slate-200"><?= htmlspecialchars($item['jenis']) ?></h3>
                            <div class="text-3xl font-bold text-orange-400 mb-4">
                                Rp <?= number_format($item['nominal'], 0, ',', '.') ?>
                            </div>
                            <p class="text-slate-400 text-sm mb-4"><?= htmlspecialchars($item['keterangan']) ?></p>
                            <?php if(isset($item['catatan'])): ?>
                            <div class="text-xs bg-slate-900 p-2 rounded text-orange-300/80">
                                ℹ️ <?= htmlspecialchars($item['catatan']) ?>
                            </div>
                            <?php endif; ?>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-span-3 text-center text-slate-500">Detail biaya pendaftaran tidak ditemukan.</div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Biaya Semester -->
    <section class="py-20 bg-slate-800">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold mb-12 text-center text-cyan-400">Biaya Per Semester</h2>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-6xl mx-auto">
                <!-- PERBAIKAN LINE 93: Cek isset sebelum foreach -->
                <?php if (isset($biaya['biaya_semester']) && is_array($biaya['biaya_semester'])): ?>
                    <?php foreach ($biaya['biaya_semester'] as $smt): ?>
                    <div class="bg-slate-900 rounded-xl p-8 border border-slate-700 hover:border-cyan-500 transition">
                        <div class="flex justify-between items-start mb-6">
                            <div>
                                <h3 class="text-xl font-bold text-white"><?= htmlspecialchars($smt['komponen']) ?></h3>
                                <span class="text-xs text-slate-400"><?= htmlspecialchars($smt['frekuensi']) ?></span>
                            </div>
                            <div class="text-2xl">💳</div>
                        </div>
                        
                        <div class="text-3xl font-bold text-cyan-400 mb-6">
                            Rp <?= number_format($smt['nominal'], 0, ',', '.') ?>
                        </div>
                        
                        <ul class="space-y-2 text-sm text-slate-300">
                            <?php foreach($smt['rincian'] as $detail): ?>
                            <li class="flex items-center">
                                <span class="text-cyan-500 mr-2">✓</span> <?= htmlspecialchars($detail) ?>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Simulasi Total -->
    <?php if (isset($biaya['total_estimasi'])): ?>
    <section class="py-20 bg-slate-900">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto bg-gradient-to-br from-slate-800 to-slate-900 rounded-2xl p-8 border border-slate-700">
                <h2 class="text-2xl font-bold mb-8 text-center">📊 Estimasi Total Biaya</h2>
                
                <div class="space-y-6">
                    <!-- Tahun Pertama -->
                    <div class="flex flex-col md:flex-row justify-between items-center p-4 bg-slate-800/50 rounded-lg">
                        <div>
                            <h4 class="font-bold text-lg text-white">Tahun Pertama</h4>
                            <p class="text-sm text-slate-400">Termasuk uang pangkal & seragam</p>
                        </div>
                        <div class="text-2xl font-bold text-green-400 mt-2 md:mt-0">
                            Rp <?= number_format($biaya['total_estimasi']['tahun_pertama']['regular'] ?? 0, 0, ',', '.') ?>
                        </div>
                    </div>

                    <!-- Tahun Berikutnya -->
                    <div class="flex flex-col md:flex-row justify-between items-center p-4 bg-slate-800/50 rounded-lg">
                        <div>
                            <h4 class="font-bold text-lg text-white">Tahun Berikutnya (per tahun)</h4>
                            <p class="text-sm text-slate-400">Estimasi SPP & Praktikum</p>
                        </div>
                        <div class="text-2xl font-bold text-green-400 mt-2 md:mt-0">
                            Rp <?= number_format($biaya['total_estimasi']['per_tahun_berikutnya']['regular'] ?? 0, 0, ',', '.') ?>
                        </div>
                    </div>

                    <div class="border-t border-slate-700 pt-6 mt-6">
                        <div class="text-center">
                            <p class="text-slate-400 mb-2">Total Estimasi Sampai Lulus (4 Tahun)</p>
                            <div class="text-4xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-green-400 to-emerald-600">
                                Rp <?= number_format($biaya['total_estimasi']['total_4_tahun']['regular'] ?? 0, 0, ',', '.') ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Notes -->
                <div class="mt-8 p-4 bg-orange-900/20 border border-orange-900/50 rounded-lg">
                    <h5 class="text-orange-400 font-bold mb-2 text-sm">Catatan Penting:</h5>
                    <ul class="text-sm text-slate-300 space-y-1">
                        <?php if (isset($biaya['catatan_penting'])): ?>
                            <?php foreach ($biaya['catatan_penting'] as $catatan): ?>
                            <li class="flex items-start">
                                <span class="text-orange-400 mr-3 mt-1">•</span>
                                <span><?= htmlspecialchars($catatan) ?></span>
                            </li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- CTA Section -->
    <section class="py-12 bg-gradient-to-r from-indigo-600 to-cyan-600">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold mb-4">Butuh Konsultasi Lebih Lanjut?</h2>
            <p class="text-lg mb-6">Hubungi bagian keuangan untuk informasi detail dan skema pembayaran</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <?php 
                    $wa_number = isset($biaya['kontak_info']['whatsapp']) ? preg_replace('/[^0-9]/', '', $biaya['kontak_info']['whatsapp']) : '';
                ?>
                <?php if($wa_number): ?>
                <a href="https://wa.me/<?= $wa_number ?>" 
                   class="px-8 py-4 bg-green-600 hover:bg-green-700 rounded-lg font-semibold text-lg transition">
                    💬 Chat WhatsApp
                </a>
                <?php endif; ?>
                <a href="kontak.php" class="px-8 py-4 bg-white text-indigo-600 hover:bg-slate-100 rounded-lg font-semibold text-lg transition">
                    📧 Kirim Pesan
                </a>
            </div>
        </div>
    </section>

    <?php include '../../components/footer.php'; ?>
    <script src="../../assets/js/main.js"></script>
</body>
</html>