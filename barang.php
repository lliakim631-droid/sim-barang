<?php
class Barang {
    // Property
    public $kode;
    public $nama;
    public $jumlah;
    public $harga;

    // Constructor untuk inisialisasi data
    public function __construct($kode, $nama, $jumlah, $harga) {
        $this->kode = $kode;
        $this->nama = $nama;
        $this->jumlah = $jumlah;
        $this->harga = $harga;
    }

    // Method untuk menghitung total nilai aset
    public function hitungTotal() {
        return $this->jumlah * $this->harga;
    }

    // Method untuk menampilkan format informasi barang
    public function getInfoBarang() {
        $total = $this->hitungTotal();
        return "[$this->kode] $this->nama - Jumlah: $this->jumlah - Total: Rp " . number_format($total, 0, ',', '.');
    }
}
?>