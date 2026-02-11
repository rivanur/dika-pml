<?php
header('Content-Type: application/json');
require_once 'db_connect.php';

try {
    $database = new Database();
    $conn = $database->getConnection();

    $query = "
        SELECT 
            m.id,
            m.title AS judul,
            m.author,
            m.description AS deskripsi,
            m.cover,
            DATE_FORMAT(m.release_date, '%Y-%m-%d') AS tanggal_upload,
            DATE_FORMAT(m.update_date, '%Y-%m-%d') AS update_date,
            (
                SELECT GROUP_CONCAT(g.name SEPARATOR ',')
                FROM manga_genre mg
                JOIN genre g ON mg.genre_id = g.id
                WHERE mg.manga_id = m.id
            ) AS tag,
            (
                SELECT GROUP_CONCAT(
                    CONCAT(
                        '{\"name\":\"', mc.name, '\",',
                        '\"image\":\"', mc.image, '\"}'
                    ) SEPARATOR '|'
                )
                FROM manga_characters mc
                WHERE mc.manga_id = m.id
            ) AS karakter
        FROM manga m
        WHERE m.title NOT LIKE '[hide]%'
        ORDER BY m.id DESC
    ";

    $stmt = $conn->prepare($query);
    $stmt->execute();

    $comics = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // Format tag
        $row['tag'] = $row['tag'] ? explode(',', $row['tag']) : [];
        
        // Format karakter
        $karakter = [];
        if (!empty($row['karakter'])) {
            $chars = explode('|', $row['karakter']);
            foreach ($chars as $char) {
                $karakter[] = json_decode($char, true);
            }
        }
        $row['karakter'] = $karakter;
        
        $comics[] = $row;
    }

    echo json_encode($comics);
    
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}