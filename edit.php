
<?php
session_start();

if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit;
}

require_once "koneksi.php";

function e($value) {
    return htmlspecialchars((string)($value ?? ""), ENT_QUOTES, "UTF-8");
}

$id = filter_var($_GET["id"] ?? null, FILTER_VALIDATE_INT);

if ($id === false || $id === null || $id < 1) {
    exit("ID barang tidak valid.");
}

$stmt = $pdo->prepare("SELECT * FROM barang WHERE id = ?");
$stmt->execute([$id]);
$barang = $stmt->fetch();

if (!$barang) {
    exit("Barang tidak ditemukan.");
}

$kategori = $pdo->query(
    "SELECT id, nama_kategori FROM kategori ORDER BY nama_kategori"
)->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Barang - SIM-Barang</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <h1>Edit Barang</h1>
    <a href="index.php">Kembali ke Dashboard</a>
</header>

<main>
    <section>
        <form action="update.php" method="POST">
            <input type="hidden" name="id" value="<?= (int)$barang["id"] ?>">

            <label for="kode">Kode Barang</label>
            <input
                type="text"
                id="kode"
                name="kode"
                value="<?= e($barang["kode"]) ?>"
                pattern="BRG-[0-9]+"
                required
            >

            <label for="nama_barang">Nama Barang</label>
            <input
                type="text"
                id="nama_barang"
                name="nama_barang"
                value="<?= e($barang["nama_barang"]) ?>"
                required
            >

            <label for="kategori_id">Kategori</label>
            <select id="kategori_id" name="kategori_id" required>
                <?php foreach ($kategori as $k): ?>
                    <option
                        value="<?= (int)$k["id"] ?>"
                        <?= (int)$barang["kategori_id"] === (int)$k["id"] ? "selected" : "" ?>
                    >
                        <?= e($k["nama_kategori"]) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="jumlah">Jumlah</label>
            <input
                type="number"
                id="jumlah"
                name="jumlah"
                min="1"
                value="<?= (int)$barang["jumlah"] ?>"
                required
            >

            <label for="harga">Harga Satuan (Rp)</label>
            <input
                type="number"
                id="harga"
                name="harga"
                min="0"
                step="0.01"
                value="<?= e($barang["harga"]) ?>"
                required
            >

            <label for="kondisi">Kondisi</label>
            <select id="kondisi" name="kondisi" required>
                <?php foreach (["Baik", "Rusak Ringan", "Rusak Berat"] as $opsi): ?>
                    <option
                        value="<?= e($opsi) ?>"
                        <?= $barang["kondisi"] === $opsi ? "selected" : "" ?>
                    >
                        <?= e($opsi) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <button type="submit">Simpan Perubahan</button>
        </form>
    </section>
</main>

</body>
</html>
