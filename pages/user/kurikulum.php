<?php
require_once '../../config.php';

// --- PERBAIKAN: Robust Data Loading ---

// 1. Load Data Konsentrasi
$konsentrasi_data = readJSON('konsentrasi');
if (!$konsentrasi_data) {
    // Fallback Manual
    $path = __DIR__ . '/../../data/konsentrasi.json';
    if (file_exists($path)) {
        $konsentrasi_data = json_decode(file_get_contents($path), true);
    }
}

// 2. Load Data Kurikulum (Mata Kuliah)
$kurikulum_data = readJSON('kurikulum');
if (!$kurikulum_data) {
    // Fallback Manual
    $path = __DIR__ . '/../../data/kurikulum.json';
    if (file_exists($path)) {
        $kurikulum_data = json_decode(file_get_contents($path), true);
    }
}

// Validasi Data Awal
$list_konsentrasi = (isset($konsentrasi_data) && isset($konsentrasi_data['konsentrasi'])) ? $konsentrasi_data['konsentrasi'] : [];
$raw_kurikulum = (isset($kurikulum_data) && isset($kurikulum_data['kurikulum'])) ? $kurikulum_data['kurikulum'] : [];

// --- PERBAIKAN UTAMA: Normalisasi Struktur Data Kurikulum ---
// Fungsi ini mengubah struktur JSON yang bersarang (nested) menjadi array flat yang mudah di-loop
$list_semester = [];

function normalizeKurikulum($data, &$result) {
    foreach ($data as $key => $value) {
        // Jika item ini sudah memiliki format yang benar (punya key 'mata_kuliah')
        if (is_array($value) && isset($value['mata_kuliah']) && isset($value['semester'])) {
            $result[] = $value;
            continue;
        }
        
        // Deteksi pola key "semester_X" (misal: semester_1, semester_2)
        if (is_string($key) && preg_match('/semester_(\d+)/i', $key, $matches)) {
            $sem_num = (int)$matches[1];
            // Jika value adalah array list mata kuliah (bukan container)
            if (is_array($value) && !empty($value) && isset(array_values($value)[0]['kode'])) {
                $result[] = [
                    'semester' => $sem_num,
                    'mata_kuliah' => $value
                ];
            } elseif (is_array($value)) {
                // Mungkin struktur lain, coba gali lebih dalam
                normalizeKurikulum($value, $result);
            }
        } elseif (is_array($value)) {
            // Jika ini container (misal: "semester_dasar"), cari ke dalamnya (rekursif)
            normalizeKurikulum($value, $result);
        }
    }
}

// Jalankan normalisasi
normalizeKurikulum($raw_kurikulum, $list_semester);

// Urutkan berdasarkan nomor semester
usort($list_semester, function($a, $b) {
    return $a['semester'] - $b['semester'];
});

// Hitung total SKS (Untuk statistik)
$total_sks = 0;
$total_mk = 0;
if (!empty($list_semester)) {
    foreach ($list_semester as $sem) {
        if (isset($sem['mata_kuliah'])) {
            foreach ($sem['mata_kuliah'] as $mk) {
                $total_sks += (int)($mk['sks'] ?? 0);
                $total_mk++;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kurikulum - SIEGA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../../assets/css/style.css">
    <!-- Alpine.js untuk interaktivitas Accordion -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-slate-900 text-white">
    <?php include '../../components/navbar.php'; ?>
    
    <!-- Hero Section -->
    <section class="pt-32 pb-12 bg-gradient-to-br from-cyan-900 via-slate-900 to-slate-900">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center">
                <div class="text-6xl mb-6">🗺️</div>
                <h1 class="text-5xl md:text-6xl font-bold mb-6">Kurikulum & Studi</h1>
                <p class="text-xl text-slate-300">Peta jalan akademik komprehensif untuk mencetak lulusan siap kerja</p>
                
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-8 max-w-2xl mx-auto">
                    <div class="bg-slate-800/50 p-4 rounded-lg border border-slate-700">
                        <div class="text-2xl font-bold text-cyan-400"><?= $total_sks > 0 ? $total_sks : 144 ?></div>
                        <div class="text-xs text-slate-400">Total SKS</div>
                    </div>
                    <div class="bg-slate-800/50 p-4 rounded-lg border border-slate-700">
                        <div class="text-2xl font-bold text-purple-400">8</div>
                        <div class="text-xs text-slate-400">Semester</div>
                    </div>
                    <div class="bg-slate-800/50 p-4 rounded-lg border border-slate-700">
                        <div class="text-2xl font-bold text-pink-400"><?= count($list_konsentrasi) ?></div>
                        <div class="text-xs text-slate-400">Konsentrasi</div>
                    </div>
                    <div class="bg-slate-800/50 p-4 rounded-lg border border-slate-700">
                        <div class="text-2xl font-bold text-orange-400">MBKM</div>
                        <div class="text-xs text-slate-400">Support</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Konsentrasi Section -->
    <section class="py-20 bg-slate-900">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold mb-12 text-center">🎯 Konsentrasi Studi</h2>
            
            <?php if (empty($list_konsentrasi)): ?>
                <div class="text-center text-slate-500 py-8 border border-dashed border-slate-700 rounded-xl">
                    Data konsentrasi tidak dapat dimuat.
                </div>
            <?php else: ?>
                <div class="grid md:grid-cols-2 gap-8 max-w-5xl mx-auto">
                    <?php foreach ($list_konsentrasi as $k): ?>
                    <div class="bg-slate-800 rounded-xl p-8 border border-slate-700 hover:border-cyan-500/50 transition group">
                        <div class="flex items-center gap-4 mb-4">
                            <!-- Fallback Icon jika class icon library tidak load -->
                            <div class="w-12 h-12 rounded-lg bg-cyan-900/50 flex items-center justify-center text-2xl group-hover:scale-110 transition">
                                <?php 
                                    $iconMap = [
                                        'database' => '🗄️', 
                                        'shopping-cart' => '🛒', 
                                        'gamepad' => '🎮', 
                                        'calculator' => '🧮'
                                    ];
                                    echo isset($iconMap[$k['icon']]) ? $iconMap[$k['icon']] : '🎓';
                                ?>
                            </div>
                            <h3 class="text-xl font-bold group-hover:text-cyan-400 transition"><?= htmlspecialchars($k['nama']) ?></h3>
                        </div>
                        <p class="text-slate-400 mb-6 leading-relaxed">
                            <?= htmlspecialchars($k['deskripsi_singkat'] ?? ($k['deskripsi'] ?? 'Deskripsi belum tersedia.')) ?>
                        </p>
                        
                        <?php if(isset($k['career_paths']) || isset($k['prospek_karir'])): ?>
                        <div class="space-y-2">
                            <div class="text-xs font-bold text-slate-500 uppercase tracking-wider">Prospek Karir:</div>
                            <div class="flex flex-wrap gap-2">
                                <?php 
                                    $careers = $k['career_paths'] ?? ($k['prospek_karir'] ?? []);
                                    foreach($careers as $pk): 
                                        $label = is_array($pk) ? $pk['title'] : $pk;
                                ?>
                                <span class="text-xs px-2 py-1 bg-slate-700 text-cyan-300 rounded">
                                    <?= htmlspecialchars($label) ?>
                                </span>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Mata Kuliah Accordion -->
    <section class="py-20 bg-slate-800">
        <div class="container mx-auto px-4 max-w-4xl">
            <h2 class="text-3xl font-bold mb-12 text-center">📚 Struktur Mata Kuliah</h2>
            
            <?php if (empty($list_semester)): ?>
                <div class="text-center py-12">
                    <p class="text-slate-400">Data kurikulum belum tersedia saat ini.</p>
                </div>
            <?php else: ?>
                <!-- Gunakan variabel terpisah untuk accordion index untuk menghindari error string key -->
                <div class="space-y-4" x-data="{ active: 1 }">
                    <?php 
                        // Karena sudah dinormalisasi, $list_semester adalah array index (0,1,2..)
                        // $smt['semester'] pasti ada dan berupa angka.
                        foreach ($list_semester as $smt): 
                            $smt_num = $smt['semester'];
                    ?>
                    
                    <div class="bg-slate-900 rounded-xl border border-slate-700 overflow-hidden">
                        <!-- Header Accordion -->
                        <button @click="active = active === <?= $smt_num ?> ? null : <?= $smt_num ?>" 
                                class="w-full px-6 py-4 flex items-center justify-between hover:bg-slate-800/50 transition">
                            <div class="flex items-center gap-4">
                                <span class="w-8 h-8 rounded-full bg-cyan-600 flex items-center justify-center font-bold text-sm">
                                    <?= $smt_num ?>
                                </span>
                                <span class="font-bold text-lg">Semester <?= $smt_num ?></span>
                                <span class="text-sm text-slate-500 hidden sm:inline-block">
                                    (<?= count($smt['mata_kuliah'] ?? []) ?> Mata Kuliah)
                                </span>
                            </div>
                            <!-- Icon Chevron -->
                            <svg class="w-5 h-5 text-slate-500 transform transition-transform duration-200" 
                                 :class="active === <?= $smt_num ?> ? 'rotate-180' : ''"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <!-- Content Accordion -->
                        <div x-show="active === <?= $smt_num ?>" 
                             x-collapse
                             class="border-t border-slate-800">
                            <div class="p-4 sm:p-6">
                                <?php if (isset($smt['mata_kuliah']) && !empty($smt['mata_kuliah'])): ?>
                                <div class="overflow-x-auto">
                                    <table class="w-full text-left border-collapse">
                                        <thead>
                                            <tr class="text-slate-400 text-sm border-b border-slate-700">
                                                <th class="py-3 pl-2">Kode</th>
                                                <th class="py-3">Mata Kuliah</th>
                                                <th class="py-3 text-center">SKS</th>
                                                <th class="py-3">Kategori</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-sm">
                                            <?php foreach ($smt['mata_kuliah'] as $mk): ?>
                                            <tr class="border-b border-slate-800/50 hover:bg-slate-800/30 transition">
                                                <td class="py-3 pl-2 font-mono text-cyan-400/80"><?= htmlspecialchars($mk['kode'] ?? '-') ?></td>
                                                <td class="py-3 font-semibold text-slate-200"><?= htmlspecialchars($mk['nama']) ?></td>
                                                <td class="py-3 text-center text-slate-400"><?= htmlspecialchars($mk['sks']) ?></td>
                                                <td class="py-3">
                                                    <span class="px-2 py-1 rounded text-xs <?= ($mk['kategori'] ?? '') == 'Wajib' ? 'bg-cyan-900/50 text-cyan-300' : 'bg-slate-700 text-slate-300' ?>">
                                                        <?= htmlspecialchars($mk['kategori'] ?? '-') ?>
                                                    </span>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <?php else: ?>
                                    <p class="text-slate-500 text-center text-sm py-4">Daftar mata kuliah belum diinput.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Download PDF -->
    <section class="py-12 border-t border-slate-800">
        <div class="container mx-auto px-4 text-center">
            <h3 class="text-xl font-bold mb-4">Butuh Panduan Akademik Lengkap?</h3>
            <div class="flex justify-center gap-4">
                <a href="#" class="flex items-center gap-2 px-6 py-3 bg-slate-800 hover:bg-slate-700 border border-slate-600 rounded-lg transition">
                    📕 Buku Pedoman Akademik
                </a>
                <a href="#" class="flex items-center gap-2 px-6 py-3 bg-cyan-600 hover:bg-cyan-700 rounded-lg font-semibold transition">
                    📄 Download Kurikulum PDF
                </a>
            </div>
        </div>
    </section>

    <?php include '../../components/footer.php'; ?>
    <script src="../../assets/js/main.js"></script>
</body>
</html>