<?php
header('Content-Type: application/json');
require_once 'db_connect.php';

try {
    $data = json_decode(file_get_contents('php://input'), true);
    $mangaId = $data['id'];

    $database = new Database();
    $conn = $database->getConnection();

    // Ambil judul saat ini
    $stmt = $conn->prepare("SELECT title FROM manga WHERE id = ?");
    $stmt->execute([$mangaId]);
    $currentTitle = $stmt->fetchColumn();

    // Toggle status hide
    if (strpos($currentTitle, '[hide]') === 0) {
        // Jika sudah dihide, hapus prefix [hide]
        $newTitle = substr($currentTitle, 7); // 7 karakter [hide] + spasi
    } else {
        // Jika belum dihide, tambahkan prefix [hide]
        $newTitle = '[hide] ' . $currentTitle;
    }

    // Update judul
    $updateStmt = $conn->prepare("UPDATE manga SET title = ? WHERE id = ?");
    $updateStmt->execute([$newTitle, $mangaId]);

    echo json_encode([
        'status' => 'success',
        'message' => strpos($currentTitle, '[hide]') === 0 ? 
            'Manga berhasil diunhide' : 'Manga berhasil dihide'
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}