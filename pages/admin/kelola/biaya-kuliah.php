<?php
session_start();

// 1. Cek Login
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    // Perbaikan path login: keluar 1 level dari 'kelola' ke 'admin'
    header('Location: ../login.php');
    exit;
}

// 2. Setup Data Path (Naik 3 level ke root -> data)
$dataFile = '../../../data/biaya_kuliah.json';
$message = '';
$messageType = '';

// Helper Functions
function loadData() { 
    global $dataFile; 
    if (!is_dir(dirname($dataFile))) mkdir(dirname($dataFile), 0777, true);
    
    // Default Data Structure
    if (!file_exists($dataFile)) {
        $default = [
            'biaya_kuliah' => [
                'tahun_akademik' => '2024/2025',
                'last_updated' => date('Y-m-d'),
                'biaya_pendaftaran' => [],
                'biaya_per_semester' => [],
                'biaya_khusus' => [], // Untuk skripsi/praktikum dll
                'biaya_opsional' => []
            ]
        ];
        file_put_contents($dataFile, json_encode($default, JSON_PRETTY_PRINT)); 
    }
    return json_decode(file_get_contents($dataFile), true); 
}

function saveData($data) { 
    global $dataFile; 
    // Update last_updated timestamp
    $data['biaya_kuliah']['last_updated'] = date('Y-m-d');
    return file_put_contents($dataFile, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)); 
}

// 3. Handle Form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $data = loadData();
    $saved = false;

    // Handle Update Tahun Akademik
    if ($action === 'update_tahun') {
        $data['biaya_kuliah']['tahun_akademik'] = htmlspecialchars($_POST['tahun_akademik']);
        $saved = saveData($data);
        $message = $saved ? 'Tahun akademik diperbarui.' : 'Gagal menyimpan.';
        $messageType = $saved ? 'success' : 'error';
    }
    // Handle Item CRUD
    elseif ($action === 'create' || $action === 'update') {
        $kategori = $_POST['kategori']; // biaya_pendaftaran, biaya_per_semester, dll
        $id = ($action === 'create') ? time() : intval($_POST['id']);
        
        $item = [
            'id' => $id,
            'jenis' => htmlspecialchars($_POST['jenis']),
            'nominal' => intval($_POST['nominal']),
            'keterangan' => htmlspecialchars($_POST['keterangan'] ?? '')
        ];

        if (isset($data['biaya_kuliah'][$kategori])) {
            if ($action === 'create') {
                $data['biaya_kuliah'][$kategori][] = $item;
            } else {
                foreach ($data['biaya_kuliah'][$kategori] as &$row) {
                    if ($row['id'] === $id) { $row = $item; break; }
                }
            }
            $saved = saveData($data);
            $message = $saved ? 'Item biaya berhasil disimpan!' : 'Gagal menyimpan.';
            $messageType = $saved ? 'success' : 'error';
        }
    } 
    elseif ($action === 'delete') {
        $id = intval($_POST['id']);
        $kategori = $_POST['kategori'];
        
        if (isset($data['biaya_kuliah'][$kategori])) {
            $data['biaya_kuliah'][$kategori] = array_filter($data['biaya_kuliah'][$kategori], fn($i) => $i['id'] !== $id);
            // Re-index array
            $data['biaya_kuliah'][$kategori] = array_values($data['biaya_kuliah'][$kategori]);
            
            $saved = saveData($data);
            $message = $saved ? 'Item dihapus.' : 'Gagal menghapus.';
            $messageType = $saved ? 'success' : 'error';
        }
    }
}

$data = loadData();
$biaya = $data['biaya_kuliah'] ?? [];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Biaya Kuliah - Admin SIEGA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-gray-50 text-gray-800">

    <!-- INCLUDE SIDEBAR -->
    <!-- 
        PERBAIKAN PATH:
        Lokasi: pages/admin/kelola/biaya-kuliah.php
        Tujuan: components/sidebar-admin.php
        Path: ../../../components/sidebar-admin.php
        (Folder 'includes' dihapus)
    -->
    <?php include '../../../components/sidebar-admin.php'; ?>

    <div class="ml-64 min-h-screen flex flex-col transition-all duration-300">
        
        <header class="bg-white border-b h-16 flex items-center justify-between px-8 sticky top-0 z-30 shadow-sm">
            <h2 class="text-xl font-bold text-gray-800">Manajemen Biaya Kuliah</h2>
            <div class="text-sm text-gray-500">Administrator</div>
        </header>

        <main class="p-8 flex-1">
            <?php if ($message): ?>
                <div class="mb-6 p-4 rounded-lg <?= $messageType === 'success' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' ?>">
                    <?= $message ?>
                </div>
            <?php endif; ?>

            <!-- Info Header & Tahun Akademik -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 mb-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Tahun Akademik <?= $biaya['tahun_akademik'] ?? '-' ?></h1>
                    <p class="text-gray-500 text-sm mt-1">Terakhir diperbarui: <?= $biaya['last_updated'] ?? '-' ?></p>
                </div>
                <form method="POST" class="flex gap-2 items-center">
                    <input type="hidden" name="action" value="update_tahun">
                    <input type="text" name="tahun_akademik" value="<?= $biaya['tahun_akademik'] ?? '' ?>" placeholder="Contoh: 2024/2025" class="px-3 py-2 border rounded-lg focus:ring-2 focus:ring-amber-500 outline-none text-sm w-40">
                    <button type="submit" class="bg-amber-500 hover:bg-amber-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                        Update Tahun
                    </button>
                </form>
            </div>

            <!-- Grid Kategori Biaya -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                
                <!-- 1. Biaya Pendaftaran -->
                <?php renderTable('Biaya Pendaftaran', 'biaya_pendaftaran', $biaya['biaya_pendaftaran'] ?? []); ?>

                <!-- 2. Biaya Per Semester -->
                <?php renderTable('Biaya Per Semester (SPP & SKS)', 'biaya_per_semester', $biaya['biaya_per_semester'] ?? []); ?>

                <!-- 3. Biaya Khusus -->
                <?php renderTable('Biaya Khusus (Skripsi, Praktikum, dll)', 'biaya_khusus', $biaya['biaya_khusus'] ?? []); ?>

                <!-- 4. Biaya Opsional -->
                <?php renderTable('Biaya Opsional / Lainnya', 'biaya_opsional', $biaya['biaya_opsional'] ?? []); ?>

            </div>

        </main>
    </div>

    <?php
    // Helper function to render table for each category
    function renderTable($title, $key, $items) {
        ?>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden flex flex-col h-full">
            <div class="px-6 py-4 border-b bg-gray-50 flex justify-between items-center">
                <h3 class="font-bold text-gray-700"><?= $title ?></h3>
                <button onclick="openModal('<?= $key ?>', '<?= addslashes($title) ?>')" class="text-amber-600 hover:text-amber-700 text-xs font-bold uppercase tracking-wider flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Tambah
                </button>
            </div>
            <div class="flex-1 overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <tbody class="divide-y divide-gray-100">
                        <?php if (empty($items)): ?>
                            <tr><td class="px-6 py-6 text-center text-gray-400 italic">Belum ada data biaya.</td></tr>
                        <?php else: ?>
                            <?php foreach ($items as $item): ?>
                            <tr class="hover:bg-amber-50/50 transition-colors group">
                                <td class="px-6 py-3">
                                    <div class="font-medium text-gray-800"><?= $item['jenis'] ?></div>
                                    <?php if(!empty($item['keterangan'])): ?>
                                        <div class="text-xs text-gray-500 mt-0.5"><?= $item['keterangan'] ?></div>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-3 text-right font-mono font-medium text-gray-700">
                                    Rp <?= number_format($item['nominal'], 0, ',', '.') ?>
                                </td>
                                <td class="px-4 py-3 text-right w-20 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <div class="flex justify-end gap-2">
                                        <button onclick='editItem(<?= json_encode($item) ?>, "<?= $key ?>", "<?= addslashes($title) ?>")' class="text-blue-500 hover:text-blue-700"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg></button>
                                        <button onclick="deleteItem(<?= $item['id'] ?>, '<?= $key ?>', '<?= addslashes($item['jenis']) ?>')" class="text-red-500 hover:text-red-700"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php
    }
    ?>

    <!-- Modal Form -->
    <div id="modal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4 backdrop-blur-sm">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-md overflow-hidden">
            <div class="px-6 py-4 border-b flex justify-between items-center bg-gray-50">
                <h3 id="modalTitle" class="font-bold text-gray-800">Tambah Biaya</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">&times;</button>
            </div>
            <form method="POST" class="p-6 space-y-4">
                <input type="hidden" name="action" id="action" value="create">
                <input type="hidden" name="id" id="id">
                <input type="hidden" name="kategori" id="kategori_item">
                
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1">Jenis Biaya</label>
                    <input type="text" name="jenis" id="jenis" placeholder="Contoh: SPP Tetap" required class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-amber-500 outline-none font-medium">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1">Nominal (Rp)</label>
                    <input type="number" name="nominal" id="nominal" placeholder="0" required class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-amber-500 outline-none font-mono">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1">Keterangan (Opsional)</label>
                    <textarea name="keterangan" id="keterangan" rows="2" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-amber-500 outline-none text-sm"></textarea>
                </div>

                <div class="pt-2 flex justify-end space-x-3">
                    <button type="button" onclick="closeModal()" class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg text-sm font-medium">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-amber-500 text-white rounded-lg hover:bg-amber-600 text-sm font-medium">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModal(kategori, title){ 
            document.getElementById('modal').classList.remove('hidden'); 
            document.getElementById('modalTitle').textContent = 'Tambah ' + title; 
            document.getElementById('action').value = 'create'; 
            document.getElementById('kategori_item').value = kategori;
            document.querySelector('form').reset(); 
        }
        function closeModal(){ 
            document.getElementById('modal').classList.add('hidden'); 
        }
        function editItem(item, kategori, title){
            document.getElementById('modal').classList.remove('hidden');
            document.getElementById('modalTitle').textContent = 'Edit ' + title;
            document.getElementById('action').value = 'update';
            document.getElementById('id').value = item.id;
            document.getElementById('kategori_item').value = kategori;
            
            document.getElementById('jenis').value = item.jenis;
            document.getElementById('nominal').value = item.nominal;
            document.getElementById('keterangan').value = item.keterangan || '';
        }
        function deleteItem(id, kategori, nama){
            if(confirm(`Hapus komponen biaya "${nama}"?`)){
                const form = document.createElement('form');
                form.method = 'POST';
                form.innerHTML = `<input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="${id}"><input type="hidden" name="kategori" value="${kategori}">`;
                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
</body>
</html>