<?php
session_start();

// 1. Cek Login
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    // Perbaikan path login: keluar 1 level dari 'kelola' ke 'admin'
    header('Location: ../login.php');
    exit;
}

// 2. Setup Data Path
$dataFile = '../../../data/journal.json';
$message = '';
$messageType = '';

function loadData() { 
    global $dataFile; 
    if (!is_dir(dirname($dataFile))) mkdir(dirname($dataFile), 0777, true);
    if (!file_exists($dataFile)) file_put_contents($dataFile, json_encode(['journal' => []], JSON_PRETTY_PRINT)); 
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
            'penulis' => array_map('trim', explode(',', $_POST['penulis'])), // Convert comma string to array
            'jenis' => htmlspecialchars($_POST['jenis']), // Nasional, Internasional, Terakreditasi
            'nama_jurnal' => htmlspecialchars($_POST['nama_jurnal']),
            'volume' => htmlspecialchars($_POST['volume'] ?? ''),
            'nomor' => htmlspecialchars($_POST['nomor'] ?? ''),
            'halaman' => htmlspecialchars($_POST['halaman'] ?? ''),
            'tahun' => intval($_POST['tahun']),
            'issn' => htmlspecialchars($_POST['issn'] ?? ''),
            'doi' => htmlspecialchars($_POST['doi'] ?? ''),
            'link' => htmlspecialchars($_POST['link'] ?? ''),
            'abstrak' => htmlspecialchars($_POST['abstrak'] ?? ''),
            'indexed' => array_map('trim', explode(',', $_POST['indexed'] ?? '')), // SINTA, Scopus, Google Scholar
            'citation_count' => intval($_POST['citation_count'] ?? 0)
        ];

        if ($action === 'create') {
            array_unshift($data['journal'], $item);
        } else {
            foreach ($data['journal'] as &$row) {
                if ($row['id'] === $id) { $row = $item; break; }
            }
        }
        $saved = saveData($data);
        $message = $saved ? 'Data Publikasi berhasil disimpan!' : 'Gagal menyimpan.';
        $messageType = $saved ? 'success' : 'error';
    } 
    elseif ($action === 'delete') {
        $id = intval($_POST['id']);
        $data['journal'] = array_filter($data['journal'], fn($i) => $i['id'] !== $id);
        $saved = saveData($data);
        $message = $saved ? 'Data dihapus.' : 'Gagal menghapus.';
        $messageType = $saved ? 'success' : 'error';
    }
}

$data = loadData();
$list = $data['journal'] ?? [];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Journal - Admin SIEGA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-gray-50 text-gray-800">

    <!-- INCLUDE SIDEBAR -->
    <!-- 
        PERBAIKAN PATH:
        Lokasi: pages/admin/kelola/journal.php
        Tujuan: components/sidebar-admin.php
        Path: ../../../components/sidebar-admin.php
        (Folder 'includes' dihapus)
    -->
    <?php include '../../../components/sidebar-admin.php'; ?>

    <div class="ml-64 min-h-screen flex flex-col transition-all duration-300">
        
        <header class="bg-white border-b h-16 flex items-center justify-between px-8 sticky top-0 z-30 shadow-sm">
            <h2 class="text-xl font-bold text-gray-800">Manajemen Publikasi & Jurnal</h2>
            <div class="text-sm text-gray-500">Administrator</div>
        </header>

        <main class="p-8 flex-1">
            <?php if ($message): ?>
                <div class="mb-6 p-4 rounded-lg <?= $messageType === 'success' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' ?>">
                    <?= $message ?>
                </div>
            <?php endif; ?>

            <div class="flex justify-between items-center mb-6">
                <p class="text-gray-600">Daftar publikasi ilmiah dosen dan mahasiswa.</p>
                <button onclick="openModal()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Tambah Publikasi
                </button>
            </div>

            <!-- Tabel Data -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-gray-50 border-b border-gray-100 text-gray-500 uppercase font-semibold">
                            <tr>
                                <th class="px-6 py-4 w-1/3">Judul Artikel</th>
                                <th class="px-6 py-4">Jurnal & Tahun</th>
                                <th class="px-6 py-4">Indeks</th>
                                <th class="px-6 py-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <?php if (empty($list)): ?>
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-gray-500">Belum ada data publikasi.</td>
                            </tr>
                            <?php else: ?>
                                <?php foreach ($list as $item): ?>
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-gray-800 line-clamp-2 hover:text-blue-600 transition-colors">
                                            <?= $item['link'] ? "<a href='{$item['link']}' target='_blank'>{$item['judul']}</a>" : $item['judul'] ?>
                                        </div>
                                        <div class="text-xs text-gray-500 mt-1 line-clamp-1">
                                            <?= implode(', ', $item['penulis']) ?>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-medium text-gray-700"><?= $item['nama_jurnal'] ?></div>
                                        <div class="text-xs text-gray-400">
                                            Vol. <?= $item['volume'] ?>, No. <?= $item['nomor'] ?> (<?= $item['tahun'] ?>)
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-wrap gap-1">
                                            <?php foreach ($item['indexed'] as $idx): ?>
                                                <?php if(trim($idx)): ?>
                                                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-indigo-50 text-indigo-600 border border-indigo-100">
                                                    <?= trim($idx) ?>
                                                </span>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-gray-100 text-gray-600 border border-gray-200">
                                                <?= $item['jenis'] ?>
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-right space-x-2">
                                        <button onclick='editItem(<?= json_encode($item) ?>)' class="text-blue-600 hover:text-blue-800 font-medium text-xs">Edit</button>
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
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-3xl overflow-hidden h-auto max-h-[90vh] flex flex-col">
            <div class="px-6 py-4 border-b flex justify-between items-center bg-gray-50 shrink-0">
                <h3 id="modalTitle" class="font-bold text-gray-800">Tambah Publikasi</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">&times;</button>
            </div>
            
            <form method="POST" class="flex-1 overflow-y-auto p-6 space-y-4">
                <input type="hidden" name="action" id="action" value="create">
                <input type="hidden" name="id" id="id">
                
                <!-- Judul -->
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1">Judul Artikel</label>
                    <textarea name="judul" id="judul" rows="2" required class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none font-medium"></textarea>
                </div>

                <!-- Penulis (Input as string, processed to array) -->
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1">Penulis (Pisahkan dengan koma)</label>
                    <input type="text" name="penulis" id="penulis" placeholder="Nama 1, Nama 2, Nama 3" required class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                </div>

                <!-- Info Jurnal Grid -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="col-span-2">
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Nama Jurnal</label>
                        <input type="text" name="nama_jurnal" id="nama_jurnal" required class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Tahun</label>
                        <input type="number" name="tahun" id="tahun" value="<?= date('Y') ?>" required class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Jenis</label>
                        <select name="jenis" id="jenis" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none bg-white">
                            <option value="Nasional">Nasional</option>
                            <option value="Nasional Terakreditasi">Nasional Terakreditasi</option>
                            <option value="Internasional">Internasional</option>
                            <option value="Internasional Bereputasi">Internasional Bereputasi</option>
                        </select>
                    </div>
                </div>

                <!-- Detail Volume dll -->
                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Volume</label>
                        <input type="text" name="volume" id="volume" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Nomor</label>
                        <input type="text" name="nomor" id="nomor" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Halaman</label>
                        <input type="text" name="halaman" id="halaman" placeholder="ex: 100-115" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                </div>

                <!-- Identitas -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1">ISSN</label>
                        <input type="text" name="issn" id="issn" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1">DOI (Link/ID)</label>
                        <input type="text" name="doi" id="doi" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                         <label class="block text-xs font-semibold text-gray-500 mb-1">Terindeks (Pisahkan koma)</label>
                         <input type="text" name="indexed" id="indexed" placeholder="SINTA 2, Scopus Q3" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Link Full Text</label>
                        <input type="url" name="link" id="link" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                </div>

                <div>
                     <label class="block text-xs font-semibold text-gray-500 mb-1">Abstrak (Opsional)</label>
                     <textarea name="abstrak" id="abstrak" rows="3" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none text-sm"></textarea>
                </div>
                
                <!-- Tombol -->
                <div class="pt-4 flex justify-end space-x-3 border-t mt-4">
                    <button type="button" onclick="closeModal()" class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg text-sm font-medium">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm font-medium">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModal(){ 
            document.getElementById('modal').classList.remove('hidden'); 
            document.getElementById('modalTitle').textContent='Tambah Publikasi'; 
            document.getElementById('action').value='create'; 
            document.querySelector('form').reset(); 
        }
        function closeModal(){ document.getElementById('modal').classList.add('hidden'); }
        function editItem(item){
            document.getElementById('modal').classList.remove('hidden'); 
            document.getElementById('modalTitle').textContent='Edit Publikasi'; 
            document.getElementById('action').value='update';
            document.getElementById('id').value=item.id;
            document.getElementById('judul').value=item.judul;
            document.getElementById('penulis').value=(item.penulis||[]).join(', ');
            document.getElementById('jenis').value=item.jenis;
            document.getElementById('nama_jurnal').value=item.nama_jurnal;
            document.getElementById('volume').value=item.volume||'';
            document.getElementById('nomor').value=item.nomor||'';
            document.getElementById('halaman').value=item.halaman||'';
            document.getElementById('tahun').value=item.tahun;
            document.getElementById('issn').value=item.issn||'';
            document.getElementById('doi').value=item.doi||'';
            document.getElementById('link').value=item.link||'';
            document.getElementById('abstrak').value=item.abstrak||'';
            document.getElementById('indexed').value=(item.indexed||[]).join(', ');
            document.getElementById('citation_count').value=item.citation_count||0;
        }
        function deleteItem(id,judul){
            if(confirm(`Yakin ingin menghapus publikasi "${judul}"?`)){
                const form=document.createElement('form'); form.method='POST';
                form.innerHTML=`<input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="${id}">`;
                document.body.appendChild(form); form.submit();
            }
        }
    </script>
</body>
</html>