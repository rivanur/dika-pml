<?php
// FILE: proyek-kupon/admin/delete_coupon.php

require 'auth_check.php'; // Pastikan hanya admin yang bisa akses

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Siapkan query untuk menghapus
    // Kita tambahkan 'is_used = 0' untuk keamanan ekstra, agar kupon yg sudah dipakai tidak bisa dihapus
    $stmt = $conn->prepare("DELETE FROM coupons WHERE id = ? AND is_used = 0");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            $_SESSION['message'] = "Kupon berhasil dihapus.";
            $_SESSION['message_type'] = "success";
        } else {
            $_SESSION['message'] = "Gagal menghapus kupon. Mungkin kupon tidak ditemukan atau sudah pernah dipakai.";
            $_SESSION['message_type'] = "error";
        }
    } else {
        $_SESSION['message'] = "Terjadi kesalahan saat menghapus kupon.";
        $_SESSION['message_type'] = "error";
    }
    $stmt->close();
} else {
    $_SESSION['message'] = "ID Kupon tidak valid.";
    $_SESSION['message_type'] = "error";
}

$conn->close();

// Kembalikan admin ke halaman utama
header("Location: index.php");
exit();
?>