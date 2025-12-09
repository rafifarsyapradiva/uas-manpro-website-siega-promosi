<?php
session_start();

// 1. Cek Login
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: ../login.php');
    exit;
}

// 2. Setup Data Path
$dataFile = '../../../data/berita.json';
$message = '';
$messageType = '';

function loadData() { 
    global $dataFile; 
    if (!is_dir(dirname($dataFile))) mkdir(dirname($dataFile), 0777, true);
    if (!file_exists($dataFile)) file_put_contents($dataFile, json_encode(['berita' => []], JSON_PRETTY_PRINT)); 
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

    // Ambil data input
    $judul = $_POST['judul'] ?? '';
    $kategori = $_POST['kategori'] ?? 'Berita';
    $penulis = $_POST['penulis'] ?? 'Admin';
    $tanggal = $_POST['tanggal'] ?? date('Y-m-d');
    $ringkasan = $_POST['ringkasan'] ?? '';
    $konten = $_POST['konten'] ?? '';
    $sumber = $_POST['sumber'] ?? '';
    $trending = isset($_POST['trending']);

    // Upload Gambar
    $gambar = $_POST['existing_gambar'] ?? '';
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === 0) {
        $targetDir = "../../../assets/images/berita/";
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
            'kategori' => $kategori,
            'penulis' => $penulis,
            'tanggal' => $tanggal,
            'ringkasan' => $ringkasan,
            'konten' => $konten,
            'sumber' => $sumber,
            'trending' => $trending,
            'gambar' => $gambar
        ];
        $data['berita'][] = $newItem;
        $saved = saveData($data);
        $message = "Berita berhasil ditambahkan!";
        $messageType = "success";
    } 
    elseif ($action === 'update') {
        $id = $_POST['id'];
        foreach ($data['berita'] as &$item) {
            if ($item['id'] == $id) {
                $item['judul'] = $judul;
                $item['kategori'] = $kategori;
                $item['penulis'] = $penulis;
                $item['tanggal'] = $tanggal;
                $item['ringkasan'] = $ringkasan;
                $item['konten'] = $konten;
                $item['sumber'] = $sumber;
                $item['trending'] = $trending;
                if ($gambar) $item['gambar'] = $gambar;
                break;
            }
        }
        $saved = saveData($data);
        $message = "Berita berhasil diperbarui!";
        $messageType = "success";
    } 
    elseif ($action === 'delete') {
        $id = $_POST['id'];
        $data['berita'] = array_filter($data['berita'], fn($i) => $i['id'] != $id);
        $data['berita'] = array_values($data['berita']);
        $saved = saveData($data);
        $message = "Berita berhasil dihapus!";
        $messageType = "success";
    }
}

$data = loadData();
// Urutkan berita berdasarkan tanggal terbaru
usort($data['berita'], fn($a, $b) => strtotime($b['tanggal']) - strtotime($a['tanggal']));
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Berita - Admin SIEGA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-gray-50 text-gray-800">

    <!-- INCLUDE SIDEBAR -->
    <!-- 
        PERBAIKAN PATH:
        Lokasi: pages/admin/kelola/artikel.php
        Tujuan: components/sidebar-admin.php
        Path: ../../../components/sidebar-admin.php
        (Folder 'includes' dihapus)
    -->
    <?php include '../../../components/sidebar-admin.php'; ?>

   <div class="flex min-h-screen">
        <!-- Sidebar Manual (Pengganti Include yang Error) -->
        <aside class="w-64 bg-white border-r hidden md:block">
            <div class="p-6">
                <h1 class="text-2xl font-bold text-blue-600">Admin Panel</h1>
            </div>
            <nav class="mt-4">
                <a href="../dashboard.php" class="block py-2.5 px-6 hover:bg-blue-50">Dashboard</a>
                <a href="berita.php" class="block py-2.5 px-6 bg-blue-50 text-blue-600 font-medium">Berita</a>
                <a href="prestasi.php" class="block py-2.5 px-6 hover:bg-blue-50">Prestasi</a>
                <a href="../logout.php" class="block py-2.5 px-6 text-red-500 hover:bg-red-50 mt-10">Logout</a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-8">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-2xl font-bold">Kelola Berita & Artikel</h2>
                <button onclick="openModal('create')" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 shadow flex items-center gap-2">
                    <i class="fas fa-plus"></i> Tambah Berita
                </button>
            </div>

            <!-- Notifikasi -->
            <?php if ($message): ?>
                <div class="p-4 mb-4 rounded-lg <?= $messageType === 'success' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' ?>">
                    <?= $message ?>
                </div>
            <?php endif; ?>

            <!-- List Berita -->
            <div class="bg-white rounded-xl shadow border overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                        <tr>
                            <th class="p-4 border-b">Tanggal</th>
                            <th class="p-4 border-b">Judul</th>
                            <th class="p-4 border-b">Kategori</th>
                            <th class="p-4 border-b">Penulis</th>
                            <th class="p-4 border-b text-center">Status</th>
                            <th class="p-4 border-b text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php foreach ($data['berita'] as $row): ?>
                            <tr class="hover:bg-gray-50">
                                <td class="p-4 text-sm text-gray-500 w-32"><?= htmlspecialchars($row['tanggal']) ?></td>
                                <td class="p-4">
                                    <div class="font-bold text-gray-800"><?= htmlspecialchars($row['judul']) ?></div>
                                    <div class="text-xs text-gray-500 truncate w-64"><?= htmlspecialchars($row['ringkasan'] ?? '') ?></div>
                                </td>
                                <td class="p-4">
                                    <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full font-semibold">
                                        <?= htmlspecialchars($row['kategori']) ?>
                                    </span>
                                </td>
                                <td class="p-4 text-sm text-gray-600"><?= htmlspecialchars($row['penulis']) ?></td>
                                <td class="p-4 text-center">
                                    <?php if (!empty($row['trending'])): ?>
                                        <span class="text-yellow-500" title="Trending"><i class="fas fa-fire"></i></span>
                                    <?php else: ?>
                                        <span class="text-gray-300">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="p-4 text-right space-x-2">
                                    <button onclick='editItem(<?= json_encode($row) ?>)' class="text-blue-600 hover:text-blue-800"><i class="fas fa-edit"></i></button>
                                    <button onclick="deleteItem(<?= $row['id'] ?>, '<?= addslashes($row['judul']) ?>')" class="text-red-600 hover:text-red-800"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (empty($data['berita'])): ?>
                            <tr>
                                <td colspan="6" class="p-8 text-center text-gray-400">Belum ada data berita.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <!-- Modal Form -->
    <div id="modal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
        <div class="bg-white rounded-xl w-full max-w-2xl p-6 m-4 shadow-2xl relative max-h-[90vh] overflow-y-auto">
            <h3 id="modalTitle" class="text-xl font-bold mb-4">Tambah Berita</h3>
            
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" id="action" value="create">
                <input type="hidden" name="id" id="id">
                <input type="hidden" name="existing_gambar" id="existing_gambar">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Judul Berita</label>
                        <input type="text" name="judul" id="judul" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                        <select name="kategori" id="kategori" class="w-full border rounded-lg px-3 py-2">
                            <option value="Berita">Berita</option>
                            <option value="Artikel">Artikel</option>
                            <option value="Pengumuman">Pengumuman</option>
                            <option value="Event">Event</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                        <input type="date" name="tanggal" id="tanggal" value="<?= date('Y-m-d') ?>" class="w-full border rounded-lg px-3 py-2">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Penulis</label>
                        <input type="text" name="penulis" id="penulis" class="w-full border rounded-lg px-3 py-2">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Sumber (Opsional)</label>
                        <input type="text" name="sumber" id="sumber" class="w-full border rounded-lg px-3 py-2" placeholder="Link original...">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Ringkasan Singkat</label>
                    <textarea name="ringkasan" id="ringkasan" rows="2" class="w-full border rounded-lg px-3 py-2"></textarea>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Konten Lengkap</label>
                    <textarea name="konten" id="konten" rows="6" class="w-full border rounded-lg px-3 py-2"></textarea>
                </div>

                <div class="flex items-center gap-2 mb-6">
                    <input type="checkbox" name="trending" id="trending" class="rounded text-blue-600">
                    <label for="trending" class="text-sm text-gray-700">Jadikan Trending / Highlight</label>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t">
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
                document.getElementById('modalTitle').textContent = 'Tambah Berita';
                document.getElementById('action').value = 'create';
                document.querySelector('form').reset();
            }
        }

        function closeModal() {
            document.getElementById('modal').classList.add('hidden');
        }

        function editItem(item) {
            document.getElementById('modal').classList.remove('hidden');
            document.getElementById('modalTitle').textContent = 'Edit Berita';
            document.getElementById('action').value = 'update';
            
            document.getElementById('id').value = item.id;
            document.getElementById('judul').value = item.judul;
            document.getElementById('kategori').value = item.kategori;
            document.getElementById('penulis').value = item.penulis;
            document.getElementById('tanggal').value = item.tanggal;
            document.getElementById('ringkasan').value = item.ringkasan || '';
            document.getElementById('konten').value = item.konten || '';
            document.getElementById('sumber').value = item.sumber || '';
            document.getElementById('existing_gambar').value = item.gambar || '';
            document.getElementById('trending').checked = item.trending || false;
        }

        function deleteItem(id, judul) {
            if(confirm(`Yakin ingin menghapus berita "${judul}"?`)) {
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