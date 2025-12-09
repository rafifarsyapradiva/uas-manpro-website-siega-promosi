<?php
/**
 * SIEGA Footer Component
 * Refactored: Menggunakan struktur data yang sinkron dengan Navbar agar isinya lebih lengkap ("ramai").
 */

// LOGIKA PENENTUAN PATH
$current_script = $_SERVER['PHP_SELF'];
$path = "./";

if (strpos($current_script, '/pages/user/konsentrasi/') !== false || strpos($current_script, '/pages/admin/kelola/') !== false) {
    $path = "../../../";
} elseif (strpos($current_script, '/pages/user/') !== false || strpos($current_script, '/pages/admin/') !== false) {
    $path = "../../";
}

// DEFINISI MENU FOOTER (Sinkron dengan Navbar)
$footer_sections = [
    'Akademik & Konsentrasi' => [
        ['label' => 'Kurikulum', 'url' => 'pages/user/kurikulum.php'],
        ['label' => 'Dosen & Staff', 'url' => 'pages/user/dosen.php'],
        ['label' => 'Sistem Informasi', 'url' => 'pages/user/konsentrasi/sistem-informasi.php'],
        ['label' => 'E-Commerce', 'url' => 'pages/user/konsentrasi/e-commerce.php'],
        ['label' => 'Game Technology', 'url' => 'pages/user/konsentrasi/game-technology.php'],
        ['label' => 'Akuntansi SI', 'url' => 'pages/user/konsentrasi/akuntansi-si.php'],
    ],
    'Informasi & Publikasi' => [
        ['label' => 'Berita Terkini', 'url' => 'pages/user/berita.php'],
        ['label' => 'Artikel Mahasiswa', 'url' => 'pages/user/artikel.php'],
        ['label' => 'Agenda Kegiatan', 'url' => 'pages/user/kegiatan.php'],
        ['label' => 'Jurnal Ilmiah', 'url' => 'pages/user/journal.php'],
        ['label' => 'Skripsi', 'url' => 'pages/user/skripsi.php'],
        ['label' => 'Biaya Kuliah', 'url' => 'pages/user/biaya-kuliah.php'],
    ],
    'Mahasiswa & Alumni' => [
        ['label' => 'Alumni Sukses', 'url' => 'pages/user/alumni.php'],
        ['label' => 'Fasilitas Kampus', 'url' => 'pages/user/fasilitas.php'],
        ['label' => 'Gallery Foto', 'url' => 'pages/user/gallery.php'],
        ['label' => 'Quiz Interaktif', 'url' => 'pages/user/quiz.php'],
        ['label' => 'FAQ', 'url' => 'pages/user/faq.php'],
    ]
];
?>

<footer class="bg-slate-900 border-t border-slate-800 mt-20 font-sans">
    <!-- Main Footer Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-12 lg:gap-8">
            
            <!-- COLUMN 1: BRAND & ADDRESS (Lebar 4 kolom grid) -->
            <div class="lg:col-span-4 space-y-6">
                <div class="flex items-center space-x-3">
                    <img src="<?= $path ?>assets/images/logo-siega.png" 
                         onerror="this.src='https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS7_E-GHjO-1AHhwnumcaSvT4LhU4Nl-lT5Fg&s'"
                         alt="SIEGA Logo" 
                         class="h-14 w-auto">
                    <div>
                        <h3 class="text-2xl font-bold text-white tracking-tight">SIEGA</h3>
                        <p class="text-sm text-cyan-400 font-medium">Harvest Your Future</p>
                    </div>
                </div>
                <p class="text-slate-400 text-sm leading-relaxed pr-4">
                    Program Studi Sistem Informasi, Fakultas Ilmu Komputer, Universitas Katolik Soegijapranata (SCU). Menghasilkan lulusan yang kompeten dalam teknologi dan bisnis.
                </p>
                
                <div class="space-y-3 pt-2">
                    <div class="flex items-start space-x-3 text-slate-400 text-sm group">
                        <!-- Icon Map -->
                        <svg class="w-5 h-5 text-cyan-500 mt-0.5 flex-shrink-0 group-hover:text-white transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span class="group-hover:text-slate-200 transition-colors">
                            Gedung Henricus Constant, Lt. 6<br>
                            Jl. Pawiyatan Luhur IV/1, Bendan Duwur,<br>
                            Semarang, Jawa Tengah
                        </span>
                    </div>
                    <div class="flex items-center space-x-3 text-slate-400 text-sm group">
                        <!-- Icon Mail -->
                        <svg class="w-5 h-5 text-cyan-500 flex-shrink-0 group-hover:text-white transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <a href="mailto:siega@unika.ac.id" class="group-hover:text-cyan-400 transition-colors">siega@unika.ac.id</a>
                    </div>
                </div>
            </div>

            <!-- DYNAMIC COLUMNS (Menggunakan Array) -->
            
            <!-- Column 2: Akademik (Lebar 3 kolom) -->
            <div class="lg:col-span-3">
                <h4 class="text-white font-bold text-lg mb-6 border-b border-slate-800 pb-2 inline-block">Akademik</h4>
                <ul class="space-y-3 text-sm">
                    <?php foreach ($footer_sections['Akademik & Konsentrasi'] as $item): ?>
                    <li>
                        <a href="<?= $path . $item['url'] ?>" class="text-slate-400 hover:text-cyan-400 hover:translate-x-1 transition-all inline-flex items-center">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-600 mr-2"></span>
                            <?= $item['label'] ?>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- Column 3: Informasi (Lebar 3 kolom) -->
            <div class="lg:col-span-3">
                <h4 class="text-white font-bold text-lg mb-6 border-b border-slate-800 pb-2 inline-block">Publikasi</h4>
                <ul class="space-y-3 text-sm">
                    <?php foreach ($footer_sections['Informasi & Publikasi'] as $item): ?>
                    <li>
                        <a href="<?= $path . $item['url'] ?>" class="text-slate-400 hover:text-cyan-400 hover:translate-x-1 transition-all inline-flex items-center">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-600 mr-2"></span>
                            <?= $item['label'] ?>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- Column 4: Lainnya & Sosmed (Lebar 2 kolom) -->
            <div class="lg:col-span-2">
                <h4 class="text-white font-bold text-lg mb-6 border-b border-slate-800 pb-2 inline-block">Lainnya</h4>
                <ul class="space-y-3 text-sm mb-8">
                    <?php foreach ($footer_sections['Mahasiswa & Alumni'] as $item): ?>
                    <li>
                        <a href="<?= $path . $item['url'] ?>" class="text-slate-400 hover:text-cyan-400 hover:translate-x-1 transition-all inline-flex items-center">
                            <?= $item['label'] ?>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>

                <h5 class="text-white font-semibold text-sm mb-4">Ikuti Kami</h5>
                <div class="flex space-x-3">
                    <!-- Instagram -->
                    <a href="#" class="bg-slate-800 p-2 rounded-lg text-slate-400 hover:text-white hover:bg-pink-600 transition-all transform hover:-translate-y-1">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                    </a>
                    <!-- Youtube -->
                    <a href="#" class="bg-slate-800 p-2 rounded-lg text-slate-400 hover:text-white hover:bg-red-600 transition-all transform hover:-translate-y-1">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/></svg>
                    </a>
                </div>
            </div>
        </div>

        <!-- Copyright -->
        <div class="border-t border-slate-800 mt-16 pt-8 flex flex-col md:flex-row justify-between items-center text-sm text-slate-500">
            <p>&copy; <?= date('Y') ?> SIEGA Unika Soegijapranata. All rights reserved.</p>
            <div class="flex space-x-6 mt-4 md:mt-0">
                <a href="#" class="hover:text-slate-300 transition-colors">Privacy Policy</a>
                <a href="#" class="hover:text-slate-300 transition-colors">Terms of Service</a>
            </div>
        </div>
    </div>
</footer>