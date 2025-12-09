<?php
session_start();

// 1. Cek Login
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    // Perbaikan path login: keluar 1 level dari 'kelola' ke 'admin'
    header('Location: ../login.php');
    exit;
}

// 2. Setup Data Path
// Path ke file JSON (Naik 3 level ke root -> data)
$dataFile = '../../../data/artikel.json';
$message = '';
$messageType = '';

// Helper Functions
function loadData() { 
    global $dataFile; 
    if (!is_dir(dirname($dataFile))) mkdir(dirname($dataFile), 0777, true);
    if (!file_exists($dataFile)) file_put_contents($dataFile, json_encode(['artikel' => []], JSON_PRETTY_PRINT)); 
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

    if ($action === 'create' || $action === 'update') {
        $id = ($action === 'create') ? time() : intval($_POST['id']);
        
        $item = [
            'id' => $id,
            'judul' => htmlspecialchars($_POST['judul']),
            'kategori' => htmlspecialchars($_POST['kategori']),
            'tanggal' => htmlspecialchars($_POST['tanggal']),
            'ringkasan' => htmlspecialchars($_POST['ringkasan']),
            'konten' => htmlspecialchars($_POST['konten']), // Mengizinkan tag HTML sederhana jika perlu, tapi disini kita escape dulu
            'gambar' => htmlspecialchars($_POST['gambar'] ?? ''), // URL Gambar
            'tags' => array_map('trim', explode(',', $_POST['tags'] ?? ''))
        ];

        if ($action === 'create') {
            array_unshift($data['artikel'], $item);
        } else {
            foreach ($data['artikel'] as &$row) {
                if ($row['id'] === $id) { $row = $item; break; }
            }
        }
        $saved = saveData($data);
        $message = $saved ? 'Artikel berhasil disimpan!' : 'Gagal menyimpan.';
        $messageType = $saved ? 'success' : 'error';
    } 
    elseif ($action === 'delete') {
        $id = intval($_POST['id']);
        $data['artikel'] = array_filter($data['artikel'], fn($i) => $i['id'] !== $id);
        $saved = saveData($data);
        $message = $saved ? 'Artikel dihapus.' : 'Gagal menghapus.';
        $messageType = $saved ? 'success' : 'error';
    }
}

$data = loadData();
$list = $data['artikel'] ?? [];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Artikel - Admin SIEGA</title>
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

    <div class="ml-64 min-h-screen flex flex-col transition-all duration-300">
        
        <header class="bg-white border-b h-16 flex items-center justify-between px-8 sticky top-0 z-30 shadow-sm">
            <h2 class="text-xl font-bold text-gray-800">Manajemen Artikel</h2>
            <div class="text-sm text-gray-500">Administrator</div>
        </header>

        <main class="p-8 flex-1">
            <?php if ($message): ?>
                <div class="mb-6 p-4 rounded-lg <?= $messageType === 'success' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' ?>">
                    <?= $message ?>
                </div>
            <?php endif; ?>

            <div class="flex justify-between items-center mb-6">
                <p class="text-gray-600">Artikel edukasi dan informasi seputar teknologi.</p>
                <button onclick="openModal()" class="bg-teal-600 hover:bg-teal-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Tulis Artikel
                </button>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-gray-50 border-b border-gray-100 text-gray-500 uppercase font-semibold">
                            <tr>
                                <th class="px-6 py-4 w-1/3">Judul & Ringkasan</th>
                                <th class="px-6 py-4">Kategori & Tags</th>
                                <th class="px-6 py-4">Tanggal</th>
                                <th class="px-6 py-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <?php if (empty($list)): ?>
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-gray-500">Belum ada artikel.</td>
                            </tr>
                            <?php else: ?>
                                <?php foreach ($list as $item): ?>
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-gray-800 line-clamp-1 mb-1"><?= $item['judul'] ?></div>
                                        <div class="text-xs text-gray-500 line-clamp-2"><?= $item['ringkasan'] ?></div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="inline-block px-2 py-1 rounded bg-teal-50 text-teal-700 font-semibold text-xs mb-1">
                                            <?= $item['kategori'] ?>
                                        </div>
                                        <div class="text-xs text-gray-400">
                                            <?= implode(', ', array_slice($item['tags'], 0, 3)) ?>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-gray-600 text-xs">
                                        <?= date('d M Y', strtotime($item['tanggal'])) ?>
                                    </td>
                                    <td class="px-6 py-4 text-right space-x-2">
                                        <button onclick='editItem(<?= json_encode($item) ?>)' class="text-teal-600 hover:text-teal-800 font-medium text-xs">Edit</button>
                                        <button onclick="deleteItem(<?= $item['id'] ?>, '<?= addslashes($item['judul']) ?>')" class="text-red-500 hover:text-red-700 font-medium text-xs">Hapus</button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <!-- Modal Form -->
    <div id="modal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4 backdrop-blur-sm">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-4xl overflow-hidden h-auto max-h-[90vh] flex flex-col">
            <div class="px-6 py-4 border-b flex justify-between items-center bg-gray-50 shrink-0">
                <h3 id="modalTitle" class="font-bold text-gray-800">Tulis Artikel</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">&times;</button>
            </div>
            
            <form method="POST" class="flex-1 overflow-y-auto p-6 space-y-4">
                <input type="hidden" name="action" id="action" value="create">
                <input type="hidden" name="id" id="id">
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Kolom Kiri -->
                    <div class="md:col-span-2 space-y-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 mb-1">Judul Artikel</label>
                            <input type="text" name="judul" id="judul" required class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-teal-500 outline-none font-bold text-gray-800">
                        </div>
                        
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 mb-1">Ringkasan (Excerpt)</label>
                            <textarea name="ringkasan" id="ringkasan" rows="2" required class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-teal-500 outline-none text-sm"></textarea>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-500 mb-1">Konten Lengkap</label>
                            <textarea name="konten" id="konten" rows="12" required class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-teal-500 outline-none text-sm font-mono"></textarea>
                            <p class="text-[10px] text-gray-400 mt-1">* Gunakan tag HTML dasar untuk formatting (&lt;p&gt;, &lt;b&gt;, dll)</p>
                        </div>
                    </div>

                    <!-- Kolom Kanan (Meta) -->
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 mb-1">Kategori</label>
                            <select name="kategori" id="kategori" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-teal-500 outline-none bg-white">
                                <option value="Teknologi">Teknologi</option>
                                <option value="Tutorial">Tutorial</option>
                                <option value="Review">Review</option>
                                <option value="Opini">Opini</option>
                                <option value="Karir">Karir</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-500 mb-1">Tanggal Publish</label>
                            <input type="date" name="tanggal" id="tanggal" value="<?= date('Y-m-d') ?>" required class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-teal-500 outline-none">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-500 mb-1">URL Gambar (Header)</label>
                            <input type="url" name="gambar" id="gambar" placeholder="https://..." class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-teal-500 outline-none">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-500 mb-1">Tags (Pisahkan koma)</label>
                            <input type="text" name="tags" id="tags" placeholder="coding, web, ai" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-teal-500 outline-none">
                        </div>
                    </div>
                </div>

                <div class="pt-4 flex justify-end space-x-3 border-t mt-4">
                    <button type="button" onclick="closeModal()" class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg text-sm font-medium">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700 text-sm font-medium">Simpan Artikel</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModal(){ document.getElementById('modal').classList.remove('hidden'); document.getElementById('modalTitle').textContent='Tulis Artikel'; document.getElementById('action').value='create'; document.querySelector('form').reset(); }
        function closeModal(){ document.getElementById('modal').classList.add('hidden'); }
        function editItem(item){
            document.getElementById('modal').classList.remove('hidden'); document.getElementById('modalTitle').textContent='Edit Artikel'; document.getElementById('action').value='update';
            document.getElementById('id').value=item.id; document.getElementById('judul').value=item.judul;
            document.getElementById('kategori').value=item.kategori; document.getElementById('tanggal').value=item.tanggal;
            document.getElementById('ringkasan').value=item.ringkasan; document.getElementById('konten').value=item.konten;
            document.getElementById('gambar').value=item.gambar; document.getElementById('tags').value=(item.tags||[]).join(', ');
        }
        function deleteItem(id,judul){
            if(confirm(`Hapus artikel "${judul}"?`)){
                const form=document.createElement('form'); form.method='POST';
                form.innerHTML=`<input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="${id}">`;
                document.body.appendChild(form); form.submit();
            }
        }
    </script>
</body>
</html>