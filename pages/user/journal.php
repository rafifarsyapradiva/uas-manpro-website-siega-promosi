<?php
require_once '../../config.php';

// --- PERBAIKAN: DATA LOADING YANG LEBIH KUAT ---
$journal_data = readJSON('journal');

// Fallback: Jika readJSON gagal, load manual dari path relatif
if (!$journal_data) {
    $path_journal = __DIR__ . '/../../data/journal.json';
    if (file_exists($path_journal)) {
        $json_content = file_get_contents($path_journal);
        $journal_data = json_decode($json_content, true);
    }
}

// PERBAIKAN LINE 9: Validasi sebelum akses array
// Jika null, set menjadi array kosong [] agar tidak error
$journal_list = (isset($journal_data) && isset($journal_data['journal'])) ? $journal_data['journal'] : [];

// Filter Parameters
$filter_jenis = $_GET['jenis'] ?? 'all';
$filter_kategori = $_GET['kategori'] ?? 'all';
$search = $_GET['search'] ?? '';

// Apply filters (Hanya jalan jika data ada)
if (!empty($journal_list)) {
    if ($filter_jenis != 'all') {
        $journal_list = array_filter($journal_list, function($j) use ($filter_jenis) {
            return $j['jenis'] == $filter_jenis;
        });
    }

    if ($filter_kategori != 'all') {
        $journal_list = array_filter($journal_list, function($j) use ($filter_kategori) {
            return $j['kategori'] == $filter_kategori;
        });
    }
    
    // Tambahan fitur search judul agar konsisten
    if ($search) {
        $journal_list = array_filter($journal_list, function($j) use ($search) {
            return stripos($j['judul'], $search) !== false || 
                   stripos(implode(' ', $j['penulis']), $search) !== false;
        });
    }
}

$kategori_list = ['Sistem Informasi', 'E-Commerce', 'Game Technology', 'Akuntansi-SI'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Publikasi Jurnal - SIEGA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body class="bg-slate-900 text-white">
    <?php include '../../components/navbar.php'; ?>
    
    <!-- Hero Section -->
    <section class="pt-32 pb-12 bg-gradient-to-br from-indigo-900 via-slate-900 to-slate-900">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center">
                <div class="text-6xl mb-6">📝</div>
                <h1 class="text-5xl md:text-6xl font-bold mb-6">Publikasi Ilmiah</h1>
                <p class="text-xl text-slate-300">Kumpulan jurnal nasional dan internasional karya dosen dan mahasiswa SIEGA</p>
            </div>
        </div>
    </section>

    <!-- Filter Section -->
    <section class="py-8 bg-slate-800 sticky top-20 z-10 shadow-xl">
        <div class="container mx-auto px-4">
            <form class="flex flex-col md:flex-row gap-4 justify-center max-w-4xl mx-auto">
                <div class="flex-grow md:w-1/3">
                    <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="Cari judul jurnal..." 
                           class="w-full px-4 py-3 rounded-lg bg-slate-700 border border-slate-600 focus:border-indigo-500 focus:outline-none">
                </div>
                <select name="jenis" class="px-4 py-3 rounded-lg bg-slate-700 border border-slate-600 focus:border-indigo-500 focus:outline-none">
                    <option value="all">Semua Jenis</option>
                    <option value="International" <?= $filter_jenis == 'International' ? 'selected' : '' ?>>International</option>
                    <option value="National" <?= $filter_jenis == 'National' ? 'selected' : '' ?>>National</option>
                </select>
                <select name="kategori" class="px-4 py-3 rounded-lg bg-slate-700 border border-slate-600 focus:border-indigo-500 focus:outline-none">
                    <option value="all">Semua Kategori</option>
                    <?php foreach($kategori_list as $kat): ?>
                    <option value="<?= $kat ?>" <?= $filter_kategori == $kat ? 'selected' : '' ?>><?= $kat ?></option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" class="px-8 py-2 bg-indigo-600 hover:bg-indigo-700 rounded-lg font-semibold transition">
                    Filter
                </button>
            </form>
        </div>
    </section>

    <!-- Journal List -->
    <section class="py-20 bg-slate-900">
        <div class="container mx-auto px-4">
            <!-- PERBAIKAN: Cek apakah array kosong untuk mencegah Fatal Error count() -->
            <?php if (empty($journal_list)): ?>
                <div class="text-center py-10">
                    <div class="text-6xl mb-4">📭</div>
                    <h3 class="text-2xl font-bold text-slate-400">Belum ada data jurnal</h3>
                    <p class="text-slate-500 mt-2">Data tidak ditemukan atau terjadi kesalahan saat memuat database.</p>
                </div>
            <?php else: ?>
                <div class="grid gap-8 max-w-5xl mx-auto">
                    <?php foreach ($journal_list as $j): ?>
                    <article class="bg-slate-800 rounded-xl p-8 border border-slate-700 hover:border-indigo-500/50 transition group">
                        <div class="flex flex-wrap gap-3 mb-4">
                            <span class="px-3 py-1 <?= $j['jenis'] == 'International' ? 'bg-purple-900/50 text-purple-300' : 'bg-green-900/50 text-green-300' ?> rounded-full text-xs font-semibold uppercase tracking-wider">
                                <?= htmlspecialchars($j['jenis']) ?> Journal
                            </span>
                            <span class="px-3 py-1 bg-indigo-900/50 text-indigo-300 rounded-full text-xs font-semibold">
                                <?= htmlspecialchars($j['kategori']) ?>
                            </span>
                            <span class="px-3 py-1 bg-slate-700 text-slate-300 rounded-full text-xs">
                                <?= htmlspecialchars($j['tahun']) ?>
                            </span>
                        </div>
                        
                        <h2 class="text-2xl font-bold mb-4 group-hover:text-indigo-400 transition">
                            <a href="<?= htmlspecialchars($j['link'] ?? '#') ?>" target="_blank">
                                <?= htmlspecialchars($j['judul']) ?>
                            </a>
                        </h2>
                        
                        <div class="mb-4 text-slate-300 text-sm">
                            <span class="text-slate-500">Penulis:</span> 
                            <?= htmlspecialchars(implode(', ', $j['penulis'])) ?>
                        </div>

                        <div class="bg-slate-900/50 rounded-lg p-4 mb-6 border border-slate-700/50">
                            <p class="text-slate-400 text-sm italic">
                                "<?= htmlspecialchars($j['nama_jurnal']) ?>, <?= htmlspecialchars($j['volume']) ?>, <?= htmlspecialchars($j['nomor']) ?>"
                            </p>
                            <?php if (isset($j['doi'])): ?>
                            <div class="mt-2 text-xs text-indigo-400 font-mono">
                                DOI: <?= htmlspecialchars($j['doi']) ?>
                            </div>
                            <?php endif; ?>
                        </div>
                        
                        <p class="text-slate-300 mb-6 leading-relaxed">
                            <?= htmlspecialchars($j['abstrak']) ?>
                        </p>
                        
                        <div class="flex flex-wrap items-center justify-between gap-4 pt-6 border-t border-slate-700">
                            <div class="flex flex-wrap gap-2">
                                <?php if(isset($j['indexed']) && is_array($j['indexed'])): ?>
                                    <?php foreach($j['indexed'] as $idx): ?>
                                    <span class="flex items-center gap-1 text-xs text-slate-400 bg-slate-900 px-2 py-1 rounded">
                                        ✅ <?= htmlspecialchars($idx) ?>
                                    </span>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                            
                            <div class="flex gap-3">
                                <?php if (isset($j['link'])): ?>
                                <a href="<?= htmlspecialchars($j['link']) ?>" target="_blank" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 rounded-lg text-sm font-semibold transition">
                                    🌐 Visit Journal
                                </a>
                                <?php endif; ?>
                                <button onclick="copyDOI('<?= isset($j['doi']) ? $j['doi'] : '' ?>')" class="px-4 py-2 border border-slate-600 hover:bg-slate-700 rounded-lg text-sm font-semibold transition">
                                    📋 Copy DOI
                                </button>
                            </div>
                        </div>
                    </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Info Section -->
    <section class="py-12 bg-slate-800">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto bg-slate-900 rounded-xl p-8">
                <h3 class="text-2xl font-bold mb-4">ℹ️ Tentang Publikasi Jurnal</h3>
                <div class="space-y-4 text-slate-300">
                    <p>• Publikasi jurnal merupakan output penelitian dosen dan mahasiswa SIEGA</p>
                    <p>• Jurnal internasional terindeks di database seperti Scopus, Web of Science, IEEE Xplore</p>
                    <p>• Jurnal nasional terakreditasi Sinta 2 atau lebih tinggi</p>
                    <p>• Mahasiswa berkesempatan menjadi co-author dalam publikasi penelitian</p>
                    <p>• Publikasi berkualitas menjadi salah satu indikator keunggulan program studi</p>
                </div>
            </div>
        </div>
    </section>

    <?php include '../../components/footer.php'; ?>
    
    <script src="../../assets/js/main.js"></script>
    <script>
    function copyDOI(doi) {
        if (doi) {
            navigator.clipboard.writeText(doi).then(() => {
                alert('DOI copied to clipboard!');
            });
        } else {
            alert('DOI not available');
        }
    }
    </script>
</body>
</html>