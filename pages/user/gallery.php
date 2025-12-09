<?php
require_once '../../config.php';

// --- ROBUST DATA LOADING ---
// 1. Coba load menggunakan fungsi config
$gallery_data = readJSON('gallery');

// 2. Fallback Manual: Jika gagal (null), load langsung dari path absolut
if (!$gallery_data) {
    $path_gallery = __DIR__ . '/../../data/gallery.json';
    if (file_exists($path_gallery)) {
        $json_content = file_get_contents($path_gallery);
        $gallery_data = json_decode($json_content, true);
    }
}

// Validasi Data
$gallery_list = (isset($gallery_data) && isset($gallery_data['gallery'])) ? $gallery_data['gallery'] : [];

// --- FILTER & SEARCH LOGIC ---
$filter_kategori = $_GET['kategori'] ?? 'all';
$search_query = $_GET['search'] ?? '';

// Ambil list unik kategori untuk filter button
$categories = [];
if (!empty($gallery_list)) {
    $categories = array_unique(array_column($gallery_list, 'kategori'));
    sort($categories);
}

// Terapkan Filter
if (!empty($gallery_list)) {
    // Filter by Category
    if ($filter_kategori != 'all') {
        $gallery_list = array_filter($gallery_list, function($item) use ($filter_kategori) {
            return $item['kategori'] === $filter_kategori;
        });
    }

    // Filter by Search
    if (!empty($search_query)) {
        $gallery_list = array_filter($gallery_list, function($item) use ($search_query) {
            $keyword = strtolower($search_query);
            return (
                strpos(strtolower($item['judul']), $keyword) !== false ||
                strpos(strtolower($item['deskripsi']), $keyword) !== false ||
                strpos(strtolower(implode(' ', $item['teknologi'])), $keyword) !== false
            );
        });
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Showcase Karya Mahasiswa - SIEGA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../../assets/css/style.css">
    <!-- Alpine.js untuk Modal Interactivity -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        .card-zoom:hover .card-img { transform: scale(1.1); }
        .tech-badge { transition: all 0.2s; }
        .tech-badge:hover { transform: translateY(-2px); }
    </style>
</head>
<body class="bg-slate-900 text-white font-sans antialiased">
    <?php include '../../components/navbar.php'; ?>
    
    <!-- Hero Section -->
    <section class="pt-32 pb-12 bg-gradient-to-br from-pink-900 via-slate-900 to-slate-900 relative overflow-hidden">
        <!-- Background decorative elements -->
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden opacity-20 pointer-events-none">
            <div class="absolute top-10 left-10 w-64 h-64 bg-pink-600 rounded-full mix-blend-multiply filter blur-3xl animate-blob"></div>
            <div class="absolute top-10 right-10 w-64 h-64 bg-purple-600 rounded-full mix-blend-multiply filter blur-3xl animate-blob animation-delay-2000"></div>
            <div class="absolute bottom-10 left-1/2 w-64 h-64 bg-indigo-600 rounded-full mix-blend-multiply filter blur-3xl animate-blob animation-delay-4000"></div>
        </div>

        <div class="container mx-auto px-4 relative z-10">
            <div class="max-w-4xl mx-auto text-center">
                <div class="text-6xl mb-6 animate-bounce">🎨</div>
                <h1 class="text-5xl md:text-6xl font-bold mb-6 bg-clip-text text-transparent bg-gradient-to-r from-pink-400 to-purple-400">
                    Showcase Karya Mahasiswa
                </h1>
                <p class="text-xl text-slate-300">
                    Galeri inovasi teknologi hasil karya mahasiswa SIEGA. Dari Game VR, Aplikasi Web, hingga solusi E-Commerce.
                </p>
            </div>
        </div>
    </section>

    <!-- Search & Filter Bar -->
    <section class="py-8 bg-slate-800 border-y border-slate-700 sticky top-20 z-30 shadow-2xl backdrop-blur-md bg-opacity-90">
        <div class="container mx-auto px-4">
            <form method="GET" action="" class="flex flex-col md:flex-row gap-4 justify-between items-center">
                
                <!-- Category Filters -->
                <div class="flex flex-wrap gap-2 justify-center md:justify-start order-2 md:order-1">
                    <a href="?kategori=all" 
                       class="px-4 py-2 rounded-full text-sm font-semibold transition border border-slate-600 <?= $filter_kategori == 'all' ? 'bg-pink-600 text-white border-pink-500' : 'bg-slate-700 text-slate-300 hover:bg-slate-600' ?>">
                       Semua
                    </a>
                    <?php foreach($categories as $cat): ?>
                    <a href="?kategori=<?= urlencode($cat) ?>" 
                       class="px-4 py-2 rounded-full text-sm font-semibold transition border border-slate-600 <?= $filter_kategori == $cat ? 'bg-pink-600 text-white border-pink-500' : 'bg-slate-700 text-slate-300 hover:bg-slate-600' ?>">
                       <?= htmlspecialchars($cat) ?>
                    </a>
                    <?php endforeach; ?>
                </div>

                <!-- Search Input -->
                <div class="relative w-full md:w-1/3 order-1 md:order-2">
                    <input type="text" name="search" value="<?= htmlspecialchars($search_query) ?>" 
                           placeholder="Cari project, teknologi, mahasiswa..." 
                           class="w-full px-5 py-2.5 bg-slate-900 border border-slate-600 rounded-full focus:outline-none focus:border-pink-500 text-white placeholder-slate-500 transition shadow-inner">
                    <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-pink-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </button>
                    <!-- Hidden input to keep category filter when searching -->
                    <?php if($filter_kategori != 'all'): ?>
                        <input type="hidden" name="kategori" value="<?= htmlspecialchars($filter_kategori) ?>">
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </section>

    <!-- Gallery Grid -->
    <section class="py-20 bg-slate-900 min-h-screen">
        <div class="container mx-auto px-4">
            
            <?php if (empty($gallery_list)): ?>
                <!-- Empty State -->
                <div class="text-center py-32">
                    <div class="text-6xl mb-6 opacity-50 grayscale">🖼️</div>
                    <h3 class="text-3xl font-bold text-slate-400 mb-2">Belum Ada Karya Ditemukan</h3>
                    <p class="text-slate-500 max-w-md mx-auto">
                        Coba ubah kata kunci pencarian atau filter kategori Anda. Atau mungkin, jadilah yang pertama memamerkan karyamu di sini!
                    </p>
                    <a href="gallery.php" class="mt-8 inline-block px-6 py-2 border border-slate-600 rounded-lg text-slate-400 hover:text-white hover:border-white transition">
                        Reset Filter
                    </a>
                </div>
            <?php else: ?>
                
                <!-- Projects Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" x-data="{ openModal: null }">
                    
                    <?php foreach ($gallery_list as $index => $item): ?>
                    <!-- Project Card -->
                    <div class="bg-slate-800 rounded-2xl overflow-hidden border border-slate-700 hover:border-pink-500/50 transition duration-300 shadow-xl flex flex-col h-full card-zoom group">
                        
                        <!-- Thumbnail Image -->
                        <div class="relative h-56 overflow-hidden bg-slate-900">
                            <?php if (!empty($item['gambar_thumbnail'])): ?>
                                <img src="<?= htmlspecialchars($item['gambar_thumbnail']) ?>" 
                                     alt="<?= htmlspecialchars($item['judul']) ?>" 
                                     class="w-full h-full object-cover card-img transition duration-700 ease-in-out"
                                     onerror="this.src='https://placehold.co/600x400/1e293b/cbd5e1?text=Project+Thumbnail'">
                            <?php else: ?>
                                <div class="w-full h-full flex items-center justify-center text-slate-600 bg-slate-800">
                                    <span class="text-4xl">🚀</span>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Overlay Gradient -->
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-transparent opacity-80"></div>
                            
                            <!-- Badges -->
                            <div class="absolute top-4 left-4 flex gap-2">
                                <span class="px-3 py-1 bg-pink-600/90 text-white text-xs font-bold rounded-full backdrop-blur-md shadow-lg border border-pink-500/30">
                                    <?= htmlspecialchars($item['kategori']) ?>
                                </span>
                            </div>
                            
                            <!-- Year Badge -->
                            <div class="absolute bottom-4 right-4">
                                <span class="px-2 py-1 bg-slate-900/80 text-slate-300 text-xs font-mono rounded border border-slate-600">
                                    <?= htmlspecialchars($item['tahun']) ?>
                                </span>
                            </div>
                        </div>

                        <!-- Card Body -->
                        <div class="p-6 flex flex-col flex-grow relative">
                            <!-- Concentration Label -->
                            <div class="text-xs text-pink-400 font-bold tracking-wider uppercase mb-1">
                                <?= htmlspecialchars($item['konsentrasi']) ?>
                            </div>

                            <h3 class="text-xl font-bold text-white mb-3 group-hover:text-pink-400 transition leading-tight">
                                <?= htmlspecialchars($item['judul']) ?>
                            </h3>

                            <p class="text-slate-400 text-sm mb-6 line-clamp-3 leading-relaxed flex-grow">
                                <?= htmlspecialchars($item['deskripsi']) ?>
                            </p>

                            <!-- Tech Stack Preview -->
                            <div class="flex flex-wrap gap-2 mb-6">
                                <?php foreach (array_slice($item['teknologi'], 0, 3) as $tech): ?>
                                <span class="text-[10px] px-2 py-1 bg-slate-700 text-slate-300 rounded border border-slate-600">
                                    <?= htmlspecialchars($tech) ?>
                                </span>
                                <?php endforeach; ?>
                                <?php if (count($item['teknologi']) > 3): ?>
                                <span class="text-[10px] px-2 py-1 bg-slate-700 text-slate-400 rounded border border-slate-600">
                                    +<?= count($item['teknologi']) - 3 ?>
                                </span>
                                <?php endif; ?>
                            </div>

                            <!-- Footer / Action -->
                            <div class="pt-4 border-t border-slate-700 flex justify-between items-center">
                                <div class="flex -space-x-2 overflow-hidden">
                                    <!-- Avatar Team (Placeholder) -->
                                    <?php foreach ($item['pembuat'] as $idx => $maker): ?>
                                        <?php if ($idx < 3): ?>
                                        <div class="inline-block h-8 w-8 rounded-full ring-2 ring-slate-800 bg-slate-600 flex items-center justify-center text-xs font-bold text-white" title="<?= htmlspecialchars($maker) ?>">
                                            <?= substr($maker, 0, 1) ?>
                                        </div>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                    <?php if (count($item['pembuat']) > 3): ?>
                                        <div class="inline-block h-8 w-8 rounded-full ring-2 ring-slate-800 bg-slate-700 flex items-center justify-center text-[10px] text-white">
                                            +<?= count($item['pembuat']) - 3 ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                
                                <button @click="openModal = <?= $item['id'] ?>" class="text-sm font-bold text-pink-400 hover:text-pink-300 transition flex items-center gap-1 group-hover:underline">
                                    Lihat Detail <span class="transform group-hover:translate-x-1 transition">→</span>
                                </button>
                            </div>
                        </div>

                        <!-- MODAL DETAIL (Alpine.js based) -->
                        <div x-show="openModal === <?= $item['id'] ?>" 
                             style="display: none;"
                             class="fixed inset-0 z-50 overflow-y-auto" 
                             aria-labelledby="modal-title" role="dialog" aria-modal="true">
                            
                            <!-- Backdrop -->
                            <div x-show="openModal === <?= $item['id'] ?>"
                                 x-transition:enter="ease-out duration-300"
                                 x-transition:enter-start="opacity-0"
                                 x-transition:enter-end="opacity-100"
                                 x-transition:leave="ease-in duration-200"
                                 x-transition:leave-start="opacity-100"
                                 x-transition:leave-end="opacity-0"
                                 class="fixed inset-0 bg-slate-900/90 backdrop-blur-sm transition-opacity"
                                 @click="openModal = null"></div>

                            <!-- Modal Panel -->
                            <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                                <div x-show="openModal === <?= $item['id'] ?>"
                                     x-transition:enter="ease-out duration-300"
                                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                                     x-transition:leave="ease-in duration-200"
                                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                     class="relative transform overflow-hidden rounded-2xl bg-slate-800 text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-4xl border border-slate-700">
                                    
                                    <!-- Modal Header Image -->
                                    <div class="relative h-64 sm:h-80 bg-slate-900">
                                        <?php if (!empty($item['gambar_thumbnail'])): ?>
                                            <img src="<?= htmlspecialchars($item['gambar_thumbnail']) ?>" class="w-full h-full object-cover opacity-50">
                                        <?php endif; ?>
                                        <div class="absolute inset-0 bg-gradient-to-t from-slate-800 to-transparent"></div>
                                        
                                        <button @click="openModal = null" class="absolute top-4 right-4 p-2 bg-black/50 text-white rounded-full hover:bg-white/20 transition z-10">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        </button>

                                        <div class="absolute bottom-0 left-0 p-8 w-full">
                                            <div class="flex items-center gap-3 mb-2">
                                                <span class="px-3 py-1 bg-pink-600 text-white text-xs font-bold rounded-full">
                                                    <?= htmlspecialchars($item['kategori']) ?>
                                                </span>
                                                <span class="px-3 py-1 bg-slate-700/80 text-slate-300 text-xs font-bold rounded-full border border-slate-600">
                                                    <?= htmlspecialchars($item['konsentrasi']) ?>
                                                </span>
                                            </div>
                                            <h2 class="text-3xl sm:text-4xl font-bold text-white mb-2"><?= htmlspecialchars($item['judul']) ?></h2>
                                            <?php if(isset($item['achievement'])): ?>
                                                <div class="flex items-center gap-2 text-yellow-400 font-semibold text-sm">
                                                    <span>🏆</span> <?= htmlspecialchars($item['achievement']) ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <!-- Modal Content -->
                                    <div class="p-8">
                                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                                            <!-- Left Column: Description & Gallery -->
                                            <div class="lg:col-span-2 space-y-8">
                                                <div>
                                                    <h3 class="text-lg font-bold text-white mb-3">Tentang Project</h3>
                                                    <p class="text-slate-300 leading-relaxed text-justify">
                                                        <?= nl2br(htmlspecialchars($item['deskripsi'])) ?>
                                                    </p>
                                                </div>

                                                <?php if (!empty($item['gambar_detail'])): ?>
                                                <div>
                                                    <h3 class="text-lg font-bold text-white mb-3">Preview Gallery</h3>
                                                    <div class="grid grid-cols-2 gap-4">
                                                        <?php foreach ($item['gambar_detail'] as $img): ?>
                                                        <div class="rounded-lg overflow-hidden border border-slate-700 hover:border-pink-500 transition cursor-pointer">
                                                            <img src="<?= htmlspecialchars($img) ?>" class="w-full h-32 object-cover hover:scale-110 transition duration-500" onerror="this.src='https://placehold.co/400x300/1e293b/cbd5e1?text=Gallery'">
                                                        </div>
                                                        <?php endforeach; ?>
                                                    </div>
                                                </div>
                                                <?php endif; ?>
                                            </div>

                                            <!-- Right Column: Meta Info -->
                                            <div class="space-y-6">
                                                <!-- Team -->
                                                <div class="bg-slate-900/50 p-5 rounded-xl border border-slate-700">
                                                    <h3 class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-4">Tim Pengembang</h3>
                                                    <ul class="space-y-3">
                                                        <?php foreach ($item['pembuat'] as $maker): ?>
                                                        <li class="flex items-center gap-3">
                                                            <div class="w-8 h-8 rounded-full bg-pink-900/50 flex items-center justify-center text-pink-400 font-bold text-xs border border-pink-500/30">
                                                                <?= substr($maker, 0, 1) ?>
                                                            </div>
                                                            <div>
                                                                <p class="text-sm font-semibold text-white"><?= htmlspecialchars($maker) ?></p>
                                                                <p class="text-xs text-slate-500">Angkatan <?= htmlspecialchars($item['angkatan']) ?></p>
                                                            </div>
                                                        </li>
                                                        <?php endforeach; ?>
                                                    </ul>
                                                </div>

                                                <!-- Tech Stack -->
                                                <div class="bg-slate-900/50 p-5 rounded-xl border border-slate-700">
                                                    <h3 class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-4">Teknologi</h3>
                                                    <div class="flex flex-wrap gap-2">
                                                        <?php foreach ($item['teknologi'] as $tech): ?>
                                                        <span class="px-3 py-1 bg-slate-700 text-slate-200 text-xs rounded border border-slate-600 tech-badge cursor-default">
                                                            <?= htmlspecialchars($tech) ?>
                                                        </span>
                                                        <?php endforeach; ?>
                                                    </div>
                                                </div>

                                                <!-- Links -->
                                                <div class="flex flex-col gap-3">
                                                    <?php if(!empty($item['video_demo'])): ?>
                                                    <a href="<?= htmlspecialchars($item['video_demo']) ?>" target="_blank" class="flex items-center justify-center gap-2 px-4 py-3 bg-red-600 hover:bg-red-700 text-white rounded-lg font-semibold transition">
                                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/></svg>
                                                        Tonton Demo
                                                    </a>
                                                    <?php endif; ?>
                                                    
                                                    <?php if(!empty($item['github'])): ?>
                                                    <a href="<?= htmlspecialchars($item['github']) ?>" target="_blank" class="flex items-center justify-center gap-2 px-4 py-3 bg-slate-700 hover:bg-slate-600 text-white rounded-lg font-semibold transition border border-slate-600">
                                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>
                                                        Source Code
                                                    </a>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- End Modal -->
                        
                    </div>
                    <?php endforeach; ?>
                    
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Submission CTA -->
    <section class="py-20 bg-slate-800">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto bg-gradient-to-r from-pink-900/50 to-purple-900/50 rounded-2xl p-10 border border-pink-500/30 text-center relative overflow-hidden">
                <div class="absolute -top-20 -left-20 w-64 h-64 bg-pink-600 rounded-full mix-blend-overlay filter blur-3xl opacity-20"></div>
                
                <h2 class="text-3xl font-bold mb-4 relative z-10">Punya Karya Keren? Pamerkan Disini!</h2>
                <p class="text-lg text-slate-300 mb-8 max-w-2xl mx-auto relative z-10">
                    Kirimkan project tugas akhir, tugas kuliah, atau side project kamu untuk ditampilkan di galeri SIEGA. Bangun portofolio digitalmu sekarang.
                </p>
                
                <div class="flex flex-col sm:flex-row gap-4 justify-center relative z-10">
                    <a href="https://forms.google.com/submit-project" target="_blank" 
                       class="px-8 py-3 bg-pink-600 hover:bg-pink-700 text-white rounded-lg font-bold transition shadow-lg hover:shadow-pink-600/30 transform hover:-translate-y-1">
                        📤 Submit Project
                    </a>
                    <a href="kontak.php" 
                       class="px-8 py-3 bg-transparent border border-white/30 hover:bg-white/10 text-white rounded-lg font-bold transition">
                        📞 Hubungi Admin
                    </a>
                </div>
            </div>
        </div>
    </section>

    <?php include '../../components/footer.php'; ?>
    <script src="../../assets/js/main.js"></script>
</body>
</html>