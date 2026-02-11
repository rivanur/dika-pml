<?php
header('Content-Type: application/json');
require_once 'db_connect.php';

try {
    if (empty($_GET['id'])) {
        throw new Exception('ID manga tidak ditemukan');
    }

    $mangaId = $_GET['id'];

    $database = new Database();
    $conn = $database->getConnection();

    // Ambil data manga
    $stmt = $conn->prepare("SELECT * FROM manga WHERE id = ?");
    $stmt->execute([$mangaId]);
    $manga = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$manga) {
        throw new Exception('Manga tidak ditemukan');
    }

    // Ambil genre manga
    $stmt = $conn->prepare("SELECT genre_id FROM manga_genre WHERE manga_id = ?");
    $stmt->execute([$mangaId]);
    $genres = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

    // Ambil karakter manga
    $stmt = $conn->prepare("SELECT name, image FROM manga_characters WHERE manga_id = ?");
    $stmt->execute([$mangaId]);
    $characters = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'id' => $manga['id'],
        'title' => $manga['title'],
        'author' => $manga['author'],
        'description' => $manga['description'],
        'release_date' => $manga['release_date'],
        'cover' => $manga['cover'],
        'genres' => $genres,
        'characters' => $characters
    ]);
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['error' => $e->getMessage()]);
}
?>