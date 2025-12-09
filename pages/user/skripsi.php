<?php
require_once '../../config.php';

// --- BAGIAN PERBAIKAN DATA LOADING ---
// 1. Coba baca menggunakan fungsi bawaan config
$skripsi_data = readJSON('skripsi');
$konsentrasi_data = readJSON('konsentrasi');

// 2. Fallback Manual: Jika readJSON gagal (return null), kita load paksa dari path yang benar
// Ini mengatasi masalah path jika script dijalankan dari folder pages/user/
if (!$skripsi_data) {
    $path_skripsi = __DIR__ . '/../../data/skripsi.json';
    if (file_exists($path_skripsi)) {
        $json_content = file_get_contents($path_skripsi);
        $skripsi_data = json_decode($json_content, true);
    }
}

if (!$konsentrasi_data) {
    $path_konsentrasi = __DIR__ . '/../../data/konsentrasi.json';
    if (file_exists($path_konsentrasi)) {
        $json_content = file_get_contents($path_konsentrasi);
        $konsentrasi_data = json_decode($json_content, true);
    }
}
// -------------------------------------

// Validasi sebelum akses array
// Jika null, set menjadi array kosong []
$skripsi_list = (isset($skripsi_data) && isset($skripsi_data['skripsi'])) ? $skripsi_data['skripsi'] : [];

// Siapkan data konsentrasi untuk dropdown filter
$list_konsentrasi = (isset($konsentrasi_data) && isset($konsentrasi_data['konsentrasi'])) ? $konsentrasi_data['konsentrasi'] : [];

// Filter Parameters
$filter_konsentrasi = $_GET['konsentrasi'] ?? 'all';
$filter_tahun = $_GET['tahun'] ?? 'all';
$search = $_GET['search'] ?? '';

// Apply filters (Hanya jalan jika $skripsi_list tidak kosong)
if (!empty($skripsi_list)) {
    if ($filter_konsentrasi != 'all') {
        $skripsi_list = array_filter($skripsi_list, function($s) use ($filter_konsentrasi) {
            return $s['konsentrasi'] == $filter_konsentrasi;
        });
    }

    if ($filter_tahun != 'all') {
        $skripsi_list = array_filter($skripsi_list, function($s) use ($filter_tahun) {
            return $s['tahun'] == $filter_tahun;
        });
    }

    if ($search) {
        $skripsi_list = array_filter($skripsi_list, function($s) use ($search) {
            return stripos($s['judul'], $search) !== false || 
                   stripos($s['mahasiswa'], $search) !== false;
        });
    }
}

// Validasi array_column untuk dropdown tahun
$years = [];
$raw_skripsi = (isset($skripsi_data) && isset($skripsi_data['skripsi'])) ? $skripsi_data['skripsi'] : [];

if (!empty($raw_skripsi)) {
    $years = array_unique(array_column($raw_skripsi, 'tahun'));
    rsort($years);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skripsi & Tugas Akhir - SIEGA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body class="bg-slate-900 text-white">
    <?php include '../../components/navbar.php'; ?>
    
    <!-- Hero Section -->
    <section class="pt-32 pb-12 bg-gradient-to-br from-indigo-900 via-slate-900 to-slate-900">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center">
                <div class="text-6xl mb-6">📚</div>
                <h1 class="text-5xl md:text-6xl font-bold mb-6">Bank Skripsi</h1>
                <p class="text-xl text-slate-300">Koleksi tugas akhir dan skripsi mahasiswa Sistem Informasi</p>
            </div>
        </div>
    </section>

    <!-- Search & Filter -->
    <section class="py-8 bg-slate-800 sticky top-20 z-10 shadow-xl">
        <div class="container mx-auto px-4">
            <form class="grid md:grid-cols-4 gap-4 max-w-6xl mx-auto">
                <div class="md:col-span-2">
                    <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" 
                           placeholder="Cari judul atau nama mahasiswa..." 
                           class="w-full px-4 py-3 rounded-lg bg-slate-700 border border-slate-600 focus:border-indigo-500 focus:outline-none text-white placeholder-slate-400">
                </div>
                <div>
                    <select name="konsentrasi" class="w-full px-4 py-3 rounded-lg bg-slate-700 border border-slate-600 focus:border-indigo-500 focus:outline-none text-white">
                        <option value="all">Semua Konsentrasi</option>
                        <?php foreach($list_konsentrasi as $k): ?>
                        <option value="<?= htmlspecialchars($k['nama']) ?>" <?= $filter_konsentrasi == $k['nama'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($k['nama']) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <select name="tahun" class="w-full px-4 py-3 rounded-lg bg-slate-700 border border-slate-600 focus:border-indigo-500 focus:outline-none text-white">
                        <option value="all">Semua Tahun</option>
                        <?php foreach($years as $y): ?>
                        <option value="<?= $y ?>" <?= $filter_tahun == $y ? 'selected' : '' ?>><?= $y ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="md:col-span-4 text-center mt-2">
                    <button type="submit" class="px-8 py-2 bg-indigo-600 hover:bg-indigo-700 rounded-lg font-semibold transition">
                        Terapkan Filter
                    </button>
                    <?php if($search || $filter_konsentrasi != 'all' || $filter_tahun != 'all'): ?>
                    <a href="skripsi.php" class="ml-4 px-8 py-2 border border-slate-500 hover:bg-slate-800 rounded-lg text-slate-300 transition">
                        Reset
                    </a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </section>

    <!-- Skripsi List -->
    <section class="py-20 bg-slate-900">
        <div class="container mx-auto px-4">
            <?php if (empty($skripsi_list)): ?>
                <div class="text-center py-20">
                    <div class="text-6xl mb-4">🔍</div>
                    <h3 class="text-2xl font-bold text-slate-400 mb-2">Data Tidak Ditemukan</h3>
                    <p class="text-slate-500">
                        <?= empty($raw_skripsi) ? "Terjadi kesalahan saat memuat database skripsi." : "Coba ubah kata kunci pencarian atau filter anda." ?>
                    </p>
                    <?php if(empty($raw_skripsi)): ?>
                        <p class="text-xs text-slate-600 mt-2">Debug Path: <?= __DIR__ . '/../../data/skripsi.json' ?></p>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <div class="grid gap-6">
                    <?php foreach ($skripsi_list as $s): ?>
                    <div class="bg-slate-800 rounded-xl p-6 hover:bg-slate-750 transition border border-slate-700 hover:border-indigo-500/50">
                        <div class="flex flex-col md:flex-row gap-6">
                            <div class="flex-grow">
                                <div class="flex flex-wrap gap-2 mb-3">
                                    <span class="px-3 py-1 bg-indigo-900/50 text-indigo-300 rounded-full text-xs font-semibold">
                                        <?= htmlspecialchars($s['konsentrasi']) ?>
                                    </span>
                                    <span class="px-3 py-1 bg-slate-700 text-slate-300 rounded-full text-xs">
                                        <?= htmlspecialchars($s['tahun']) ?>
                                    </span>
                                </div>
                                <h3 class="text-xl font-bold mb-2 text-indigo-100">
                                    <a href="#" class="hover:text-indigo-400 transition"><?= htmlspecialchars($s['judul']) ?></a>
                                </h3>
                                <div class="text-sm text-slate-400 mb-4">
                                    Oleh: <span class="text-slate-200"><?= htmlspecialchars($s['mahasiswa']) ?></span> • 
                                    NIM: <?= htmlspecialchars($s['nim']) ?>
                                </div>
                                <p class="text-slate-300 text-sm line-clamp-3 mb-4">
                                    <?= htmlspecialchars($s['abstrak']) ?>
                                </p>
                                <div class="flex flex-wrap gap-2 text-xs">
                                    <?php foreach($s['keywords'] as $tag): ?>
                                    <span class="text-slate-500">#<?= htmlspecialchars($tag) ?></span>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <div class="md:w-64 flex-shrink-0 flex flex-col justify-between border-t md:border-t-0 md:border-l border-slate-700 pt-4 md:pt-0 md:pl-6">
                                <div>
                                    <div class="text-xs text-slate-500 mb-1">Pembimbing 1</div>
                                    <div class="text-sm font-semibold text-slate-300 mb-3"><?= htmlspecialchars($s['pembimbing1']) ?></div>
                                    
                                    <div class="text-xs text-slate-500 mb-1">Pembimbing 2</div>
                                    <div class="text-sm font-semibold text-slate-300"><?= htmlspecialchars($s['pembimbing2']) ?></div>
                                </div>
                                
                                <?php if (isset($s['file_pdf'])): ?>
                                <div class="mt-4">
                                    <a href="#" class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 rounded-lg transition w-full justify-center text-sm">
                                        📄 Download Abstract
                                    </a>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Info Section -->
    <section class="py-12 bg-slate-800">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto bg-slate-900 rounded-xl p-8">
                <h3 class="text-2xl font-bold mb-4">ℹ️ Informasi</h3>
                <ul class="space-y-3 text-slate-300">
                    <li>• Skripsi merupakan karya ilmiah mahasiswa sebagai syarat kelulusan program S1</li>
                    <li>• Setiap skripsi dibimbing oleh 2 dosen pembimbing yang berpengalaman</li>
                    <li>• Mahasiswa dapat memilih topik sesuai dengan konsentrasi yang diambil</li>
                    <li>• Beberapa skripsi terbaik dipublikasikan di jurnal ilmiah nasional/internasional</li>
                </ul>
            </div>
        </div>
    </section>

    <?php include '../../components/footer.php'; ?>
    <script src="../../assets/js/main.js"></script>
</body>
</html>