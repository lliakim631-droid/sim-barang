document.addEventListener('DOMContentLoaded', function () {
    const formBarang = document.querySelector('#form-barang form');
    const inputKode = document.getElementById('kode');
    const inputNama = document.getElementById('nama');
    const selectKategori = document.getElementById('kategori');
    const inputJumlah = document.getElementById('jumlah');
    const inputHarga = document.getElementById('harga');
    const selectKondisi = document.getElementById('kondisi');
    const inputCari = document.getElementById('cari-barang');
    const tabelBarang = document.querySelector('#tabel-barang tbody');
    const toast = document.getElementById('toast');

    function showToast(message, type = 'success') {
        if (!toast) return;
        toast.textContent = message;
        toast.className = `toast show ${type}`;
        setTimeout(() => {
            toast.className = 'toast';
        }, 3000);
    }

    if (formBarang) {
        formBarang.addEventListener('submit', function (event) {
            event.preventDefault();

            const kode = inputKode.value.trim().toUpperCase();
            const jumlah = parseInt(inputJumlah.value, 10);
            const harga = parseFloat(inputHarga.value);

            inputKode.value = kode;

            const regexKode = /^BRG-\d+$/;
            if (!regexKode.test(kode)) {
                showToast('Kode barang harus diawali "BRG-" dan diikuti angka (contoh: BRG-004)!', 'error');
                inputKode.focus();
                return;
            }

            if (isNaN(jumlah) || jumlah <= 0) {
                showToast('Jumlah barang harus berupa angka positif lebih dari 0!', 'error');
                inputJumlah.focus();
                return;
            }

            if (isNaN(harga) || harga < 0) {
                showToast('Harga satuan harus berupa angka yang valid!', 'error');
                inputHarga.focus();
                return;
            }

            // Hitung total nilai otomatis (Jumlah * Harga)
            const totalNilai = jumlah * harga;

            const formatRupiah = (angka) => {
                return 'Rp ' + angka.toLocaleString('id-ID');
            };

            // Tambahkan ke tabel dengan 7 kolom lengkap
            tambahBarangKeTabel(
                kode, 
                inputNama.value, 
                selectKategori.value, 
                jumlah, 
                formatRupiah(harga), 
                formatRupiah(totalNilai), 
                selectKondisi.value
            );

            showToast('Data barang berhasil ditambahkan!', 'success');
            formBarang.reset();
        });
    }

    function tambahBarangKeTabel(kode, nama, kategori, jumlah, hargaSatuan, totalNilai, kondisi) {
        const barisBaru = document.createElement('tr');
        barisBaru.innerHTML = `
            <td>${kode}</td>
            <td>${nama}</td>
            <td>${kategori}</td>
            <td>${jumlah}</td>
            <td>${hargaSatuan}</td>
            <td>${totalNilai}</td>
            <td>${kondisi}</td>
        `;
        tabelBarang.appendChild(barisBaru);
    }

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