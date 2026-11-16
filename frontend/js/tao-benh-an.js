
// ==========================================
// 1. TẢI DANH SÁCH BỆNH NHÂN
// ==========================================

async function taiDanhSachBenhNhan() {
    const select = document.getElementById("maBenhNhan");

    try {
        const response = await fetch(
            "../backend/benh-nhan/danh-sach.php"
        );

        const result = await response.json();

        if (!result.thanh_cong) {
            throw new Error(result.thong_bao || "Không thể tải bệnh nhân");
        }

        select.innerHTML =
            '<option value="">-- Chọn bệnh nhân --</option>';

        result.du_lieu.forEach(function (benhNhan) {
            const option = document.createElement("option");

            option.value = benhNhan.ma_benh_nhan;
            option.textContent =
                benhNhan.ma_benh_nhan + " - " + benhNhan.ho_ten;

            select.appendChild(option);
        });

        if (result.du_lieu.length === 0) {
            select.innerHTML =
                '<option value="">Chưa có bệnh nhân</option>';
        }

    } catch (error) {
        console.error("Lỗi tải bệnh nhân:", error);

        select.innerHTML =
            '<option value="">Lỗi tải danh sách bệnh nhân</option>';
    }
}


// ==========================================
// 2. TÍNH MÃ BĂM SHA-256
// ==========================================

async function tinhSHA256(noiDung) {
    const duLieu = new TextEncoder().encode(noiDung);

    const ketQua = await crypto.subtle.digest(
        "SHA-256",
        duLieu
    );

    return Array.from(new Uint8Array(ketQua))
        .map(byte => byte.toString(16).padStart(2, "0"))
        .join("");
}


// ==========================================
// 3. XỬ LÝ NÚT TẠO BỆNH ÁN
// ==========================================

document.getElementById("formBenhAn")
    .addEventListener("submit", async function (event) {

        event.preventDefault();

        const thongBao = document.getElementById("thongBao");
        const nutTao = this.querySelector('button[type="submit"]');

        try {

            // Kiểm tra MetaMask
            if (!window.ethereum || !diaChiVi) {
                throw new Error("Vui lòng kết nối MetaMask trước!");
            }

            const maSoBenhAn =
                document.getElementById("maSoBenhAn").value.trim();

            const maBenhNhan =
                document.getElementById("maBenhNhan").value;

            const trieuChung =
                document.getElementById("trieuChung").value.trim();

            const chanDoan =
                document.getElementById("chanDoan").value.trim();

            const phuongPhap =
                document.getElementById("phuongPhapDieuTri").value.trim();

            if (!maSoBenhAn || !maBenhNhan || !chanDoan) {
                throw new Error("Vui lòng nhập đầy đủ thông tin!");
            }

            nutTao.disabled = true;

            // Bước 1: Kết nối Smart Contract nếu chưa kết nối
            thongBao.textContent = "Đang kết nối Blockchain...";

            if (!medicalContract) {
                const contract = await ketNoiBlockchain();

                if (!contract) {
                    throw new Error("Không thể kết nối Smart Contract");
                }
            }

            // Bước 2: Chuẩn bị nội dung để tính SHA-256
            const noiDungBenhAn = JSON.stringify({
                maSoBenhAn: maSoBenhAn,
                maBenhNhan: Number(maBenhNhan),
                trieuChung: trieuChung,
                chanDoan: chanDoan,
                phuongPhapDieuTri: phuongPhap
            });

            // Bước 3: Tính mã băm SHA-256
            thongBao.textContent = "Đang tính mã SHA-256...";

            const maBam = await tinhSHA256(noiDungBenhAn);

            console.log("Mã SHA-256:", maBam);

            // Bước 4: Gửi mã băm lên Blockchain
            thongBao.textContent =
                "Vui lòng xác nhận giao dịch trên MetaMask...";

            const giaoDich = await medicalContract.createRecord(
                maSoBenhAn,
                "0x" + maBam
            );

            console.log("Transaction Hash:", giaoDich.hash);

            // Bước 5: Chờ giao dịch được xác nhận
            thongBao.textContent =
                "Đang chờ Blockchain xác nhận giao dịch...";

            const bienLai = await giaoDich.wait();

            if (!bienLai || bienLai.status !== 1) {
                throw new Error("Giao dịch Blockchain thất bại!");
            }

            console.log("Giao dịch thành công:", bienLai);

            // Bước 6: Lưu bệnh án vào MySQL
            thongBao.textContent =
                "Blockchain thành công. Đang lưu bệnh án vào MySQL...";

            const response = await fetch(
                "../backend/benh-an/tao.php",
                {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        ma_so_benh_an: maSoBenhAn,
                        ma_benh_nhan: maBenhNhan,
                        trieu_chung: trieuChung,
                        chan_doan: chanDoan,
                        phuong_phap_dieu_tri: phuongPhap,
                        dia_chi_vi: diaChiVi,
                        ma_bam: maBam,
                        ma_giao_dich: giaoDich.hash
                    })
                }
            );

            const ketQua = await response.json();

            if (!response.ok || !ketQua.thanh_cong) {
                throw new Error(
                    "Blockchain đã ghi nhận nhưng MySQL chưa lưu được: " +
                    (ketQua.thong_bao || "Lỗi không xác định")
                );
            }

            // Bước 7: Thông báo thành công
            thongBao.innerHTML = `
                <strong>Tạo bệnh án thành công!</strong><br><br>
                Mã bệnh án: ${maSoBenhAn}<br>
                Mã SHA-256: ${maBam}<br>
                Mã giao dịch: ${giaoDich.hash}
            `;

            this.reset();

            console.log("Lưu bệnh án thành công:", ketQua);

        } catch (error) {

            console.error("Lỗi tạo bệnh án:", error);

            thongBao.textContent = error.message;

        } finally {
            nutTao.disabled = false;
        }
    });


// ==========================================
// 4. KHỞI CHẠY
// ==========================================

document.addEventListener("DOMContentLoaded", function () {
    taiDanhSachBenhNhan();
});
