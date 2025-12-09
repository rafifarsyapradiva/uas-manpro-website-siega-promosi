<?php
require_once '../../config.php';

// --- PERBAIKAN: Robust Data Loading ---
// 1. Coba load menggunakan fungsi config
$prestasi_data = readJSON('prestasi');

// 2. Fallback Manual: Jika gagal (null), load langsung dari path absolut
if (!$prestasi_data) {
    $path_prestasi = __DIR__ . '/../../data/prestasi.json';
    if (file_exists($path_prestasi)) {
        $json_content = file_get_contents($path_prestasi);
        $prestasi_data = json_decode($json_content, true);
    }
}

// Validasi Data: Pastikan variabel ini selalu Array
$prestasi_list = (isset($prestasi_data) && isset($prestasi_data['prestasi'])) ? $prestasi_data['prestasi'] : [];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prestasi - SIEGA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body class="bg-slate-900 text-white">
    <?php include '../../components/navbar.php'; ?>
    
    <!-- Hero Section -->
    <section class="pt-32 pb-12 bg-gradient-to-br from-yellow-900 via-slate-900 to-slate-900">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center">
                <div class="text-6xl mb-6">🏆</div>
                <h1 class="text-5xl md:text-6xl font-bold mb-6">Prestasi & Penghargaan</h1>
                <p class="text-xl text-slate-300">Capaian gemilang mahasiswa dan dosen SIEGA di berbagai kompetisi dan konferensi</p>
            </div>
        </div>
    </section>

    <!-- Filter by Category -->
    <section class="py-8 bg-slate-800 border-y border-slate-700 sticky top-20 z-10 shadow-xl">
        <div class="container mx-auto px-4">
            <div class="flex flex-wrap justify-center gap-4">
                <button class="px-6 py-2 bg-indigo-600 rounded-full font-semibold transition hover:bg-indigo-700" data-filter="all">Semua</button>
                <button class="px-6 py-2 bg-slate-700 rounded-full font-semibold transition hover:bg-indigo-600" data-filter="Competition">Kompetisi</button>
                <button class="px-6 py-2 bg-slate-700 rounded-full font-semibold transition hover:bg-indigo-600" data-filter="Academic">Akademik</button>
                <button class="px-6 py-2 bg-slate-700 rounded-full font-semibold transition hover:bg-indigo-600" data-filter="International">Internasional</button>
            </div>
        </div>
    </section>

    <!-- Achievement Grid -->
    <section class="py-20 bg-slate-900">
        <div class="container mx-auto px-4">
            <?php if (empty($prestasi_list)): ?>
                <!-- Tampilan jika data kosong -->
                <div class="text-center py-20 border border-dashed border-slate-700 rounded-xl">
                    <div class="text-4xl mb-4">🎖️</div>
                    <h3 class="text-2xl font-bold text-slate-400">Belum ada data prestasi</h3>
                    <p class="text-slate-500 mt-2">Data prestasi sedang dalam proses input.</p>
                </div>
            <?php else: ?>
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- PERBAIKAN: Loop menggunakan variabel yang sudah divalidasi -->
                    <?php foreach ($prestasi_list as $p): ?>
                    <div class="bg-slate-800 rounded-xl overflow-hidden hover:transform hover:-translate-y-2 transition duration-300 shadow-lg border border-slate-700 hover:border-yellow-500/50 flex flex-col h-full" data-category="<?= htmlspecialchars($p['kategori'] ?? 'General') ?>">
                        <div class="relative h-56 bg-slate-700 overflow-hidden">
                            <!-- Label Kategori -->
                            <div class="absolute top-4 left-4 z-10">
                                <span class="px-3 py-1 bg-yellow-600/90 text-white text-xs font-bold rounded-full backdrop-blur-sm shadow-lg uppercase tracking-wider">
                                    <?= htmlspecialchars($p['kategori'] ?? 'Umum') ?>
                                </span>
                            </div>

                            <!-- Gambar Prestasi -->
                            <?php if(!empty($p['gambar'])): ?>
                                <img src="../../assets/images/prestasi/<?= htmlspecialchars($p['gambar']) ?>" 
                                     alt="<?= htmlspecialchars($p['judul']) ?>" 
                                     class="w-full h-full object-cover transition duration-500 hover:scale-110"
                                     onerror="this.src='https://placehold.co/600x400/1e293b/cbd5e1?text=Prestasi'">
                            <?php else: ?>
                                <div class="w-full h-full flex items-center justify-center text-slate-500">
                                    <span class="text-6xl">🏆</span>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="p-6 flex flex-col flex-grow">
                            <div class="text-sm text-yellow-400 font-bold mb-2">
                                <?= htmlspecialchars($p['tahun'] ?? '-') ?> • <?= htmlspecialchars($p['tingkat'] ?? 'Nasional') ?>
                            </div>
                            
                            <h3 class="text-xl font-bold mb-3 line-clamp-2"><?= htmlspecialchars($p['judul'] ?? 'Judul Tidak Tersedia') ?></h3>
                            
                            <div class="mb-4">
                                <div class="text-xs text-slate-500 uppercase tracking-wide mb-1">Pemenang:</div>
                                <div class="font-semibold text-slate-200">
                                    <!-- PERBAIKAN DISINI: Menambahkan operator ?? untuk fallback jika null -->
                                    <?= htmlspecialchars($p['pemenang'] ?? '-') ?>
                                </div>
                                <?php if(isset($p['anggota']) && is_array($p['anggota'])): ?>
                                    <div class="text-xs text-slate-400 mt-1">
                                        with <?= implode(', ', array_slice($p['anggota'], 0, 2)) ?>
                                        <?= count($p['anggota']) > 2 ? 'dkk.' : '' ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <p class="text-slate-400 text-sm mb-4 line-clamp-3 flex-grow">
                                <?= htmlspecialchars($p['deskripsi'] ?? '') ?>
                            </p>
                            
                            <div class="pt-4 border-t border-slate-700 mt-auto">
                                <div class="flex items-center justify-between text-xs text-slate-500">
                                    <span class="flex items-center gap-1">
                                        🏢 <?= htmlspecialchars($p['penyelenggara'] ?? '-') ?>
                                    </span>
                                    <?php if(isset($p['reward'])): ?>
                                    <span class="text-green-400 font-bold">
                                        🎁 <?= htmlspecialchars($p['reward']) ?>
                                    </span>
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

    <!-- CTA -->
    <section class="py-20 bg-gradient-to-r from-yellow-600 to-orange-600">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-4xl font-bold mb-6">Raih Prestasimu Bersama SIEGA!</h2>
            <p class="text-xl mb-8">Wujudkan potensi terbaikmu dan ukir prestasi gemilang</p>
            <a href="kontak.php" class="inline-block px-8 py-4 bg-white text-yellow-600 rounded-lg font-semibold hover:bg-slate-100 transition">
                Bergabung Sekarang
            </a>
        </div>
    </section>

    <?php include '../../components/footer.php'; ?>
    <script src="../../assets/js/main.js"></script>
    <script>
    // Filter functionality
    document.querySelectorAll('[data-filter]').forEach(btn => {
        btn.addEventListener('click', function() {
            const filter = this.getAttribute('data-filter');
            
            // Update active button
            document.querySelectorAll('[data-filter]').forEach(b => {
                b.classList.remove('bg-indigo-600');
                b.classList.add('bg-slate-700');
            });
            this.classList.add('bg-indigo-600');
            this.classList.remove('bg-slate-700');
            
            // Filter items
            const items = document.querySelectorAll('[data-category]');
            items.forEach(item => {
                if (filter === 'all') {
                    item.style.display = 'flex'; // Mengembalikan ke flex karena kita pakai flex-col
                } else {
                    // Cek apakah kategori item mengandung kata kunci filter (case insensitive)
                    const itemCat = item.getAttribute('data-category').toLowerCase();
                    if (itemCat.includes(filter.toLowerCase())) {
                        item.style.display = 'flex';
                    } else {
                        item.style.display = 'none';
                    }
                }
            });
        });
    });
    </script>
</body>
</html>