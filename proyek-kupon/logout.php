<?php
require 'db.php'; // Cukup untuk memanggil session_start()

// Hancurkan semua data sesi
session_destroy();

// Arahkan ke halaman login
header("Location: login.php");
exit();
?>