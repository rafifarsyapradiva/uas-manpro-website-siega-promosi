<?php require_once '../../config.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang SIEGA - Program Studi Sistem Informasi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body class="bg-slate-900 text-white">
    <?php include '../../components/navbar.php'; ?>
    
    <!-- Hero Section -->
    <section class="pt-32 pb-20 bg-gradient-to-br from-indigo-900 via-slate-900 to-slate-900">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center">
                <h1 class="text-5xl md:text-6xl font-bold mb-6">Tentang SIEGA</h1>
                <p class="text-xl text-slate-300">Sistem Informasi, E-Commerce, Game Technology, Akuntansi-SI</p>
            </div>
        </div>
    </section>

    <!-- Filosofi SIEGA -->
    <section class="py-20 bg-slate-900">
        <div class="container mx-auto px-4">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div>
                    <img src="https://siega.id/wp-content/uploads/2023/01/logosieganew.png" 
                         alt="Logo SIEGA" class="w-full max-w-md mx-auto">
                </div>
                <div>
                    <h2 class="text-4xl font-bold mb-6">Filosofi "SIEGA" - Panen</h2>
                    <p class="text-lg text-slate-300 mb-4">
                        Dalam bahasa Spanyol, <span class="text-indigo-400 font-bold">SIEGA</span> berarti <span class="text-indigo-400 font-bold">PANEN</span>. 
                        Filosofi ini menjadi landasan program studi kami: dengan menguasai teknologi informasi dengan benar, 
                        mahasiswa akan memanen masa depan yang cemerlang.
                    </p>
                    <p class="text-lg text-slate-300 mb-4">
                        SIEGA adalah singkatan dari empat konsentrasi unggulan yang kami tawarkan:
                    </p>
                    <ul class="space-y-3 text-lg">
                        <li class="flex items-start">
                            <span class="text-indigo-400 mr-3">🖥️</span>
                            <span><strong>Sistem Informasi</strong> - Business Information Systems</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-cyan-400 mr-3">🛒</span>
                            <span><strong>E-Commerce</strong> - Electronic Commerce</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-pink-400 mr-3">🎮</span>
                            <span><strong>Game Technology</strong> - Game Development & Technology</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-orange-400 mr-3">💼</span>
                            <span><strong>Akuntansi-SI</strong> - Double Degree Program</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Visi Misi -->
    <section class="py-20 bg-slate-800">
        <div class="container mx-auto px-4">
            <div class="grid md:grid-cols-2 gap-12">
                <div class="bg-slate-900 rounded-2xl p-8">
                    <h3 class="text-3xl font-bold mb-6 text-indigo-400">Visi</h3>
                    <p class="text-lg text-slate-300 leading-relaxed">
                        Menjadi komunitas akademik yang unggul dalam pendidikan, penelitian dan pengabdian dengan dilandasi nilai-nilai Kristiani: cinta kasih, keadilan dan kejujuran
                    </p>
                </div>
                <div class="bg-slate-900 rounded-2xl p-8">
                    <h3 class="text-3xl font-bold mb-6 text-cyan-400">Misi</h3>
                    <ul class="space-y-4 text-slate-300">
                        <li class="flex items-start">
                            <span class="text-cyan-400 mr-3 mt-1">✓</span>
                            <span>Menyelenggarakan pendidikan yang berkualitas secara akademik dengan didukung pengembangan kepribadian yang utuh dan potensi kepemimpinan.</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-cyan-400 mr-3 mt-1">✓</span>
                            <span>Melakukan penelitian untuk pengembangan ilmu dan teknologi demi meningkatkan kesejahteraan manusia.</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-cyan-400 mr-3 mt-1">✓</span>
                            <span>Melakukan pengabdian kepada masyarakat sebagai penerapan ilmu dan teknologi yang telah dikembangkan dalam penelitian dan kesejahteraan manusia.</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-cyan-400 mr-3 mt-1">✓</span>
                            <span>Memberikan perhatian dan mencari pemecahan terhadap berbagai masalah sosial budaya masyarakat melalui komunitas akademik.</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-cyan-400 mr-3 mt-1">✓</span>
                            <span>Mengembangkan jaringan Kerjasama dengan berbagai institusi pendidikan, penelitian dan pengabdian lokal, nasional dan internasional untuk meningkatkan kualitas pendidikan dan penelitian.</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-cyan-400 mr-3 mt-1">✓</span>
                            <span>Memperbaiki dan mengembangkan universitas secara terus menerus, sehingga dapat mendukung segala upaya untuk mencapai keunggulan.</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Akreditasi -->
    <section class="py-20 bg-slate-900">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center">
                <div class="bg-gradient-to-r from-indigo-600 to-cyan-600 rounded-2xl p-12">
                    <div class="text-6xl mb-6">🏆</div>
                    <h2 class="text-4xl font-bold mb-4">Akreditasi Baik Sekali</h2>
                    <p class="text-xl mb-6">Program Studi Sistem Informasi terakreditasi <strong>Baik Sekali</strong></p>
                    <div class="bg-white/10 backdrop-blur-lg rounded-xl p-6 inline-block">
                        <p class="text-lg mb-2">Nilai Akreditasi: <span class="text-3xl font-bold">338</span></p>
                        <p class="text-sm text-indigo-200">SK BAN-PT No. 10974/SK/BAN-PT/Ak.ISK/S/IX/2021</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Kenapa Pilih SIEGA -->
    <section class="py-20 bg-slate-800">
        <div class="container mx-auto px-4">
            <h2 class="text-4xl font-bold text-center mb-16">Kenapa Pilih SIEGA?</h2>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-slate-900 rounded-xl p-8 hover:bg-slate-800 transition">
                    <div class="text-5xl mb-4">🎓</div>
                    <h3 class="text-xl font-bold mb-3">Kurikulum Industri</h3>
                    <p class="text-slate-400">Kurikulum dirancang bersama praktisi industri untuk memenuhi kebutuhan pasar kerja</p>
                </div>
                <div class="bg-slate-900 rounded-xl p-8 hover:bg-slate-800 transition">
                    <div class="text-5xl mb-4">👨‍🏫</div>
                    <h3 class="text-xl font-bold mb-3">Dosen Berpengalaman</h3>
                    <p class="text-slate-400">Dosen dengan gelar Doktor dan pengalaman di industri teknologi</p>
                </div>
                <div class="bg-slate-900 rounded-xl p-8 hover:bg-slate-800 transition">
                    <div class="text-5xl mb-4">🏢</div>
                    <h3 class="text-xl font-bold mb-3">Mitra Industri</h3>
                    <p class="text-slate-400">Kerjasama dengan 50+ perusahaan untuk magang dan rekrutmen</p>
                </div>
                <div class="bg-slate-900 rounded-xl p-8 hover:bg-slate-800 transition">
                    <div class="text-5xl mb-4">🔬</div>
                    <h3 class="text-xl font-bold mb-3">Lab Modern</h3>
                    <p class="text-slate-400">Fasilitas laboratorium dengan peralatan dan software terkini</p>
                </div>
                <div class="bg-slate-900 rounded-xl p-8 hover:bg-slate-800 transition">
                    <div class="text-5xl mb-4">🌍</div>
                    <h3 class="text-xl font-bold mb-3">Program MBKM</h3>
                    <p class="text-slate-400">Kesempatan magang, studi independen, dan pertukaran mahasiswa</p>
                </div>
                <div class="bg-slate-900 rounded-xl p-8 hover:bg-slate-800 transition">
                    <div class="text-5xl mb-4">📜</div>
                    <h3 class="text-xl font-bold mb-3">Sertifikasi Internasional</h3>
                    <p class="text-slate-400">Kesempatan mendapat sertifikasi Oracle, Microsoft, SAP, dan lainnya</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Sejarah Singkat -->
    <section class="py-20 bg-slate-900">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto">
                <h2 class="text-4xl font-bold mb-12 text-center">Sejarah Program Studi</h2>
                <div class="space-y-8">
                    <div class="bg-slate-800 rounded-xl p-8 border-l-4 border-indigo-500">
                        <div class="text-2xl font-bold text-indigo-400 mb-2">2005</div>
                        <p class="text-slate-300">Program Studi Sistem Informasi didirikan sebagai bagian dari Fakultas Ilmu Komputer Universitas Katolik Soegijapranata</p>
                    </div>
                    <div class="bg-slate-800 rounded-xl p-8 border-l-4 border-cyan-500">
                        <div class="text-2xl font-bold text-cyan-400 mb-2">2015</div>
                        <p class="text-slate-300">Pengembangan 4 konsentrasi: Sistem Informasi, E-Commerce, Game Technology, dan Akuntansi-SI</p>
                    </div>
                    <div class="bg-slate-800 rounded-xl p-8 border-l-4 border-pink-500">
                        <div class="text-2xl font-bold text-pink-400 mb-2">2021</div>
                        <p class="text-slate-300">Meraih Akreditasi Baik Sekali dari BAN-PT dengan nilai 338</p>
                    </div>
                    <div class="bg-slate-800 rounded-xl p-8 border-l-4 border-orange-500">
                        <div class="text-2xl font-bold text-orange-400 mb-2">2024</div>
                        <p class="text-slate-300">Terus berinovasi dengan program MBKM dan kerjasama internasional</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="py-20 bg-gradient-to-r from-indigo-600 to-cyan-600">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-4xl font-bold mb-6">Tertarik Bergabung dengan SIEGA?</h2>
            <p class="text-xl mb-8">Mulai perjalanan karirmu di dunia teknologi bersama kami</p>
            <a href="kontak.php" class="inline-block px-8 py-4 bg-white text-indigo-600 rounded-lg font-semibold text-lg hover:bg-slate-100 transition duration-300">
                Hubungi Kami Sekarang
            </a>
        </div>
    </section>

    <?php include '../../components/footer.php'; ?>
    <script src="../../assets/js/main.js"></script>
</body>
</html>