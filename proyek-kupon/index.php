<?php
require 'db.php';

// Cek apakah user sudah login atau belum
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Ambil data poin pengguna
$stmt = $conn->prepare("SELECT points FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$current_points = $user['points'];
$stmt->close();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container dashboard">
        <h2>Selamat Datang, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
        
        <div class="points-display">
            Poin Anda Saat Ini:<br>
            <span><?php echo $current_points; ?></span>
        </div>

        <?php if(isset($_SESSION['message'])): ?>
            <p class="message <?php echo $_SESSION['message_type']; ?>"><?php echo $_SESSION['message']; ?></p>
            <?php 
                // Hapus pesan setelah ditampilkan
                unset($_SESSION['message']);
                unset($_SESSION['message_type']);
            ?>
        <?php endif; ?>

        <h3>Tukarkan Kupon Anda</h3>
        <form action="redeem.php" method="post">
            <div class="form-group">
                <label for="coupon_code">Masukkan Kode Kupon:</label>
                <input type="text" name="coupon_code" id="coupon_code" required>
            </div>
            <button type="submit">Tukar Kupon</button>
        </form>

        <h3>Riwayat Transaksi</h3>
        <table>
            <thead>
                <tr>
                    <th>Deskripsi</th>
                    <th>Perubahan Poin</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $stmt_trans = $conn->prepare("SELECT description, points_change, created_at FROM transactions WHERE user_id = ? ORDER BY created_at DESC");
                $stmt_trans->bind_param("i", $user_id);
                $stmt_trans->execute();
                $transactions = $stmt_trans->get_result();

                if ($transactions->num_rows > 0) {
                    while($row = $transactions->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['description']) . "</td>";
                        echo "<td>" . ($row['points_change'] > 0 ? '+' : '') . $row['points_change'] . "</td>";
                        echo "<td>" . date('d M Y, H:i', strtotime($row['created_at'])) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3' style='text-align:center;'>Belum ada transaksi.</td></tr>";
                }
                $stmt_trans->close();
                ?>
            </tbody>
        </table>

        <a href="logout.php" class="logout-link">Logout</a>
    </div>
</body>
</html>