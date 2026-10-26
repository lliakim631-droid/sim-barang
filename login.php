
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
<body style="display:flex;justify-content:center;align-items:center;min-height:100vh;background-color:#f4f7f6;padding:20px;box-sizing:border-box;">

    <div style="background:white;padding:30px;border-radius:8px;box-shadow:0 4px 10px rgba(0,0,0,0.1);width:350px;max-width:100%;box-sizing:border-box;">
        <h2 style="text-align:center;margin-bottom:20px;">
            Login SIM-Barang
        </h2>

        <?php if ($error !== ""): ?>
            <div style="background:#ffdddd;color:#d8000c;padding:10px;border-radius:4px;margin-bottom:15px;font-size:14px;">
                <?= htmlspecialchars($error, ENT_QUOTES, "UTF-8") ?>
            </div>
        <?php endif; ?>

        <form action="login.php" method="POST">
            <div style="margin-bottom:15px;">
                <label for="username">Username:</label><br>
                <input
                    type="text"
                    id="username"
                    name="username"
                    required
                    autocomplete="username"
                    style="width:100%;padding:8px;margin-top:5px;box-sizing:border-box;"
                >
            </div>

            <div style="margin-bottom:20px;">
                <label for="password">Password:</label><br>
                <input
                    type="password"
                    id="password"
                    name="password"
                    required
                    autocomplete="current-password"
                    style="width:100%;padding:8px;margin-top:5px;box-sizing:border-box;"
                >
            </div>

            <button
                type="submit"
                style="width:100%;background:#007bff;color:white;padding:10px;border:none;border-radius:4px;font-weight:bold;cursor:pointer;"
            >
                Masuk
            </button>
        </form>
    </div>

</body>
</html>
