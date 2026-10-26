<?php
session_start();
require_once "koneksi.php";

if (isset($_SESSION["user"])) {
    header("Location: index.php");
    exit;
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usernameInput = trim($_POST["username"] ?? "");
    $passwordInput = $_POST["password"] ?? "";

    if ($usernameInput === "" || $passwordInput === "") {
        $error = "Username dan password wajib diisi.";
    } else {
        $stmt = $pdo->prepare(
            "SELECT id, username, password
             FROM users
             WHERE username = ?
             LIMIT 1"
        );

        $stmt->execute([$usernameInput]);
        $user = $stmt->fetch();

        if ($user && $passwordInput === $user["password"]) {
            session_regenerate_id(true);

            $_SESSION["user"] = $user["username"];
            $_SESSION["user_id"] = $user["id"];

            header("Location: index.php");
            exit;
        } else {
            $error = "Username atau password salah!";
        }
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
<body class="login-page">

    <div class="login-card">
        <h2>SIM-Barang</h2>
        <p class="sub">Silakan login untuk melanjutkan</p>

        <?php if ($error !== ""): ?>
            <div class="error">
                <?= htmlspecialchars($error, ENT_QUOTES, "UTF-8") ?>
            </div>
        <?php endif; ?>

        <form action="login.php" method="POST">
            <label for="username">Username</label>
            <input
                type="text"
                id="username"
                name="username"
                required
                autocomplete="username"
            >

            <label for="password">Password</label>
            <input
                type="password"
                id="password"
                name="password"
                required
                autocomplete="current-password"
            >

            <button type="submit">Masuk</button>
        </form>
    </div>

</body>
</html>