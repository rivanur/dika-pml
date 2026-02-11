<?php
header('Content-Type: application/json');
require_once 'db_connect.php';

try {
    $mangaId = $_GET['id'] ?? 0;
    
    if (empty($mangaId)) {
        throw new Exception('ID manga tidak valid');
    }
    
    $database = new Database();
    $conn = $database->getConnection();
    
    // Ambil data manga
    $stmt = $conn->prepare("SELECT * FROM manga WHERE id = ?");
    $stmt->execute([$mangaId]);
    $manga = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$manga) {
        throw new Exception('Manga tidak ditemukan');
    }
    
    // Ambil karakter
    $charStmt = $conn->prepare("SELECT * FROM manga_characters WHERE manga_id = ?");
    $charStmt->execute([$mangaId]);
    $characters = $charStmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode([
        'manga' => $manga,
        'characters' => $characters
    ]);
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['error' => $e->getMessage()]);
}
?>