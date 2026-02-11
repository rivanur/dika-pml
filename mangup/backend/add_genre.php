<?php
header('Content-Type: application/json');
require_once 'db_connect.php';

try {
    if (empty($_POST['name'])) {
        throw new Exception('Nama genre harus diisi');
    }
    
    $genreName = trim($_POST['name']);
    
    $database = new Database();
    $conn = $database->getConnection();
    
    // Cek apakah genre sudah ada
    $stmt = $conn->prepare("SELECT id FROM genre WHERE name = ?");
    $stmt->execute([$genreName]);
    $existing = $stmt->fetch();
    
    if ($existing) {
        echo json_encode([
            'status' => 'success',
            'genre_id' => $existing['id'],
            'message' => 'Genre sudah ada'
        ]);
        exit;
    }
    
    // Tambahkan genre baru
    $stmt = $conn->prepare("INSERT INTO genre (name) VALUES (?)");
    $stmt->execute([$genreName]);
    $genreId = $conn->lastInsertId();
    
    echo json_encode([
        'status' => 'success',
        'genre_id' => $genreId,
        'message' => 'Genre berhasil ditambahkan'
    ]);
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}
?>