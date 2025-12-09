<?php
session_start();

// 1. Cek Login
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: ../login.php');
    exit;
}

// 2. Setup Data Path
$dataFile = '../../../data/kegiatan.json';
$message = '';
$messageType = '';

// [PERBAIKAN] Menggunakan nama fungsi unik & pengecekan exists untuk mencegah error "Cannot redeclare"
if (!function_exists('loadKegiatanData')) {
    function loadKegiatanData() { 
        global $dataFile; 
        if (!is_dir(dirname($dataFile))) mkdir(dirname($dataFile), 0777, true);
        if (!file_exists($dataFile)) file_put_contents($dataFile, json_encode(['kegiatan' => []], JSON_PRETTY_PRINT)); 
        return json_decode(file_get_contents($dataFile), true); 
    }
}

if (!function_exists('saveKegiatanData')) {
    function saveKegiatanData($data) { 
        global $dataFile; 
        return file_put_contents($dataFile, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)); 
    }
}

// 3. Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $data = loadKegiatanData(); // [PERBAIKAN] Panggil fungsi baru
    $saved = false;

    // Ambil data input dengan fallback aman
    $judul = $_POST['judul'] ?? '';
    $jenis = $_POST['jenis'] ?? 'Seminar';
    $tanggal = $_POST['tanggal'] ?? date('Y-m-d');
    $lokasi = $_POST['lokasi'] ?? '';
    $pembicara = $_POST['pembicara'] ?? '';
    $deskripsi = $_POST['deskripsi'] ?? '';
    $status = $_POST['status'] ?? 'Upcoming'; // Upcoming, Ongoing, Done

    // Upload Gambar
    $gambar = $_POST['existing_gambar'] ?? '';
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === 0) {
        $targetDir = "../../../assets/images/kegiatan/";
        if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);
        $fileName = time() . '_' . basename($_FILES['gambar']['name']);
        if (move_uploaded_file($_FILES['gambar']['tmp_name'], $targetDir . $fileName)) {
            $gambar = $fileName;
        }
    }

    if ($action === 'create') {
        $newItem = [
            'id' => time(),
            'judul' => $judul,
            'jenis' => $jenis, 
            'tanggal' => $tanggal,
            'lokasi' => $lokasi,
            'pembicara' => $pembicara,
            'deskripsi' => $deskripsi,
            'status' => $status,
            'gambar' => $gambar
        ];
        $data['kegiatan'][] = $newItem;
        $saved = saveKegiatanData($data); // [PERBAIKAN] Panggil fungsi baru
        $message = "Kegiatan berhasil ditambahkan!";
        $messageType = "success";
    } 
    elseif ($action === 'update') {
        $id = $_POST['id'];
        foreach ($data['kegiatan'] as &$item) {
            if ($item['id'] == $id) {
                $item['judul'] = $judul;
                $item['jenis'] = $jenis;
                $item['tanggal'] = $tanggal;
                $item['lokasi'] = $lokasi;
                $item['pembicara'] = $pembicara;
                $item['deskripsi'] = $deskripsi;
                $item['status'] = $status;
                if ($gambar) $item['gambar'] = $gambar;
                break;
            }
        }
        $saved = saveKegiatanData($data); // [PERBAIKAN] Panggil fungsi baru
        $message = "Kegiatan berhasil diperbarui!";
        $messageType = "success";
    } 
    elseif ($action === 'delete') {
        $id = $_POST['id'];
        $data['kegiatan'] = array_filter($data['kegiatan'], fn($i) => $i['id'] != $id);
        $data['kegiatan'] = array_values($data['kegiatan']);
        $saved = saveKegiatanData($data); // [PERBAIKAN] Panggil fungsi baru
        $message = "Kegiatan berhasil dihapus!";
        $messageType = "success";
    }
}

$data = loadKegiatanData(); // [PERBAIKAN] Panggil fungsi baru
// Urutkan kegiatan berdasarkan tanggal terbaru
if (isset($data['kegiatan']) && is_array($data['kegiatan'])) {
    usort($data['kegiatan'], fn($a, $b) => strtotime($b['tanggal']) - strtotime($a['tanggal']));
    $kegiatanList = $data['kegiatan'];
} else {
    $kegiatanList = [];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Kegiatan - Admin SIEGA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-gray-50 text-gray-800">

    <?php include '../../../components/sidebar-admin.php'; ?>

    <div class="ml-64 min-h-screen flex flex-col transition-all duration-300">
        
        <header class="bg-white border-b h-16 flex items-center justify-between px-8 sticky top-0 z-30 shadow-sm">
            <h2 class="text-xl font-bold text-gray-800">Manajemen Kegiatan & Event</h2>
            <div class="text-sm text-gray-500">Administrator</div>
        </header>

        <main class="p-8 flex-1">
            <?php if ($message): ?>
                <div class="mb-6 p-4 rounded-lg <?= $messageType === 'success' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' ?>">
                    <?= $message ?>
                </div>
            <?php endif; ?>

            <div class="flex justify-between items-center mb-6">
                <p class="text-gray-600">Jadwal seminar, workshop, dan kuliah tamu.</p>
                <button onclick="openModal()" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Tambah Kegiatan
                </button>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <table class="w-full text-left text-sm text-gray-600">
                    <thead class="bg-gray-50 text-gray-800 font-semibold border-b">
                        <tr>
                            <th class="px-6 py-4">Nama Kegiatan</th>
                            <th class="px-6 py-4">Jenis & Pembicara</th>
                            <th class="px-6 py-4">Waktu & Lokasi</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php foreach ($kegiatanList as $item): ?>
                        <?php 
                            // [HELPER] Normalisasi data
                            $displayJenis = $item['jenis'] ?? $item['kategori'] ?? 'Umum';
                            $displayPembicara = is_array($item['pembicara'] ?? '') ? 'Tim/Panelis' : ($item['pembicara'] ?? '-');
                            $displayDeskripsi = $item['deskripsi'] ?? '';
                        ?>
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="font-medium text-gray-900"><?= $item['judul'] ?></div>
                                <div class="text-xs text-gray-500 mt-1 line-clamp-1"><?= $displayDeskripsi ?></div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-block px-2 py-1 bg-purple-50 text-purple-700 rounded text-xs font-medium mb-1"><?= $displayJenis ?></span>
                                <div class="text-xs text-gray-500"><?= $displayPembicara ?></div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-gray-900 font-medium"><?= date('d M Y', strtotime($item['tanggal'])) ?></div>
                                <div class="text-xs text-gray-500"><?= $item['lokasi'] ?></div>
                            </td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <button onclick='editItem(<?= json_encode($item, JSON_HEX_APOS | JSON_HEX_QUOT) ?>)' class="text-indigo-600 hover:text-indigo-900 font-medium">Edit</button>
                                <button onclick="deleteItem(<?= $item['id'] ?>, '<?= addslashes($item['judul']) ?>')" class="text-red-600 hover:text-red-900 font-medium">Hapus</button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php if (empty($kegiatanList)): ?>
                            <tr><td colspan="4" class="px-6 py-8 text-center text-gray-400">Belum ada kegiatan.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <!-- Modal Form -->
    <div id="modal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4 backdrop-blur-sm">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg overflow-hidden h-auto">
            <div class="px-6 py-4 border-b flex justify-between items-center bg-gray-50">
                <h3 id="modalTitle" class="font-bold text-gray-800">Tambah Kegiatan</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">&times;</button>
            </div>
            <form method="POST" class="p-6 space-y-4" enctype="multipart/form-data">
                <input type="hidden" name="action" id="action" value="create">
                <input type="hidden" name="id" id="id">
                
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1">Nama Kegiatan</label>
                    <input type="text" name="judul" id="judul" required class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none font-medium">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Jenis</label>
                        <select name="jenis" id="jenis" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none bg-white">
                            <option value="Kuliah Umum">Kuliah Umum</option>
                            <option value="Seminar">Seminar</option>
                            <option value="Workshop">Workshop</option>
                            <option value="Lomba">Lomba</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Tanggal</label>
                        <input type="date" name="tanggal" id="tanggal" value="<?= date('Y-m-d') ?>" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Lokasi</label>
                        <input type="text" name="lokasi" id="lokasi" required class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Pembicara / Tamu</label>
                        <input type="text" name="pembicara" id="pembicara" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1">Deskripsi Singkat</label>
                    <textarea name="deskripsi" id="deskripsi" rows="3" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none text-sm"></textarea>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1">Upload Gambar (Opsional)</label>
                    <input type="file" name="gambar" id="gambar_input" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                    <input type="hidden" name="existing_gambar" id="gambar">
                </div>

                <div class="pt-2 flex justify-end space-x-3">
                    <button type="button" onclick="closeModal()" class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg text-sm font-medium">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 text-sm font-medium">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModal(){ 
            document.getElementById('modal').classList.remove('hidden'); 
            document.getElementById('modalTitle').textContent='Tambah Kegiatan'; 
            document.getElementById('action').value='create'; 
            document.querySelector('form').reset(); 
        }
        function closeModal(){ document.getElementById('modal').classList.add('hidden'); }
        
        function editItem(item){
            document.getElementById('modal').classList.remove('hidden'); 
            document.getElementById('modalTitle').textContent='Edit Kegiatan'; 
            document.getElementById('action').value='update';
            document.getElementById('id').value=item.id;
            document.getElementById('judul').value=item.judul;
            
            // Handle perbedaan key antara JSON lama (kategori) dan form baru (jenis)
            document.getElementById('jenis').value = item.jenis || item.kategori || 'Lainnya';
            
            document.getElementById('tanggal').value=item.tanggal;
            document.getElementById('lokasi').value=item.lokasi;
            
            // Handle pembicara jika array
            let pembicaraVal = item.pembicara;
            if (Array.isArray(item.pembicara)) {
                 pembicaraVal = item.pembicara.map(p => p.nama || p).join(', ');
            }
            document.getElementById('pembicara').value = pembicaraVal || '';
            
            document.getElementById('deskripsi').value=item.deskripsi||'';
            document.getElementById('gambar').value=item.gambar||'';
        }

        function deleteItem(id,judul){
            if(confirm(`Yakin ingin menghapus kegiatan "${judul}"?`)){
                const form=document.createElement('form'); form.method='POST';
                form.innerHTML=`<input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="${id}">`;
                document.body.appendChild(form); form.submit();
            }
        }
    </script>
</body>
</html>