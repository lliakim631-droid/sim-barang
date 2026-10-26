# SIM-Barang

**Sistem Pengelolaan Inventaris Barang Jurusan**

Aplikasi web sederhana untuk mencatat, mengelola, dan memantau barang (aset) jurusan. Dibuat sebagai tugas praktikum mata kuliah **Praktikum Pemrograman Web**, Program Studi D3 Manajemen Informatika, Politeknik Negeri Sriwijaya.

Pengembangan dilakukan bertahap dari Pertemuan 1 sampai 7: penyiapan lingkungan kerja, antarmuka HTML/CSS, validasi JavaScript, hingga pemrosesan backend PHP dan basis data MySQL.

## Fitur

- Login dan logout dengan session PHP
- Dashboard ringkasan: total jenis barang, total stok, dan total nilai inventaris
- Tambah, ubah, dan hapus data barang (CRUD)
- Pengelompokan barang berdasarkan kategori
- Pencarian barang secara langsung (kode atau nama) dengan JavaScript
- Validasi data di sisi klien (JavaScript) dan sisi server (PHP)
- Keamanan dasar: PDO prepared statement, `htmlspecialchars` untuk mencegah XSS, dan `session_regenerate_id` saat login

## Teknologi

| Bagian   | Teknologi                     |
|----------|-------------------------------|
| Frontend | HTML, CSS, JavaScript         |
| Backend  | PHP 8+ (PDO)                  |
| Database | MySQL / MariaDB               |
| Server   | Laragon (Apache + MySQL)      |

## Struktur Berkas

```
sim-barang/
├── index.php      # Dashboard: ringkasan, form tambah, daftar barang
├── login.php      # Halaman login
├── logout.php     # Menghapus session lalu kembali ke login
├── edit.php       # Form ubah data barang
├── simpan.php     # Proses tambah barang (INSERT)
├── update.php     # Proses ubah barang (UPDATE)
├── hapus.php      # Proses hapus barang (DELETE)
├── barang.php     # Class Barang (OOP): hitungTotal() dan getInfoBarang()
├── koneksi.php    # Koneksi database dengan PDO
├── main.js        # Pencarian tabel dan validasi form
└── style.css      # Tampilan aplikasi
```

## Cara Menjalankan

1. Pasang **Laragon**, lalu klik **Start All** untuk menjalankan Apache dan MySQL.
2. Salin folder proyek ke `C:\laragon\www\sim-barang`.
3. Buka database lewat **HeidiSQL** (klik tombol **Database** di Laragon), lalu jalankan SQL pada bagian **Struktur Database** di bawah. Bisa juga memakai phpMyAdmin bila sudah dipasang.
4. Sesuaikan `koneksi.php` bila perlu (default Laragon: host `localhost`, user `root`, password kosong, database `sim_barang_db`).
5. Buka `http://localhost/sim-barang/login.php` di browser. Jika fitur *Auto Virtual Hosts* Laragon aktif, bisa juga lewat `http://sim-barang.test/login.php`.

## Struktur Database

```sql
CREATE DATABASE IF NOT EXISTS sim_barang_db CHARACTER SET utf8mb4;
USE sim_barang_db;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE kategori (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_kategori VARCHAR(100) NOT NULL
);

CREATE TABLE barang (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kode VARCHAR(20) NOT NULL UNIQUE,
    nama_barang VARCHAR(150) NOT NULL,
    kategori_id INT NOT NULL,
    jumlah INT NOT NULL,
    harga DECIMAL(15,2) NOT NULL,
    kondisi ENUM('Baik','Rusak Ringan','Rusak Berat') NOT NULL,
    FOREIGN KEY (kategori_id) REFERENCES kategori(id)
);

-- Data contoh
INSERT INTO users (username, password) VALUES ('admin', 'admin123');
INSERT INTO kategori (nama_kategori) VALUES ('Elektronik'), ('Furnitur'), ('Alat Tulis');
```

> Catatan: pada versi tugas ini password disimpan dan dibandingkan sebagai teks biasa. Untuk penggunaan nyata, gunakan `password_hash()` dan `password_verify()`.

## Konsep HTTP Request & Response

- **HTTP Request**: pesan yang dikirim klien (misalnya browser) ke server untuk meminta halaman atau sumber daya. Metode yang dipakai pada proyek ini:
  - `GET` untuk mengambil data (membuka dashboard, membuka form edit)
  - `POST` untuk mengirim data (login, simpan, update, hapus)
- **HTTP Response**: pesan balasan dari server berisi kode status (misalnya `200 OK`, `302 Found` untuk redirect, `404 Not Found`) beserta isi halaman HTML yang ditampilkan di browser.

Alur contoh saat menambah barang: browser mengirim `POST` ke `simpan.php`, server memvalidasi dan menyimpan data, lalu membalas dengan redirect (`302`) ke `index.php?status=berhasil`.

## Identitas

Tugas praktikum Praktikum Pemrograman Web, D3 Manajemen Informatika, Politeknik Negeri Sriwijaya.