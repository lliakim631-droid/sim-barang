document.addEventListener("DOMContentLoaded", function () {
    const inputCari = document.getElementById("cari-barang");
    const tabelBarang = document.getElementById("isi-tabel-barang");
    const formBarang = document.getElementById("formInputBarang");

    // Toast: pemberitahuan singkat yang hilang otomatis.
    function showToast(pesan, tipe) {
        let toast = document.getElementById("toast");

        if (!toast) {
            toast = document.createElement("div");
            toast.id = "toast";
            toast.setAttribute("role", "status");
            toast.setAttribute("aria-live", "polite");
            document.body.appendChild(toast);
        }

        toast.textContent = pesan;
        toast.className = "toast toast-" + (tipe || "sukses") + " tampil";

        clearTimeout(showToast.timer);
        showToast.timer = setTimeout(function () {
            toast.classList.remove("tampil");
        }, 2500);
    }

    // Pencarian berdasarkan isi tabel (real-time).
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
        let sedangMengirim = false;

        formBarang.addEventListener("submit", function (event) {
            event.preventDefault();

            if (sedangMengirim) {
                return;
            }

            const kode = document.getElementById("kode").value.trim();
            const jumlah = Number(
                document.getElementById("jumlah").value
            );
            const harga = Number(
                document.getElementById("harga").value
            );

            if (!/^BRG-\d+$/.test(kode)) {
                showToast("Format kode harus seperti BRG-004.", "error");
                return;
            }

            if (!Number.isInteger(jumlah) || jumlah < 1) {
                showToast("Jumlah barang minimal 1.", "error");
                return;
            }

            if (!Number.isFinite(harga) || harga < 0) {
                showToast(
                    "Harga harus berupa angka nol atau lebih.",
                    "error"
                );
                return;
            }

            // Validasi berhasil: tampilkan toast, lalu kirim ke PHP.
            sedangMengirim = true;
            showToast("Data valid! Menyimpan barang...", "sukses");

            setTimeout(function () {
                formBarang.submit();
            }, 900);
        });
    }
});