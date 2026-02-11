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
    if (empty($_POST['id'])) {
        throw new Exception('ID manga tidak valid');
    }
    
    $mangaId = $_POST['id'];
    $database = new Database();
    $conn = $database->getConnection();
    $conn->beginTransaction();
    
    // 1. Update data manga utama
    $updateFields = [
        'title' => $_POST['title'],
        'author' => $_POST['author'],
        'description' => $_POST['description'],
        'update_date' => $_POST['update_date'],
        'release_date' => $_POST['release_date']
    ];
    
    // Handle cover jika diupload
    if (!empty($_FILES['cover']['name'])) {
        $coverDir = "../uploads/cover/";
        $coverFile = uploadFile($_FILES['cover'], $coverDir);
        $updateFields['cover'] = $coverFile;
    }
    
    $setParts = [];
    $params = [];
    foreach ($updateFields as $field => $value) {
        $setParts[] = "$field = ?";
        $params[] = $value;
    }
    $params[] = $mangaId;
    
    $sql = "UPDATE manga SET " . implode(', ', $setParts) . " WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute($params);
    
    // 2. Update genre
    // Hapus semua genre lama
    $conn->prepare("DELETE FROM manga_genre WHERE manga_id = ?")->execute([$mangaId]);
    
    // Tambahkan genre baru
    if (!empty($_POST['genres'])) {
        $genreStmt = $conn->prepare("INSERT INTO manga_genre (manga_id, genre_id) VALUES (?, ?)");
        $genreIds = explode(',', $_POST['genres']);
        
        foreach ($genreIds as $genreId) {
            $genreStmt->execute([$mangaId, $genreId]);
        }
    }
    
    // 3. Handle karakter
    // Update karakter yang ada
    if (!empty($_POST['character_names'])) {
        foreach ($_POST['character_names'] as $charId => $charName) {
            $charData = [
                'name' => $charName,
                'deskripsi' => $_POST['character_descriptions'][$charId],
                'id' => $charId
            ];
            
            // Jika ada file gambar baru
            if (!empty($_FILES['character_images']['name'][$charId])) {
                $charFile = [
                    'name' => $_FILES['character_images']['name'][$charId],
                    'tmp_name' => $_FILES['character_images']['tmp_name'][$charId],
                    'error' => $_FILES['character_images']['error'][$charId]
                ];
                
                $charDir = "../uploads/characters/";
                $charImage = uploadFile($charFile, $charDir);
                $charData['image'] = $charImage;
            }
            
            // Bangar query update
            $setParts = [];
            $params = [];
            foreach ($charData as $field => $value) {
                if ($field !== 'id') {
                    $setParts[] = "$field = ?";
                    $params[] = $value;
                }
            }
            $params[] = $charId;
            
            $sql = "UPDATE manga_characters SET " . implode(', ', $setParts) . " WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute($params);
        }
    }
    
    // Hapus karakter yang ditandai
    if (!empty($_POST['delete_characters'])) {
        $deleteStmt = $conn->prepare("DELETE FROM manga_characters WHERE id = ?");
        foreach ($_POST['delete_characters'] as $charId) {
            $deleteStmt->execute([$charId]);
        }
    }
    
    // Tambahkan karakter baru
    if (!empty($_POST['new_character_names'])) {
        $charStmt = $conn->prepare("INSERT INTO manga_characters (manga_id, name, image, deskripsi) VALUES (?, ?, ?, ?)");
        
        foreach ($_POST['new_character_names'] as $index => $charName) {
            $charImage = '';
            $charDescription = $_POST['new_character_descriptions'][$index];
            
            // Jika ada file gambar
            if (!empty($_FILES['new_character_images']['name'][$index])) {
                $charFile = [
                    'name' => $_FILES['new_character_images']['name'][$index],
                    'tmp_name' => $_FILES['new_character_images']['tmp_name'][$index],
                    'error' => $_FILES['new_character_images']['error'][$index]
                ];
                
                $charDir = "../uploads/characters/";
                $charImage = uploadFile($charFile, $charDir);
            }
            
            $charStmt->execute([$mangaId, $charName, $charImage]);
        }
    }
    
    $conn->commit();
    echo json_encode(['status' => 'success', 'message' => 'Manga berhasil diperbarui']);
} catch (Exception $e) {
    if (isset($conn)) {
        $conn->rollBack();
    }
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>