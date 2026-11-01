/**
 * ==========================================
 * 1. CONFIGURATION & GLOBAL SETUP
 * ==========================================
 */
// CSRF Token Setup untuk jQuery AJAX (Laravel Integration)
$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

/**
 * ==========================================
 * 2. CHARTS & VISUALIZATION (Chart.js)
 * ==========================================
 */
function createAttendanceChart(elementId) {
    const el = document.getElementById(elementId);
    if (!el) return;

    const labels = JSON.parse(el.getAttribute("data-labels"));
    const dataH = JSON.parse(el.getAttribute("data-h"));
    const dataS = JSON.parse(el.getAttribute("data-s"));
    const dataI = JSON.parse(el.getAttribute("data-i"));
    const dataA = JSON.parse(el.getAttribute("data-a"));
    const maxVal = parseInt(el.getAttribute("data-max")) || 100;

    new Chart(el.getContext("2d"), {
        type: "line",
        data: {
            labels: labels,
            datasets: [
                {
                    label: "Hadir",
                    data: dataH,
                    borderColor: "#2ecc71",
                    backgroundColor: "transparent",
                    tension: 0.4,
                },
                {
                    label: "Sakit",
                    data: dataS,
                    borderColor: "#f1c40f",
                    backgroundColor: "transparent",
                    tension: 0.4,
                },
                {
                    label: "Izin",
                    data: dataI,
                    borderColor: "#3498db",
                    backgroundColor: "transparent",
                    tension: 0.4,
                },
                {
                    label: "Alpa",
                    data: dataA,
                    borderColor: "#e74c3c",
                    backgroundColor: "transparent",
                    tension: 0.4,
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { position: "top" } },
            scales: { y: { beginAtZero: true, max: maxVal } },
        },
    });
}

function createClassChart(elementId) {
    const el = document.getElementById(elementId);
    if (!el) return;

    const labels = JSON.parse(el.getAttribute("data-labels"));
    const dataH = JSON.parse(el.getAttribute("data-h"));
    const dataS = JSON.parse(el.getAttribute("data-s"));
    const dataI = JSON.parse(el.getAttribute("data-i"));
    const dataA = JSON.parse(el.getAttribute("data-a"));
    const maxsVal = parseInt(el.getAttribute("data-siswa-max")) || 30;

    new Chart(el.getContext("2d"), {
        type: "bar",
        data: {
            labels: labels,
            datasets: [
                {
                    label: "Hadir",
                    data: dataH,
                    backgroundColor: "#2ecc71",
                    borderRadius: 5,
                },
                {
                    label: "Izin",
                    data: dataI,
                    backgroundColor: "#3498db",
                    borderRadius: 5,
                },
                {
                    label: "Sakit",
                    data: dataS,
                    backgroundColor: "#f1c40f",
                    borderRadius: 5,
                },
                {
                    label: "Alpa",
                    data: dataA,
                    backgroundColor: "#e74c3c",
                    borderRadius: 5,
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: true, position: "bottom" } },
            scales: {
                y: {
                    stacked: true,
                    beginAtZero: true,
                    grid: { color: "rgba(255, 255, 255, 0.1)" },
                    max: maxsVal,
                },
                x: { stacked: true, grid: { display: false } },
            },
        },
    });
}

/**
 * ==========================================
 * 3. AUTHENTICATION & CONFIRMATION DIALOGS
 * ==========================================
 */
// SweetAlert Konfirmasi Logout
window.confirmLogout = function () {
    Swal.fire({
        title: "Anda yakin ingin keluar?",
        text: "Pastiin semua perubahan sudah disimpan ya!",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya, Logout!",
        cancelButtonText: "Gak Jadi",
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.createElement("form");
            form.action = "/logout";
            form.method = "POST";
            form.innerHTML = `<input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').getAttribute("content")}">`;
            document.body.appendChild(form);
            form.submit();
        }
    });
};

// SweetAlert Konfirmasi Delete Universal
window.confirmDelete = function (id, name, type) {
    Swal.fire({
        title: "Yakin mau hapus?",
        text: `Data ${type.toUpperCase()} Ini Akan Dihapus Permanen!`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Ya, Hapus!",
        cancelButtonText: "Batal",
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.createElement("form");
            form.method = "POST";
            form.action = `/admin/${type}/${id}`;

            const csrfToken = document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content");

            const csrfInput = document.createElement("input");
            csrfInput.type = "hidden";
            csrfInput.name = "_token";
            csrfInput.value = csrfToken;

            const methodInput = document.createElement("input");
            methodInput.type = "hidden";
            methodInput.name = "_method";
            methodInput.value = "DELETE";

            form.appendChild(csrfInput);
            form.appendChild(methodInput);
            document.body.appendChild(form);
            form.submit();
        }
    });
};

/**
 * Universal AJAX Form Submit Handler (Create / Update)
 * @param {HTMLFormElement} formElement - Elemen form yang di-submit
 * @param {Function|null} onSuccessCallback - Callback khusus jika butuh aksi tambahan setelah sukses
 */
window.handleAjaxFormSubmit = function (formElement, onSuccessCallback = null) {
    const form = $(formElement);
    const actionUrl = form.attr("action");
    const formData = form.serialize();

    // Tampilkan Loading Swal
    Swal.fire({
        title: "Menyimpan Data...",
        text: "Harap tunggu sebentar",
        allowOutsideClick: false,
        didOpen: () => Swal.showLoading(),
    });

    $.ajax({
        url: actionUrl,
        type: "POST",
        data: formData,
        dataType: "JSON",
        success: function (res) {
            // JIKA RESPON SUKSES (HTTP 200)
            Swal.fire({
                icon: "success",
                title: "Berhasil!",
                text: res.message || "Data berhasil disimpan.",
                timer: 1500,
                showConfirmButton: false,
            }).then(() => {
                if (typeof onSuccessCallback === "function") {
                    onSuccessCallback(res);
                } else {
                    location.reload(); // Default reload halaman
                }
            });
        },
        error: function (xhr) {
            // JIKA RESPON GAGAL (HTTP 422 / Validasi Fail-Safe)
            let errorTitle = "Gagal Menyimpan!";
            let errorMsg = "Terjadi kesalahan pada input data.";

            if (xhr.responseJSON) {
                if (xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                } else if (xhr.responseJSON.errors) {
                    // Ambil error validasi pertama jika array validation
                    const firstKey = Object.keys(xhr.responseJSON.errors)[0];
                    errorMsg = xhr.responseJSON.errors[firstKey][0];
                }
            }

            Swal.fire({
                icon: "warning",
                title: errorTitle,
                html: errorMsg,
                confirmButtonColor: "#f59e0b",
            });
        },
    });
};

/**
 * ==========================================
 * 4. LOGIKA ABSENSI & KALENDER LIBUR
 * ==========================================
 */
// Cek Hari Libur sebelum mulai absen
window.confirmCekLibur = function () {
    const targetUrl = document
        .getElementById("btn-mulai-absen")
        .getAttribute("data-url");

    Swal.fire({
        title: "Memeriksa Kalender...",
        text: "Harap tunggu, sistem sedang mengecek status hari libur.",
        allowOutsideClick: false,
        didOpen: () => Swal.showLoading(),
    });

    $.ajax({
        url: "/guru/cek-hari-libur",
        type: "GET",
        success: function (res) {
            if (res.is_libur) {
                Swal.fire({
                    title: "Sekolah Libur!",
                    text: res.pesan,
                    icon: "info",
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "Oke",
                });
            } else {
                Swal.close();
                window.location.href = targetUrl;
            }
        },
        error: function (xhr) {
            Swal.close();
            Swal.fire({
                title: "Error!!",
                text: `Status: ${xhr.status} - ${xhr.responseText || "Cek console log atau network tab"}`,
                icon: "error",
            });
        },
    });
};

// Synchronize Status & Keterangan Absen
window.syncStatus = function (idSiswa, value) {
    const hiddenStatus = document.getElementById("hidden-status-" + idSiswa);
    if (hiddenStatus) hiddenStatus.value = value;

    document
        .querySelectorAll(
            `.input-sync[data-id="${idSiswa}"][data-type="status"]`,
        )
        .forEach((el) => {
            if (el.value !== value) el.value = value;
        });
};

window.syncKet = function (idSiswa, value) {
    const hiddenKet = document.getElementById("hidden-ket-" + idSiswa);
    if (hiddenKet) hiddenKet.value = value;

    document
        .querySelectorAll(`.input-sync[data-id="${idSiswa}"][data-type="ket"]`)
        .forEach((el) => {
            if (el.value !== value) el.value = value;
        });
};

// Modal & CRUD Edit Hari Libur
window.tutupModalLibur = function () {
    const modalEditLibur = document.getElementById("modalEditLibur");
    if (modalEditLibur) modalEditLibur.classList.add("hidden");
};

window.editHariLibur = function (id) {
    const row = document.getElementById(`row-libur-${id}`);
    if (!row) return;

    const tanggalRaw = row
        .querySelector(".kolom-tanggal")
        .getAttribute("data-tanggal");
    const keteranganRaw = row
        .querySelector(".kolom-keterangan")
        .innerText.trim();

    const form = document.getElementById("form-edit-libur");
    form.setAttribute("action", `/admin/hari-libur/${id}/update`);

    let methodInput = form.querySelector('input[name="_method"]');
    if (!methodInput) {
        methodInput = document.createElement("input");
        methodInput.type = "hidden";
        methodInput.name = "_method";
        methodInput.value = "PUT";
        form.appendChild(methodInput);
    }

    document.getElementById("edit_id").value = id;
    document.getElementById("edit_tanggal").value = tanggalRaw;
    document.getElementById("edit_keterangan").value = keteranganRaw;

    const modalEditLibur = document.getElementById("modalEditLibur");
    if (modalEditLibur) modalEditLibur.classList.remove("hidden");
};

// Event Handler AJAX Edit Libur (Document Ready)
$(document).ready(function () {
    $("#form-edit-libur").submit(function (e) {
        e.preventDefault();
        const form = $(this);

        $.ajax({
            url: form.attr("action"),
            type: "POST",
            data: form.serialize(),
            dataType: "JSON",
            success: function (response) {
                if (response.status === "success") {
                    const updatedData = response.data;
                    const row = $(`#row-libur-${updatedData.id}`);

                    if (row.length > 0) {
                        const dateObj = new Date(updatedData.tanggal);
                        const formattedDate = dateObj.toLocaleDateString(
                            "id-ID",
                            {
                                day: "2-digit",
                                month: "short",
                                year: "numeric",
                            },
                        );

                        row.find(".kolom-tanggal")
                            .text(formattedDate)
                            .attr("data-tanggal", updatedData.tanggal);
                        row.find(".kolom-keterangan").text(
                            updatedData.keterangan,
                        );
                    }

                    if (typeof tutupModalLibur === "function")
                        tutupModalLibur();
                    else $("#modalEditLibur").addClass("hidden");

                    Swal.fire({
                        title: "Berhasil!",
                        text: response.message,
                        icon: "success",
                        timer: 1500,
                        showConfirmButton: false,
                    });
                }
            },
            error: function (xhr) {
                let errorText = "Status: " + xhr.status;
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorText += " - " + xhr.responseJSON.message;
                }
                Swal.fire({
                    title: "Gagal Menyimpan...",
                    text: errorText,
                    icon: "error",
                    confirmButtonColor: "#d33",
                });
            },
        });
    });
});

/**
 * ==========================================
 * 5. MANAJEMEN PENGUMUMAN (MODAL & AJAX)
 * ==========================================
 */
window.openAddModal = function () {
    document.getElementById("modalTambah").classList.remove("hidden");
};

window.closeAddModal = function () {
    document.getElementById("modalTambah").classList.add("hidden");
    $("#add-judul, #add-isi, #add-tgl").val("");
};

window.saveNew = function () {
    const judul = $("#add-judul").val();
    const kategori = $("#add-kategori").val();
    const isi = $("#add-isi").val();
    const tgl = $("#add-tgl").val();

    if (!judul || !isi || !tgl) {
        return Swal.fire("Peringatan!!", "Harap Diisi Dengan Benar", "warning");
    }

    $.ajax({
        url: "/admin/pengumuman",
        type: "POST",
        data: {
            _token: $('meta[name="csrf-token"]').attr("content"),
            judul,
            kategori,
            isi,
            tgl_tampil: tgl,
        },
        success: function () {
            Swal.fire({
                icon: "success",
                title: "Berhasil!",
                text: "Pengumuman baru berhasil ditambahkan.",
                timer: 2000,
            }).then(() => location.reload());
        },
        error: function (err) {
            console.error(err.responseText);
            Swal.fire("Gagal", "Cek koneksi atau inputan lo!", "error");
        },
    });
};

window.openDetail = function (element) {
    const data = JSON.parse(element.getAttribute("data-pengumuman"));
    const formatIndo = (dateStr) => {
        if (!dateStr) return "";
        const [year, month, day] = dateStr.split("-");
        return `${day}-${month}-${year}`;
    };

    $("#modalTitle").text(data.judul);
    $("#view-isi").text(data.isi);
    $("#view-tgl").text("Tanggal: " + formatIndo(data.tgl_tampil));

    $("#target-id").val(data.id_pengumuman);
    $("#edit-judul").val(data.judul);
    $("#edit-kategori").val(data.kategori);
    $("#edit-tgl").val(data.tgl_tampil);
    $("#edit-isi").val(data.isi);

    $("#modalPengumuman").removeClass("hidden").addClass("active");
};

window.closeModal = function () {
    const modal = document.getElementById("modalPengumuman");
    modal.classList.remove("active");
    setTimeout(() => {
        modal.classList.add("hidden");
        window.toggleEditMode(false);
    }, 300);
};

window.saveUpdate = function () {
    const id = $("#target-id").val();
    const dataInput = {
        _token: $('meta[name="csrf-token"]').attr("content"),
        judul: $("#edit-judul").val(),
        kategori: $("#edit-kategori").val(),
        isi: $("#edit-isi").val(),
        tgl_tampil: $("#edit-tgl").val(),
    };

    $.ajax({
        url: `/admin/pengumuman/update/${id}`,
        type: "POST",
        data: dataInput,
        success: function () {
            Swal.fire("Berhasil!", "Data diperbarui!", "success").then(() =>
                location.reload(),
            );
        },
    });
};

window.toggleEditMode = function (isEdit) {
    const views = document.querySelectorAll(".mode-view");
    const edits = document.querySelectorAll(".mode-edit");
    if (isEdit) {
        views.forEach((el) => el.classList.add("hidden"));
        edits.forEach((el) => el.classList.remove("hidden"));
    } else {
        views.forEach((el) => el.classList.remove("hidden"));
        edits.forEach((el) => el.classList.add("hidden"));
    }
};

/**
 * ==========================================
 * 6. EXPORT LAPORAN (ExcelJS & FileSaver)
 * ==========================================
 */
window.exportExcel = async function () {
    const kelasSelect =
        document.querySelector('select[name="id_kelas"]') ||
        document.getElementById("filterKelas");
    const tahunSelect =
        document.querySelector('select[name="id_tahun_ajaran"]') ||
        document.getElementById("filterTahunAjaranRekap");

    if (!kelasSelect || !tahunSelect) {
        return Swal.fire(
            "Waduh!",
            "Komponen filter halaman tidak ditemukan!",
            "error",
        );
    }

    if (tahunSelect.value === "") {
        return Swal.fire(
            "Waduh!",
            "Silahkan pilih filter Tahun Ajaran dan klik Tampilkan dahulu!",
            "warning",
        );
    }

    const namaKelas = kelasSelect.options[kelasSelect.selectedIndex]
        ? kelasSelect.options[kelasSelect.selectedIndex].text
        : "Semua Kelas";
    const labelKelas = namaKelas.includes("--") ? "Semua Kelas" : namaKelas;

    const namaTahun = tahunSelect.options[tahunSelect.selectedIndex]
        ? tahunSelect.options[tahunSelect.selectedIndex].text
        : "Semua Periode";
    const labelTahun = namaTahun.includes("--")
        ? "Semua Periode"
        : namaTahun.replace("Tahun Ajaran: ", "");

    const table = document.querySelector(".data-table");
    if (!table)
        return Swal.fire("Waduh!", "Tabel data tidak ditemukan!", "error");

    const workbook = new ExcelJS.Workbook();
    const worksheet = workbook.addWorksheet("Rekap Absensi");

    const getColumnLetter = (n) => {
        let letter = "";
        while (n > 0) {
            let mod = (n - 1) % 26;
            letter = String.fromCharCode(65 + mod) + letter;
            n = Math.floor((n - mod) / 26);
        }
        return letter;
    };

    const totalCols = table.querySelectorAll("thead th").length;
    const lastCol = getColumnLetter(totalCols);

    // Header Laporan
    const schoolRow = worksheet.addRow(["SD NEGERI O2 WONOREJO"]); // <-- Tinggal ganti nama sekolahmu di sini
    const titleRow = worksheet.addRow(["LAPORAN REKAPITULASI ABSENSI SISWA"]);
    const subTitleRow = worksheet.addRow([
        `Kelas: ${labelKelas} | Periode Tahun Ajaran: ${labelTahun}`,
    ]);
    worksheet.addRow([]); // Spasi kosong

    // Merge Cells untuk 3 Baris Header Laporan
    worksheet.mergeCells(`A1:${lastCol}1`);
    worksheet.mergeCells(`A2:${lastCol}2`);
    worksheet.mergeCells(`A3:${lastCol}3`);

    // Styling Teks Header
    [schoolRow, titleRow, subTitleRow].forEach((row, idx) => {
        row.getCell(1).alignment = { horizontal: "center", vertical: "middle" };
        if (idx === 0) {
            row.getCell(1).font = {
                bold: true,
                size: 15,
                color: { argb: "1A252F" },
            };
        } else if (idx === 1) {
            row.getCell(1).font = {
                bold: true,
                size: 12,
                color: { argb: "2C3E50" },
            };
        } else {
            row.getCell(1).font = {
                bold: false,
                size: 10,
                color: { argb: "555555" },
            };
        }
    });

    // Header Tabel
    const headers = Array.from(table.querySelectorAll("thead th")).map((th) =>
        th.innerText.trim(),
    );
    const headerRow = worksheet.addRow(headers);

    headerRow.eachCell((cell) => {
        cell.fill = {
            type: "pattern",
            pattern: "solid",
            fgColor: { argb: "34495E" },
        };
        cell.font = { bold: true, color: { argb: "FFFFFF" } };
        cell.alignment = { horizontal: "center", vertical: "middle" };
        cell.border = {
            top: { style: "thin" },
            left: { style: "thin" },
            bottom: { style: "thin" },
            right: { style: "thin" },
        };
    });

    // Isi Data
    const rows = table.querySelectorAll("tbody tr");
    rows.forEach((tr, index) => {
        const rowData = Array.from(tr.querySelectorAll("td")).map(
            (td) => td.innerText,
        );
        const newRow = worksheet.addRow(rowData);

        newRow.eachCell((cell, colNumber) => {
            cell.border = {
                top: { style: "thin" },
                left: { style: "thin" },
                bottom: { style: "thin" },
                right: { style: "thin" },
            };
            if (index % 2 !== 0) {
                cell.fill = {
                    type: "pattern",
                    pattern: "solid",
                    fgColor: { argb: "ededed" },
                };
            }

            const headerText = headers[colNumber - 1];
            if (headerText.includes("Nama")) {
                cell.alignment = {
                    horizontal: "left",
                    vertical: "middle",
                    indent: 1,
                };
            } else {
                cell.alignment = { horizontal: "center", vertical: "middle" };
            }
        });
    });

    // Auto-fit Column Width
    worksheet.columns.forEach((column, i) => {
        let maxWidth = 8;
        column.eachCell({ includeEmpty: true }, (cell) => {
            if (cell.row >= 4) {
                const cellValue = cell.value ? cell.value.toString() : "";
                const columnWidth = cellValue.length + 3;
                if (columnWidth > maxWidth) maxWidth = columnWidth;
            }
        });

        const headerText = headers[i].toLowerCase().trim();
        if (headerText === "no") column.width = 5;
        else if (headerText.includes("nama"))
            column.width = Math.max(maxWidth, 30);
        else if (headerText === "nis" || headerText === "nisn")
            column.width = 15;
        else if (
            [
                "hadir",
                "h",
                "sakit",
                "s",
                "izin",
                "i",
                "alpa",
                "a",
                "total",
            ].some((k) => headerText.includes(k))
        )
            column.width = 10;
        else column.width = Math.min(maxWidth, 40);
    });

    // Generate & Download File
    try {
        const buffer = await workbook.xlsx.writeBuffer();
        const blob = new Blob([buffer], {
            type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
        });

        const cleanKelas = labelKelas.replace(/[^a-z0-9]/gi, "_");
        const cleanTahun = labelTahun.replace(/[^a-z0-9]/gi, "_");
        const fileName = `Rekap_${cleanKelas}_Tahun_${cleanTahun}.xlsx`;

        if (typeof saveAs !== "undefined") {
            saveAs(blob, fileName);
        } else {
            const link = document.createElement("a");
            link.href = URL.createObjectURL(blob);
            link.download = fileName;
            link.click();
        }

        Swal.fire({
            title: "Sukses!",
            text: `Laporan ${labelKelas} Periode ${labelTahun} siap!`,
            icon: "success",
            timer: 2000,
            showConfirmButton: false,
        });
    } catch (error) {
        console.error(error);
        Swal.fire("Error!", "Gagal membuat file Excel.", "error");
    }
};

/**
 * ==========================================
 * 7. UTILITIES & HELPERS
 * ==========================================
 */
// Jam Digital Realtime
function updateClock() {
    const clockElement = document.getElementById("digital-clock");
    if (clockElement) {
        const now = new Date();
        clockElement.textContent = now.toLocaleTimeString("id-ID", {
            hour: "2-digit",
            minute: "2-digit",
            second: "2-digit",
        });
    }
}

/**
 * ==========================================
 * 8. DOM READY & INITIALIZATION
 * ==========================================
 */
document.addEventListener("DOMContentLoaded", function () {
    // --- 8.1 Initialize Clock ---
    setInterval(updateClock, 1000);
    updateClock();

    // --- 8.2 Initialize Charts ---
    if (document.getElementById("absensiChart")) {
        createAttendanceChart("absensiChart");
    }
    if (document.getElementById("chartKelas")) {
        createClassChart("chartKelas");
    }

    // --- 8.3 Form Submit Guards ---
    $("#formAbsensi").on("submit", function (e) {
        e.preventDefault();
        Swal.fire({
            title: "Sudah Yakin?",
            text: "Data absen ini bersifat FINAL dan tidak bisa diubah lagi!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Ya, Simpan!",
            cancelButtonText: "Cek Lagi",
        }).then((result) => {
            if (result.isConfirmed) this.submit();
        });
    });

    const btnGantiPeriode = document.getElementById("btnGantiPeriode");
    const formGantiPeriode = document.getElementById("formGantiPeriode");
    if (btnGantiPeriode && formGantiPeriode) {
        btnGantiPeriode.addEventListener("click", function (e) {
            e.preventDefault();
            let semester = this.getAttribute("data-semester");
            let teksTambahan =
                "Pastikan semua data absensi periode saat ini sudah direkap karena proses ini tidak bisa dibatalkan!";
            if (semester === "genap") {
                teksTambahan =
                    "Siswa tingkat akhir akan dinyatakan LULUS dan siswa aktif lainnya akan NAIK KELAS otomatis (kecuali yang Anda centang tinggal kelas).";
            }
            Swal.fire({
                title: "Yakin ingin ganti periode akademik?",
                text: teksTambahan,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#dc3545",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Ya, Proses Sekarang!",
                cancelButtonText: "Batal",
            }).then((result) => {
                if (result.isConfirmed) formGantiPeriode.submit();
            });
        });
    }

    // --- 8.4 Event Listeners (UI Interaction) ---
    const btnSimpan = document.getElementById("btn-simpan-pengumuman");
    if (btnSimpan) {
        btnSimpan.addEventListener("click", saveUpdate);
    }

    const btnClose = document.querySelectorAll(".close-modal-trigger");
    btnClose.forEach((btn) => btn.addEventListener("click", closeModal));

    const container = document.getElementById("announcement-list-container");
    if (container) {
        container.addEventListener("click", function (e) {
            const item = e.target.closest(".announcement-item");
            if (item) openDetail(item);
        });
    }

    // --- 8.5 Client-side Table Filters ---
    const searchInput = document.getElementById("searchInput");
    if (searchInput) {
        searchInput.addEventListener("input", function () {
            const filter = this.value.toLowerCase();
            document.querySelectorAll(".data-table tbody tr").forEach((row) => {
                row.style.display = row.textContent
                    .toLowerCase()
                    .includes(filter)
                    ? ""
                    : "none";
            });
        });
    }

    const filterKelas = document.getElementById("filterKelas");
    if (filterKelas) {
        filterKelas.addEventListener("change", function () {
            const selectedClass = this.value.toLowerCase();
            document.querySelectorAll("#siswaTable tbody tr").forEach((row) => {
                const classCellText = row.querySelector("td:nth-child(4)")
                    ? row
                          .querySelector("td:nth-child(4)")
                          .textContent.toLowerCase()
                    : "";
                row.style.display =
                    selectedClass === "" ||
                    classCellText.includes(selectedClass)
                        ? ""
                        : "none";
            });
        });
    }

    // --- 8.6 Handling URL Query Flash Messages (Toast/Alert) ---
    const urlParams = new URLSearchParams(window.location.search);
    const status = urlParams.get("status");

    if (status) {
        let title = "",
            text = "",
            icon = "";

        switch (status) {
            case "sukses":
                title = "Berhasil!";
                text = "Data berhasil ditambahkan.";
                icon = "success";
                break;
            case "update_sukses":
                title = "Update Berhasil!";
                text = "Data sudah diperbarui.";
                icon = "success";
                break;
            case "hapus_sukses":
                title = "Terhapus!";
                text = "Data berhasil dihapus.";
                icon = "success";
                break;
            case "username_ada":
                title = "Waduh!";
                text = "Username itu sudah dipakai";
                icon = "error";
                break;
            case "gagal":
                title = "Yah, Gagal...";
                text = "Ada error dikit pas proses data. Coba lagi.";
                icon = "error";
                break;
            case "gagal_walas":
                title = "Gagal Hapus!";
                text =
                    "Guru ini tidak bisa dihapus karena masih menjadi Wali Kelas!";
                icon = "error";
                break;
            case "gagal_sesi":
                title = "Gagal!";
                text = "Jam & Sesi ini tidak boleh sama dengan yang ada!";
                icon = "error";
                break;
        }

        if (title !== "") {
            Swal.fire({
                title: title,
                text: text,
                icon: icon,
                confirmButtonColor: "#3085d6",
                timer: 3000,
                timerProgressBar: true,
            });
        }
        window.history.replaceState(
            {},
            document.title,
            window.location.pathname,
        );
    }
});

/* ==========================================================================
   MODULE: VALIDASI KEHADIRAN (GPS + QR / PIN KELAS)
   ========================================================================== */

let html5QrcodeScanner = null;

// 1. Rumus Haversine (Hitung Jarak Koordinat GPS dalam Meter)
function calculateHaversineDistance(lat1, lon1, lat2, lon2) {
    const R = 6371000; // Radius Bumi (Meter)
    const dLat = ((lat2 - lat1) * Math.PI) / 180;
    const dLon = ((lon2 - lon1) * Math.PI) / 180;
    const a =
        Math.sin(dLat / 2) * Math.sin(dLat / 2) +
        Math.cos((lat1 * Math.PI) / 180) *
            Math.cos((lat2 * Math.PI) / 180) *
            Math.sin(dLon / 2) *
            Math.sin(dLon / 2);
    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    return R * c;
}

// 2. Detect Mobile vs Desktop Device
function isMobileDevice() {
    return (
        /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(
            navigator.userAgent,
        ) || window.innerWidth <= 768
    );
}

// 3. Global Window Function: Buka Form Absensi Utama
window.unlockMainAbsenForm = function () {
    Swal.fire({
        icon: "success",
        title: "Verifikasi Berhasil!",
        text: "Lokasi & Kelas Terkonfirmasi.",
        timer: 1200,
        showConfirmButton: false,
        customClass: {
            popup: "bg-dark text-white border border-secondary",
            title: "text-success fw-bold",
            htmlContainer: "text-light",
        },
    });

    const overlay = document.getElementById("validation-overlay");
    const mainContainer = document.getElementById("main-absen-container");
    const btnFloat = document.getElementById("btn-float-scroll");

    if (overlay) overlay.style.display = "none";
    if (mainContainer) mainContainer.style.display = "block";
    if (btnFloat) btnFloat.style.display = "flex";
};

// 4. Global Window Function: Switch Modal QR (HP) - Auto Click Permission
window.switchToQrModal = function () {
    const qrContainer = document.getElementById("modal-qr-container");
    const pinContainer = document.getElementById("modal-pin-container");
    const overlay = document.getElementById("validation-overlay");

    if (!qrContainer || !pinContainer || !overlay) return;

    qrContainer.style.display = "block";
    pinContainer.style.display = "none";

    const validPin = overlay.dataset.pin;

    if (!html5QrcodeScanner && typeof Html5QrcodeScanner !== "undefined") {
        html5QrcodeScanner = new Html5QrcodeScanner("reader", {
            fps: 10,
            qrbox: { width: 220, height: 220 },
            rememberLastUsedCamera: true,
            supportedScanTypes: [Html5QrcodeScanType.SCAN_TYPE_CAMERA],
        });

        html5QrcodeScanner.render((decodedText) => {
            if (decodedText.trim().toUpperCase() === validPin.toUpperCase()) {
                html5QrcodeScanner.clear();
                window.unlockMainAbsenForm();
            } else {
                const isScanning =
                    typeof html5QrcodeScanner.getState === "function" &&
                    html5QrcodeScanner.getState() === Html5QrcodeScannerState.SCANNING;

                if (isScanning) {
                    try { html5QrcodeScanner.pause(true); } catch (e) {}
                }

                Swal.fire({
                    icon: "error",
                    title: "QR Tidak Cocok",
                    text: "QR Code ini bukan milik kelas ini!",
                    target: "#validation-overlay",
                    confirmButtonText: "Coba Lagi",
                    confirmButtonColor: "#dc3545",
                    customClass: {
                        popup: "bg-dark text-white border border-secondary",
                        title: "text-danger fw-bold",
                        htmlContainer: "text-light",
                    },
                }).then(() => {
                    if (isScanning && html5QrcodeScanner) {
                        try { html5QrcodeScanner.resume(); } catch (e) {}
                    }
                });
            }
        });

        // TRIK AUTO-CLICK: Otomatis menekan tombol 'Request Camera Permissions' begitu UI terpasang
        setTimeout(() => {
            const btnPermission = document.querySelector("#reader button");
            if (btnPermission) {
                btnPermission.click();
            }
        }, 200);
    }
};

// 5. Global Window Function: Switch Modal PIN (Laptop)
window.switchToPinModal = function () {
    if (html5QrcodeScanner) {
        try {
            html5QrcodeScanner.clear();
        } catch (e) {}
        html5QrcodeScanner = null;
    }

    const qrContainer = document.getElementById("modal-qr-container");
    const pinContainer = document.getElementById("modal-pin-container");

    if (pinContainer) pinContainer.style.display = "block";
    if (qrContainer) qrContainer.style.display = "none";
};

// 6. Global Window Function: Submit Manual PIN (Laptop)
window.submitPinManual = function () {
    const overlay = document.getElementById("validation-overlay");
    const inputEl = document.getElementById("pin_input");

    if (!overlay || !inputEl) return;

    const validPin = overlay.dataset.pin;
    const inputPin = inputEl.value.trim();

    if (inputPin.toUpperCase() === validPin.toUpperCase()) {
        window.unlockMainAbsenForm();
    } else {
        Swal.fire({
            icon: "error",
            title: "PIN Salah",
            text: "Kode PIN Kelas tidak sesuai!",
            target: "#validation-overlay",
            customClass: {
                popup: "bg-dark text-white border border-secondary",
                title: "text-danger fw-bold",
                htmlContainer: "text-light",
            },
        });
    }
};

// 7. Inisialisasi Pengecekan GPS saat Halaman Diload
function initValidationGate() {
    const overlay = document.getElementById("validation-overlay");
    if (!overlay) return; // Exit mulus jika bukan di halaman input_absen

    const targetLat = parseFloat(overlay.dataset.lat);
    const targetLong = parseFloat(overlay.dataset.long);
    const maxRadius = 20000;
    const redirectUrl = overlay.dataset.redirectUrl;

    if (!navigator.geolocation) {
        Swal.fire(
            "Error GPS",
            "Browser Anda tidak mendukung Geolocation.",
            "error",
        );
        return;
    }

    navigator.geolocation.getCurrentPosition(
        (position) => {
            const userLat = position.coords.latitude;
            const userLong = position.coords.longitude;
            const distance = calculateHaversineDistance(
                userLat,
                userLong,
                targetLat,
                targetLong,
            );

            const gpsLoading = document.getElementById("gps-loading-status");
            if (gpsLoading) gpsLoading.style.display = "none";

            // Cek Toleransi Jarak GPS
            if (distance <= maxRadius) {
                // GPS LOLOS -> Auto Detect Perangkat
                if (isMobileDevice()) {
                    window.switchToQrModal();
                } else {
                    window.switchToPinModal();
                }
            } else {
                // GPS GAGAL -> SEMBUNYIKAN OVERLAY HITAM DULU SEBELUM SWAL MUNCUL
                overlay.style.display = "none";

                Swal.fire({
                    icon: "error",
                    title: "Akses Ditolak!",
                    html: `Anda berada di luar area sekolah.<br><b class="text-danger">Jarak Anda: ${Math.round(distance)} meter dari sekolah.</b>`,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    confirmButtonText:
                        '<i class="fas fa-arrow-left"></i> Kembali ke Dashboard',
                    confirmButtonColor: "#dc3545",
                    customClass: {
                        popup: "bg-dark text-white border border-secondary",
                        title: "text-danger fw-bold",
                        htmlContainer: "text-light",
                    },
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = redirectUrl;
                    }
                });
            }
        },
        (error) => {
            // Jika GPS Mati / Di-deny User
            overlay.style.display = "none";

            Swal.fire({
                icon: "warning",
                title: "GPS Terkunci",
                text: "Harap aktifkan/izinkan Akses Lokasi (GPS) di browser Anda!",
                confirmButtonText: "Coba Lagi",
                confirmButtonColor: "#ffc107",
                customClass: {
                    popup: "bg-dark text-white border border-secondary",
                    title: "text-warning fw-bold",
                    htmlContainer: "text-light",
                },
            }).then(() => {
                location.reload();
            });
        },
        { enableHighAccuracy: true },
    );
}

// Auto Event Listener
document.addEventListener("DOMContentLoaded", initValidationGate);

/**
 * Handler Klik Tombol Cetak Poster QR (Direct Download)
 * @param {HTMLElement} element
 */
window.handleQrClick = function (element) {
    const downloadUrl = element.getAttribute("data-url");

    fetch(downloadUrl, {
        headers: {
            "X-Requested-With": "XMLHttpRequest",
            Accept: "application/json",
        },
    })
        .then((response) =>
            response
                .json()
                .then((data) => ({ status: response.status, body: data })),
        )
        .then((res) => {
            if (res.status === 422) {
                // PIN KOSONG -> TAMPILKAN SWALFIRE WARNING KETERANGAN SAJA!
                Swal.fire({
                    icon: "warning",
                    title: "Kode PIN Belum Di-setting!",
                    html:
                        res.body.message +
                        '<br><small class="text-muted">Silakan isi Kode PIN kelas terlebih dahulu pada menu edit kelas.</small>',
                    confirmButtonText: "Oke, Mengerti",
                    confirmButtonColor: "#f59e0b",
                    customClass: {
                        popup: "bg-dark text-white border border-secondary",
                        title: "text-warning fw-bold",
                        htmlContainer: "text-light",
                    },
                });
            } else if (res.status === 200) {
                window.location.href = downloadUrl;
            }
        })
        .catch((error) => {
            console.error("QR Generator Error:", error);
            Swal.fire("Error", "Gagal memproses download QR.", "error");
        });
};

// Function Smooth Scroll ke Tombol Simpan Absensi
window.scrollToSimpan = function () {
    const btnSimpan = document.getElementById("btn-simpan-absen");
    if (btnSimpan) {
        btnSimpan.scrollIntoView({ behavior: "smooth", block: "center" });
    }
};
