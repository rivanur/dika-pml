<?php
require '../db.php'; 

// Hancurkan semua data sesi
session_destroy();

// Arahkan ke halaman login admin
header("Location: login.php");
exit();
?>