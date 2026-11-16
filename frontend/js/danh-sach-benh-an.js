
async function taiDanhSachBenhAn() {
    const tbody = document.getElementById("danhSachBenhAn");
    const thongBao = document.getElementById("thongBao");

    try {
        const response = await fetch(
            "../backend/benh-an/danh-sach.php"
        );

        const result = await response.json();

        if (!response.ok || !result.thanh_cong) {
            throw new Error(
                result.thong_bao || "Không thể tải danh sách bệnh án"
            );
        }

        tbody.innerHTML = "";

        if (result.du_lieu.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="7">Chưa có bệnh án nào.</td>
                </tr>
            `;

            thongBao.textContent = "Có 0 bệnh án.";
            return;
        }

        result.du_lieu.forEach(function (benhAn) {
            const tr = document.createElement("tr");

            const cacCot = [
                benhAn.ma_so_benh_an,
                benhAn.ten_benh_nhan,
                benhAn.dia_chi_vi,
                benhAn.chan_doan,
                benhAn.ma_bam,
                benhAn.ma_giao_dich,
                benhAn.ngay_tao
            ];

            cacCot.forEach(function (giaTri, index) {
                const td = document.createElement("td");

                td.textContent = giaTri ?? "";

                if (index === 2) {
                    td.textContent =
                        giaTri
                            ? giaTri.slice(0, 10) + "..." + giaTri.slice(-6)
                            : "";
                }

                if (index === 4) {
                    td.className = "hash";
                }

                if (index === 5) {
                    td.className = "transaction";
                }

                tr.appendChild(td);
            });

            tbody.appendChild(tr);
        });

        thongBao.textContent =
            "Tổng số bệnh án: " + result.du_lieu.length;

    } catch (error) {
        console.error("Lỗi tải danh sách bệnh án:", error);

        thongBao.textContent = error.message;

        tbody.innerHTML = `
            <tr>
                <td colspan="7">Không thể tải dữ liệu.</td>
            </tr>
        `;
    }
}

document.addEventListener("DOMContentLoaded", function () {
    taiDanhSachBenhAn();
});
