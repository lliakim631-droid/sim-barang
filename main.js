
document.addEventListener("DOMContentLoaded", function () {
    const inputCari = document.getElementById("cari-barang");
    const tabelBarang = document.getElementById("isi-tabel-barang");
    const formBarang = document.getElementById("formInputBarang");

    // Pencarian berdasarkan isi tabel.
    if (inputCari && tabelBarang) {
        inputCari.addEventListener("input", function () {
            const kataKunci = inputCari.value.toLowerCase();

            tabelBarang.querySelectorAll("tr").forEach(function (baris) {
                const teks = baris.textContent.toLowerCase();

                baris.style.display = teks.includes(kataKunci)
                    ? ""
                    : "none";
            });
        });
    }

    // Validasi sebelum data dikirim ke PHP.
    if (formBarang) {
        formBarang.addEventListener("submit", function (event) {
            const kode = document.getElementById("kode").value.trim();
            const jumlah = Number(
                document.getElementById("jumlah").value
            );
            const harga = Number(
                document.getElementById("harga").value
            );

            if (!/^BRG-\d+$/.test(kode)) {
                event.preventDefault();
                alert("Format kode harus seperti BRG-004.");
                return;
            }

            if (!Number.isInteger(jumlah) || jumlah < 1) {
                event.preventDefault();
                alert("Jumlah barang minimal 1.");
                return;
            }

            if (!Number.isFinite(harga) || harga < 0) {
                event.preventDefault();
                alert("Harga harus berupa angka nol atau lebih.");
            }
        });
    }
});
