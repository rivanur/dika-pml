<?php
// FILE: proyek-kupon/admin/edit_coupon.php

require 'auth_check.php';

$id = 0;
$code = '';
$value = '';
$error = '';
$coupon_is_used = false;

// Bagian untuk memproses form yang di-submit (UPDATE)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = intval($_POST['id']);
    $code = trim($_POST['code']);
    $value = intval($_POST['value']);
    
    if (empty($code) || $value <= 0) {
        $error = "Kode kupon dan nilai poin tidak boleh kosong.";
    } else {
        $stmt = $conn->prepare("UPDATE coupons SET code = ?, value = ? WHERE id = ?");
        $stmt->bind_param("sii", $code, $value, $id);
        
        if ($stmt->execute()) {
            $_SESSION['message'] = "Kupon berhasil diperbarui.";
            $_SESSION['message_type'] = "success";
            header("Location: index.php");
            exit();
        } else {
            $error = "Gagal memperbarui kupon. Kode mungkin sudah ada yang pakai.";
        }
        $stmt->close();
    }
} 
// Bagian untuk menampilkan data awal ke form (SELECT)
elseif (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $conn->prepare("SELECT code, value, is_used FROM coupons WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $coupon = $result->fetch_assoc();
        $code = $coupon['code'];
        $value = $coupon['value'];
        $coupon_is_used = $coupon['is_used'];
    } else {
        $_SESSION['message'] = "Kupon tidak ditemukan.";
        $_SESSION['message_type'] = "error";
        header("Location: index.php");
        exit();
    }
    $stmt->close();
} 
// Jika tidak ada ID di GET atau POST
else {
    header("Location: index.php");
    exit();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Kupon</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="container">
        <h2>Edit Kupon</h2>
        <form action="edit_coupon.php" method="post">
            <input type="hidden" name="id" value="<?php echo $id; ?>">

            <?php if($error): ?>
                <p class="message error"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>
            
            <?php if($coupon_is_used): ?>
                <p class="message error">Kupon ini sudah pernah dipakai dan tidak bisa diedit lagi.</p>
            <?php endif; ?>

            <div class="form-group">
                <label for="code">Kode Kupon:</label>
                <input type="text" name="code" id="code" value="<?php echo htmlspecialchars($code); ?>" <?php if($coupon_is_used) echo 'disabled'; ?> required>
            </div>
            <div class="form-group">
                <label for="value">Nilai Poin:</label>
                <input type="number" name="value" id="value" value="<?php echo $value; ?>" <?php if($coupon_is_used) echo 'disabled'; ?> required>
            </div>
            
            <button type="submit" <?php if($coupon_is_used) echo 'disabled'; ?>>Update Kupon</button>
            <a href="index.php" style="display:block; text-align:center; margin-top:1em;">Batal</a>
        </form>
    </div>
</body>
</html>