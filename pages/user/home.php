<?php
require_once '../../config.php';
$konsentrasi = readJSON('konsentrasi');
$berita = readJSON('berita');
$prestasi = readJSON('prestasi');
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIEGA - Harvest Your Future Through Technology</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body class="bg-slate-900 text-white">
    <?php include '../../components/navbar.php'; ?>
    
    <!-- Hero Section -->
    <section class="relative min-h-screen flex items-center justify-center overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-indigo-900 via-slate-900 to-slate-900"></div>
        <div class="absolute inset-0 opacity-20">
            <div class="absolute top-20 left-20 w-72 h-72 bg-indigo-500 rounded-full mix-blend-multiply filter blur-xl animate-blob"></div>
            <div class="absolute top-40 right-20 w-72 h-72 bg-cyan-500 rounded-full mix-blend-multiply filter blur-xl animate-blob animation-delay-2000"></div>
            <div class="absolute bottom-20 left-40 w-72 h-72 bg-pink-500 rounded-full mix-blend-multiply filter blur-xl animate-blob animation-delay-4000"></div>
        </div>
        
        <div class="container mx-auto px-4 relative z-10">
            <div class="text-center max-w-4xl mx-auto">
                <img src="https://siega.id/wp-content/uploads/2024/10/logo-siega-unika-soegijapranata-semarang.png" 
                     alt="SIEGA Logo" class="w-48 h-48 mx-auto mb-8 drop-shadow-2xl">
                <h1 class="text-5xl md:text-7xl font-bold mb-6 bg-gradient-to-r from-indigo-400 via-cyan-400 to-pink-400 bg-clip-text text-transparent">
                    Harvest Your Future Through Technology
                </h1>
                <p class="text-xl md:text-2xl text-slate-300 mb-8">
                    Program Studi Sistem Informasi Universitas Katolik Soegijapranata
                </p>
                <p class="text-lg text-slate-400 mb-12">
                    4 Konsentrasi Unggulan | Akreditasi Baik Sekali | Career-Ready Graduates
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="kontak.php" class="px-8 py-4 bg-gradient-to-r from-indigo-500 to-cyan-500 rounded-lg font-semibold text-lg hover:shadow-2xl hover:scale-105 transition duration-300">
                        Daftar Sekarang
                    </a>
                    <a href="konsentrasi/index.php" class="px-8 py-4 bg-slate-800 border-2 border-slate-600 rounded-lg font-semibold text-lg hover:bg-slate-700 transition duration-300">
                        Lihat Konsentrasi
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Scroll Indicator -->
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
            <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
            </svg>
        </div>
    </section>

    <!-- Live Stats Counter -->
    <section class="py-20 bg-slate-800">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="text-5xl font-bold text-indigo-400 mb-2" data-count="500">0</div>
                    <div class="text-slate-400">Mahasiswa Aktif</div>
                </div>
                <div class="text-center">
                    <div class="text-5xl font-bold text-cyan-400 mb-2" data-count="300">0</div>
                    <div class="text-slate-400">Alumni Sukses</div>
                </div>
                <div class="text-center">
                    <div class="text-5xl font-bold text-pink-400 mb-2" data-count="50">0</div>
                    <div class="text-slate-400">Mitra Industri</div>
                </div>
                <div class="text-center">
                    <div class="text-5xl font-bold text-orange-400 mb-2" data-count="100">0</div>
                    <div class="text-slate-400">Projek Selesai</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Konsentrasi Cards -->
    <section class="py-20 bg-slate-900">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold mb-4">4 Konsentrasi Unggulan</h2>
                <p class="text-xl text-slate-400">Pilih jalur karir yang sesuai dengan passion-mu</p>
            </div>
            
            <div class="grid md:grid-cols-2 gap-8">
                <?php foreach ($konsentrasi['konsentrasi'] as $k): ?>
                <a href="konsentrasi/<?= $k['id'] ?>.php" class="group relative bg-slate-800 rounded-2xl p-8 hover:bg-slate-700 transition duration-300 overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-<?= str_replace('#', '', $k['color']) ?> opacity-10 rounded-full blur-3xl"></div>
                    <div class="relative z-10">
                        <div class="text-5xl mb-4">
                            <?php 
                            $icons = [
                                'database' => '🖥️',
                                'shopping-cart' => '🛒',
                                'gamepad' => '🎮',
                                'calculator' => '💼'
                            ];
                            echo $icons[$k['icon']] ?? '📊';
                            ?>
                        </div>
                        <h3 class="text-2xl font-bold mb-2 group-hover:text-indigo-400 transition"><?= $k['nama'] ?></h3>
                        <p class="text-slate-400 mb-4"><?= $k['nama_inggris'] ?></p>
                        <p class="text-slate-300 mb-6"><?= $k['deskripsi_singkat'] ?></p>
                        <div class="flex items-center text-indigo-400 font-semibold">
                            Selengkapnya 
                            <svg class="w-5 h-5 ml-2 group-hover:translate-x-2 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Why Choose SIEGA -->
    <section class="py-20 bg-slate-800">
        <div class="container mx-auto px-4">
            <h2 class="text-4xl font-bold text-center mb-16">Kenapa Pilih SIEGA?</h2>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-slate-900 rounded-xl p-8">
                    <div class="w-16 h-16 bg-indigo-500 rounded-lg flex items-center justify-center text-3xl mb-4">🏆</div>
                    <h3 class="text-xl font-bold mb-3">Akreditasi Baik Sekali</h3>
                    <p class="text-slate-400">Terakreditasi Baik Sekali dengan nilai 338 dari BAN-PT</p>
                </div>
                <div class="bg-slate-900 rounded-xl p-8">
                    <div class="w-16 h-16 bg-cyan-500 rounded-lg flex items-center justify-center text-3xl mb-4">💼</div>
                    <h3 class="text-xl font-bold mb-3">Career Ready</h3>
                    <p class="text-slate-400">90% alumni bekerja di perusahaan ternama dalam 6 bulan</p>
                </div>
                <div class="bg-slate-900 rounded-xl p-8">
                    <div class="w-16 h-16 bg-pink-500 rounded-lg flex items-center justify-center text-3xl mb-4">🚀</div>
                    <h3 class="text-xl font-bold mb-3">Praktik Langsung</h3>
                    <p class="text-slate-400">Project-based learning dengan mitra industri terkemuka</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Latest News Preview -->
    <section class="py-20 bg-slate-900">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center mb-12">
                <h2 class="text-4xl font-bold">Berita Terbaru</h2>
                <a href="berita.php" class="text-indigo-400 hover:text-indigo-300 font-semibold">Lihat Semua →</a>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                <?php 
                $latest_news = array_slice($berita['berita'], 0, 3);
                foreach ($latest_news as $news): 
                ?>
                <article class="bg-slate-800 rounded-xl overflow-hidden hover:transform hover:scale-105 transition duration-300">
                    <img src="https://siega.id/wp-content/uploads/2024/10/student-of-the-year-2025-unika-soegijapranata.jpg" 
                         alt="<?= htmlspecialchars($news['judul']) ?>" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <div class="text-sm text-indigo-400 mb-2"><?= date('d M Y', strtotime($news['tanggal'])) ?></div>
                        <h3 class="text-xl font-bold mb-3 line-clamp-2"><?= htmlspecialchars($news['judul']) ?></h3>
                        <p class="text-slate-400 mb-4 line-clamp-3"><?= htmlspecialchars($news['excerpt']) ?></p>
                        <a href="berita.php?id=<?= $news['id'] ?>" class="text-indigo-400 font-semibold hover:text-indigo-300">
                            Baca Selengkapnya →
                        </a>
                    </div>
                </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-gradient-to-r from-indigo-600 to-cyan-600">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-4xl md:text-5xl font-bold mb-6">Siap Memanen Masa Depanmu?</h2>
            <p class="text-xl mb-8 text-indigo-100">Bergabunglah dengan SIEGA dan mulai perjalanan karirmu di dunia teknologi</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="kontak.php" class="px-8 py-4 bg-white text-indigo-600 rounded-lg font-semibold text-lg hover:bg-slate-100 transition duration-300">
                    Hubungi Kami
                </a>
                <a href="biaya-kuliah.php" class="px-8 py-4 bg-transparent border-2 border-white rounded-lg font-semibold text-lg hover:bg-white hover:text-indigo-600 transition duration-300">
                    Lihat Biaya Kuliah
                </a>
            </div>
        </div>
    </section>

    <?php include '../../components/footer.php'; ?>
    
    <script src="../../assets/js/counter.js"></script>
    <script src="../../assets/js/main.js"></script>
</body>
</html>