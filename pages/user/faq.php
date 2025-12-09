<?php
require_once '../../config.php';

// --- PERBAIKAN: Robust Data Loading ---
// 1. Coba load menggunakan fungsi config
$faq_data = readJSON('faq');

// 2. Fallback Manual: Jika gagal (null), load langsung dari path absolut
if (!$faq_data) {
    $path_faq = __DIR__ . '/../../data/faq.json';
    if (file_exists($path_faq)) {
        $json_content = file_get_contents($path_faq);
        $faq_data = json_decode($json_content, true);
    }
}

// Validasi Data: Pastikan variabel ini selalu Array
$faq_list = (isset($faq_data) && isset($faq_data['faq'])) ? $faq_data['faq'] : [];

// PERBAIKAN: Mengambil Kategori Unik Secara Aman
$categories = [];
if (!empty($faq_list)) {
    // array_column aman dipanggil karena $faq_list sudah pasti array (minimal kosong)
    $categories = array_unique(array_column($faq_list, 'kategori'));
    sort($categories); // Urutkan abjad
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ - SIEGA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../../assets/css/style.css">
    <style>
        .faq-answer { transition: all 0.3s ease-in-out; }
        .rotate-180 { transform: rotate(180deg); }
    </style>
</head>
<body class="bg-slate-900 text-white">
    <?php include '../../components/navbar.php'; ?>
    
    <!-- Hero Section -->
    <section class="pt-32 pb-12 bg-gradient-to-br from-blue-900 via-slate-900 to-slate-900">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center">
                <div class="text-6xl mb-6">❓</div>
                <h1 class="text-5xl md:text-6xl font-bold mb-6">Frequently Asked Questions</h1>
                <p class="text-xl text-slate-300">Pertanyaan yang sering ditanyakan tentang pendaftaran, kurikulum, dan perkuliahan di SIEGA</p>
            </div>
        </div>
    </section>

    <!-- Search & Filter -->
    <section class="py-8 bg-slate-800 border-y border-slate-700 sticky top-20 z-10 shadow-xl">
        <div class="container mx-auto px-4 max-w-4xl">
            <!-- Search Bar -->
            <div class="mb-6">
                <div class="relative">
                    <input type="text" id="faqSearch" placeholder="Cari pertanyaan (misal: biaya, beasiswa, sks)..." 
                           class="w-full px-6 py-4 rounded-xl bg-slate-900 border border-slate-600 focus:border-blue-500 focus:outline-none text-white pl-12 shadow-inner">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-2xl">🔍</span>
                </div>
            </div>

            <!-- Category Buttons -->
            <?php if (!empty($categories)): ?>
            <div class="flex flex-wrap justify-center gap-3">
                <button class="filter-btn active px-4 py-2 bg-blue-600 rounded-full text-sm font-semibold transition hover:bg-blue-700" data-category="all">
                    Semua
                </button>
                <?php foreach($categories as $cat): ?>
                <button class="filter-btn px-4 py-2 bg-slate-700 rounded-full text-sm font-semibold transition hover:bg-blue-600 border border-slate-600" data-category="<?= htmlspecialchars($cat) ?>">
                    <?= htmlspecialchars($cat) ?>
                </button>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- FAQ Accordion List -->
    <section class="py-20 bg-slate-900 min-h-screen">
        <div class="container mx-auto px-4 max-w-3xl">
            <?php if (empty($faq_list)): ?>
                <!-- Tampilan jika data kosong -->
                <div class="text-center py-20 border border-dashed border-slate-700 rounded-xl">
                    <div class="text-4xl mb-4">📭</div>
                    <h3 class="text-2xl font-bold text-slate-400">Belum ada data FAQ</h3>
                    <p class="text-slate-500 mt-2">Database FAQ sedang diperbarui.</p>
                </div>
            <?php else: ?>
                <div class="space-y-4" id="faqContainer">
                    <?php foreach ($faq_list as $index => $item): ?>
                    <div class="faq-item bg-slate-800 rounded-xl border border-slate-700 overflow-hidden hover:border-blue-500/50 transition group" 
                         data-category="<?= htmlspecialchars($item['kategori']) ?>">
                        
                        <button class="faq-question w-full px-6 py-5 text-left flex justify-between items-center focus:outline-none">
                            <div class="flex items-center gap-4">
                                <span class="px-2 py-1 bg-slate-700 text-xs text-blue-300 rounded uppercase font-bold tracking-wider shrink-0">
                                    <?= htmlspecialchars($item['kategori']) ?>
                                </span>
                                <span class="font-bold text-lg group-hover:text-blue-400 transition"><?= htmlspecialchars($item['pertanyaan']) ?></span>
                            </div>
                            <svg class="faq-icon w-6 h-6 text-slate-500 transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        
                        <div class="faq-answer hidden bg-slate-900/50 border-t border-slate-700">
                            <div class="px-6 py-5 text-slate-300 leading-relaxed">
                                <?= nl2br(htmlspecialchars($item['jawaban'])) ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                
                <!-- Pesan jika pencarian tidak ditemukan -->
                <div id="noResults" class="hidden text-center py-12">
                    <p class="text-slate-500 text-lg">Pertanyaan tidak ditemukan 😔</p>
                    <button onclick="document.getElementById('faqSearch').value=''; document.getElementById('faqSearch').dispatchEvent(new Event('input'));" class="text-blue-400 hover:underline mt-2">
                        Reset Pencarian
                    </button>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Contact Support -->
    <section class="py-12 bg-slate-800 border-t border-slate-700">
        <div class="container mx-auto px-4 text-center">
            <h3 class="text-xl font-bold mb-4">Masih punya pertanyaan?</h3>
            <p class="text-slate-400 mb-6">Tim admin kami siap membantu menjawab pertanyaan Anda</p>
            <div class="flex justify-center gap-4">
                <a href="https://wa.me/6281234567890" target="_blank" class="px-6 py-3 bg-green-600 hover:bg-green-700 rounded-lg font-semibold transition flex items-center gap-2">
                    💬 Chat WhatsApp
                </a>
                <a href="kontak.php" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 rounded-lg font-semibold transition flex items-center gap-2">
                    📧 Kirim Email
                </a>
            </div>
        </div>
    </section>

    <?php include '../../components/footer.php'; ?>
    
    <script src="../../assets/js/main.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // 1. Accordion Logic
        const questions = document.querySelectorAll('.faq-question');
        
        questions.forEach(btn => {
            btn.addEventListener('click', function() {
                const item = this.parentElement;
                const answer = this.nextElementSibling;
                const icon = this.querySelector('.faq-icon');
                const isOpen = !answer.classList.contains('hidden');
                
                // Close all other items (Optional: remove this block if you want multiple open)
                document.querySelectorAll('.faq-answer').forEach(a => a.classList.add('hidden'));
                document.querySelectorAll('.faq-icon').forEach(i => i.classList.remove('rotate-180'));
                document.querySelectorAll('.faq-question').forEach(q => q.classList.remove('text-blue-400'));

                // Toggle current
                if (!isOpen) {
                    answer.classList.remove('hidden');
                    icon.classList.add('rotate-180');
                    this.classList.add('text-blue-400');
                }
            });
        });

        // 2. Search & Filter Logic
        const searchInput = document.getElementById('faqSearch');
        const filterBtns = document.querySelectorAll('.filter-btn');
        const faqItems = document.querySelectorAll('.faq-item');
        const noResults = document.getElementById('noResults');
        let currentCategory = 'all';

        function filterItems() {
            const keyword = searchInput.value.toLowerCase();
            let visibleCount = 0;

            faqItems.forEach(item => {
                const category = item.getAttribute('data-category');
                const question = item.querySelector('.faq-question span.text-lg').textContent.toLowerCase();
                const answer = item.querySelector('.faq-answer').textContent.toLowerCase();
                
                // Check Category Match
                const categoryMatch = (currentCategory === 'all' || category === currentCategory);
                
                // Check Search Keyword Match
                const searchMatch = (question.includes(keyword) || answer.includes(keyword));

                if (categoryMatch && searchMatch) {
                    item.style.display = 'block';
                    visibleCount++;
                } else {
                    item.style.display = 'none';
                }
            });

            // Show/Hide "No Results" message
            if (visibleCount === 0) {
                noResults.classList.remove('hidden');
            } else {
                noResults.classList.add('hidden');
            }
        }

        // Event Listener: Search
        searchInput.addEventListener('input', filterItems);

        // Event Listener: Category Buttons
        filterBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                // Update UI Buttons
                filterBtns.forEach(b => {
                    b.classList.remove('bg-blue-600', 'active');
                    b.classList.add('bg-slate-700');
                });
                this.classList.remove('bg-slate-700');
                this.classList.add('bg-blue-600', 'active');

                // Update Logic
                currentCategory = this.getAttribute('data-category');
                filterItems();
            });
        });
    });
    </script>
</body>
</html>