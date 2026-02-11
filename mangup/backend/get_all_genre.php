<?php
header('Content-Type: application/json');
require_once 'db_connect.php';

try {
    $database = new Database();
    $conn = $database->getConnection();
    
    $stmt = $conn->query("SELECT * FROM genre ORDER BY name");
    $genres = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($genres);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>