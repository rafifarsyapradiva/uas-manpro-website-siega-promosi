<?php
session_start();

// 1. Cek Login
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    // Perbaikan path login: keluar 1 level dari 'kelola' ke 'admin'
    header('Location: ../login.php');
    exit;
}

// 2. Setup Data Path (Naik 3 level ke root -> data)
$dataFile = '../../../data/alumni.json';
$message = '';
$messageType = '';

// Helper Functions
function loadData() { 
    global $dataFile; 
    if (!is_dir(dirname($dataFile))) mkdir(dirname($dataFile), 0777, true);
    if (!file_exists($dataFile)) file_put_contents($dataFile, json_encode(['alumni' => []], JSON_PRETTY_PRINT)); 
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
            'nama' => htmlspecialchars($_POST['nama']),
            'angkatan' => intval($_POST['angkatan']),
            'konsentrasi' => htmlspecialchars($_POST['konsentrasi']),
            // Simpan dengan key standar baru
            'posisi' => htmlspecialchars($_POST['posisi']), 
            'perusahaan' => htmlspecialchars($_POST['perusahaan']),
            'lokasi' => htmlspecialchars($_POST['lokasi'] ?? ''),
            'testimoni' => htmlspecialchars($_POST['testimoni'] ?? ''), 
            'foto' => htmlspecialchars($_POST['foto'] ?? ''), 
            'featured' => isset($_POST['featured']) 
        ];

        // Membersihkan key lama jika ada (opsional, untuk kerapihan data kedepannya)
        if (isset($item['posisi_saat_ini'])) unset($item['posisi_saat_ini']);
        if (isset($item['testimony'])) unset($item['testimony']);

        if ($action === 'create') {
            array_unshift($data['alumni'], $item);
        } else {
            foreach ($data['alumni'] as &$row) {
                if ($row['id'] === $id) { 
                    // Merge agar data lain yang tidak ada di form tidak hilang (opsional)
                    $row = array_merge($row, $item); 
                    break; 
                }
            }
        }
        $saved = saveData($data);
        $message = $saved ? 'Data Alumni berhasil disimpan!' : 'Gagal menyimpan.';
        $messageType = $saved ? 'success' : 'error';
    } 
    elseif ($action === 'delete') {
        $id = intval($_POST['id']);
        $data['alumni'] = array_filter($data['alumni'], fn($i) => $i['id'] !== $id);
        $saved = saveData($data);
        $message = $saved ? 'Data dihapus.' : 'Gagal menghapus.';
        $messageType = $saved ? 'success' : 'error';
    }
}

$data = loadData();
$list = $data['alumni'] ?? [];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Alumni - Admin SIEGA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-gray-50 text-gray-800">

    <!-- INCLUDE SIDEBAR -->
    <?php include '../../../components/sidebar-admin.php'; ?>

    <div class="ml-64 min-h-screen flex flex-col transition-all duration-300">
        
        <header class="bg-white border-b h-16 flex items-center justify-between px-8 sticky top-0 z-30 shadow-sm">
            <h2 class="text-xl font-bold text-gray-800">Manajemen Alumni & Testimoni</h2>
            <div class="text-sm text-gray-500">Administrator</div>
        </header>

        <main class="p-8 flex-1">
            <?php if ($message): ?>
                <div class="mb-6 p-4 rounded-lg <?= $messageType === 'success' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' ?>">
                    <?= $message ?>
                </div>
            <?php endif; ?>

            <div class="flex justify-between items-center mb-6">
                <p class="text-gray-600">Daftar alumni sukses dan testimoni karir.</p>
                <button onclick="openModal()" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Tambah Alumni
                </button>
            </div>

            <!-- Grid Card Alumni -->
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                <?php if (empty($list)): ?>
                    <div class="col-span-full text-center py-10 text-gray-500">Belum ada data alumni.</div>
                <?php else: ?>
                    <?php foreach ($list as $item): ?>
                    <?php 
                        // FIX: Normalisasi Data (Handle perbedaan key JSON lama vs baru)
                        $posisi = $item['posisi'] ?? $item['posisi_saat_ini'] ?? '-';
                        $testimoni = $item['testimoni'] ?? $item['testimony'] ?? '';
                        $featured = $item['featured'] ?? false;
                        $foto = $item['foto'] ?? '';
                        $nama = $item['nama'] ?? 'Tanpa Nama';
                        $angkatan = $item['angkatan'] ?? '';
                        $konsentrasi = $item['konsentrasi'] ?? '';
                        $perusahaan = $item['perusahaan'] ?? '';
                        $lokasi = $item['lokasi'] ?? '';
                    ?>
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col hover:shadow-md transition-shadow relative">
                        <?php if($featured): ?>
                            <span class="absolute top-4 right-4 text-[10px] font-bold bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full uppercase tracking-wide">Featured</span>
                        <?php endif; ?>
                        
                        <div class="flex items-center space-x-4 mb-4">
                            <div class="w-12 h-12 rounded-full bg-gray-200 flex items-center justify-center overflow-hidden shrink-0">
                                <?php if($foto): ?>
                                    <img src="<?= $foto ?>" alt="<?= $nama ?>" class="w-full h-full object-cover">
                                <?php else: ?>
                                    <span class="text-xl">🎓</span>
                                <?php endif; ?>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-800"><?= $nama ?></h3>
                                <p class="text-xs text-gray-500">Angkatan <?= $angkatan ?> • <?= $konsentrasi ?></p>
                            </div>
                        </div>
                        
                        <div class="flex-1 mb-4">
                            <div class="flex items-start gap-2 mb-2">
                                <svg class="w-4 h-4 text-purple-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                <div>
                                    <p class="text-sm font-semibold text-gray-700"><?= $posisi ?></p>
                                    <p class="text-xs text-gray-500"><?= $perusahaan ?> <?= $lokasi ? "($lokasi)" : '' ?></p>
                                </div>
                            </div>
                            <?php if($testimoni): ?>
                                <p class="text-xs text-gray-500 italic border-l-2 border-purple-200 pl-3 mt-3 line-clamp-3">
                                    "<?= $testimoni ?>"
                                </p>
                            <?php endif; ?>
                        </div>

                        <div class="flex justify-end space-x-3 pt-4 border-t border-gray-50">
                            <!-- Pass normalized item to JS edit function -->
                            <?php 
                                // Buat item baru untuk edit agar JS menerima key yang konsisten
                                $editItem = $item;
                                $editItem['posisi'] = $posisi;
                                $editItem['testimoni'] = $testimoni;
                                $editItem['featured'] = $featured;
                            ?>
                            <button onclick='editItem(<?= json_encode($editItem) ?>)' class="text-purple-600 hover:text-purple-800 text-xs font-semibold uppercase tracking-wide">Edit</button>
                            <button onclick="deleteItem(<?= $item['id'] ?>, '<?= addslashes($nama) ?>')" class="text-red-500 hover:text-red-700 text-xs font-semibold uppercase tracking-wide">Hapus</button>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

        </main>
    </div>

    <!-- Modal Form -->
    <div id="modal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4 backdrop-blur-sm">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-2xl overflow-hidden h-auto max-h-[90vh] flex flex-col">
            <div class="px-6 py-4 border-b flex justify-between items-center bg-gray-50 shrink-0">
                <h3 id="modalTitle" class="font-bold text-gray-800">Tambah Data Alumni</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">&times;</button>
            </div>
            
            <form method="POST" class="flex-1 overflow-y-auto p-6 space-y-4">
                <input type="hidden" name="action" id="action" value="create">
                <input type="hidden" name="id" id="id">
                
                <!-- Baris 1: Nama & Angkatan -->
                <div class="grid grid-cols-2 gap-4">
                    <div class="col-span-2 md:col-span-1">
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Nama Lengkap</label>
                        <input type="text" name="nama" id="nama" required class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-purple-500 outline-none font-bold text-gray-800">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Angkatan</label>
                        <input type="number" name="angkatan" id="angkatan" placeholder="2018" required class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-purple-500 outline-none">
                    </div>
                </div>

                <!-- Baris 2: Konsentrasi & Foto -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Konsentrasi</label>
                        <select name="konsentrasi" id="konsentrasi" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-purple-500 outline-none bg-white">
                            <option value="Sistem Informasi">Sistem Informasi</option>
                            <option value="E-Commerce">E-Commerce</option>
                            <option value="Game Technology">Game Technology</option>
                            <option value="Akuntansi SI">Akuntansi SI</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1">URL Foto (Opsional)</label>
                        <input type="url" name="foto" id="foto" placeholder="https://..." class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-purple-500 outline-none">
                    </div>
                </div>

                <!-- Baris 3: Pekerjaan -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Posisi / Jabatan</label>
                        <input type="text" name="posisi" id="posisi" placeholder="CEO / Developer" required class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-purple-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Perusahaan</label>
                        <input type="text" name="perusahaan" id="perusahaan" required class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-purple-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Lokasi (Kota/Negara)</label>
                        <input type="text" name="lokasi" id="lokasi" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-purple-500 outline-none">
                    </div>
                </div>

                <!-- Testimoni -->
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1">Testimoni / Kata Mutiara</label>
                    <textarea name="testimoni" id="testimoni" rows="3" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-purple-500 outline-none text-sm"></textarea>
                </div>

                <!-- Featured Checkbox -->
                <div class="flex items-center space-x-2 bg-purple-50 p-3 rounded-lg border border-purple-100">
                    <input type="checkbox" name="featured" id="featured" class="w-4 h-4 text-purple-600 rounded border-gray-300 focus:ring-purple-500">
                    <label for="featured" class="text-sm font-medium text-purple-900 select-none cursor-pointer">
                        Tampilkan sebagai Alumni Unggulan (Featured)
                    </label>
                </div>

                <div class="pt-4 flex justify-end space-x-3 border-t mt-4">
                    <button type="button" onclick="closeModal()" class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg text-sm font-medium">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 text-sm font-medium">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModal(){ 
            document.getElementById('modal').classList.remove('hidden'); 
            document.getElementById('modalTitle').textContent='Tambah Data Alumni'; 
            document.getElementById('action').value='create'; 
            document.querySelector('form').reset(); 
            document.getElementById('featured').checked=false;
        }
        function closeModal(){ 
            document.getElementById('modal').classList.add('hidden'); 
        }
        function editItem(item){
            document.getElementById('modal').classList.remove('hidden');
            document.getElementById('modalTitle').textContent='Edit Alumni';
            document.getElementById('action').value='update';
            document.getElementById('id').value=item.id;
            document.getElementById('nama').value=item.nama;
            document.getElementById('angkatan').value=item.angkatan;
            document.getElementById('konsentrasi').value=item.konsentrasi;
            
            // Handle variasi key dari data lama (JS juga butuh dihandle atau sudah dinormalisasi via PHP di atas)
            // Karena kita sudah kirim object $editItem dari PHP, key-nya sudah pasti 'posisi' dan 'testimoni'
            document.getElementById('posisi').value = item.posisi;
            document.getElementById('testimoni').value = item.testimoni || '';
            
            document.getElementById('perusahaan').value=item.perusahaan;
            document.getElementById('lokasi').value=item.lokasi||'';
            document.getElementById('foto').value=item.foto||'';
            document.getElementById('featured').checked=item.featured||false;
        }
        function deleteItem(id,nama){
            if(confirm(`Yakin ingin menghapus alumni "${nama}"?`)){
                const form=document.createElement('form');
                form.method='POST';
                form.innerHTML=`<input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="${id}">`;
                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
</body>
</html>