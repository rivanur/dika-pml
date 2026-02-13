<?php
// FILE: proyek-kupon/admin/register.php

// Path ke db.php harus mundur satu direktori
require '../db.php'; 

$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $admin_key = $_POST['admin_key'];

    // 1. Validasi input
    if (empty($username) || empty($password) || empty($admin_key)) {
        $error = 'Semua field wajib diisi!';
    } 
    // 2. Validasi Kunci Registrasi Admin
    elseif ($admin_key !== ADMIN_REGISTRATION_KEY) {
        $error = 'Kunci Registrasi Admin salah!';
    } 
    // 3. Jika semua valid, proses data
    else {
        // Hash password untuk keamanan
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Siapkan query untuk memasukkan user baru sebagai admin (is_admin = 1)
        $stmt = $conn->prepare("INSERT INTO users (username, password, is_admin) VALUES (?, ?, 1)");
        $stmt->bind_param("ss", $username, $hashed_password);

        if ($stmt->execute()) {
            $success = "Akun admin berhasil dibuat! Silakan login.";
            // Alihkan ke halaman login setelah beberapa detik atau tampilkan pesan
            header("refresh:3;url=login.php");
        } else {
            $error = "Gagal mendaftar. Username mungkin sudah digunakan.";
        }
        $stmt->close();
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin Registration</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="container">
        <form action="register.php" method="post">
            <h2>Registrasi Akun Admin</h2>
            <?php if($error): ?>
                <p class="message error"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>
            <?php if($success): ?>
                <p class="message success"><?php echo htmlspecialchars($success); ?></p>
            <?php endif; ?>

            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required>
            </div>
            <div class="form-group">
                <label for="admin_key">Kunci Registrasi Admin:</label>
                <input type="password" name="admin_key" id="admin_key" required>
                <small>Masukkan kode rahasia untuk mendaftar sebagai admin.</small>
            </div>
            <button type="submit">Buat Akun Admin</button>
            <p style="text-align: center; margin-top: 1em;">
                Sudah punya akun? <a href="login.php">Login di sini</a>
            </p>
        </form>
    </div>
</body>
</html>