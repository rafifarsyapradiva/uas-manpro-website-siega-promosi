<?php
session_start();

// 1. Cek Login
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    // Arahkan ke halaman login jika belum login
    // PERBAIKAN: Berdasarkan struktur folder, login.php ada di folder yang sama (pages/admin/)
    header('Location: login.php'); 
    exit;
}

// 2. Load Data Statistik
// Menggunakan path relatif: keluar dari 'admin' (../) -> keluar dari 'pages' (../../) -> masuk 'data'
$dataDir = '../../data/';

// Fungsi helper untuk menghitung jumlah item di JSON
function getCount($filename) {
    global $dataDir;
    $path = $dataDir . $filename;
    
    if (file_exists($path)) {
        $content = file_get_contents($path);
        $json = json_decode($content, true);
        
        if ($json === null) return 0;

        // Ambil nama file tanpa ekstensi sebagai key utama (standar struktur data SIEGA)
        $key = pathinfo($filename, PATHINFO_FILENAME);
        
        // Handle kasus khusus
        if ($key === 'biaya_kuliah') {
            // Untuk biaya kuliah, jika ada isinya dianggap 1 (Aktif)
            return isset($json['biaya_kuliah']) ? 1 : 0;
        }

        // Cek jika struktur menggunakan key utama (e.g. ['skripsi' => [...]])
        if (isset($json[$key]) && is_array($json[$key])) {
            return count($json[$key]);
        }
        
        // Fallback jika json langsung array root (e.g. [...])
        if (is_array($json)) {
            return count($json);
        }
    }
    return 0;
}

// Mengambil data statistik aktual
$stats = [
    'skripsi' => getCount('skripsi.json'),
    'journal' => getCount('journal.json'),
    'artikel' => getCount('artikel.json'),
    'berita'  => getCount('berita.json'),
    'biaya'   => 'Aktif' // Status statis untuk config
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - SIEGA</title>
    <!-- Menggunakan Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        /* Custom Scrollbar untuk sidebar jika konten panjang */
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #1e293b; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #475569; border-radius: 4px; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">

    <!-- INCLUDE SIDEBAR -->
    <!-- 
        PERBAIKAN PATH:
        Dari: pages/admin/dashboard.php
        Ke:   components/sidebar-admin.php
        Path: ../../components/sidebar-admin.php
        (Folder 'includes' dihapus karena tidak ada di struktur folder project)
    -->
    <?php include '../../components/sidebar-admin.php'; ?>

    <!-- MAIN CONTENT WRAPPER -->
    <!-- ml-64 PENTING agar konten tidak tertutup sidebar yang fixed (w-64) -->
    <div class="ml-64 min-h-screen flex flex-col transition-all duration-300">
        
        <!-- Top Navigation / Header Mobile -->
        <header class="bg-white border-b h-16 flex items-center justify-between px-8 sticky top-0 z-30 shadow-sm">
            <div class="text-sm text-gray-500">
                Selamat Datang, <span class="font-bold text-gray-800">Administrator</span>
            </div>
            <div class="text-sm text-gray-400">
                <?= date('l, d F Y') ?>
            </div>
        </header>

        <!-- Content Area -->
        <main class="p-8 flex-1">
            <div class="mb-8">
                <h1 class="text-2xl font-bold text-gray-800">Dashboard Overview</h1>
                <p class="text-gray-500 mt-1">Ringkasan aktivitas dan konten website SIEGA.</p>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Card 1: Skripsi -->
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-indigo-50 p-3 rounded-lg text-indigo-600">
                            <!-- Icon Academic Cap -->
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"></path></svg>
                        </div>
                        <span class="text-xs font-semibold text-green-600 bg-green-50 px-2 py-1 rounded-full">Publik</span>
                    </div>
                    <h3 class="text-gray-500 text-sm font-medium">Total Data Skripsi</h3>
                    <p class="text-3xl font-bold text-gray-800 mt-1"><?= $stats['skripsi'] ?></p>
                    <a href="kelola/skripsi.php" class="text-indigo-600 text-sm font-medium mt-4 inline-block hover:underline">Kelola Data &rarr;</a>
                </div>

                <!-- Card 2: Journal -->
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-blue-50 p-3 rounded-lg text-blue-600">
                            <!-- Icon Book -->
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        </div>
                    </div>
                    <h3 class="text-gray-500 text-sm font-medium">E-Journal Terbit</h3>
                    <p class="text-3xl font-bold text-gray-800 mt-1"><?= $stats['journal'] ?></p>
                    <a href="kelola/journal.php" class="text-blue-600 text-sm font-medium mt-4 inline-block hover:underline">Kelola Journal &rarr;</a>
                </div>

                <!-- Card 3: Berita -->
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-pink-50 p-3 rounded-lg text-pink-600">
                            <!-- Icon Newspaper -->
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                        </div>
                    </div>
                    <h3 class="text-gray-500 text-sm font-medium">Berita & Artikel</h3>
                    <p class="text-3xl font-bold text-gray-800 mt-1"><?= $stats['berita'] + $stats['artikel'] ?></p>
                    <a href="kelola/berita.php" class="text-pink-600 text-sm font-medium mt-4 inline-block hover:underline">Lihat Berita &rarr;</a>
                </div>

                <!-- Card 4: Biaya Kuliah -->
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-amber-50 p-3 rounded-lg text-amber-600">
                            <!-- Icon Cash -->
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <span class="text-xs font-semibold text-amber-600 bg-amber-50 px-2 py-1 rounded-full">Updated</span>
                    </div>
                    <h3 class="text-gray-500 text-sm font-medium">Status Biaya Kuliah</h3>
                    <p class="text-xl font-bold text-gray-800 mt-1"><?= $stats['biaya'] ?></p>
                    <a href="kelola/biaya-kuliah.php" class="text-amber-600 text-sm font-medium mt-4 inline-block hover:underline">Update Biaya &rarr;</a>
                </div>
            </div>

            <!-- Quick Actions Section -->
            <div class="bg-white rounded-xl p-8 shadow-sm border border-gray-100">
                <h2 class="text-lg font-bold text-gray-800 mb-6">Aksi Cepat</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <a href="kelola/skripsi.php" class="flex flex-col items-center justify-center p-6 rounded-xl border-2 border-dashed border-gray-200 hover:border-indigo-500 hover:bg-indigo-50 transition-all group">
                        <span class="text-3xl mb-2 group-hover:scale-110 transition-transform">🎓</span>
                        <span class="font-medium text-gray-600 group-hover:text-indigo-700">Tambah Skripsi</span>
                    </a>
                    <a href="kelola/berita.php" class="flex flex-col items-center justify-center p-6 rounded-xl border-2 border-dashed border-gray-200 hover:border-pink-500 hover:bg-pink-50 transition-all group">
                        <span class="text-3xl mb-2 group-hover:scale-110 transition-transform">📢</span>
                        <span class="font-medium text-gray-600 group-hover:text-pink-700">Posting Berita</span>
                    </a>
                    <a href="kelola/biaya-kuliah.php" class="flex flex-col items-center justify-center p-6 rounded-xl border-2 border-dashed border-gray-200 hover:border-amber-500 hover:bg-amber-50 transition-all group">
                        <span class="text-3xl mb-2 group-hover:scale-110 transition-transform">💰</span>
                        <span class="font-medium text-gray-600 group-hover:text-amber-700">Ubah Biaya</span>
                    </a>
                    <a href="kelola/konsentrasi.php" class="flex flex-col items-center justify-center p-6 rounded-xl border-2 border-dashed border-gray-200 hover:border-blue-500 hover:bg-blue-50 transition-all group">
                        <span class="text-3xl mb-2 group-hover:scale-110 transition-transform">🧩</span>
                        <span class="font-medium text-gray-600 group-hover:text-blue-700">Konsentrasi</span>
                    </a>
                </div>
            </div>

        </main>
    </div>

</body>
</html>