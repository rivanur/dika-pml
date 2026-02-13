<?php
require 'db.php';
$error = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        $error = 'Username dan password tidak boleh kosong!';
    } else {
        $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                // Password cocok, simpan data user ke session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $username;
                header("Location: index.php");
                exit();
            } else {
                $error = 'Password salah.';
            }
        } else {
            $error = 'Username tidak ditemukan.';
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
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <form action="login.php" method="post">
            <h2>Login</h2>
            <?php if($error): ?>
                <p class="message error"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required>
            </div>
            <button type="submit">Login</button>
            <p style="text-align: center; margin-top: 1em;">
                Belum punya akun? <a href="register.php">Daftar di sini</a>
            </p>
        </form>
    </div>
</body>
</html>