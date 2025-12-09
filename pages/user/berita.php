<?php
require_once '../../config.php';

// --- PERBAIKAN: Robust Data Loading ---
// 1. Coba load menggunakan fungsi config
$berita_data = readJSON('berita');

// 2. Fallback Manual: Jika gagal (null), load langsung dari path absolut
if (!$berita_data) {
    $path_berita = __DIR__ . '/../../data/berita.json';
    if (file_exists($path_berita)) {
        $json_content = file_get_contents($path_berita);
        $berita_data = json_decode($json_content, true);
    }
}

// Validasi Data: Pastikan variabel ini selalu Array
$all_berita = (isset($berita_data) && isset($berita_data['berita'])) ? $berita_data['berita'] : [];

// PERBAIKAN: usort hanya jalan jika array tidak kosong
if (!empty($all_berita)) {
    usort($all_berita, function($a, $b) {
        return strtotime($b['tanggal']) - strtotime($a['tanggal']);
    });
}

// Pagination Logic
$per_page = 9;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// count() aman karena $all_berita pasti array (walaupun kosong)
$total = count($all_berita);
$total_pages = $total > 0 ? ceil($total / $per_page) : 1;
$offset = ($page - 1) * $per_page;

// Slice data
$berita_list = !empty($all_berita) ? array_slice($all_berita, $offset, $per_page) : [];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berita - SIEGA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body class="bg-slate-900 text-white">
    <?php include '../../components/navbar.php'; ?>
    
    <!-- Hero Section -->
    <section class="pt-32 pb-12 bg-gradient-to-br from-red-900 via-slate-900 to-slate-900">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center">
                <div class="text-6xl mb-6">📢</div>
                <h1 class="text-5xl md:text-6xl font-bold mb-6">Berita Terkini</h1>
                <p class="text-xl text-slate-300">Informasi terbaru seputar prestasi, kegiatan, dan perkembangan kampus</p>
            </div>
        </div>
    </section>

    <!-- News Grid -->
    <section class="py-20 bg-slate-900">
        <div class="container mx-auto px-4">
            <?php if (empty($berita_list)): ?>
                <!-- Tampilan jika data kosong -->
                <div class="text-center py-20 border border-dashed border-slate-700 rounded-xl">
                    <div class="text-4xl mb-4">📭</div>
                    <h3 class="text-2xl font-bold text-slate-400">Belum ada berita</h3>
                    <p class="text-slate-500 mt-2">Nantikan kabar terbaru dari SIEGA!</p>
                </div>
            <?php else: ?>
                <!-- Grid Berita -->
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <?php foreach ($berita_list as $b): ?>
                    <article class="bg-slate-800 rounded-xl overflow-hidden group hover:transform hover:-translate-y-2 transition duration-300 shadow-lg border border-slate-700 hover:border-red-500/50 flex flex-col h-full">
                        <div class="relative h-48 overflow-hidden bg-slate-700 shrink-0">
                            <?php if(!empty($b['gambar'])): ?>
                                <img src="<?= htmlspecialchars($b['gambar']) ?>" 
                                     alt="<?= htmlspecialchars($b['judul']) ?>" 
                                     class="w-full h-full object-cover group-hover:scale-110 transition duration-500"
                                     onerror="this.src='https://placehold.co/600x400/1e293b/cbd5e1?text=No+Image'">
                            <?php else: ?>
                                <div class="w-full h-full flex items-center justify-center text-slate-500">
                                    <span class="text-4xl">🖼️</span>
                                </div>
                            <?php endif; ?>
                            
                            <div class="absolute top-4 right-4">
                                <span class="px-3 py-1 bg-red-600/90 text-white text-xs font-bold rounded-full backdrop-blur-sm shadow-lg uppercase tracking-wider">
                                    <?= htmlspecialchars($b['kategori']) ?>
                                </span>
                            </div>
                        </div>
                        
                        <div class="p-6 flex flex-col flex-grow">
                            <div class="text-xs text-slate-400 mb-3 flex items-center gap-2">
                                <span>🗓️ <?= htmlspecialchars($b['tanggal']) ?></span>
                                <?php if(isset($b['views'])): ?>
                                    <span>•</span>
                                    <span>👁️ <?= number_format($b['views']) ?></span>
                                <?php endif; ?>
                            </div>
                            
                            <h3 class="text-xl font-bold mb-3 group-hover:text-red-400 transition line-clamp-2">
                                <a href="detail-berita.php?slug=<?= htmlspecialchars($b['slug']) ?>">
                                    <?= htmlspecialchars($b['judul']) ?>
                                </a>
                            </h3>
                            
                            <p class="text-slate-400 text-sm mb-6 line-clamp-3 flex-grow">
                                <?= htmlspecialchars($b['ringkasan']) ?>
                            </p>
                            
                            <a href="detail-berita.php?slug=<?= htmlspecialchars($b['slug']) ?>" 
                               class="inline-block text-center w-full py-2 border border-slate-600 rounded-lg text-sm font-semibold hover:bg-red-600 hover:border-red-600 hover:text-white transition mt-auto">
                                Baca Selengkapnya
                            </a>
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
                    <a href="?page=<?= $i ?>" class="px-4 py-2 rounded-lg transition <?= $i == $page ? 'bg-red-600 text-white' : 'bg-slate-800 hover:bg-slate-700' ?>">
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

    <!-- Categories Filters -->
    <section class="py-12 bg-slate-800">
        <div class="container mx-auto px-4">
            <h3 class="text-2xl font-bold text-center mb-8">📂 Jelajahi Kategori</h3>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="#" class="px-6 py-3 bg-slate-900 hover:bg-red-600 rounded-lg transition border border-slate-700 hover:border-red-600">Prestasi</a>
                <a href="#" class="px-6 py-3 bg-slate-900 hover:bg-red-600 rounded-lg transition border border-slate-700 hover:border-red-600">Kegiatan Mahasiswa</a>
                <a href="#" class="px-6 py-3 bg-slate-900 hover:bg-red-600 rounded-lg transition border border-slate-700 hover:border-red-600">Alumni</a>
                <a href="#" class="px-6 py-3 bg-slate-900 hover:bg-red-600 rounded-lg transition border border-slate-700 hover:border-red-600">Penelitian</a>
                <a href="#" class="px-6 py-3 bg-slate-900 hover:bg-red-600 rounded-lg transition border border-slate-700 hover:border-red-600">Partnership</a>
            </div>
        </div>
    </section>

    <!-- Newsletter Subscription -->
    <section class="py-20 bg-slate-900 border-t border-slate-800">
        <div class="container mx-auto px-4">
            <div class="max-w-2xl mx-auto bg-gradient-to-r from-red-900/50 to-orange-900/50 border border-red-500/30 rounded-2xl p-8 text-center backdrop-blur-sm">
                <div class="text-5xl mb-4">📬</div>
                <h3 class="text-2xl font-bold mb-4">Subscribe Newsletter</h3>
                <p class="mb-6 text-slate-300">Dapatkan update berita terbaru langsung ke email Anda</p>
                <form class="flex flex-col sm:flex-row gap-3">
                    <input type="email" placeholder="Masukkan email Anda" 
                           class="flex-1 px-4 py-3 rounded-lg bg-slate-900/50 border border-slate-600 placeholder-slate-400 outline-none focus:border-red-500 transition text-white">
                    <button type="button" class="px-6 py-3 bg-red-600 text-white rounded-lg font-semibold hover:bg-red-700 transition shadow-lg shadow-red-900/50">
                        Langganan
                    </button>
                </form>
            </div>
        </div>
    </section>

    <?php include '../../components/footer.php'; ?>
    <script src="../../assets/js/main.js"></script>
</body>
</html>