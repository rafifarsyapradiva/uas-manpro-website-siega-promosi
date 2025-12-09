<?php
session_start();

// Redirect jika sudah login
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: dashboard.php');
    exit;
}

// Load admin credentials dari JSON
$adminFile = '../../data/admin.json';
$errorMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    
    // Gunakan fallback path jika file tidak ditemukan
    if (!file_exists($adminFile)) {
         $adminFile = __DIR__ . '/../../data/admin.json';
    }

    if (file_exists($adminFile)) {
        $jsonContent = file_get_contents($adminFile);
        $data = json_decode($jsonContent, true);
        
        // Perbaikan: Akses array 'admin' lalu loop untuk mencari user
        $admins = $data['admin'] ?? [];
        $loginSuccess = false;
        $foundAdmin = null;

        foreach ($admins as $admin) {
            // Cek username (case-insensitive)
            if (strcasecmp($admin['username'], $username) === 0) {
                // Cek Password
                // Catatan: Di file JSON Anda password sepertinya plain text ("admin123").
                // Jika password di JSON sudah di-hash, gunakan password_verify().
                // Untuk keamanan, sebaiknya di masa depan gunakan hash.
                // Kode di bawah ini mendukung keduanya (plain text atau hash).
                
                if ($password === $admin['password'] || password_verify($password, $admin['password'])) {
                    $loginSuccess = true;
                    $foundAdmin = $admin;
                    break;
                }
            }
        }

        if ($loginSuccess) {
            // Login success
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_username'] = $foundAdmin['username'];
            $_SESSION['admin_name'] = $foundAdmin['nama_lengkap'] ?? $foundAdmin['username']; // Pakai 'nama_lengkap' sesuai JSON
            $_SESSION['admin_role'] = $foundAdmin['role'] ?? 'admin';
            $_SESSION['login_time'] = time();
            
            header('Location: dashboard.php');
            exit;
        } else {
            $errorMessage = 'Username atau password salah!';
        }
    } else {
        $errorMessage = 'File database admin tidak ditemukan!';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - SIEGA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-900 min-h-screen flex items-center justify-center p-4">

    <div class="max-w-md w-full bg-white rounded-2xl shadow-2xl overflow-hidden">
        <!-- Header -->
        <div class="bg-indigo-600 p-8 text-center">
            <div class="w-16 h-16 bg-white/20 rounded-xl flex items-center justify-center mx-auto mb-4 backdrop-blur-sm">
                <span class="text-3xl">🔐</span>
            </div>
            <h2 class="text-2xl font-bold text-white mb-1">Admin Portal</h2>
            <p class="text-indigo-200 text-sm">Masuk untuk mengelola data SIEGA</p>
        </div>

        <!-- Form -->
        <div class="p-8">
            <?php if ($errorMessage): ?>
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded flex items-center gap-3">
                    <span class="text-red-500 text-xl">⚠️</span>
                    <p class="text-sm text-red-700 font-medium"><?= htmlspecialchars($errorMessage) ?></p>
                </div>
            <?php endif; ?>

            <form method="POST" action="" class="space-y-6">
                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">👤</span>
                        <input type="text" 
                               id="username" 
                               name="username" 
                               required 
                               class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition outline-none"
                               placeholder="Masukkan username">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">🔑</span>
                        <input type="password" 
                               id="password" 
                               name="password" 
                               required 
                               class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition outline-none"
                               placeholder="••••••••">
                    </div>
                </div>

                <div class="flex items-center">
                    <input type="checkbox" 
                           id="remember" 
                           class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                    <label for="remember" class="ml-2 text-sm text-gray-700">
                        Ingat saya
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 rounded-lg transition duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                    Masuk ke Dashboard
                </button>
            </form>

            <!-- Demo Credentials Info -->
            <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                <p class="text-xs text-blue-700 font-medium mb-2">Login Info:</p>
                <div class="flex justify-between text-xs text-blue-600 mb-1">
                    <span>Username: <code class="bg-blue-100 px-2 py-0.5 rounded font-bold">admin</code></span>
                </div>
                <div class="flex justify-between text-xs text-blue-600">
                    <span>Password: <code class="bg-blue-100 px-2 py-0.5 rounded font-bold">admin123</code></span>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center p-4 bg-gray-50 border-t border-gray-100">
            <a href="../../index.php" class="text-sm text-gray-500 hover:text-indigo-600 transition flex items-center justify-center gap-1">
                <span>←</span> Kembali ke Halaman Utama
            </a>
        </div>
    </div>

</body>
</html>