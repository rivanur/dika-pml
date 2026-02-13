<?php
require 'auth_check.php'; // Pemeriksa login admin

// Logika untuk menambah kupon baru
$message = '';
$message_type = '';
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_coupon'])) {
    $code = trim($_POST['code']);
    $value = intval($_POST['value']);

    if (!empty($code) && $value > 0) {
        $stmt = $conn->prepare("INSERT INTO coupons (code, value) VALUES (?, ?)");
        $stmt->bind_param("si", $code, $value);
        if ($stmt->execute()) {
            $message = "Kupon '" . htmlspecialchars($code) . "' berhasil ditambahkan!";
            $message_type = 'success';
        } else {
            $message = "Gagal menambahkan kupon. Kode mungkin sudah ada.";
            $message_type = 'error';
        }
        $stmt->close();
    } else {
        $message = 'Kode kupon dan nilai poin tidak boleh kosong.';
        $message_type = 'error';
    }
}

// Ambil data semua kupon untuk ditampilkan
$coupons = $conn->query("SELECT code, value, is_used, created_at FROM coupons ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../style.css">
    <style>
        /* Style tambahan untuk dashboard admin */
        .admin-container { max-width: 800px; }
        .flex-container { display: flex; gap: 2em; }
        .flex-child { flex: 1; }
        @media (max-width: 768px) { .flex-container { flex-direction: column; } }
    </style>
</head>
<body>
    <div class="container admin-container">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h2>Admin Dashboard</h2>
            <a href="logout.php">Logout</a>
        </div>
        <p>Selamat datang, <?php echo htmlspecialchars($_SESSION['admin_username']); ?>!</p>
        
        <?php if($message): ?>
            <p class="message <?php echo $message_type; ?>"><?php echo $message; ?></p>
        <?php endif; ?>

        <div class="flex-container">
            <div class="flex-child">
                <h3>Tambah Kupon Baru</h3>
                <form action="index.php" method="post">
                    <div class="form-group">
                        <label for="code">Kode Kupon:</label>
                        <input type="text" name="code" id="code" required>
                    </div>
                    <div class="form-group">
                        <label for="value">Nilai Poin:</label>
                        <input type="number" name="value" id="value" min="1" required>
                    </div>
                    <button type="submit" name="add_coupon">Tambah Kupon</button>
                </form>
            </div>

            <div class="flex-child">
                <h3>Daftar Kupon</h3>
                <div style="max-height: 400px; overflow-y: auto;">
                    <table>
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Poin</th>
                                <th>Status</th>
                                <th>Aksi</th> </tr>
                        </thead>
                         <tbody>
                            <?php 
                            // Ambil data semua kupon untuk ditampilkan
                            $coupons = $conn->query("SELECT id, code, value, is_used FROM coupons ORDER BY created_at DESC");

                            if ($coupons->num_rows > 0):
                                while($row = $coupons->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['code']); ?></td>
                                    <td><?php echo $row['value']; ?></td>
                                    <td>
                                        <?php if ($row['is_used']): ?>
                                            <span style="color:red;">Terpakai</span>
                                        <?php else: ?>
                                            <span style="color:green;">Tersedia</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="edit_coupon.php?id=<?php echo $row['id']; ?>" style="text-decoration:none;">✏️ Edit</a>
                                        
                                        <?php if (!$row['is_used']): ?>
                                        |
                                        <a href="delete_coupon.php?id=<?php echo $row['id']; ?>" 
                                        style="color:red; text-decoration:none;"
                                        onclick="return confirm('Anda yakin ingin menghapus kupon ini? Aksi ini tidak bisa dibatalkan.');">🗑️ Hapus</a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr><td colspan="4" style="text-align:center;">Belum ada kupon.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>