<?php
require_once '../../config.php';

// --- PERBAIKAN: Robust Data Loading ---
$kegiatan_data = readJSON('kegiatan');

// Fallback jika readJSON gagal
if (!$kegiatan_data) {
    $path_kegiatan = __DIR__ . '/../../data/kegiatan.json';
    if (file_exists($path_kegiatan)) {
        $json_content = file_get_contents($path_kegiatan);
        $kegiatan_data = json_decode($json_content, true);
    }
}

// Validasi Array
$list_kegiatan = (isset($kegiatan_data) && isset($kegiatan_data['kegiatan'])) ? $kegiatan_data['kegiatan'] : [];

// Fungsi helper untuk format tanggal Indonesia
function tanggal_indo($tanggal) {
    if (strpos($tanggal, 's/d') !== false) return $tanggal; // Jika format range, biarkan
    $bulan = array (
        1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    );
    $split = explode('-', $tanggal);
    if(count($split) === 3) {
        return $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];
    }
    return $tanggal;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kegiatan & Workshop - SIEGA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body class="bg-slate-900 text-white">
    <?php include '../../components/navbar.php'; ?>
    
    <!-- Hero Section -->
    <section class="pt-32 pb-12 bg-gradient-to-br from-purple-900 via-slate-900 to-slate-900">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center">
                <div class="text-6xl mb-6">🎭</div>
                <h1 class="text-5xl md:text-6xl font-bold mb-6">Kegiatan & Workshop</h1>
                <p class="text-xl text-slate-300">Program pengembangan skill, kompetisi, dan networking mahasiswa SIEGA</p>
            </div>
        </div>
    </section>

    <!-- Events List -->
    <section class="py-20 bg-slate-900">
        <div class="container mx-auto px-4">
            <?php if (empty($list_kegiatan)): ?>
                <div class="text-center py-20 border-2 border-dashed border-slate-700 rounded-xl">
                    <div class="text-4xl mb-4">📅</div>
                    <h3 class="text-2xl font-bold text-slate-400">Jadwal Belum Tersedia</h3>
                    <p class="text-slate-500 mt-2">Nantikan update kegiatan seru dari SIEGA!</p>
                </div>
            <?php else: ?>
                <div class="grid lg:grid-cols-2 gap-8 max-w-6xl mx-auto">
                    <?php foreach ($list_kegiatan as $k): ?>
                    <div class="bg-slate-800 rounded-xl overflow-hidden border border-slate-700 hover:border-purple-500 transition group flex flex-col md:flex-row">
                        <!-- Date Badge (Left Side) -->
                        <div class="md:w-32 bg-slate-900 flex flex-col items-center justify-center p-6 border-b md:border-b-0 md:border-r border-slate-700 group-hover:bg-purple-900/20 transition">
                            <span class="text-xs font-bold text-purple-400 uppercase tracking-wider mb-1">
                                <?= htmlspecialchars($k['kategori']) ?>
                            </span>
                            <?php 
                                // Ambil tanggal/bulan simple jika format tanggal YYYY-MM-DD
                                $tgl_parts = explode('-', $k['tanggal']);
                                if(count($tgl_parts) == 3):
                            ?>
                                <span class="text-4xl font-bold text-white"><?= $tgl_parts[2] ?></span>
                                <span class="text-sm text-slate-400 uppercase"><?= date('M', strtotime($k['tanggal'])) ?></span>
                            <?php else: ?>
                                <span class="text-xl font-bold text-white text-center text-xs mt-2"><?= htmlspecialchars($k['tanggal']) ?></span>
                            <?php endif; ?>
                            
                            <?php if(isset($k['status']) && $k['status'] == 'Selesai'): ?>
                                <span class="mt-3 px-2 py-1 bg-slate-700 text-slate-400 text-[10px] rounded-full uppercase font-bold">Selesai</span>
                            <?php else: ?>
                                <span class="mt-3 px-2 py-1 bg-green-900 text-green-400 text-[10px] rounded-full uppercase font-bold">Open</span>
                            <?php endif; ?>
                        </div>

                        <!-- Content (Right Side) -->
                        <div class="p-6 flex-grow flex flex-col justify-between">
                            <div>
                                <h3 class="text-xl font-bold mb-2 group-hover:text-purple-400 transition">
                                    <?= htmlspecialchars($k['judul']) ?>
                                </h3>
                                
                                <div class="flex flex-wrap gap-4 text-sm text-slate-400 mb-4">
                                    <div class="flex items-center gap-1">
                                        🕒 <?= htmlspecialchars($k['waktu']) ?>
                                    </div>
                                    <div class="flex items-center gap-1">
                                        📍 <?= htmlspecialchars($k['lokasi']) ?>
                                    </div>
                                </div>

                                <p class="text-slate-300 text-sm mb-4 line-clamp-3">
                                    <?= htmlspecialchars($k['deskripsi']) ?>
                                </p>

                                <?php if(isset($k['materi']) || isset($k['agenda'])): ?>
                                <div class="mb-4">
                                    <div class="text-xs font-bold text-slate-500 uppercase mb-1">Highlight:</div>
                                    <div class="flex flex-wrap gap-2">
                                        <?php 
                                            $items = $k['materi'] ?? $k['agenda'];
                                            foreach(array_slice($items, 0, 2) as $item): 
                                        ?>
                                        <span class="text-xs px-2 py-1 bg-slate-900 text-purple-300 rounded border border-slate-700">
                                            <?= htmlspecialchars($item) ?>
                                        </span>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                <?php endif; ?>
                            </div>

                            <div class="pt-4 border-t border-slate-700 flex justify-between items-center mt-auto">
                                <div class="text-sm">
                                    <span class="text-slate-500">Biaya:</span> 
                                    <span class="font-bold <?= ($k['biaya'] == 'Gratis') ? 'text-green-400' : 'text-orange-400' ?>">
                                        <?= htmlspecialchars($k['biaya']) ?>
                                    </span>
                                </div>
                                
                                <?php if(isset($k['registrasi']) && $k['status'] != 'Selesai'): ?>
                                <a href="<?= htmlspecialchars($k['registrasi']) ?>" target="_blank" class="px-4 py-2 bg-purple-600 hover:bg-purple-700 rounded-lg text-sm font-bold transition">
                                    Daftar Sekarang
                                </a>
                                <?php elseif(isset($k['link_download'])): ?>
                                <a href="<?= htmlspecialchars($k['link_download']) ?>" target="_blank" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 rounded-lg text-sm font-bold transition">
                                    📥 Download
                                </a>
                                <?php else: ?>
                                <button disabled class="px-4 py-2 bg-slate-700 text-slate-500 rounded-lg text-sm font-bold cursor-not-allowed">
                                    Pendaftaran Tutup
                                </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Gallery Preview (Static for now) -->
    <section class="py-12 bg-slate-800">
        <div class="container mx-auto px-4">
            <h2 class="text-2xl font-bold mb-8 text-center">📸 Dokumentasi Kegiatan</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <?php for($i=1; $i<=4; $i++): ?>
                <div class="aspect-video bg-slate-700 rounded-lg flex items-center justify-center text-slate-500 hover:bg-slate-600 transition cursor-pointer">
                    <span class="text-3xl">📷</span>
                </div>
                <?php endfor; ?>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="py-20 bg-gradient-to-r from-purple-600 to-pink-600">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-4xl font-bold mb-6">Jangan Lewatkan Event Berikutnya!</h2>
            <p class="text-xl mb-8">Follow media sosial kami untuk update kegiatan terbaru</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="https://www.instagram.com/siega_unika/" target="_blank" 
                   class="inline-block px-8 py-4 bg-white text-purple-600 rounded-lg font-semibold hover:bg-slate-100 transition">
                    [Image of Instagram Logo] Follow Instagram
                </a>
                <a href="kontak.php" class="inline-block px-8 py-4 bg-transparent border-2 border-white rounded-lg font-semibold hover:bg-white hover:text-purple-600 transition">
                    📧 Subscribe Newsletter
                </a>
            </div>
        </div>
    </section>

    <?php include '../../components/footer.php'; ?>
    <script src="../../assets/js/main.js"></script>
</body>
</html>