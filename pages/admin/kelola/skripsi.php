<?php
session_start();

// 1. Cek Login
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    // Perbaikan path login: keluar 1 level dari 'kelola' ke 'admin'
    header('Location: ../login.php');
    exit;
}

// 2. Setup Data Path
// Path ini sudah benar (mundur 3 langkah ke root, lalu ke data)
$dataFile = '../../../data/skripsi.json';
$message = '';
$messageType = '';

function loadData() { 
    global $dataFile; 
    if (!is_dir(dirname($dataFile))) mkdir(dirname($dataFile), 0777, true);
    if (!file_exists($dataFile)) file_put_contents($dataFile, json_encode(['skripsi' => []], JSON_PRETTY_PRINT)); 
    return json_decode(file_get_contents($dataFile), true); 
}

function saveData($data) { 
    global $dataFile; 
    return file_put_contents($dataFile, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)); 
}

// 3. Handle Form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $data = loadData();
    $saved = false;

    if ($action === 'create' || $action === 'update') {
        $id = ($action === 'create') ? time() : intval($_POST['id']);
        
        $item = [
            'id' => $id,
            'judul' => htmlspecialchars($_POST['judul']),
            'mahasiswa' => htmlspecialchars($_POST['mahasiswa']),
            'nim' => htmlspecialchars($_POST['nim']),
            'konsentrasi' => htmlspecialchars($_POST['konsentrasi']),
            'tahun' => intval($_POST['tahun']),
            'pembimbing1' => htmlspecialchars($_POST['pembimbing1']),
            'pembimbing2' => htmlspecialchars($_POST['pembimbing2'] ?? ''),
            'status' => htmlspecialchars($_POST['status']), // Diajukan, Sedang Dikerjakan, Selesai
            'abstrak' => htmlspecialchars($_POST['abstrak'] ?? ''),
            'file_pdf' => $_POST['file_pdf'] ?? '' // Link ke file (jika ada)
        ];

        if ($action === 'create') {
            array_unshift($data['skripsi'], $item);
        } else {
            foreach ($data['skripsi'] as &$row) {
                if ($row['id'] === $id) { $row = $item; break; }
            }
        }
        $saved = saveData($data);
        $message = $saved ? 'Data Skripsi berhasil disimpan!' : 'Gagal menyimpan.';
        $messageType = $saved ? 'success' : 'error';
    } 
    elseif ($action === 'delete') {
        $id = intval($_POST['id']);
        $data['skripsi'] = array_filter($data['skripsi'], fn($i) => $i['id'] !== $id);
        $saved = saveData($data);
        $message = $saved ? 'Data dihapus.' : 'Gagal menghapus.';
        $messageType = $saved ? 'success' : 'error';
    }
}

$data = loadData();
$list = $data['skripsi'] ?? [];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Skripsi - Admin SIEGA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-gray-50 text-gray-800">

    <!-- INCLUDE SIDEBAR -->
    <!-- 
        PERBAIKAN PATH:
        Lokasi: pages/admin/kelola/skripsi.php
        Tujuan: components/sidebar-admin.php
        Path: ../../../components/sidebar-admin.php
        (Folder 'includes' dihapus)
    -->
    <?php include '../../../components/sidebar-admin.php'; ?>

    <div class="ml-64 min-h-screen flex flex-col transition-all duration-300">
        
        <header class="bg-white border-b h-16 flex items-center justify-between px-8 sticky top-0 z-30 shadow-sm">
            <h2 class="text-xl font-bold text-gray-800">Manajemen Data Skripsi</h2>
            <div class="text-sm text-gray-500">Administrator</div>
        </header>

        <main class="p-8 flex-1">
            <?php if ($message): ?>
                <div class="mb-6 p-4 rounded-lg <?= $messageType === 'success' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' ?>">
                    <?= $message ?>
                </div>
            <?php endif; ?>

            <div class="flex justify-between items-center mb-6">
                <p class="text-gray-600">Daftar judul skripsi dan tugas akhir mahasiswa.</p>
                <button onclick="openModal()" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Tambah Data
                </button>
            </div>

            <!-- Tabel Data -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-gray-50 border-b border-gray-100 text-gray-500 uppercase font-semibold">
                            <tr>
                                <th class="px-6 py-4">Judul Skripsi</th>
                                <th class="px-6 py-4">Mahasiswa</th>
                                <th class="px-6 py-4">Tahun</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <?php if (empty($list)): ?>
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-gray-500">Belum ada data skripsi.</td>
                            </tr>
                            <?php else: ?>
                                <?php foreach ($list as $item): ?>
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="font-semibold text-gray-800 line-clamp-2"><?= $item['judul'] ?></div>
                                        <div class="text-xs text-gray-500 mt-1"><?= $item['konsentrasi'] ?></div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-medium text-gray-800"><?= $item['mahasiswa'] ?></div>
                                        <div class="text-xs text-gray-400"><?= $item['nim'] ?></div>
                                    </td>
                                    <td class="px-6 py-4 text-gray-600"><?= $item['tahun'] ?></td>
                                    <td class="px-6 py-4">
                                        <?php 
                                            $statusColor = 'bg-gray-100 text-gray-600';
                                            if($item['status'] == 'Selesai') $statusColor = 'bg-green-100 text-green-700';
                                            elseif($item['status'] == 'Sedang Dikerjakan') $statusColor = 'bg-blue-100 text-blue-700';
                                            elseif($item['status'] == 'Diajukan') $statusColor = 'bg-yellow-100 text-yellow-700';
                                        ?>
                                        <span class="px-2 py-1 rounded-full text-xs font-semibold <?= $statusColor ?>">
                                            <?= $item['status'] ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right space-x-2">
                                        <button onclick='editItem(<?= json_encode($item) ?>)' class="text-indigo-600 hover:text-indigo-800 font-medium text-xs">Edit</button>
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
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-2xl overflow-hidden h-auto max-h-[90vh] flex flex-col">
            <div class="px-6 py-4 border-b flex justify-between items-center bg-gray-50 shrink-0">
                <h3 id="modalTitle" class="font-bold text-gray-800">Tambah Data Skripsi</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">&times;</button>
            </div>
            
            <form method="POST" class="flex-1 overflow-y-auto p-6 space-y-4">
                <input type="hidden" name="action" id="action" value="create">
                <input type="hidden" name="id" id="id">
                
                <!-- Judul Full Width -->
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1">Judul Skripsi</label>
                    <textarea name="judul" id="judul" rows="2" required class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none font-medium"></textarea>
                </div>

                <!-- 2 Kolom: Mahasiswa & NIM -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Nama Mahasiswa</label>
                        <input type="text" name="mahasiswa" id="mahasiswa" required class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1">NIM</label>
                        <input type="text" name="nim" id="nim" required class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none">
                    </div>
                </div>

                <!-- 3 Kolom: Konsentrasi, Tahun, Status -->
                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Konsentrasi</label>
                        <select name="konsentrasi" id="konsentrasi" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none bg-white">
                            <option value="Sistem Informasi">Sistem Informasi</option>
                            <option value="E-Commerce">E-Commerce</option>
                            <option value="Game Technology">Game Technology</option>
                            <option value="Akuntansi SI">Akuntansi SI</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Tahun</label>
                        <input type="number" name="tahun" id="tahun" value="<?= date('Y') ?>" required class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Status</label>
                        <select name="status" id="status" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none bg-white">
                            <option value="Diajukan">Diajukan</option>
                            <option value="Sedang Dikerjakan">Sedang Dikerjakan</option>
                            <option value="Selesai">Selesai</option>
                        </select>
                    </div>
                </div>

                <!-- Pembimbing -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Pembimbing 1</label>
                        <input type="text" name="pembimbing1" id="pembimbing1" required class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Pembimbing 2 (Opsional)</label>
                        <input type="text" name="pembimbing2" id="pembimbing2" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none">
                    </div>
                </div>
                
                <div>
                     <label class="block text-xs font-semibold text-gray-500 mb-1">Abstrak (Opsional)</label>
                     <textarea name="abstrak" id="abstrak" rows="3" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none text-sm"></textarea>
                </div>
                
                <!-- Tombol -->
                <div class="pt-4 flex justify-end space-x-3 border-t mt-4">
                    <button type="button" onclick="closeModal()" class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg text-sm font-medium">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 text-sm font-medium">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModal(){ 
            document.getElementById('modal').classList.remove('hidden'); 
            document.getElementById('modalTitle').textContent='Tambah Data Skripsi'; 
            document.getElementById('action').value='create'; 
            document.querySelector('form').reset(); 
        }
        function closeModal(){ document.getElementById('modal').classList.add('hidden'); }
        function editItem(item){
            document.getElementById('modal').classList.remove('hidden'); 
            document.getElementById('modalTitle').textContent='Edit Skripsi'; 
            document.getElementById('action').value='update';
            document.getElementById('id').value=item.id;
            document.getElementById('judul').value=item.judul;
            document.getElementById('mahasiswa').value=item.mahasiswa;
            document.getElementById('nim').value=item.nim;
            document.getElementById('konsentrasi').value=item.konsentrasi;
            document.getElementById('tahun').value=item.tahun;
            document.getElementById('pembimbing1').value=item.pembimbing1;
            document.getElementById('pembimbing2').value=item.pembimbing2||'';
            document.getElementById('status').value=item.status;
            document.getElementById('abstrak').value=item.abstrak||'';
            document.getElementById('file_pdf').value=item.file_pdf||'';
        }
        function deleteItem(id,nama){
            if(confirm(`Yakin ingin menghapus skripsi dari "${nama}"?`)){
                const form=document.createElement('form'); form.method='POST';
                form.innerHTML=`<input type="hidden" name="action" value="delete"><input type=\"hidden\" name=\"id\" value=\"${id}\">`;
                document.body.appendChild(form); form.submit();
            }
        }
    </script>
</body>
</html>