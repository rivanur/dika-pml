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
    
    $stmt = $conn->prepare("SELECT g.id, g.name FROM genre g 
                           JOIN manga_genre mg ON g.id = mg.genre_id 
                           WHERE mg.manga_id = ?");
    $stmt->execute([$mangaId]);
    $genres = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($genres);
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['error' => $e->getMessage()]);
}
?>