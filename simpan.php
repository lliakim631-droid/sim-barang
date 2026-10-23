<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Pemrosesan - SIM-Barang</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <header>
        <h1>SIM-Barang</h1>
        <p>Hasil Pemrosesan Data di Sisi Server (PHP)</p>
    </header>

    <main style="grid-template-columns: 1fr;">
        <section>
            <h2>Ringkasan Data Barang Masuk</h2>

            <?php
            // Menangkap data yang dikirimkan melalui metode POST
            $kode = isset($_POST['kode']) ? htmlspecialchars($_POST['kode']) : '-';
            $nama = isset($_POST['nama']) ? htmlspecialchars($_POST['nama']) : '-';
            $kategori = isset($_POST['kategori']) ? htmlspecialchars($_POST['kategori']) : '-';
            $jumlah = isset($_POST['jumlah']) ? (int)$_POST['jumlah'] : 0;
            $harga = isset($_POST['harga']) ? (int)$_POST['harga'] : 0;
            $kondisi = isset($_POST['kondisi']) ? htmlspecialchars($_POST['kondisi']) : '-';

            // Logika Perhitungan Aset: Jumlah Barang * Harga Satuan (Diperbaiki dengan operator *)
            $total_nilai = $jumlah * $harga;
            ?>

            <!-- Tabel Ringkasan Pemrosesan -->
            <table>
                <tr>
                    <th>Informasi Atribut</th>
                    <th>Nilai Data</th>
                </tr>
                <tr>
                    <td><strong>Kode Barang</strong></td>
                    <td><?php echo $kode; ?></td>
                </tr>
                <tr>
                    <td><strong>Nama Barang</strong></td>
                    <td><?php echo $nama; ?></td>
                </tr>
                <tr>
                    <td><strong>Kategori</strong></td>
                    <td><?php echo $kategori; ?></td>
                </tr>
                <tr>
                    <td><strong>Jumlah Barang</strong></td>
                    <td><?php echo $jumlah; ?> Unit</td>
                </tr>
                <tr>
                    <td><strong>Harga Satuan</strong></td>
                    <td>Rp <?php echo number_format($harga, 0, ',', '.'); ?></td>
                </tr>
                <tr>
                    <td><strong>Total Estimasi Nilai Aset</strong></td>
                    <td><strong style="color: #28a745;">Rp <?php echo number_format($total_nilai, 0, ',', '.'); ?></strong></td>
                </tr>
                <tr>
                    <td><strong>Kondisi Barang</strong></td>
                    <td><?php echo $kondisi; ?></td>
                </tr>
            </table>

            <div style="margin-top: 20px; text-align: center;">
                <a href="index.html" style="background-color: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 4px; font-weight: bold;">&larr; Kembali ke Formulir Utama</a>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2026 SIM-Barang - D3 Manajemen Informatika Politeknik Negeri Sriwijaya</p>
    </footer>

</body>
</html>