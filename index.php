<?php
require_once 'config.php';

// Get data for landing page
$konsentrasi = getKonsentrasi();
$berita = getBerita(3); // Latest 3 news
$prestasi = array_slice(getPrestasi(), 0, 3); // Top 3 achievements
$stats = getStatistics();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo SITE_NAME; ?> - <?php echo SITE_TAGLINE; ?>">
    <title><?php echo SITE_NAME; ?></title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Favicon -->
    <link rel="icon" href="<?php echo WEBSITE_SIEGA; ?>/favicon.ico">
</head>
<body class="font-sans bg-slate-900 text-white">
    
    <!-- Navbar -->
    <?php include 'components/navbar.php'; ?>
    
    <!-- Hero Section -->
    <section class="relative min-h-screen flex items-center justify-center overflow-hidden">
        <!-- Animated Background -->
        <div class="absolute inset-0 bg-gradient-to-br from-slate-900 via-indigo-900 to-slate-900">
            <div class="absolute inset-0 opacity-20">
                <div class="absolute top-0 -left-4 w-72 h-72 bg-purple-500 rounded-full mix-blend-multiply filter blur-xl animate-blob"></div>
                <div class="absolute top-0 -right-4 w-72 h-72 bg-blue-500 rounded-full mix-blend-multiply filter blur-xl animate-blob animation-delay-2000"></div>
                <div class="absolute -bottom-8 left-20 w-72 h-72 bg-pink-500 rounded-full mix-blend-multiply filter blur-xl animate-blob animation-delay-4000"></div>
            </div>
        </div>
        
        <div class="container mx-auto px-4 relative z-10">
            <div class="text-center max-w-5xl mx-auto">
                <!-- Logo -->
                <div class="mb-8 animate-fade-in">
                    <img src="<?php echo WEBSITE_SIEGA; ?>/assets/images/logo-siega.png" 
                         alt="SIEGA Logo" 
                         class="h-24 mx-auto mb-4"
                         onerror="this.style.display='none'">
                </div>
                
                <!-- Main Heading -->
                <h1 class="text-5xl md:text-7xl font-bold mb-6 animate-fade-in-up">
                    <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-400 via-purple-400 to-pink-400">
                        SIEGA
                    </span>
                </h1>
                
                <h2 class="text-2xl md:text-3xl font-semibold mb-4 text-slate-300 animate-fade-in-up animation-delay-200">
                    Sistem Informasi, E-Commerce, Game Technology, Akuntansi-SI
                </h2>
                
                <!-- Tagline -->
                <p class="text-xl md:text-2xl text-slate-400 mb-8 animate-fade-in-up animation-delay-400">
                    🌾 <?php echo SITE_TAGLINE; ?>
                </p>
                
                <!-- Live Stats Counter -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-12 animate-fade-in-up animation-delay-600">
                    <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-6 border border-white/20 hover:bg-white/20 transition-all duration-300">
                        <div class="text-4xl font-bold text-blue-400 counter" data-target="<?php echo $stats['total_mahasiswa']; ?>">0</div>
                        <div class="text-sm text-slate-300 mt-2">Mahasiswa Aktif</div>
                    </div>
                    
                    <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-6 border border-white/20 hover:bg-white/20 transition-all duration-300">
                        <div class="text-4xl font-bold text-purple-400 counter" data-target="<?php echo $stats['total_alumni']; ?>">0</div>
                        <div class="text-sm text-slate-300 mt-2">Alumni Sukses</div>
                    </div>
                    
                    <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-6 border border-white/20 hover:bg-white/20 transition-all duration-300">
                        <div class="text-4xl font-bold text-pink-400 counter" data-target="<?php echo $stats['employment_rate']; ?>">0</div>
                        <div class="text-sm text-slate-300 mt-2">% Bekerja</div>
                    </div>
                    
                    <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-6 border border-white/20 hover:bg-white/20 transition-all duration-300">
                        <div class="text-4xl font-bold text-cyan-400 counter" data-target="4">0</div>
                        <div class="text-sm text-slate-300 mt-2">Konsentrasi</div>
                    </div>
                </div>
                
                <!-- CTA Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center animate-fade-in-up animation-delay-800">
                    <a href="<?php echo WEBSITE_PMB; ?>" 
                       target="_blank"
                       class="px-8 py-4 bg-gradient-to-r from-blue-500 to-purple-600 text-white font-semibold rounded-full hover:shadow-2xl hover:scale-105 transition-all duration-300">
                        📝 Daftar Sekarang
                    </a>
                    
                    <a href="pages/user/konsentrasi/index.php" 
                       class="px-8 py-4 bg-white/10 backdrop-blur-lg text-white font-semibold rounded-full border-2 border-white/30 hover:bg-white/20 hover:scale-105 transition-all duration-300">
                        🎯 Lihat Konsentrasi
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Scroll Indicator -->
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
            <svg class="w-6 h-6 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
            </svg>
        </div>
    </section>
    
    <!-- 4 Konsentrasi Cards -->
    <section class="py-20 bg-slate-800">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold mb-4">
                    4 Konsentrasi <span class="text-blue-400">Unggulan</span>
                </h2>
                <p class="text-xl text-slate-400">Pilih jalur karirmu di era digital</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <?php foreach ($konsentrasi as $k): ?>
                <div class="group">
                    <a href="pages/user/konsentrasi/<?php echo $k['id']; ?>.php" 
                       class="block bg-gradient-to-br from-slate-700 to-slate-800 rounded-2xl p-8 border border-slate-600 hover:border-<?php echo str_replace('#', '', $k['color']); ?>-400 hover:shadow-2xl hover:scale-105 transition-all duration-300">
                        
                        <!-- Icon -->
                        <div class="text-6xl mb-4 transform group-hover:scale-110 transition-transform duration-300">
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
                        
                        <!-- Title -->
                        <h3 class="text-2xl font-bold mb-3" style="color: <?php echo $k['color']; ?>">
                            <?php echo $k['nama']; ?>
                        </h3>
                        
                        <!-- Description -->
                        <p class="text-slate-400 mb-6 line-clamp-3">
                            <?php echo $k['deskripsi_singkat']; ?>
                        </p>
                        
                        <!-- Career Preview -->
                        <div class="space-y-2 mb-6">
                            <?php foreach (array_slice($k['career_paths'], 0, 2) as $career): ?>
                            <div class="flex items-center text-sm text-slate-300">
                                <span class="mr-2">💼</span>
                                <?php echo $career['title']; ?>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        
                        <!-- Learn More Button -->
                        <div class="flex items-center text-blue-400 font-semibold group-hover:text-blue-300">
                            <span>Pelajari Lebih Lanjut</span>
                            <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                            </svg>
                        </div>
                    </a>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    
    <!-- Why Choose SIEGA -->
    <section class="py-20 bg-slate-900">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold mb-4">
                    Kenapa Pilih <span class="text-purple-400">SIEGA?</span>
                </h2>
                <p class="text-xl text-slate-400">Keunggulan yang membuat kami berbeda</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Benefit 1 -->
                <div class="bg-gradient-to-br from-blue-900/30 to-slate-800/30 rounded-2xl p-8 border border-blue-500/20 backdrop-blur-lg">
                    <div class="text-5xl mb-4">🎓</div>
                    <h3 class="text-2xl font-bold mb-4 text-blue-400">Akreditasi Baik Sekali</h3>
                    <p class="text-slate-400">Program studi terakreditasi A dengan nilai 338 dari BAN-PT</p>
                </div>
                
                <!-- Benefit 2 -->
                <div class="bg-gradient-to-br from-purple-900/30 to-slate-800/30 rounded-2xl p-8 border border-purple-500/20 backdrop-blur-lg">
                    <div class="text-5xl mb-4">🏢</div>
                    <h3 class="text-2xl font-bold mb-4 text-purple-400">Kerja Sama Industri</h3>
                    <p class="text-slate-400">Partnership dengan Gojek, Tokopedia, Shopee, dan perusahaan unicorn lainnya</p>
                </div>
                
                <!-- Benefit 3 -->
                <div class="bg-gradient-to-br from-pink-900/30 to-slate-800/30 rounded-2xl p-8 border border-pink-500/20 backdrop-blur-lg">
                    <div class="text-5xl mb-4">💻</div>
                    <h3 class="text-2xl font-bold mb-4 text-pink-400">Lab Modern</h3>
                    <p class="text-slate-400">Fasilitas VR/AR, Game Lab, dan software berlisensi untuk praktik optimal</p>
                </div>
                
                <!-- Benefit 4 -->
                <div class="bg-gradient-to-br from-cyan-900/30 to-slate-800/30 rounded-2xl p-8 border border-cyan-500/20 backdrop-blur-lg">
                    <div class="text-5xl mb-4">🚀</div>
                    <h3 class="text-2xl font-bold mb-4 text-cyan-400">Program MBKM</h3>
                    <p class="text-slate-400">Magang 5 bulan di perusahaan ternama dengan konversi SKS</p>
                </div>
                
                <!-- Benefit 5 -->
                <div class="bg-gradient-to-br from-orange-900/30 to-slate-800/30 rounded-2xl p-8 border border-orange-500/20 backdrop-blur-lg">
                    <div class="text-5xl mb-4">👨‍🏫</div>
                    <h3 class="text-2xl font-bold mb-4 text-orange-400">Dosen Berkualitas</h3>
                    <p class="text-slate-400">Dosen profesional dengan gelar Doktor dan pengalaman industri</p>
                </div>
                
                <!-- Benefit 6 -->
                <div class="bg-gradient-to-br from-lime-900/30 to-slate-800/30 rounded-2xl p-8 border border-lime-500/20 backdrop-blur-lg">
                    <div class="text-5xl mb-4">💰</div>
                    <h3 class="text-2xl font-bold mb-4 text-lime-400">Beasiswa Lengkap</h3>
                    <p class="text-slate-400">Berbagai skema beasiswa hingga 100% untuk mahasiswa berprestasi</p>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Latest News -->
    <section class="py-20 bg-slate-800">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center mb-12">
                <div>
                    <h2 class="text-4xl md:text-5xl font-bold mb-4">
                        Berita <span class="text-blue-400">Terbaru</span>
                    </h2>
                    <p class="text-xl text-slate-400">Update terkini dari SIEGA</p>
                </div>
                <a href="pages/user/berita.php" class="text-blue-400 hover:text-blue-300 font-semibold flex items-center">
                    Lihat Semua
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                    </svg>
                </a>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <?php foreach ($berita as $b): ?>
                <article class="bg-slate-700 rounded-2xl overflow-hidden hover:shadow-2xl hover:scale-105 transition-all duration-300">
                    <img src="<?php echo $b['gambar']; ?>" 
                         alt="<?php echo $b['judul']; ?>"
                         class="w-full h-48 object-cover"
                         onerror="this.src='https://placehold.co/600x400/1e293b/64748b?text=SIEGA+News'">
                    
                    <div class="p-6">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="px-3 py-1 bg-blue-500/20 text-blue-400 text-xs font-semibold rounded-full">
                                <?php echo $b['kategori']; ?>
                            </span>
                            <span class="text-xs text-slate-400">
                                <?php echo formatTanggal($b['tanggal']); ?>
                            </span>
                        </div>
                        
                        <h3 class="text-xl font-bold mb-3 line-clamp-2">
                            <?php echo $b['judul']; ?>
                        </h3>
                        
                        <p class="text-slate-400 mb-4 line-clamp-3">
                            <?php echo $b['ringkasan']; ?>
                        </p>
                        
                        <a href="pages/user/berita-detail.php?id=<?php echo $b['id']; ?>" 
                           class="text-blue-400 hover:text-blue-300 font-semibold inline-flex items-center">
                            Baca Selengkapnya
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    
    <!-- CTA Section -->
    <section class="py-20 bg-gradient-to-br from-blue-900 via-purple-900 to-pink-900 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 left-0 w-96 h-96 bg-white rounded-full filter blur-3xl animate-pulse"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-white rounded-full filter blur-3xl animate-pulse animation-delay-2000"></div>
        </div>
        
        <div class="container mx-auto px-4 relative z-10">
            <div class="text-center max-w-4xl mx-auto">
                <h2 class="text-4xl md:text-6xl font-bold mb-6">
                    Siap Memanen Masa Depanmu?
                </h2>
                <p class="text-xl md:text-2xl text-slate-300 mb-8">
                    Bergabunglah dengan SIEGA dan wujudkan karir impianmu di dunia teknologi
                </p>
                
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="<?php echo WEBSITE_PMB; ?>" 
                       target="_blank"
                       class="px-10 py-5 bg-white text-purple-900 font-bold rounded-full text-lg hover:shadow-2xl hover:scale-105 transition-all duration-300">
                        🎓 Daftar Sekarang
                    </a>
                    
                    <a href="pages/user/kontak.php" 
                       class="px-10 py-5 bg-white/10 backdrop-blur-lg text-white font-bold rounded-full text-lg border-2 border-white/30 hover:bg-white/20 hover:scale-105 transition-all duration-300">
                        📞 Hubungi Kami
                    </a>
                </div>
                
                <div class="mt-12 flex items-center justify-center gap-8 text-sm text-slate-300">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span>Akreditasi A</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span>Beasiswa Tersedia</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span>92% Alumni Bekerja</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Footer -->
    <?php include 'components/footer.php'; ?>
    
    <!-- JavaScript -->
    <script src="assets/js/main.js"></script>
    <script src="assets/js/counter.js"></script>
</body>
</html>