<?php
/**
 * SIEGA Admin Sidebar Component
 * Lokasi File: /admin/includes/components/sidebar-admin.php
 * * Logic navigasi ini bekerja relatif terhadap file INDUK yang memanggilnya (dashboard.php dll),
 * bukan relatif terhadap lokasi fisik file sidebar ini.
 */

// 1. Deteksi Posisi Halaman Aktif (Browser URL)
$current_script = $_SERVER['PHP_SELF'];
$current_page   = basename($current_script, '.php');

// Cek apakah kita sedang berada di dalam sub-folder 'kelola'
// Jika URL browser mengandung '/kelola/', berarti kita ada di level yang lebih dalam
$is_in_kelola = strpos($current_script, '/kelola/') !== false;

// 2. Konfigurasi Link Navigasi (Relatif)

// Link ke Dashboard
// Jika di folder 'kelola', harus mundur satu folder (../)
$link_dashboard = $is_in_kelola ? '../dashboard.php' : 'dashboard.php';

// Link ke Menu Kelola (Skripsi, Jurnal, dll)
// Jika SUDAH di 'kelola', link langsung ke nama file (misal: skripsi.php)
// Jika BELUM (di dashboard), harus masuk folder dulu (misal: kelola/skripsi.php)
$path_kelola_prefix = $is_in_kelola ? '' : 'kelola/';

// Link Logout
// Asumsi: logout.php ada di luar folder admin (root project) atau parent folder
// Logic asli: dashboard (level 1) -> ../logout | kelola (level 2) -> ../../logout
$link_logout = $is_in_kelola ? '../../logout.php' : '../logout.php';

?>

<aside id="admin-sidebar" class="fixed inset-y-0 left-0 w-64 bg-slate-900 text-white transition-transform duration-300 z-50 flex flex-col h-screen border-r border-slate-800">
    <!-- Header Logo -->
    <div class="flex items-center space-x-3 px-6 h-16 border-b border-slate-800 bg-slate-900">
        <!-- Logo menggunakan URL absolut agar aman diakses dari level folder manapun -->
        <img src="https://siega.id/wp-content/uploads/2023/08/logo-siega-01-e1693365535817-150x150.png" alt="SIEGA Logo" class="h-8 w-8 rounded bg-white">
        <div>
            <h1 class="font-bold text-lg tracking-wide text-white">SIEGA</h1>
            <p class="text-[10px] text-slate-400 uppercase tracking-wider">Admin Panel</p>
        </div>
    </div>

    <!-- Scrollable Menu Area -->
    <div class="flex-1 overflow-y-auto py-4 px-3 space-y-1 custom-scrollbar">
        
        <!-- DASHBOARD -->
        <a href="<?= $link_dashboard ?>" 
           class="flex items-center space-x-3 px-3 py-2.5 rounded-lg transition-all duration-200 group <?= ($current_page === 'dashboard') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' ?>">
            <svg class="w-5 h-5 <?= ($current_page === 'dashboard') ? 'text-white' : 'text-slate-400 group-hover:text-white' ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
            <span class="font-medium text-sm">Dashboard</span>
        </a>

        <!-- SECTION: KELOLA KONTEN -->
        <div class="pt-5 pb-2 px-3 text-xs font-bold text-slate-500 uppercase tracking-wider">
            Manajemen Konten
        </div>

        <?php
        // Array Menu didefinisikan di sini agar HTML lebih bersih
        // 'file' harus sesuai dengan nama file php (tanpa ekstensi)
        $menus = [
            // --- Kelompok 1: Akademik & Info ---
            [
                'file' => 'konsentrasi', 
                'label' => 'Konsentrasi', 
                'icon' => 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10'
            ],
            [
                'file' => 'biaya-kuliah', 
                'label' => 'Biaya Kuliah', 
                'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z'
            ],

            // --- Kelompok 2: Data Mahasiswa & Alumni ---
            [
                'file' => 'skripsi', 
                'label' => 'Data Skripsi', 
                'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253'
            ],
            [
                'file' => 'alumni', 
                'label' => 'Data Alumni', 
                'icon' => 'M12 14l9-5-9-5-9 5 9 5z M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z'
            ],
            [
                'file' => 'prestasi', 
                'label' => 'Prestasi', 
                'icon' => 'M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z'
            ],

            // --- Kelompok 3: Publikasi & Berita ---
            [
                'file' => 'berita', 
                'label' => 'Berita', 
                'icon' => 'M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z'
            ],
            [
                'file' => 'kegiatan', 
                'label' => 'Kegiatan', 
                'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'
            ],
            [
                'file' => 'artikel', 
                'label' => 'Artikel / Blog', 
                'icon' => 'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z'
            ],
            [
                'file' => 'journal', 
                'label' => 'E-Journal', 
                'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253'
            ],

            // --- Kelompok 4: Media ---
            [
                'file' => 'gallery', 
                'label' => 'Galeri Foto', 
                'icon' => 'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z'
            ],
        ];

        foreach ($menus as $menu) {
            // Cek Active State
            $isActive = ($current_page === $menu['file']);
            
            // Tentukan Kelas CSS berdasarkan state
            $activeClass = $isActive 
                ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/30' 
                : 'text-slate-300 hover:bg-slate-800 hover:text-white';
            
            $iconClass = $isActive 
                ? 'text-white' 
                : 'text-slate-400 group-hover:text-white';
            
            // Render Menu Item
            echo "<a href=\"{$path_kelola_prefix}{$menu['file']}.php\" class=\"flex items-center space-x-3 px-3 py-2.5 rounded-lg transition-all duration-200 group mb-1 {$activeClass}\">";
            echo "  <svg class=\"w-5 h-5 flex-shrink-0 {$iconClass}\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\">";
            echo "      <path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"{$menu['icon']}\"></path>";
            echo "  </svg>";
            echo "  <span class=\"font-medium text-sm\">{$menu['label']}</span>";
            echo "</a>";
        }
        ?>

    </div>

    <!-- Footer Logout -->
    <div class="p-4 border-t border-slate-800 bg-slate-900">
        <a href="<?= $link_logout ?>" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-red-400 hover:bg-red-500/10 hover:text-red-300 transition-colors w-full group">
            <svg class="w-5 h-5 group-hover:text-red-300 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
            <span class="font-medium text-sm">Logout</span>
        </a>
    </div>
</aside>