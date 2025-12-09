<?php
session_start();

// 1. Cek Login
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: ../login.php');
    exit;
}

// 2. Setup Data Path
$dataFile = '../../../data/prestasi.json';
$message = '';
$messageType = '';

function loadData() { 
    global $dataFile; 
    if (!is_dir(dirname($dataFile))) mkdir(dirname($dataFile), 0777, true);
    if (!file_exists($dataFile)) file_put_contents($dataFile, json_encode(['prestasi' => []], JSON_PRETTY_PRINT)); 
    return json_decode(file_get_contents($dataFile), true); 
}

function saveData($data) { 
    global $dataFile; 
    return file_put_contents($dataFile, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)); 
}

// 3. Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $data = loadData();
    $saved = false;

    // Ambil data input dengan fallback string kosong agar tidak error undefined index
    $judul = $_POST['judul'] ?? '';
    $kategori = $_POST['kategori'] ?? 'National';
    $pemenang = $_POST['pemenang'] ?? '';
    $angkatan = $_POST['angkatan'] ?? '';
    $tahun = $_POST['tahun'] ?? date('Y');
    
    // Upload Gambar Sederhana
    $gambar = $_POST['existing_gambar'] ?? '';
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === 0) {
        $targetDir = "../../../assets/images/prestasi/";
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
            'kategori' => $kategori, // Menggunakan kategori, bukan tingkat
            'pemenang' => $pemenang,
            'angkatan' => $angkatan,
            'tahun' => $tahun,
            'gambar' => $gambar,
            'highlight' => isset($_POST['highlight']) // Checkbox
        ];
        $data['prestasi'][] = $newItem;
        $saved = saveData($data);
        $message = "Prestasi berhasil ditambahkan!";
        $messageType = "success";
    } 
    elseif ($action === 'update') {
        $id = $_POST['id'];
        foreach ($data['prestasi'] as &$item) {
            if ($item['id'] == $id) {
                $item['judul'] = $judul;
                $item['kategori'] = $kategori;
                $item['pemenang'] = $pemenang;
                $item['angkatan'] = $angkatan;
                $item['tahun'] = $tahun;
                if ($gambar) $item['gambar'] = $gambar;
                $item['highlight'] = isset($_POST['highlight']);
                break;
            }
        }
        $saved = saveData($data);
        $message = "Prestasi berhasil diperbarui!";
        $messageType = "success";
    } 
    elseif ($action === 'delete') {
        $id = $_POST['id'];
        $data['prestasi'] = array_filter($data['prestasi'], fn($i) => $i['id'] != $id);
        $data['prestasi'] = array_values($data['prestasi']); // Reindex array
        $saved = saveData($data);
        $message = "Prestasi berhasil dihapus!";
        $messageType = "success";
    }
}

$data = loadData();
// Urutkan data berdasarkan tahun terbaru
usort($data['prestasi'], fn($a, $b) => $b['tahun'] <=> $a['tahun']);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Prestasi - Admin SIEGA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-gray-50 text-gray-800">

    <!-- INCLUDE SIDEBAR -->
    <!-- 
        PERBAIKAN PATH:
        Lokasi: pages/admin/kelola/prestasi.php
        Tujuan: components/sidebar-admin.php
        Path: ../../../components/sidebar-admin.php
        (Folder 'includes' dihapus)
    -->
    <?php include '../../../components/sidebar-admin.php'; ?>

    <div class="flex min-h-screen">
        <!-- Sidebar Sederhana -->
        <aside class="w-64 bg-white border-r hidden md:block">
            <div class="p-6">
                <h1 class="text-2xl font-bold text-blue-600">Admin Panel</h1>
            </div>
            <nav class="mt-4">
                <a href="../dashboard.php" class="block py-2.5 px-6 hover:bg-blue-50">Dashboard</a>
                <a href="prestasi.php" class="block py-2.5 px-6 bg-blue-50 text-blue-600 font-medium">Prestasi</a>
                <a href="../logout.php" class="block py-2.5 px-6 text-red-500 hover:bg-red-50 mt-10">Logout</a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-8">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-2xl font-bold">Kelola Prestasi Mahasiswa</h2>
                <button onclick="openModal('create')" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 shadow flex items-center gap-2">
                    <i class="fas fa-plus"></i> Tambah Data
                </button>
            </div>

            <!-- Notifikasi -->
            <?php if ($message): ?>
                <div class="p-4 mb-4 rounded-lg <?= $messageType === 'success' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' ?>">
                    <?= $message ?>
                </div>
            <?php endif; ?>

            <!-- Grid Data -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($data['prestasi'] as $row): ?>
                    <!-- LOGIC FIX START: Mengambil data dengan aman -->
                    <?php 
                        // Fix undefined key 'judul' (sebelumnya penghargaan)
                        $judul = $row['judul'] ?? $row['penghargaan'] ?? 'Tanpa Judul';
                        
                        // Fix undefined key 'kategori' (sebelumnya tingkat)
                        $kategori = $row['kategori'] ?? $row['tingkat'] ?? 'Umum';
                        
                        // Fix undefined key 'pemenang' (terkadang 'penerima' atau kosong)
                        $pemenang = $row['pemenang'] ?? $row['penerima'] ?? '-';
                        
                        // Fix undefined key 'angkatan'
                        $angkatan = isset($row['angkatan']) ? "(" . $row['angkatan'] . ")" : "";
                    ?>
                    <!-- LOGIC FIX END -->

                    <div class="bg-white rounded-xl shadow border overflow-hidden hover:shadow-lg transition">
                        <div class="p-5">
                            <div class="flex justify-between items-start mb-2">
                                <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full font-semibold uppercase">
                                    <?= htmlspecialchars($kategori) ?>
                                </span>
                                <?php if (!empty($row['highlight'])): ?>
                                    <span class="text-yellow-500" title="Featured"><i class="fas fa-star"></i></span>
                                <?php endif; ?>
                            </div>
                            
                            <h3 class="font-bold text-lg mb-1 leading-snug"><?= htmlspecialchars($judul) ?></h3>
                            
                            <p class="text-gray-600 text-sm mb-3">
                                <i class="fas fa-user-graduate mr-1"></i> 
                                <?= htmlspecialchars($pemenang) ?> <?= htmlspecialchars($angkatan) ?>
                            </p>
                            
                            <div class="flex items-center text-gray-400 text-xs">
                                <i class="fas fa-calendar-alt mr-1"></i> Tahun <?= htmlspecialchars($row['tahun']) ?>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-5 py-3 border-t flex justify-end gap-3">
                            <button onclick='editItem(<?= json_encode($row) ?>)' class="text-blue-600 hover:text-blue-800 text-sm font-medium">Edit</button>
                            <button onclick="deleteItem(<?= $row['id'] ?>, '<?= addslashes($judul) ?>')" class="text-red-600 hover:text-red-800 text-sm font-medium">Hapus</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </main>
    </div>

    <!-- Modal Form -->
    <div id="modal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
        <div class="bg-white rounded-xl w-full max-w-lg p-6 m-4 shadow-2xl relative">
            <h3 id="modalTitle" class="text-xl font-bold mb-4">Tambah Prestasi</h3>
            
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" id="action" value="create">
                <input type="hidden" name="id" id="id">
                <input type="hidden" name="existing_gambar" id="existing_gambar">

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Judul Prestasi / Penghargaan</label>
                        <input type="text" name="judul" id="judul" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500" required>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Kategori / Tingkat</label>
                            <select name="kategori" id="kategori" class="w-full border rounded-lg px-3 py-2">
                                <option value="International">International</option>
                                <option value="National">National</option>
                                <option value="Regional">Regional</option>
                                <option value="University">University</option>
                                <option value="Achievement">Achievement</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tahun</label>
                            <input type="number" name="tahun" id="tahun" value="<?= date('Y') ?>" class="w-full border rounded-lg px-3 py-2">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Pemenang / Tim</label>
                        <input type="text" name="pemenang" id="pemenang" class="w-full border rounded-lg px-3 py-2">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Angkatan (Opsional)</label>
                        <input type="text" name="angkatan" id="angkatan" class="w-full border rounded-lg px-3 py-2" placeholder="Contoh: 2023">
                    </div>

                    <!-- Fitur Tambahan: Checkbox Highlight -->
                    <div class="flex items-center gap-2">
                        <input type="checkbox" name="highlight" id="highlight" class="rounded text-blue-600">
                        <label for="highlight" class="text-sm text-gray-700">Tampilkan di Beranda (Highlight)</label>
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" onclick="closeModal()" class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModal(mode) {
            document.getElementById('modal').classList.remove('hidden');
            if(mode === 'create') {
                document.getElementById('modalTitle').textContent = 'Tambah Prestasi';
                document.getElementById('action').value = 'create';
                document.querySelector('form').reset();
            }
        }

        function closeModal() {
            document.getElementById('modal').classList.add('hidden');
        }

        function editItem(item) {
            document.getElementById('modal').classList.remove('hidden');
            document.getElementById('modalTitle').textContent = 'Edit Prestasi';
            document.getElementById('action').value = 'update';
            
            document.getElementById('id').value = item.id;
            
            // Mapping Data JSON ke Form Input (Handling perbedaan nama key)
            document.getElementById('judul').value = item.judul || item.penghargaan || '';
            document.getElementById('kategori').value = item.kategori || item.tingkat || 'National';
            document.getElementById('pemenang').value = item.pemenang || item.penerima || '';
            document.getElementById('angkatan').value = item.angkatan || '';
            document.getElementById('tahun').value = item.tahun;
            
            document.getElementById('existing_gambar').value = item.gambar || '';
            document.getElementById('highlight').checked = item.highlight || false;
        }

        function deleteItem(id, judul) {
            if(confirm(`Yakin ingin menghapus prestasi "${judul}"?`)) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.innerHTML = `<input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="${id}">`;
                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
</body>
</html>