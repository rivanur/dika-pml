<?php
// File ini akan dipanggil di setiap halaman admin yang butuh login
// Path ke db.php perlu disesuaikan karena file ini ada di dalam folder admin
require_once __DIR__ . '/../db.php';

// Jika session admin tidak ada, tendang ke halaman login
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}
?>