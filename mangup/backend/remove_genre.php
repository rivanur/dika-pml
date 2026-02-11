<?php
header('Content-Type: application/json');
require_once 'db_connect.php';

try {
    if (empty($_POST['id'])) {
        throw new Exception('ID genre harus disediakan');
    }
    
    $genreId = (int)$_POST['id'];
    
    $database = new Database();
    $conn = $database->getConnection();
    
    // Hapus genre
    $stmt = $conn->prepare("DELETE FROM genre WHERE id = ?");
    $stmt->execute([$genreId]);
    
    if ($stmt->rowCount() > 0) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Genre berhasil dihapus'
        ]);
    } else {
        throw new Exception('Genre tidak ditemukan');
    }
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}
?>