<?php
require 'db.php';
$error = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        $error = 'Username dan password tidak boleh kosong!';
    } else {
        // Hash password sebelum disimpan
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Gunakan prepared statement untuk keamanan
        $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $hashed_password);

        if ($stmt->execute()) {
            header("Location: login.php");
            exit();
        } else {
            $error = "Gagal mendaftar. Username mungkin sudah ada.";
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
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <form action="register.php" method="post">
            <h2>Buat Akun Baru</h2>
            <?php if($error): ?>
                <p class="message error"><?php echo $error; ?></p>
            <?php endif; ?>
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required>
            </div>
            <button type="submit">Register</button>
            <p style="text-align: center; margin-top: 1em;">
                Sudah punya akun? <a href="login.php">Login di sini</a>
            </p>
        </form>
    </div>
</body>
</html>