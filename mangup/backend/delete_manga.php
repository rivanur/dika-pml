<?php
header('Content-Type: application/json');
require_once 'db_connect.php';

try {
    $data = json_decode(file_get_contents('php://input'), true);
    $mangaId = $data['id'];

    $database = new Database();
    $conn = $database->getConnection();
    $conn->beginTransaction();

    // 1. Dapatkan nama file cover dan karakter yang akan dihapus
    $filesToDelete = [];
    
    // Ambil cover manga
    $stmt = $conn->prepare("SELECT cover FROM manga WHERE id = ?");
    $stmt->execute([$mangaId]);
    $cover = $stmt->fetchColumn();
    if ($cover) {
        $filesToDelete[] = "../uploads/cover/" . $cover;
    }

    // Ambil gambar karakter
    $stmt = $conn->prepare("SELECT image FROM manga_characters WHERE manga_id = ?");
    $stmt->execute([$mangaId]);
    $characterImages = $stmt->fetchAll(PDO::FETCH_COLUMN);
    foreach ($characterImages as $image) {
        if ($image) {
            $filesToDelete[] = "../uploads/characters/" . $image;
        }
    }

    // 2. Hapus data dari database
    // Hapus genre
    $stmt = $conn->prepare("DELETE FROM manga_genre WHERE manga_id = ?");
    $stmt->execute([$mangaId]);

    // Hapus karakter
    $stmt = $conn->prepare("DELETE FROM manga_characters WHERE manga_id = ?");
    $stmt->execute([$mangaId]);

    // Hapus manga
    $stmt = $conn->prepare("DELETE FROM manga WHERE id = ?");
    $stmt->execute([$mangaId]);

    $conn->commit();

    // 3. Hapus file gambar setelah transaksi berhasil
    foreach ($filesToDelete as $filePath) {
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }

    echo json_encode(['status' => 'success', 'message' => 'Manga dan semua gambarnya berhasil dihapus']);
} catch (Exception $e) {
    $conn->rollBack();
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}