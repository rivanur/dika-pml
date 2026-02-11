<?php
header('Content-Type: application/json');
require_once 'db_connect.php';

try {
    $query = $_GET['query'] ?? '';
    
    if (empty($query)) {
        throw new Exception('Query pencarian tidak boleh kosong');
    }
    
    $database = new Database();
    $conn = $database->getConnection();
    
    $stmt = $conn->prepare("SELECT * FROM manga WHERE title LIKE ? ORDER BY title LIMIT 20");
    $searchTerm = "%$query%";
    $stmt->execute([$searchTerm]);
    
    $mangas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($mangas);
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['error' => $e->getMessage()]);
}
?>