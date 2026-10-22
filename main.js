// Menunggu seluruh dokumen HTML selesai dimuat
document.addEventListener('DOMContentLoaded', function () {

    // --- 1. ELEMEN SELEKTOR ---
    const formBarang = document.querySelector('#form-barang form');
    const inputKode = document.getElementById('kode');
    const inputNama = document.getElementById('nama');
    const selectKategori = document.getElementById('kategori');
    const inputJumlah = document.getElementById('jumlah');
    const selectKondisi = document.getElementById('kondisi');
    const inputCari = document.getElementById('cari-barang');
    const tabelBarang = document.querySelector('#tabel-barang tbody');
    const toast = document.getElementById('toast');

    // --- 2. FUNGSI MENAMPILKAN NOTIFIKASI TOAST ---
    function showToast(message, type = 'success') {
        toast.textContent = message;
        toast.className = `toast show ${type}`;

        // Sembunyikan notifikasi setelah 3 detik
        setTimeout(() => {
            toast.className = 'toast';
        }, 3000);
    }

    // --- 3. VALIDASI FORMULIR (CLIENT-SIDE) ---
    if (formBarang) {
        formBarang.addEventListener('submit', function (event) {
            // Mencegah formulir dari pengiriman default/reload halaman
            event.preventDefault();

            // Ambil nilai, hilangkan spasi, dan otomatis ubah ke huruf kapital
            const kode = inputKode.value.trim().toUpperCase();
            const jumlah = parseInt(inputJumlah.value, 10);

            // Perbarui nilai input di form agar langsung jadi kapital
            inputKode.value = kode;

            // Validasi Kode Barang: Wajib diawali "BRG-" diikuti angka (contoh: BRG-001)
            const regexKode = /^BRG-\d+$/;
            if (!regexKode.test(kode)) {
                showToast('Kode barang harus diawali "BRG-" dan diikuti angka (contoh: BRG-001)!', 'error');
                inputKode.focus();
                return;
            }

            // Validasi Jumlah Barang: Wajib bernilai numerik & > 0
            if (isNaN(jumlah) || jumlah <= 0) {
                showToast('Jumlah barang harus berupa angka positif lebih dari 0!', 'error');
                inputJumlah.focus();
                return;
            }

            // Jika validasi berhasil: Tambahkan data baru ke tabel (Interaksi DOM)
            tambahBarangKeTabel(kode, inputNama.value, selectKategori.value, jumlah, selectKondisi.value);

            // Tampilkan notifikasi sukses
            showToast('Data barang berhasil ditambahkan!', 'success');

            // Reset formulir input
            formBarang.reset();
        });
    }

    // --- 4. TAMBAH BARANG DINAMIS KE TABEL ---
    function tambahBarangKeTabel(kode, nama, kategori, jumlah, kondisi) {
        const barisBaru = document.createElement('tr');
        barisBaru.innerHTML = `
            <td>${kode}</td>
            <td>${nama}</td>
            <td>${kategori}</td>
            <td>${jumlah}</td>
            <td>${kondisi}</td>
        `;
        tabelBarang.appendChild(barisBaru);
    }

    // --- 5. FITUR PENCARIAN REAL-TIME ---
    if (inputCari) {
        inputCari.addEventListener('keyup', function () {
            const kataKunci = inputCari.value.toLowerCase();
            const semuaBaris = tabelBarang.querySelectorAll('tr');

            semuaBaris.forEach(function (baris) {
                const teksBaris = baris.textContent.toLowerCase();
                if (teksBaris.includes(kataKunci)) {
                    baris.style.display = '';
                } else {
                    baris.style.display = 'none';
                }
            });
        });
    }

});