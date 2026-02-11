<?php
header('Content-Type: application/json');

require_once 'db_connect.php';

try {
    // Validasi input
    if (empty($_POST['username'])) {
        throw new Exception('Username harus diisi');
    }
    if (empty($_POST['password'])) {
        throw new Exception('Password harus diisi');
    }

    $database = new Database();
    $conn = $database->getConnection();

    // Cek apakah username sudah ada
    $checkStmt = $conn->prepare("SELECT id FROM admin WHERE username = ?");
    $checkStmt->execute([$_POST['username']]);
    
    if ($checkStmt->rowCount() > 0) {
        throw new Exception('Username sudah digunakan');
    }

    // Hash password
    $hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Tambahkan admin baru
    $stmt = $conn->prepare("INSERT INTO admin (username, password) VALUES (?, ?)");
    $stmt->execute([$_POST['username'], $hashedPassword]);

    echo json_encode([
        'status' => 'success',
        'message' => 'Admin berhasil ditambahkan'
    ]);
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}
?>