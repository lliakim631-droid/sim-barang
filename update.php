
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
$kode = strtoupper(trim($_POST["kode"] ?? ""));
$nama = trim($_POST["nama_barang"] ?? "");
$kategoriId = filter_var(
    $_POST["kategori_id"] ?? null,
    FILTER_VALIDATE_INT
);
$jumlahRaw = $_POST["jumlah"] ?? "";
$hargaRaw = $_POST["harga"] ?? "";
$kondisi = $_POST["kondisi"] ?? "";

if (
    $id === false || $id === null || $id < 1 ||
    !preg_match('/^BRG-[0-9]+$/', $kode) ||
    $nama === "" ||
    $kategoriId === false || $kategoriId === null || $kategoriId < 1 ||
    filter_var($jumlahRaw, FILTER_VALIDATE_INT) === false ||
    (int)$jumlahRaw < 1 ||
    !is_numeric($hargaRaw) ||
    !is_finite((float)$hargaRaw) ||
    (float)$hargaRaw < 0 ||
    !in_array(
        $kondisi,
        ["Baik", "Rusak Ringan", "Rusak Berat"],
        true
    )
) {
    exit("Data tidak valid. Periksa kembali formulir.");
}

try {
    $cek = $pdo->prepare(
        "SELECT COUNT(*) FROM kategori WHERE id = ?"
    );
    $cek->execute([$kategoriId]);

    if ((int)$cek->fetchColumn() === 0) {
        exit("Kategori tidak ditemukan.");
    }

    $stmt = $pdo->prepare(
        "UPDATE barang
         SET kode = ?,
             nama_barang = ?,
             kategori_id = ?,
             jumlah = ?,
             harga = ?,
             kondisi = ?
         WHERE id = ?"
    );

    $stmt->execute([
        $kode,
        $nama,
        $kategoriId,
        (int)$jumlahRaw,
        (float)$hargaRaw,
        $kondisi,
        $id
    ]);

    header("Location: index.php?status=diupdate");
    exit;

} catch (PDOException $e) {
    error_log($e->getMessage());

    if ($e->getCode() === "23000") {
        exit("Kode barang sudah digunakan atau kategori tidak valid.");
    }

    exit("Perubahan data gagal disimpan.");
}
?>
