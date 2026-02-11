<?php
header('Content-Type: application/json');
require_once 'db_connect.php';

function uploadFile($file, $targetDir) {
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }
    
    $fileName = uniqid() . '_' . basename($file["name"]);
    $targetPath = $targetDir . $fileName;
    
    if (!move_uploaded_file($file["tmp_name"], $targetPath)) {
        throw new Exception("Gagal mengupload file");
    }
    
    return $fileName;
}

try {
    $required = ['author', 'title', 'description', 'release_date', 'genres'];
    foreach ($required as $field) {
        if (empty($_POST[$field])) {
            throw new Exception("Field $field harus diisi");
        }
    }

    // Validasi genre
    $genreIds = explode(',', $_POST['genres']);
    if (empty($genreIds)) {
        throw new Exception("Pilih minimal satu genre");
    }

    $database = new Database();
    $conn = $database->getConnection();
    $conn->beginTransaction();

    // Upload cover manga
    $coverDir = "../uploads/cover/";
    $coverFile = uploadFile($_FILES['cover'], $coverDir);

    // Simpan data manga
    $stmt = $conn->prepare("INSERT INTO manga (title, author, description, cover, update_date, release_date) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $_POST['title'],
        $_POST['author'],
        $_POST['description'],
        $coverFile,
        date('Y-m-d', strtotime($_POST['update_date'])),
        date('Y-m-d', strtotime($_POST['release_date']))
    ]);
    
    $mangaId = $conn->lastInsertId();

    // Simpan genre
    $genreStmt = $conn->prepare("INSERT INTO manga_genre (manga_id, genre_id) VALUES (?, ?)");
    foreach ($genreIds as $genreId) {
        $genreStmt->execute([$mangaId, $genreId]);
    }

    // Simpan karakter
    if (!empty($_POST['character_names'])) {
        $charDir = "../uploads/characters/";
        $charStmt = $conn->prepare("INSERT INTO manga_characters (manga_id, name, image, deskripsi) VALUES (?, ?, ?, ?)");
        
        for ($i = 0; $i < count($_POST['character_names']); $i++) {
            $charFile = [
                'name' => $_FILES['character_images']['name'][$i],
                'tmp_name' => $_FILES['character_images']['tmp_name'][$i],
                'error' => $_FILES['character_images']['error'][$i]
            ];
            
            $charImage = uploadFile($charFile, $charDir);
            
            $charStmt->execute([
                $mangaId,
                $_POST['character_names'][$i],
                $charImage,
                $_POST['character_descriptions'][$i]
            ]);
        }
    }

    $conn->commit();
    echo json_encode(['status' => 'success', 'message' => 'Manga berhasil diupload']);
} catch (Exception $e) {
    if (isset($conn)) {
        $conn->rollBack();
    }
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>