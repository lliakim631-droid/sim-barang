<?php
session_start();
// Menghapus semua variabel sesi
$_SESSION = array();
// Menghancurkan sesi
session_destroy();
// Arahkan kembali ke halaman login
header("Location: login.php");
exit;
?>