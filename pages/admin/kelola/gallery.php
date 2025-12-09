<?php
session_start();

// 1. Cek Login
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: ../login.php');
    exit;
}

// 2. Setup Data Path
$dataFile = '../../../data/gallery.json';
$message = '';
$messageType = '';

// Mencegah error redeclare function
if (!function_exists('loadGalleryData')) {
    function loadGalleryData() { 
        global $dataFile; 
        if (!is_dir(dirname($dataFile))) mkdir(dirname($dataFile), 0777, true);
        if (!file_exists($dataFile)) file_put_contents($dataFile, json_encode(['gallery' => []], JSON_PRETTY_PRINT)); 
        return json_decode(file_get_contents($dataFile), true); 
    }
}

if (!function_exists('saveGalleryData')) {
    function saveGalleryData($data) { 
        global $dataFile; 
        return file_put_contents($dataFile, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)); 
    }
}

// 3. Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $data = loadGalleryData();
    $saved = false;

    // Ambil data input
    $judul = $_POST['judul'] ?? '';
    $kategori = $_POST['kategori'] ?? '';
    $konsentrasi = $_POST['konsentrasi'] ?? '';
    
    // Handle Pembuat (Convert string input to array)
    $pembuatRaw = $_POST['pembuat'] ?? '';
    $pembuat = array_map('trim', explode(',', $pembuatRaw));
    
    $tahun = $_POST['tahun'] ?? date('Y');
    $deskripsi = $_POST['deskripsi'] ?? '';
    
    // Handle Teknologi (Convert string input to array)
    $teknologiRaw = $_POST['teknologi'] ?? '';
    $teknologi = array_map('trim', explode(',', $teknologiRaw));
    
    $link_demo = $_POST['link_demo'] ?? '';
    $link_github = $_POST['link_github'] ?? '';
    $featured = isset($_POST['featured']) ? true : false;

    // Upload Gambar
    $gambar = $_POST['existing_gambar'] ?? '';
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === 0) {
        $targetDir = "../../../assets/images/gallery/";
        if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);
        $fileName = time() . '_' . basename($_FILES['gambar']['name']);
        if (move_uploaded_file($_FILES['gambar']['tmp_name'], $targetDir . $fileName)) {
            $gambar = $fileName; // Simpan nama file saja, path diatur di frontend
        }
    }

    if ($action === 'create') {
        $newItem = [
            'id' => time(),
            'judul' => $judul,
            'kategori' => $kategori,
            'konsentrasi' => $konsentrasi,
            'pembuat' => $pembuat,
            'tahun' => $tahun,
            'deskripsi' => $deskripsi,
            'teknologi' => $teknologi,
            'gambar_thumbnail' => $gambar, // Sesuaikan dengan JSON (gambar_thumbnail)
            'video_demo' => $link_demo,    // Sesuaikan dengan JSON (video_demo)
            'github' => $link_github,      // Sesuaikan dengan JSON (github)
            'featured' => $featured
        ];
        $data['gallery'][] = $newItem;
        $saved = saveGalleryData($data);
        $message = "Project berhasil ditambahkan!";
        $messageType = "success";
    } 
    elseif ($action === 'update') {
        $id = $_POST['id'];
        foreach ($data['gallery'] as &$item) {
            if ($item['id'] == $id) {
                $item['judul'] = $judul;
                $item['kategori'] = $kategori;
                $item['konsentrasi'] = $konsentrasi;
                $item['pembuat'] = $pembuat;
                $item['tahun'] = $tahun;
                $item['deskripsi'] = $deskripsi;
                $item['teknologi'] = $teknologi;
                $item['video_demo'] = $link_demo;
                $item['github'] = $link_github;
                $item['featured'] = $featured;
                if ($gambar) $item['gambar_thumbnail'] = $gambar;
                break;
            }
        }
        $saved = saveGalleryData($data);
        $message = "Project berhasil diperbarui!";
        $messageType = "success";
    } 
    elseif ($action === 'delete') {
        $id = $_POST['id'];
        $data['gallery'] = array_filter($data['gallery'], fn($i) => $i['id'] != $id);
        $data['gallery'] = array_values($data['gallery']);
        $saved = saveGalleryData($data);
        $message = "Project berhasil dihapus!";
        $messageType = "success";
    }
}

$data = loadGalleryData();
$galleryList = $data['gallery'] ?? [];

// Sort by featured first, then newest year
usort($galleryList, function($a, $b) {
    $featA = $a['featured'] ?? false;
    $featB = $b['featured'] ?? false;
    if ($featA != $featB) return $featB - $featA;
    return ($b['tahun'] ?? 0) - ($a['tahun'] ?? 0);
});
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Gallery - Admin SIEGA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-gray-50 text-gray-800">

    <!-- [FIX] Path Sidebar -->
    <?php include '../../../components/sidebar-admin.php'; ?>

    <div class="ml-64 min-h-screen flex flex-col transition-all duration-300">
        
        <header class="bg-white border-b h-16 flex items-center justify-between px-8 sticky top-0 z-30 shadow-sm">
            <h2 class="text-xl font-bold text-gray-800">Manajemen Gallery & Showcase</h2>
            <div class="text-sm text-gray-500">Administrator</div>
        </header>

        <main class="p-8 flex-1">
            <?php if ($message): ?>
                <div class="mb-6 p-4 rounded-lg <?= $messageType === 'success' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' ?>">
                    <?= $message ?>
                </div>
            <?php endif; ?>

            <div class="flex justify-between items-center mb-6">
                <p class="text-gray-600">Showcase karya mahasiswa, tugas akhir, dan project inovatif.</p>
                <button onclick="openModal()" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Tambah Project
                </button>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <table class="w-full text-left text-sm text-gray-600">
                    <thead class="bg-gray-50 text-gray-800 font-semibold border-b">
                        <tr>
                            <th class="px-6 py-4">Project Info</th>
                            <th class="px-6 py-4">Kategori</th>
                            <th class="px-6 py-4">Pembuat</th>
                            <th class="px-6 py-4 text-center">Featured</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php foreach ($galleryList as $item): ?>
                        <?php 
                            // [FIX] Handle Array to String Conversion Error
                            $displayPembuat = is_array($item['pembuat'] ?? '') ? implode(', ', $item['pembuat']) : ($item['pembuat'] ?? '-');
                            $displayTeknologi = is_array($item['teknologi'] ?? '') ? implode(', ', $item['teknologi']) : ($item['teknologi'] ?? '');
                            $displayFeatured = $item['featured'] ?? false;
                            
                            // Tampilan Gambar
                            $imgSrc = $item['gambar_thumbnail'] ?? '';
                            // Jika link eksternal (https) biarkan, jika lokal tambahkan path
                            if (!empty($imgSrc) && !filter_var($imgSrc, FILTER_VALIDATE_URL)) {
                                $imgSrc = "../../../assets/images/gallery/" . $imgSrc;
                            }
                        ?>
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-start gap-3">
                                    <?php if($imgSrc): ?>
                                        <img src="<?= htmlspecialchars($imgSrc) ?>" alt="" class="w-12 h-12 rounded object-cover border bg-gray-100">
                                    <?php else: ?>
                                        <div class="w-12 h-12 rounded bg-gray-200 flex items-center justify-center text-gray-400 text-xs">No Img</div>
                                    <?php endif; ?>
                                    <div>
                                        <div class="font-medium text-gray-900"><?= $item['judul'] ?? 'Tanpa Judul' ?></div>
                                        <div class="text-xs text-gray-500 mt-0.5 line-clamp-1"><?= $item['deskripsi'] ?? '' ?></div>
                                        <div class="text-xs text-indigo-500 mt-1"><?= $displayTeknologi ?></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-block px-2 py-1 bg-blue-50 text-blue-700 rounded text-xs font-medium mb-1"><?= $item['kategori'] ?? 'Project' ?></span>
                                <div class="text-xs text-gray-500"><?= $item['konsentrasi'] ?? '' ?> • <?= $item['tahun'] ?? '' ?></div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-700"><?= $displayPembuat ?></div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <?php if ($displayFeatured): ?>
                                    <span class="text-yellow-500 text-lg">★</span>
                                <?php else: ?>
                                    <span class="text-gray-300">☆</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <button onclick='editItem(<?= json_encode($item, JSON_HEX_APOS | JSON_HEX_QUOT) ?>)' class="text-indigo-600 hover:text-indigo-900 font-medium">Edit</button>
                                <button onclick="deleteItem(<?= $item['id'] ?? 0 ?>, '<?= addslashes($item['judul'] ?? '') ?>')" class="text-red-600 hover:text-red-900 font-medium">Hapus</button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        
                        <?php if (empty($galleryList)): ?>
                            <tr><td colspan="5" class="px-6 py-8 text-center text-gray-400">Belum ada project di gallery.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <!-- Modal Form -->
    <div id="modal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4 backdrop-blur-sm">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-2xl overflow-hidden h-auto max-h-[90vh] flex flex-col">
            <div class="px-6 py-4 border-b flex justify-between items-center bg-gray-50">
                <h3 id="modalTitle" class="font-bold text-gray-800">Tambah Project</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">&times;</button>
            </div>
            
            <form method="POST" class="p-6 space-y-4 overflow-y-auto" enctype="multipart/form-data">
                <input type="hidden" name="action" id="action" value="create">
                <input type="hidden" name="id" id="id">
                
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1">Judul Project</label>
                    <input type="text" name="judul" id="judul" required class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none font-medium">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Kategori</label>
                        <select name="kategori" id="kategori" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none bg-white">
                            <option value="Web Application">Web Application</option>
                            <option value="Mobile App">Mobile App</option>
                            <option value="Game Project">Game Project</option>
                            <option value="IoT">Internet of Things</option>
                            <option value="Data Science">Data Science</option>
                            <option value="UI/UX Design">UI/UX Design</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Konsentrasi</label>
                        <select name="konsentrasi" id="konsentrasi" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none bg-white">
                            <option value="Sistem Informasi">Sistem Informasi</option>
                            <option value="E-Commerce">E-Commerce</option>
                            <option value="Game Technology">Game Technology</option>
                            <option value="Akuntansi-SI">Akuntansi-SI</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Pembuat / Tim (Pisahkan koma)</label>
                        <input type="text" name="pembuat" id="pembuat" placeholder="Misal: Budi, Siti" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Tahun Pembuatan</label>
                        <input type="number" name="tahun" id="tahun" value="<?= date('Y') ?>" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1">Deskripsi Project</label>
                    <textarea name="deskripsi" id="deskripsi" rows="3" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none text-sm"></textarea>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1">Teknologi (Pisahkan koma)</label>
                    <input type="text" name="teknologi" id="teknologi" placeholder="Misal: PHP, React, MySQL" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Link Video Demo (YouTube)</label>
                        <input type="url" name="link_demo" id="link_demo" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Link Repository (GitHub)</label>
                        <input type="url" name="link_github" id="link_github" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none">
                    </div>
                </div>

                <div class="flex items-center gap-4 border-t pt-4">
                    <div class="flex-1">
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Upload Thumbnail</label>
                        <input type="file" name="gambar" id="gambar_input" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                        <input type="hidden" name="existing_gambar" id="gambar">
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" name="featured" id="featured" class="w-4 h-4 text-indigo-600 rounded border-gray-300 focus:ring-indigo-500">
                        <label for="featured" class="ml-2 text-sm font-medium text-gray-700">Set as Featured</label>
                    </div>
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
            document.getElementById('modalTitle').textContent='Tambah Project'; 
            document.getElementById('action').value='create'; 
            document.querySelector('form').reset(); 
        }
        function closeModal(){ document.getElementById('modal').classList.add('hidden'); }
        
        function editItem(item){
            document.getElementById('modal').classList.remove('hidden'); 
            document.getElementById('modalTitle').textContent='Edit Project'; 
            document.getElementById('action').value='update';
            document.getElementById('id').value=item.id;
            document.getElementById('judul').value=item.judul;
            document.getElementById('kategori').value=item.kategori;
            document.getElementById('konsentrasi').value=item.konsentrasi;
            
            // Handle array for inputs
            let pembuatVal = item.pembuat;
            if(Array.isArray(item.pembuat)) pembuatVal = item.pembuat.join(', ');
            document.getElementById('pembuat').value = pembuatVal || '';
            
            document.getElementById('tahun').value=item.tahun;
            document.getElementById('deskripsi').value=item.deskripsi||'';
            
            let teknoVal = item.teknologi;
            if(Array.isArray(item.teknologi)) teknoVal = item.teknologi.join(', ');
            document.getElementById('teknologi').value = teknoVal || '';
            
            document.getElementById('gambar').value=item.gambar_thumbnail||'';
            document.getElementById('link_demo').value=item.video_demo||'';
            document.getElementById('link_github').value=item.github||'';
            document.getElementById('featured').checked=item.featured||false;
        }

        function deleteItem(id,judul){
            if(confirm(`Yakin ingin menghapus project "${judul}"?`)){
                const form=document.createElement('form'); form.method='POST';
                form.innerHTML=`<input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="${id}">`;
                document.body.appendChild(form); form.submit();
            }
        }
    </script>
</body>
</html>