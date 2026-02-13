<?php
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $coupon_code = trim($_POST['coupon_code']);

    if (empty($coupon_code)) {
        $_SESSION['message'] = 'Kode kupon tidak boleh kosong.';
        $_SESSION['message_type'] = 'error';
        header("Location: index.php");
        exit();
    }

    // Cari kupon di database
    $stmt = $conn->prepare("SELECT id, value, is_used FROM coupons WHERE code = ?");
    $stmt->bind_param("s", $coupon_code);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $coupon = $result->fetch_assoc();
        if ($coupon['is_used'] == 1) {
            $_SESSION['message'] = 'Kupon ' . htmlspecialchars($coupon_code) . ' sudah pernah digunakan.';
            $_SESSION['message_type'] = 'error';
        } else {
            // Kupon valid dan belum dipakai, proses penambahan poin
            $coupon_id = $coupon['id'];
            $points_to_add = $coupon['value'];
            
            // Gunakan transaksi untuk memastikan semua query berhasil
            mysqli_begin_transaction($conn);

            try {
                // 1. Update poin user
                $conn->query("UPDATE users SET points = points + $points_to_add WHERE id = $user_id");

                // 2. Tandai kupon sudah dipakai
                $conn->query("UPDATE coupons SET is_used = 1 WHERE id = $coupon_id");

                // 3. Catat transaksi
                $description = "Menukar kupon: " . htmlspecialchars($coupon_code);
                $stmt_trans = $conn->prepare("INSERT INTO transactions (user_id, description, points_change) VALUES (?, ?, ?)");
                $stmt_trans->bind_param("isi", $user_id, $description, $points_to_add);
                $stmt_trans->execute();
                
                // Jika semua berhasil
                mysqli_commit($conn);
                $_SESSION['message'] = 'Selamat! Anda berhasil mendapatkan ' . $points_to_add . ' poin.';
                $_SESSION['message_type'] = 'success';

            } catch (mysqli_sql_exception $exception) {
                mysqli_rollback($conn);
                $_SESSION['message'] = 'Terjadi kesalahan pada server. Silakan coba lagi.';
                $_SESSION['message_type'] = 'error';
            }
        }
    } else {
        $_SESSION['message'] = 'Kode kupon tidak valid.';
        $_SESSION['message_type'] = 'error';
    }
    $stmt->close();
    header("Location: index.php");
    exit();
}
?>