<?php
session_start();

// 1. Cek Login
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: ../../login.php');
    exit;
}

// 2. Setup Data Path
// Path ini sudah benar (mundur 3 langkah ke root, lalu ke data)
$dataFile = '../../../data/konsentrasi.json';
$message = '';
$messageType = '';

function loadData() { 
    global $dataFile; 
    if (!is_dir(dirname($dataFile))) mkdir(dirname($dataFile), 0777, true);
    if (!file_exists($dataFile)) file_put_contents($dataFile, json_encode(['konsentrasi' => []], JSON_PRETTY_PRINT)); 
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
        // Menggunakan Time untuk ID agar seragam dengan modul lain
        $id = ($action === 'create') ? time() : intval($_POST['id']);
        
        $item = [
            'id' => $id,
            'nama' => htmlspecialchars($_POST['nama']),
            'nama_inggris' => htmlspecialchars($_POST['nama_inggris']),
            'deskripsi_singkat' => htmlspecialchars($_POST['deskripsi_singkat']),
            'deskripsi_lengkap' => htmlspecialchars($_POST['deskripsi_lengkap'] ?? ''),
            'icon' => $_POST['icon'] ?? '', // SVG Path String
            'color' => $_POST['color'] ?? 'blue' // Tailwind Color Name (blue, red, green)
        ];

        if ($action === 'create') {
            array_unshift($data['konsentrasi'], $item);
        } else {
            foreach ($data['konsentrasi'] as &$row) {
                if ($row['id'] === $id) { $row = $item; break; }
            }
        }
        $saved = saveData($data);
        $message = $saved ? 'Konsentrasi berhasil disimpan!' : 'Gagal menyimpan.';
        $messageType = $saved ? 'success' : 'error';
    } 
    elseif ($action === 'delete') {
        $id = intval($_POST['id']);
        $data['konsentrasi'] = array_filter($data['konsentrasi'], fn($i) => $i['id'] !== $id);
        $saved = saveData($data);
        $message = $saved ? 'Data dihapus.' : 'Gagal menghapus.';
        $messageType = $saved ? 'success' : 'error';
    }
}

$data = loadData();
$list = $data['konsentrasi'] ?? [];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Konsentrasi - Admin SIEGA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-gray-50 text-gray-800">

    <!-- INCLUDE SIDEBAR -->
    <!-- 
        PERBAIKAN PATH:
        Lokasi File: pages/admin/kelola/konsentrasi.php
        Lokasi Sidebar: components/sidebar-admin.php
        Path: ../../../components/sidebar-admin.php
        (Mundur 3x untuk keluar dari kelola -> admin -> pages, lalu masuk components)
    -->
    <?php include '../../../components/sidebar-admin.php'; ?>

    <div class="ml-64 min-h-screen flex flex-col transition-all duration-300">
        
        <header class="bg-white border-b h-16 flex items-center justify-between px-8 sticky top-0 z-30 shadow-sm">
            <h2 class="text-xl font-bold text-gray-800">Manajemen Konsentrasi Studi</h2>
            <div class="text-sm text-gray-500">Administrator</div>
        </header>

        <main class="p-8 flex-1">
            <?php if ($message): ?>
                <div class="mb-6 p-4 rounded-lg <?= $messageType === 'success' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' ?>">
                    <?= $message ?>
                </div>
            <?php endif; ?>

            <div class="flex justify-between items-center mb-6">
                <p class="text-gray-600">Peminatan / Konsentrasi yang tersedia di program studi.</p>
                <button onclick="openModal()" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Tambah Konsentrasi
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                <?php foreach ($list as $item): ?>
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 rounded-lg bg-<?= $item['color'] ?>-50 text-<?= $item['color'] ?>-600">
                            <!-- Render SVG from string or default -->
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?= $item['icon'] ?: 'M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z' ?>"></path>
                            </svg>
                        </div>
                        <div class="flex space-x-2">
                            <button onclick='editItem(<?= json_encode($item) ?>)' class="text-gray-400 hover:text-indigo-600"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg></button>
                            <button onclick="deleteItem(<?= $item['id'] ?>, '<?= $item['nama'] ?>')" class="text-gray-400 hover:text-red-600"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button>
                        </div>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800"><?= $item['nama'] ?></h3>
                    <p class="text-sm text-indigo-600 mb-2 font-medium"><?= $item['nama_inggris'] ?></p>
                    <p class="text-sm text-gray-500 mb-4 line-clamp-3"><?= $item['deskripsi_singkat'] ?></p>
                </div>
                <?php endforeach; ?>
            </div>

        </main>
    </div>

    <!-- Modal Form -->
    <div id="modal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4 backdrop-blur-sm">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg overflow-hidden h-auto">
            <div class="px-6 py-4 border-b flex justify-between items-center bg-gray-50">
                <h3 id="modalTitle" class="font-bold text-gray-800">Tambah Konsentrasi</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">&times;</button>
            </div>
            <form method="POST" class="p-6 space-y-4">
                <input type="hidden" name="action" id="action" value="create">
                <input type="hidden" name="id" id="id">
                
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1">Nama Konsentrasi</label>
                    <input type="text" name="nama" id="nama" required class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none font-medium">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1">Nama Inggris</label>
                    <input type="text" name="nama_inggris" id="nama_inggris" required class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none font-medium">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Warna Tema (Tailwind)</label>
                        <select name="color" id="color" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none bg-white">
                            <option value="blue">Blue</option>
                            <option value="indigo">Indigo</option>
                            <option value="red">Red</option>
                            <option value="green">Green</option>
                            <option value="amber">Amber</option>
                            <option value="purple">Purple</option>
                        </select>
                    </div>
                    <div>
                         <label class="block text-xs font-semibold text-gray-500 mb-1">SVG Path Icon</label>
                         <input type="text" name="icon" id="icon" placeholder="d='M12 4v...'" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none text-xs font-mono">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1">Deskripsi Singkat</label>
                    <textarea name="deskripsi_singkat" id="deskripsi_singkat" rows="3" required class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none text-sm"></textarea>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1">Deskripsi Lengkap (Kurikulum dll)</label>
                    <textarea name="deskripsi_lengkap" id="deskripsi_lengkap" rows="4" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none text-sm"></textarea>
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
            document.getElementById('modalTitle').textContent='Tambah Konsentrasi'; 
            document.getElementById('action').value='create'; 
            document.querySelector('form').reset(); 
        }
        function closeModal(){ document.getElementById('modal').classList.add('hidden'); }
        function editItem(item){
            document.getElementById('modal').classList.remove('hidden'); 
            document.getElementById('modalTitle').textContent='Edit Konsentrasi'; 
            document.getElementById('action').value='update';
            document.getElementById('id').value=item.id;
            document.getElementById('nama').value=item.nama;
            document.getElementById('nama_inggris').value=item.nama_inggris;
            document.getElementById('color').value=item.color;
            document.getElementById('icon').value=item.icon||'';
            document.getElementById('deskripsi_singkat').value=item.deskripsi_singkat;
            document.getElementById('deskripsi_lengkap').value=item.deskripsi_lengkap||'';
        }
        function deleteItem(id,nama){
            if(confirm(`Yakin ingin menghapus konsentrasi "${nama}"?`)){
                const form=document.createElement('form'); form.method='POST';
                form.innerHTML=`<input type="hidden" name="action" value="delete"><input type=\"hidden\" name=\"id\" value=\"${id}\">`;
                document.body.appendChild(form); form.submit();
            }
        }
    </script>
</body>
</html>