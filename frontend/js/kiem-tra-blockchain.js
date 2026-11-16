
let danhSachBenhAn = [];

// 1. Tải danh sách bệnh án từ MySQL
async function taiDanhSachBenhAn() {
    const select = document.getElementById("maBenhAn");

    try {
        const response = await fetch(
            "../backend/benh-an/danh-sach.php"
        );

        const result = await response.json();

        if (!response.ok || !result.thanh_cong) {
            throw new Error("Không thể tải danh sách bệnh án");
        }

        danhSachBenhAn = result.du_lieu;

        select.innerHTML =
            '<option value="">-- Chọn bệnh án --</option>';

        danhSachBenhAn.forEach(function (benhAn) {
            const option = document.createElement("option");

            option.value = benhAn.ma_so_benh_an;
            option.textContent =
                benhAn.ma_so_benh_an + " - " + benhAn.ten_benh_nhan;

            select.appendChild(option);
        });

        if (danhSachBenhAn.length === 0) {
            select.innerHTML =
                '<option value="">Chưa có bệnh án</option>';
        }

    } catch (error) {
        console.error(error);

        select.innerHTML =
            '<option value="">Lỗi tải danh sách</option>';
    }
}


// 2. Tính lại SHA-256 từ nội dung bệnh án
async function tinhLaiSHA256(benhAn) {
    // Phải giữ đúng thứ tự thuộc tính và cách tạo JSON
    // giống với lúc tạo bệnh án ban đầu.
    const noiDungBenhAn = JSON.stringify({
        maSoBenhAn: benhAn.ma_so_benh_an,
        maBenhNhan: Number(benhAn.ma_benh_nhan),
        trieuChung: benhAn.trieu_chung ?? "",
        chanDoan: benhAn.chan_doan,
        phuongPhapDieuTri: benhAn.phuong_phap_dieu_tri ?? ""
    });

    const duLieu = new TextEncoder().encode(noiDungBenhAn);

    const ketQua = await crypto.subtle.digest(
        "SHA-256",
        duLieu
    );

    return Array.from(new Uint8Array(ketQua))
        .map(byte => byte.toString(16).padStart(2, "0"))
        .join("");
}


// 3. Kiểm tra bệnh án trên Blockchain
async function kiemTraBlockchain() {
    const maBenhAn = document.getElementById("maBenhAn").value;
    const ketQua = document.getElementById("ketQua");
    const trangThai = document.getElementById("trangThai");
    const hashMySQL = document.getElementById("hashMySQL");
    const hashBlockchain = document.getElementById("hashBlockchain");
    const nutKiemTra = document.getElementById("btnKiemTra");

    ketQua.hidden = false;
    trangThai.textContent = "";
    hashMySQL.textContent = "";
    hashBlockchain.textContent = "";

    try {
        if (!maBenhAn) {
            throw new Error("Vui lòng chọn bệnh án cần kiểm tra!");
        }

        if (!window.ethereum || !diaChiVi) {
            throw new Error("Vui lòng kết nối MetaMask trước!");
        }

        nutKiemTra.disabled = true;
        trangThai.textContent = "Đang kiểm tra...";

        // Tìm bệnh án trong dữ liệu MySQL
        const benhAn = danhSachBenhAn.find(
            item => item.ma_so_benh_an === maBenhAn
        );

        if (!benhAn) {
            throw new Error("Không tìm thấy bệnh án trong MySQL!");
        }

        // Kết nối Smart Contract nếu chưa kết nối
        if (!medicalContract) {
            const contract = await ketNoiBlockchain();

            if (!contract) {
                throw new Error("Không thể kết nối Smart Contract!");
            }
        }

        // Tính lại mã SHA-256 từ nội dung MySQL
        const maBamMoi = await tinhLaiSHA256(benhAn);

        // Đọc mã băm gốc trực tiếp từ Blockchain
        const record = await medicalContract.getRecord(maBenhAn);

        const maBamBlockchain = record[0];

        hashMySQL.textContent = "0x" + maBamMoi;
        hashBlockchain.textContent = maBamBlockchain;

        // So sánh hai mã băm
        const hopLe = await medicalContract.verifyRecord(
            maBenhAn,
            "0x" + maBamMoi
        );

        if (hopLe) {
            trangThai.textContent =
                "BỆNH ÁN HỢP LỆ - DỮ LIỆU KHÔNG BỊ THAY ĐỔI";

            trangThai.className = "success";
        } else {
            trangThai.textContent =
                "CẢNH BÁO - DỮ LIỆU BỆNH ÁN ĐÃ BỊ THAY ĐỔI";

            trangThai.className = "error";
        }

    } catch (error) {
        console.error("Lỗi kiểm tra:", error);

        trangThai.textContent =
            "Không thể kiểm tra: " + error.message;

        trangThai.className = "error";

    } finally {
        nutKiemTra.disabled = false;
    }
}


// 4. Khởi tạo trang
document.addEventListener("DOMContentLoaded", function () {
    taiDanhSachBenhAn();

    document.getElementById("btnKiemTra")
        .addEventListener("click", kiemTraBlockchain);
});
