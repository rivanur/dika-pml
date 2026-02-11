<?php
header('Content-Type: application/json');
require_once 'db_connect.php';

try {
    $database = new Database();
    $conn = $database->getConnection();
    
    $mangaId = $_GET['id'] ?? null;
    
    if (!$mangaId) {
        throw new Exception('ID manga tidak valid');
    }
    
    // Ambil data manga
    $stmt = $conn->prepare("
        SELECT * FROM manga 
        WHERE id = ?
    ");
    $stmt->execute([$mangaId]);
    $manga = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$manga) {
        throw new Exception('Manga tidak ditemukan');
    }
    
    // Ambil genre manga
    $stmt = $conn->prepare("
        SELECT g.id, g.name 
        FROM manga_genre mg
        JOIN genre g ON mg.genre_id = g.id
        WHERE mg.manga_id = ?
    ");
    $stmt->execute([$mangaId]);
    $genres = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Ambil karakter manga
    $stmt = $conn->prepare("
        SELECT * FROM manga_characters
        WHERE manga_id = ?
    ");
    $stmt->execute([$mangaId]);
    $characters = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode([
        'status' => 'success',
        'manga' => $manga,
        'genres' => $genres,
        'characters' => $characters
    ]);
    
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}