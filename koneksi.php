<?php
$host = 'localhost';
$dbname = 'sim_barang_db';
$username = 'root';
$password = '';

try {
    // Membuat koneksi PDO ke database MySQL
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    
    // Mengatur mode error PDO menjadi Exception agar mudah mendeteksi kendala
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch (PDOException $e) {
    // Menampilkan pesan jika koneksi gagal
    die("Koneksi database gagal: " . $e->getMessage());
}
?>