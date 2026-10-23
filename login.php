<?php
session_start();

// Jika pengguna sudah login, langsung alihkan ke halaman utama
if (isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}

$error = "";

// Pengecekan saat form dikirim (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Enkapsulasi data kredensial dalam array asosiatif
    $kredensial = [
        'username' => 'admin',
        'password' => 'password123'
    ];

    // Validasi login sederhana
    if ($username === $kredensial['username'] && $password === $kredensial['password']) {
        $_SESSION['user'] = $username;
        header("Location: index.php");
        exit;
    } else {
        $error = "Username atau password salah!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIM-Barang</title>
    <link rel="stylesheet" href="style.css">
</head>
<body style="display: flex; justify-content: center; align-items: center; height: 100vh; background-color: #f4f7f6;">

    <div style="background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); width: 350px;">
        <h2 style="text-align: center; margin-bottom: 20px;">Login SIM-Barang</h2>
        
        <?php if (!empty($error)): ?>
            <div style="background: #ffdddd; color: #d8000c; padding: 10px; border-radius: 4px; margin-bottom: 15px; font-size: 14px;">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form action="login.php" method="POST">
            <div style="margin-bottom: 15px;">
                <label for="username">Username:</label><br>
                <input type="text" id="username" name="username" required style="width: 100%; padding: 8px; margin-top: 5px;">
            </div>
            <div style="margin-bottom: 20px;">
                <label for="password">Password:</label><br>
                <input type="password" id="password" name="password" required style="width: 100%; padding: 8px; margin-top: 5px;">
            </div>
            <button type="submit" style="width: 100%; background: #007bff; color: white; padding: 10px; border: none; border-radius: 4px; font-weight: bold; cursor: pointer;">Masuk</button>
        </form>
    </div>

</body>
</html>