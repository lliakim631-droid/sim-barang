<?php
session_start();

// Proteksi Halaman: Jika belum login, alihkan kembali ke login.php
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

// Memanggil class Barang (Penerapan OOP Dasar)
require_once 'Barang.php';

// Contoh instansiasi objek dari class Barang
$produk1 = new Barang("BRG-001", "Laptop Asus", 10, 7500000);
$produk2 = new Barang("BRG-002", "Proyektor Epson", 3, 5000000);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIM-Barang - Sistem Pengelolaan Inventaris</title>
</head>
<body>

    <header>
        <h1>SIM-Barang</h1>
        <p>Sistem Pengelolaan Inventaris Barang Jurusan (Halo, <strong><?php echo $_SESSION['user']; ?></strong>)</p>
    </header>

    <nav style="display: flex; justify-content: space-between; align-items: center; padding: 0 20px;">
        <ul style="list-style: none; display: flex; gap: 20px; padding: 0;">
            <li><a href="index.php" style="color: white; text-decoration: none;">Beranda</a></li>
            <li><a href="#tabel-barang" style="color: white; text-decoration: none;">Daftar Barang</a></li>
            <li><a href="#form-barang" style="color: white; text-decoration: none;">Input Barang</a></li>
        </ul>
        <!-- Tombol Keluar / Logout -->
        <div>
            <a href="logout.php" style="background: #dc3545; color: white; padding: 6px 12px; border-radius: 4px; text-decoration: none; font-size: 14px;">Keluar (Logout)</a>
        </div>
    </nav>

    <main>
        
        <!-- Bagian 1: Tabel Inventaris Barang -->
        <section id="tabel-barang">
            <h2>Daftar Inventaris Barang</h2>
            
            <!-- Contoh Tampilan Informasi menggunakan OOP -->
            <div style="background: #e9ecef; padding: 10px; margin-bottom: 15px; border-radius: 4px; font-size: 14px;">
                <strong>Info Objek (OOP):</strong><br>
                - <?php echo $produk1->getInfoBarang(); ?><br>
                - <?php echo $produk2->getInfoBarang(); ?>
            </div>

            <div style="margin-bottom: 15px;">
                <label for="cari-barang">Cari Barang:</label>
                <input type="text" id="cari-barang" placeholder="Ketik kode atau nama barang...">
            </div>

            <table style="border-collapse: collapse; width: 100%;">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>Jumlah</th>
                        <th>Harga Satuan</th>
                        <th>Total Nilai</th>
                        <th>Kondisi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo $produk1->kode; ?></td>
                        <td><?php echo $produk1->nama; ?></td>
                        <td>Elektronik</td>
                        <td><?php echo $produk1->jumlah; ?></td>
                        <td>Rp <?php echo number_format($produk1->harga, 0, ',', '.'); ?></td>
                        <td>Rp <?php echo number_format($produk1->hitungTotal(), 0, ',', '.'); ?></td>
                        <td>Baik</td>
                    </tr>
                    <tr>
                        <td><?php echo $produk2->kode; ?></td>
                        <td><?php echo $produk2->nama; ?></td>
                        <td>Peralatan Kelas</td>
                        <td><?php echo $produk2->jumlah; ?></td>
                        <td>Rp <?php echo number_format($produk2->harga, 0, ',', '.'); ?></td>
                        <td>Rp <?php echo number_format($produk2->hitungTotal(), 0, ',', '.'); ?></td>
                        <td>Baik</td>
                    </tr>
                </tbody>
            </table>
        </section>

        <hr style="margin: 40px 0;">

        <!-- Bagian 2: Formulir Input Barang -->
        <section id="form-barang">
            <h2>Formulir Tambah Barang</h2>
            <form action="" method="POST">
                <div style="margin-bottom: 15px;">
                    <label for="kode">Kode Barang:</label><br>
                    <input type="text" id="kode" name="kode" placeholder="Contoh: BRG-004" required>
                </div>
                <div style="margin-bottom: 15px;">
                    <label for="nama">Nama Barang:</label><br>
                    <input type="text" id="nama" name="nama" placeholder="Masukkan nama barang" required>
                </div>
                <div style="margin-bottom: 15px;">
                    <label for="kategori">Kategori:</label><br>
                    <select id="kategori" name="kategori" required>
                        <option value="">-- Pilih Kategori --</option>
                        <option value="Elektronik">Elektronik</option>
                        <option value="Peralatan Kelas">Peralatan Kelas</option>
                        <option value="Mebel">Mebel</option>
                    </select>
                </div>
                <div style="margin-bottom: 15px;">
                    <label for="jumlah">Jumlah Barang:</label><br>
                    <input type="number" id="jumlah" name="jumlah" min="1" placeholder="Masukkan jumlah" required>
                </div>
                <div style="margin-bottom: 15px;">
                    <label for="harga">Harga Satuan (Rp):</label><br>
                    <input type="number" id="harga" name="harga" min="0" placeholder="Masukkan harga satuan" required>
                </div>
                <div style="margin-bottom: 15px;">
                    <label for="kondisi">Kondisi:</label><br>
                    <select id="kondisi" name="kondisi" required>
                        <option value="">-- Pilih Kondisi --</option>
                        <option value="Baik">Baik</option>
                        <option value="Rusak Ringan">Rusak Ringan</option>
                        <option value="Rusak Berat">Rusak Berat</option>
                    </select>
                </div>
                <button type="submit">Simpan Data Barang</button>
            </form>
        </section>

    </main>

    <div id="toast" class="toast"></div>

    <footer>
        <p>&copy; 2026 SIM-Barang - D3 Manajemen Informatika Politeknik Negeri Sriwijaya</p>
    </footer>

    <script src="main.js"></script>
</body>
</html>