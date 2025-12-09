<?php
require_once '../../config.php';

// --- PERBAIKAN: Robust Data Loading ---
// 1. Coba load menggunakan fungsi config
$artikel_data = readJSON('artikel');

// 2. Fallback Manual: Jika gagal, load langsung dari path absolut
if (!$artikel_data) {
    $path_artikel = __DIR__ . '/../../data/artikel.json';
    if (file_exists($path_artikel)) {
        $json_content = file_get_contents($path_artikel);
        $artikel_data = json_decode($json_content, true);
    }
}

// Validasi Data: Pastikan variabel ini selalu Array, jangan biarkan Null
$all_artikel = (isset($artikel_data) && isset($artikel_data['artikel'])) ? $artikel_data['artikel'] : [];

// Pagination Logic
$per_page = 9;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// PERBAIKAN: count() sekarang aman karena $all_artikel pasti array
$total = count($all_artikel); 
$total_pages = $total > 0 ? ceil($total / $per_page) : 1;
$offset = ($page - 1) * $per_page;

// Slice data hanya jika array tidak kosong
$artikel_list = !empty($all_artikel) ? array_slice($all_artikel, $offset, $per_page) : [];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artikel - SIEGA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body class="bg-slate-900 text-white">
    <?php include '../../components/navbar.php'; ?>
    
    <!-- Hero Section -->
    <section class="pt-32 pb-12 bg-gradient-to-br from-teal-900 via-slate-900 to-slate-900">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center">
                <div class="text-6xl mb-6">📰</div>
                <h1 class="text-5xl md:text-6xl font-bold mb-6">Artikel & Berita</h1>
                <p class="text-xl text-slate-300">Wawasan teknologi, tutorial, dan update terbaru seputar SIEGA</p>
            </div>
        </div>
    </section>

    <!-- Articles Grid -->
    <section class="py-20 bg-slate-900">
        <div class="container mx-auto px-4">
            <?php if (empty($artikel_list)): ?>
                <!-- Tampilan jika data kosong/error -->
                <div class="text-center py-20 border border-dashed border-slate-700 rounded-xl">
                    <div class="text-4xl mb-4">📭</div>
                    <h3 class="text-2xl font-bold text-slate-400">Belum ada artikel</h3>
                    <p class="text-slate-500 mt-2">Data artikel tidak ditemukan atau sedang dalam pembaruan.</p>
                </div>
            <?php else: ?>
                <!-- Grid Artikel -->
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <?php foreach ($artikel_list as $a): ?>
                    <article class="bg-slate-800 rounded-xl overflow-hidden group hover:transform hover:-translate-y-2 transition duration-300 shadow-lg border border-slate-700 hover:border-teal-500/50">
                        <div class="relative h-48 overflow-hidden bg-slate-700">
                            <?php if(!empty($a['gambar_thumbnail'])): ?>
                                <img src="<?= htmlspecialchars($a['gambar_thumbnail']) ?>" 
                                     alt="<?= htmlspecialchars($a['judul']) ?>" 
                                     class="w-full h-full object-cover group-hover:scale-110 transition duration-500"
                                     onerror="this.src='https://placehold.co/600x400/1e293b/cbd5e1?text=No+Image'">
                            <?php else: ?>
                                <div class="w-full h-full flex items-center justify-center text-slate-500">
                                    <span class="text-4xl">🖼️</span>
                                </div>
                            <?php endif; ?>
                            
                            <div class="absolute top-4 left-4">
                                <span class="px-3 py-1 bg-teal-600/90 text-white text-xs font-bold rounded-full backdrop-blur-sm shadow-lg">
                                    <?= htmlspecialchars($a['kategori']) ?>
                                </span>
                            </div>
                        </div>
                        
                        <div class="p-6">
                            <div class="flex items-center gap-2 text-xs text-slate-400 mb-3">
                                <span>🗓️ <?= htmlspecialchars($a['tanggal']) ?></span>
                                <span>•</span>
                                <span>👁️ <?= number_format($a['views'] ?? 0) ?> views</span>
                            </div>
                            
                            <h3 class="text-xl font-bold mb-3 line-clamp-2 group-hover:text-teal-400 transition">
                                <a href="detail-artikel.php?slug=<?= htmlspecialchars($a['slug']) ?>">
                                    <?= htmlspecialchars($a['judul']) ?>
                                </a>
                            </h3>
                            
                            <p class="text-slate-400 text-sm mb-4 line-clamp-3">
                                <?= htmlspecialchars($a['excerpt']) ?>
                            </p>
                            
                            <div class="flex items-center justify-between pt-4 border-t border-slate-700">
                                <div class="text-xs text-slate-500">
                                    Penulis: <span class="text-slate-300"><?= htmlspecialchars($a['penulis']) ?></span>
                                </div>
                                <a href="detail-artikel.php?slug=<?= htmlspecialchars($a['slug']) ?>" class="text-sm font-semibold text-teal-400 hover:text-teal-300 transition flex items-center gap-1">
                                    Baca Selengkapnya →
                                </a>
                            </div>
                        </div>
                    </article>
                    <?php endforeach; ?>
                </div>

                <!-- Pagination -->
                <?php if ($total_pages > 1): ?>
                <div class="flex justify-center gap-2 mt-12">
                    <?php if ($page > 1): ?>
                    <a href="?page=<?= $page - 1 ?>" class="px-4 py-2 bg-slate-800 rounded-lg hover:bg-slate-700 transition">
                        ← Prev
                    </a>
                    <?php endif; ?>

                    <?php for($i = 1; $i <= $total_pages; $i++): ?>
                    <a href="?page=<?= $i ?>" class="px-4 py-2 rounded-lg transition <?= $i == $page ? 'bg-teal-600 text-white' : 'bg-slate-800 hover:bg-slate-700' ?>">
                        <?= $i ?>
                    </a>
                    <?php endfor; ?>
                    
                    <?php if ($page < $total_pages): ?>
                    <a href="?page=<?= $page + 1 ?>" class="px-4 py-2 bg-slate-800 rounded-lg hover:bg-slate-700 transition">
                        Next →
                    </a>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </section>

    <!-- Categories Links -->
    <section class="py-12 bg-slate-800">
        <div class="container mx-auto px-4">
            <h3 class="text-2xl font-bold text-center mb-8">📂 Jelajahi Topik</h3>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="#" class="px-6 py-3 bg-slate-900 hover:bg-teal-600 hover:text-white rounded-lg transition border border-slate-700 text-slate-300">
                    💻 Programming
                </a>
                <a href="#" class="px-6 py-3 bg-slate-900 hover:bg-teal-600 hover:text-white rounded-lg transition border border-slate-700 text-slate-300">
                    🌐 Web Development
                </a>
                <a href="#" class="px-6 py-3 bg-slate-900 hover:bg-teal-600 hover:text-white rounded-lg transition border border-slate-700 text-slate-300">
                    📱 Mobile Apps
                </a>
                <a href="#" class="px-6 py-3 bg-slate-900 hover:bg-teal-600 hover:text-white rounded-lg transition border border-slate-700 text-slate-300">
                    🎮 Game Development
                </a>
                <a href="#" class="px-6 py-3 bg-slate-900 hover:bg-teal-600 hover:text-white rounded-lg transition border border-slate-700 text-slate-300">
                    🤖 Artificial Intelligence
                </a>
            </div>
        </div>
    </section>

    <?php include '../../components/footer.php'; ?>
    <script src="../../assets/js/main.js"></script>
</body>
</html>