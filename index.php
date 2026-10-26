
<?php
session_start();

if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit;
}

require_once "koneksi.php";

function e($value) {
    return htmlspecialchars(
        (string)($value ?? ""),
        ENT_QUOTES,
        "UTF-8"
    );
}

$kategori = $pdo->query(
    "SELECT id, nama_kategori
     FROM kategori
     ORDER BY nama_kategori"
)->fetchAll();

$barang = $pdo->query(
    "SELECT b.*, k.nama_kategori
     FROM barang b
     LEFT JOIN kategori k ON b.kategori_id = k.id
     ORDER BY b.id DESC"
)->fetchAll();

$totalJenis = count($barang);
$totalStok = 0;
$totalNilai = 0;

foreach ($barang as $b) {
    $totalStok += (int)$b["jumlah"];
    $totalNilai += (int)$b["jumlah"] * (float)$b["harga"];
}

$status = $_GET["status"] ?? "";

$pesan = [
    "berhasil" => "Barang berhasil ditambahkan.",
    "diupdate" => "Data barang berhasil diperbarui.",
    "dihapus" => "Barang berhasil dihapus."
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard SIM-Barang</title>
    <link rel="stylesheet" href="style.css">
    <script src="main.js" defer></script>
</head>
<body>

<header>
    <h1>SIM-Barang</h1>
    <p>Sistem Pengelolaan Inventaris Barang Jurusan</p>
    <p>
        Login sebagai:
        <strong><?= e($_SESSION["user"]) ?></strong>
        | <a href="logout.php">Logout</a>
    </p>
</header>

<main>
    <?php if (isset($pesan[$status])): ?>
        <p class="notice"><?= e($pesan[$status]) ?></p>
    <?php endif; ?>

    <section>
    <h2>Ringkasan Inventaris</h2>
    <div class="ringkasan">
        <div class="kartu">
            <span>Total jenis barang</span>
            <strong><?= $totalJenis ?></strong>
        </div>
        <div class="kartu">
            <span>Total seluruh stok</span>
            <strong><?= $totalStok ?></strong>
        </div>
        <div class="kartu">
            <span>Total nilai inventaris</span>
            <strong>Rp <?= number_format($totalNilai, 0, ",", ".") ?></strong>
        </div>
    </div>
    </section>

    <section>
        <h2>Tambah Barang</h2>

        <form id="formInputBarang" action="simpan.php" method="POST">
            <label for="kode">Kode Barang</label>
            <input
                type="text"
                id="kode"
                name="kode"
                placeholder="Contoh: BRG-004"
                pattern="BRG-[0-9]+"
                required
            >

            <label for="nama_barang">Nama Barang</label>
            <input
                type="text"
                id="nama_barang"
                name="nama_barang"
                required
            >

            <label for="kategori_id">Kategori</label>
            <select id="kategori_id" name="kategori_id" required>
                <option value="">-- Pilih Kategori --</option>
                <?php foreach ($kategori as $k): ?>
                    <option value="<?= (int)$k["id"] ?>">
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
                required
            >

            <label for="harga">Harga Satuan (Rp)</label>
            <input
                type="number"
                id="harga"
                name="harga"
                min="0"
                step="0.01"
                required
            >

            <label for="kondisi">Kondisi</label>
            <select id="kondisi" name="kondisi" required>
                <option value="">-- Pilih Kondisi --</option>
                <option value="Baik">Baik</option>
                <option value="Rusak Ringan">Rusak Ringan</option>
                <option value="Rusak Berat">Rusak Berat</option>
            </select>

            <button type="submit">Simpan Barang</button>
        </form>
    </section>

    <section>
        <h2>Daftar Barang</h2>

        <label for="cari-barang">Cari Barang</label>
        <input
            type="search"
            id="cari-barang"
            placeholder="Cari kode atau nama barang..."
        >

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>Jumlah</th>
                        <th>Harga Satuan</th>
                        <th>Total Nilai</th>
                        <th>Kondisi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody id="isi-tabel-barang">
                    <?php if (count($barang) === 0): ?>
                        <tr>
                            <td colspan="8">Belum ada data barang.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($barang as $b): ?>
                            <tr>
                                <td><?= e($b["kode"]) ?></td>
                                <td><?= e($b["nama_barang"]) ?></td>
                                <td>
                                    <?= e(
                                        $b["nama_kategori"]
                                        ?? "Tidak berkategori"
                                    ) ?>
                                </td>
                                <td><?= (int)$b["jumlah"] ?></td>
                                <td>
                                    Rp <?= number_format(
                                        (float)$b["harga"],
                                        0, ",", "."
                                    ) ?>
                                </td>
                                <td>
                                    Rp <?= number_format(
                                        (int)$b["jumlah"] * (float)$b["harga"],
                                        0, ",", "."
                                    ) ?>
                                </td>
                                <td><?= e($b["kondisi"]) ?></td>
                                <td class="action-cell">
                                    <a
                                        class="btn-edit"
                                        href="edit.php?id=<?= (int)$b["id"] ?>"
                                    >Edit</a>

                                    <form
                                        class="delete-form"
                                        action="hapus.php"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus barang ini?');"
                                    >
                                        <input
                                            type="hidden"
                                            name="id"
                                            value="<?= (int)$b["id"] ?>"
                                        >

                                        <button
                                            class="btn-delete"
                                            type="submit"
                                        >Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>
</main>

</body>
</html>
