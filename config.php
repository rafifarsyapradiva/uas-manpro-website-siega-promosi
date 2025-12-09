<?php
/**
 * SIEGA Modern Website - Configuration File
 * Universitas Katolik Soegijapranata
 */

// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Error Reporting (Development mode)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Site Configuration
define('SITE_NAME', 'SIEGA - Sistem Informasi Unika Soegijapranata');
define('SITE_TAGLINE', 'Harvest Your Future Through Technology');
define('SITE_URL', 'http://localhost/siega-modern');
define('DATA_DIR', __DIR__ . '/data/');

// Contact Information
define('CONTACT_EMAIL', 'si@unika.ac.id');
define('CONTACT_PHONE', '(024) 8441555');
define('CONTACT_WA', '0819-0338-5595');
define('CONTACT_ADDRESS', 'Jl. Pawiyatan Luhur IV/1, Bendan Duwur, Semarang 50234');

// Social Media
define('INSTAGRAM', 'https://instagram.com/siega_unika');
define('FACEBOOK', 'https://facebook.com/siegaunika');
define('YOUTUBE', 'https://youtube.com/@siegaunika');
define('LINKEDIN', 'https://linkedin.com/school/siega-unika');

// External Links
define('WEBSITE_SIEGA', 'https://siega.id');
define('WEBSITE_PMB', 'https://pmb.unika.ac.id');

/**
 * Read JSON file
 * @param string $filename
 * @return array|null
 */
function readJSON($filename) {
    $filepath = DATA_DIR . $filename;
    
    if (!file_exists($filepath)) {
        return null;
    }
    
    $json = file_get_contents($filepath);
    $data = json_decode($json, true);
    
    if (json_last_error() !== JSON_ERROR_NONE) {
        error_log("JSON Error in $filename: " . json_last_error_msg());
        return null;
    }
    
    return $data;
}

/**
 * Write JSON file
 * @param string $filename
 * @param array $data
 * @return bool
 */
function writeJSON($filename, $data) {
    $filepath = DATA_DIR . $filename;
    
    // Create data directory if not exists
    if (!is_dir(DATA_DIR)) {
        mkdir(DATA_DIR, 0777, true);
    }
    
    $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    
    if ($json === false) {
        error_log("JSON Encode Error: " . json_last_error_msg());
        return false;
    }
    
    $result = file_put_contents($filepath, $json);
    
    return $result !== false;
}

/**
 * Get all konsentrasi
 * @return array
 */
function getKonsentrasi() {
    $data = readJSON('konsentrasi.json');
    return $data['konsentrasi'] ?? [];
}

/**
 * Get konsentrasi by ID
 * @param string $id
 * @return array|null
 */
function getKonsentrasiById($id) {
    $konsentrasi = getKonsentrasi();
    foreach ($konsentrasi as $k) {
        if ($k['id'] === $id) {
            return $k;
        }
    }
    return null;
}

/**
 * Get all skripsi with optional filters
 * @param string|null $konsentrasi
 * @param string|null $tahun
 * @return array
 */
function getSkripsi($konsentrasi = null, $tahun = null) {
    $data = readJSON('skripsi.json');
    $skripsi = $data['skripsi'] ?? [];
    
    // Filter by konsentrasi
    if ($konsentrasi) {
        $skripsi = array_filter($skripsi, function($s) use ($konsentrasi) {
            return $s['konsentrasi'] === $konsentrasi;
        });
    }
    
    // Filter by tahun
    if ($tahun) {
        $skripsi = array_filter($skripsi, function($s) use ($tahun) {
            return $s['tahun'] === $tahun;
        });
    }
    
    return array_values($skripsi);
}

/**
 * Get all journal with optional filter
 * @param string|null $kategori
 * @return array
 */
function getJournal($kategori = null) {
    $data = readJSON('journal.json');
    $journal = $data['journal'] ?? [];
    
    if ($kategori) {
        $journal = array_filter($journal, function($j) use ($kategori) {
            return $j['kategori'] === $kategori;
        });
    }
    
    return array_values($journal);
}

/**
 * Get biaya kuliah data
 * @return array
 */
function getBiayaKuliah() {
    $data = readJSON('biaya_kuliah.json');
    return $data['biaya_kuliah'] ?? [];
}

/**
 * Get all alumni
 * @return array
 */
function getAlumni() {
    $data = readJSON('alumni.json');
    return $data['alumni'] ?? [];
}

/**
 * Get all prestasi
 * @return array
 */
function getPrestasi() {
    $data = readJSON('prestasi.json');
    return $data['prestasi'] ?? [];
}

/**
 * Get all dosen
 * @return array
 */
function getDosen() {
    $data = readJSON('dosen.json');
    return $data['dosen'] ?? [];
}

/**
 * Get all fasilitas
 * @return array
 */
function getFasilitas() {
    $data = readJSON('fasilitas.json');
    return $data['fasilitas'] ?? [];
}

/**
 * Get all kegiatan
 * @return array
 */
function getKegiatan() {
    $data = readJSON('kegiatan.json');
    return $data['kegiatan'] ?? [];
}

/**
 * Get artikel with pagination
 * @param int $limit
 * @param int $offset
 * @param string|null $kategori
 * @return array
 */
function getArtikel($limit = null, $offset = 0, $kategori = null) {
    $data = readJSON('artikel.json');
    $artikel = $data['artikel'] ?? [];
    
    // Filter by kategori
    if ($kategori) {
        $artikel = array_filter($artikel, function($a) use ($kategori) {
            return $a['kategori'] === $kategori;
        });
    }
    
    // Sort by date (newest first)
    usort($artikel, function($a, $b) {
        return strtotime($b['tanggal']) - strtotime($a['tanggal']);
    });
    
    // Apply pagination
    if ($limit) {
        $artikel = array_slice($artikel, $offset, $limit);
    }
    
    return array_values($artikel);
}

/**
 * Get berita with pagination
 * @param int $limit
 * @param int $offset
 * @return array
 */
function getBerita($limit = null, $offset = 0) {
    $data = readJSON('berita.json');
    $berita = $data['berita'] ?? [];
    
    // Sort by date (newest first)
    usort($berita, function($a, $b) {
        return strtotime($b['tanggal']) - strtotime($a['tanggal']);
    });
    
    // Apply pagination
    if ($limit) {
        $berita = array_slice($berita, $offset, $limit);
    }
    
    return array_values($berita);
}

/**
 * Get FAQ by kategori
 * @param string|null $kategori
 * @return array
 */
function getFAQ($kategori = null) {
    $data = readJSON('faq.json');
    $faq = $data['faq'] ?? [];
    
    if ($kategori) {
        $faq = array_filter($faq, function($f) use ($kategori) {
            return $f['kategori'] === $kategori;
        });
    }
    
    return array_values($faq);
}

/**
 * Get gallery/projects
 * @param string|null $konsentrasi
 * @return array
 */
function getGallery($konsentrasi = null) {
    $data = readJSON('gallery.json');
    $gallery = $data['gallery'] ?? [];
    
    if ($konsentrasi) {
        $gallery = array_filter($gallery, function($g) use ($konsentrasi) {
            return $g['konsentrasi'] === $konsentrasi;
        });
    }
    
    return array_values($gallery);
}

/**
 * Sanitize input
 * @param string $data
 * @return string
 */
function sanitize($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

/**
 * Format number to Rupiah
 * @param int $number
 * @return string
 */
function formatRupiah($number) {
    return 'Rp ' . number_format($number, 0, ',', '.');
}

/**
 * Format date to Indonesian
 * @param string $date
 * @return string
 */
function formatTanggal($date) {
    $bulan = [
        1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];
    
    $timestamp = strtotime($date);
    $tanggal = date('d', $timestamp);
    $bulanAngka = date('n', $timestamp);
    $tahun = date('Y', $timestamp);
    
    return $tanggal . ' ' . $bulan[$bulanAngka] . ' ' . $tahun;
}

/**
 * Check if user is admin
 * @return bool
 */
function isAdmin() {
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}

/**
 * Redirect to URL
 * @param string $url
 */
function redirect($url) {
    header("Location: $url");
    exit();
}

/**
 * Get admin by username
 * @param string $username
 * @return array|null
 */
function getAdminByUsername($username) {
    $data = readJSON('admin.json');
    $admins = $data['admin'] ?? [];
    
    foreach ($admins as $admin) {
        if ($admin['username'] === $username) {
            return $admin;
        }
    }
    
    return null;
}

/**
 * Verify admin password
 * @param string $username
 * @param string $password
 * @return bool
 */
function verifyAdmin($username, $password) {
    $admin = getAdminByUsername($username);
    
    if (!$admin) {
        return false;
    }
    
    // In production, use password_verify() with hashed passwords
    // For development/demo, simple comparison
    return $admin['password'] === $password;
}

/**
 * Generate unique ID
 * @return string
 */
function generateId() {
    return uniqid('siega_', true);
}

/**
 * Get current page name
 * @return string
 */
function getCurrentPage() {
    $page = basename($_SERVER['PHP_SELF'], '.php');
    return $page;
}

/**
 * Check if current page is active
 * @param string $pageName
 * @return bool
 */
function isActivePage($pageName) {
    return getCurrentPage() === $pageName;
}

/**
 * Generate random color for avatar
 * @return string
 */
function generateAvatarColor() {
    $colors = ['#6366f1', '#3b82f6', '#ec4899', '#f97316', '#84cc16', '#06b6d4'];
    return $colors[array_rand($colors)];
}

/**
 * Truncate text
 * @param string $text
 * @param int $length
 * @return string
 */
function truncate($text, $length = 150) {
    if (strlen($text) <= $length) {
        return $text;
    }
    
    return substr($text, 0, $length) . '...';
}

/**
 * Get statistics for dashboard
 * @return array
 */
function getStatistics() {
    return [
        'total_mahasiswa' => 450,
        'total_alumni' => 1200,
        'total_dosen' => count(getDosen()),
        'total_konsentrasi' => count(getKonsentrasi()),
        'total_skripsi' => count(getSkripsi()),
        'total_journal' => count(getJournal()),
        'total_prestasi' => count(getPrestasi()),
        'total_kegiatan' => count(getKegiatan()),
        'total_artikel' => count(getArtikel()),
        'total_berita' => count(getBerita()),
        'employment_rate' => 92, // percentage
        'satisfaction_rate' => 95 // percentage
    ];
}