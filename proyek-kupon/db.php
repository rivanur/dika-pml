<?php
// FILE: proyek-kupon/db.php

// Memanggil file konfigurasi
require_once __DIR__ . '/config.php';

// Mulai session di setiap halaman
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Membuat koneksi ke database menggunakan konstanta dari config.php
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if (!$conn) {
    die("Koneksi Gagal: " . mysqli_connect_error());
}
?>