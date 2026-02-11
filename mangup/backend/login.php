<?php
session_start();
header('Content-Type: application/json');

require_once 'db_connect.php';

try {
    // Validasi input
    if (empty($_POST['username']) || empty($_POST['password'])) {
        throw new Exception('Username dan password harus diisi');
    }

    $database = new Database();
    $conn = $database->getConnection();

    // Cari admin berdasarkan username
    $stmt = $conn->prepare("SELECT id, username, password FROM admin WHERE username = ?");
    $stmt->execute([$_POST['username']]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$admin) {
        throw new Exception('Username tidak ditemukan');
    }

    // Verifikasi password
    if (!password_verify($_POST['password'], $admin['password'])) {
        throw new Exception('Password salah');
    }

    // Set session
    $_SESSION['admin_logged_in'] = true;
    $_SESSION['admin_id'] = $admin['id'];
    $_SESSION['admin_username'] = $admin['username'];

    echo json_encode([
        'status' => 'success',
        'message' => 'Login berhasil'
    ]);
} catch (Exception $e) {
    http_response_code(401);
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}
?>