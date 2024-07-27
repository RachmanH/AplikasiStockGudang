<?php

// Mendapatkan peran pengguna dari sesi
$userRole = $_SESSION['role'] ?? '';

// Fungsi untuk memeriksa akses halaman
function canAccessPage($page, $userRole) {
    $allowedPages = [
        'admin' => ['index.php', 'barangmasuk.php', 'barangkeluar.php', 'stock.php', 'history.php'],
        'karyawan_barang_masuk' => ['barangmasuk.php', 'stock.php', 'barangkeluar.php'],
        'karyawan_barang_keluar' => ['barangmasuk.php', 'stock.php', 'barangkeluar.php'],
        'karyawan_stock_barang' => ['barangmasuk.php', 'stock.php', 'barangkeluar.php', 'history.php'],
    ];

    return in_array($page, $allowedPages[$userRole] ?? []);
}

// Fungsi untuk mendapatkan URL halaman utama berdasarkan peran pengguna
function getHomePageUrl($userRole) {
    $homePages = [
        'admin' => 'index.php',
        'karyawan_barang_masuk' => 'barangmasuk.php',
        'karyawan_barang_keluar' => 'barangkeluar.php',
        'karyawan_stock_barang' => 'stock.php',
    ];

    return $homePages[$userRole] ?? 'index.php';
}

// Fungsi untuk mendapatkan nama peran berdasarkan peran pengguna
function getRoleName($userRole) {
    $roleNames = [
        'admin' => 'Administrator',
        'karyawan_barang_masuk' => 'Karyawan Barang Masuk',
        'karyawan_barang_keluar' => 'Karyawan Barang Keluar',
        'karyawan_stock_barang' => 'Karyawan Stock Barang',
    ];

    return $roleNames[$userRole] ?? 'Guest';
}

// Periksa halaman yang diminta
$pageRequested = basename($_SERVER['PHP_SELF']);

if (!canAccessPage($pageRequested, $userRole)) {
    $homePageUrl = getHomePageUrl($userRole);
    header("Location: $homePageUrl");
    exit();
}
?>