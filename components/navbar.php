<?php
/**
 * SIEGA Navigation Component
 * Refactored: Menggunakan Array untuk manajemen menu agar lebih rapi & ringkas.
 */

// 1. LOGIKA PENENTUAN PATH OTOMATIS
$current_script = $_SERVER['PHP_SELF'];
$path = "./"; 

if (strpos($current_script, '/pages/user/konsentrasi/') !== false) {
    $path = "../../../";
} elseif (strpos($current_script, '/pages/user/') !== false) {
    $path = "../../";
}

// 2. DATA STRUKTUR MENU (Edit menu di sini)
$menus = [
    [
        'label' => 'Beranda',
        'url' => 'index.php',
        'type' => 'link'
    ],
    [
        'label' => 'Tentang',
        'url' => 'pages/user/about.php',
        'type' => 'link'
    ],
    [
        'label' => 'Konsentrasi',
        'type' => 'dropdown',
        'items' => [
            ['label' => '4 Matkul SIEGA', 'url' => 'pages/user/konsentrasi/index.php'],
            ['label' => 'Sistem Informasi', 'url' => 'pages/user/konsentrasi/sistem-informasi.php'],
            ['label' => 'E-Commerce', 'url' => 'pages/user/konsentrasi/e-commerce.php'],
            ['label' => 'Game Technology', 'url' => 'pages/user/konsentrasi/game-technology.php'],
            ['label' => 'Akuntansi SI', 'url' => 'pages/user/konsentrasi/akuntansi-si.php'],
        ]
    ],
    [
        'label' => 'Akademik',
        'type' => 'dropdown',
        'items' => [
            ['label' => 'Kurikulum', 'url' => 'pages/user/kurikulum.php'],
            ['label' => 'Dosen', 'url' => 'pages/user/dosen.php'],
            ['label' => 'Skripsi', 'url' => 'pages/user/skripsi.php'],
            ['label' => 'Jurnal', 'url' => 'pages/user/journal.php'],
            ['label' => 'Biaya Kuliah', 'url' => 'pages/user/biaya-kuliah.php'],
        ]
    ],
    // Mengelompokkan Kegiatan, Artikel, Berita agar ringkas
    [
        'label' => 'Publikasi',
        'type' => 'dropdown',
        'items' => [
            ['label' => 'Kegiatan', 'url' => 'pages/user/kegiatan.php'],
            ['label' => 'Artikel', 'url' => 'pages/user/artikel.php'],
            ['label' => 'Berita', 'url' => 'pages/user/berita.php'],
        ]
    ],
    // Mengelompokkan sisa menu lainnya
    [
        'label' => 'Lainnya',
        'type' => 'dropdown',
        'items' => [
            ['label' => 'Alumni', 'url' => 'pages/user/alumni.php'],
            ['label' => 'Fasilitas', 'url' => 'pages/user/fasilitas.php'],
            ['label' => 'Gallery', 'url' => 'pages/user/gallery.php'],
            ['label' => 'Quiz', 'url' => 'pages/user/quiz.php'],
            ['label' => 'FAQ', 'url' => 'pages/user/faq.php'],
        ]
    ]
];
?>

<nav class="bg-slate-900 border-b border-slate-800 sticky top-0 z-50 backdrop-blur-lg bg-opacity-95">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            
            <!-- LOGO -->
            <div class="flex items-center space-x-3">
                <a href="<?= $path ?>index.php" class="flex items-center space-x-3 group">
                    <img src="<?= $path ?>assets/images/logo-siega.png" 
                         onerror="this.src='https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS7_E-GHjO-1AHhwnumcaSvT4LhU4Nl-lT5Fg&s'"
                         alt="SIEGA Logo" 
                         class="h-10 w-auto transition-transform group-hover:scale-110">
                    <div class="hidden md:block">
                        <h1 class="text-xl font-bold text-white">SIEGA</h1>
                        <p class="text-xs text-cyan-400">Harvest Your Future</p>
                    </div>
                </a>
            </div>

            <!-- DESKTOP NAVIGATION -->
            <div class="hidden lg:flex items-center space-x-1">
                <?php foreach ($menus as $menu): ?>
                    <?php if ($menu['type'] === 'link'): ?>
                        <!-- Single Link -->
                        <a href="<?= $path . $menu['url'] ?>" 
                           class="nav-link px-3 py-2 rounded-lg text-sm font-medium text-slate-300 hover:text-white hover:bg-slate-800 transition-all">
                            <?= $menu['label'] ?>
                        </a>
                    <?php elseif ($menu['type'] === 'dropdown'): ?>
                        <!-- Dropdown -->
                        <div class="relative group">
                            <button class="nav-link px-3 py-2 rounded-lg text-sm font-medium text-slate-300 hover:text-white hover:bg-slate-800 transition-all inline-flex items-center">
                                <?= $menu['label'] ?>
                                <svg class="w-4 h-4 ml-1 transition-transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <!-- Dropdown Content -->
                            <div class="absolute left-0 mt-0 w-48 pt-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform origin-top-left z-50">
                                <div class="rounded-xl shadow-lg bg-slate-800 ring-1 ring-black ring-opacity-5 overflow-hidden">
                                    <div class="py-1">
                                        <?php foreach ($menu['items'] as $item): ?>
                                            <a href="<?= $path . $item['url'] ?>" class="block px-4 py-2 text-sm text-slate-300 hover:bg-slate-700 hover:text-white transition-colors">
                                                <?= $item['label'] ?>
                                            </a>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>

            <!-- CTA BUTTONS -->
            <div class="hidden lg:flex items-center space-x-4">
                <a href="<?= $path ?>pages/admin/login.php" class="text-slate-400 hover:text-white text-sm font-medium transition-colors">
                    Login
                </a>
                <a href="https://pmb.unika.ac.id/" target="_blank" class="px-5 py-2.5 bg-gradient-to-r from-indigo-500 to-cyan-500 hover:from-indigo-600 hover:to-cyan-600 text-white text-sm font-semibold rounded-lg shadow-lg shadow-indigo-500/30 transition-all transform hover:scale-105">
                    Daftar PMB
                </a>
            </div>

            <!-- MOBILE MENU BUTTON -->
            <div class="flex lg:hidden">
                <button type="button" id="mobile-menu-button" class="text-slate-300 hover:text-white p-2 rounded-lg hover:bg-slate-800 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- MOBILE MENU (Generated from Array) -->
    <div class="hidden lg:hidden bg-slate-900 border-t border-slate-800 overflow-hidden transition-all duration-300 ease-in-out" id="mobile-menu">
        <div class="px-2 pt-2 pb-3 space-y-1">
            <?php foreach ($menus as $menu): ?>
                <?php if ($menu['type'] === 'link'): ?>
                    <a href="<?= $path . $menu['url'] ?>" class="block px-3 py-2 rounded-lg text-base font-medium text-slate-300 hover:text-white hover:bg-slate-800">
                        <?= $menu['label'] ?>
                    </a>
                <?php elseif ($menu['type'] === 'dropdown'): ?>
                    <div class="space-y-1">
                        <div class="px-3 py-2 text-sm font-bold text-slate-500 uppercase tracking-wider">
                            <?= $menu['label'] ?>
                        </div>
                        <?php foreach ($menu['items'] as $item): ?>
                            <a href="<?= $path . $item['url'] ?>" class="block pl-6 pr-3 py-2 rounded-lg text-sm text-slate-400 hover:text-white hover:bg-slate-800">
                                <?= $item['label'] ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
            
            <!-- Mobile CTA -->
            <div class="mt-4 pt-4 border-t border-slate-800 px-2 space-y-3">
                <a href="<?= $path ?>pages/admin/login.php" class="block w-full text-center px-4 py-2 text-slate-300 border border-slate-700 rounded-lg hover:bg-slate-800 hover:text-white">
                    Login Admin
                </a>
                <a href="https://pmb.unika.ac.id/" target="_blank" class="block w-full text-center px-4 py-2 bg-gradient-to-r from-indigo-600 to-cyan-600 text-white rounded-lg hover:opacity-90">
                    Daftar PMB
                </a>
            </div>
        </div>
    </div>
</nav>

<script>
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');

    if(mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    }
</script>