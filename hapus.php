
<?php
session_start();

if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit;
}

require_once "koneksi.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.php");
    exit;
}

$id = filter_var($_POST["id"] ?? null, FILTER_VALIDATE_INT);

if ($id === false || $id === null || $id < 1) {
    exit("ID barang tidak valid.");
}

$stmt = $pdo->prepare("DELETE FROM barang WHERE id = ?");
$stmt->execute([$id]);

if ($stmt->rowCount() > 0) {
    header("Location: index.php?status=dihapus");
    exit;
}

exit("Barang tidak ditemukan atau sudah dihapus.");
?>
