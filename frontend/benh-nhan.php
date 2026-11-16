
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý bệnh nhân</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="container">
    <h1>Quản lý bệnh nhân</h1>

    <form id="formBenhNhan">
        <input type="text" name="ho_ten" placeholder="Họ và tên" required>

        <select name="gioi_tinh">
            <option value="Nam">Nam</option>
            <option value="Nu">Nữ</option>
            <option value="Khac">Khác</option>
        </select>

        <label>Ngày sinh</label>
        <input type="date" name="ngay_sinh">

        <input type="text" name="so_dien_thoai"
               placeholder="Số điện thoại">

        <input type="text" name="dia_chi"
               placeholder="Địa chỉ">

        <button type="submit">Thêm bệnh nhân</button>
    </form>

    <h2>Danh sách bệnh nhân</h2>

    <table>
        <thead>
            <tr>
                <th>Mã</th>
                <th>Họ tên</th>
                <th>Giới tính</th>
                <th>Ngày sinh</th>
                <th>Số điện thoại</th>
                <th>Địa chỉ</th>
            </tr>
        </thead>
        <tbody id="danhSachBenhNhan"></tbody>
    </table>
</div>

<script>
const form = document.getElementById('formBenhNhan');

async function taiDanhSach() {
    const response = await fetch('../backend/benh-nhan/danh-sach.php');
    const result = await response.json();

    const tbody = document.getElementById('danhSachBenhNhan');
    tbody.innerHTML = '';

    if (result.thanh_cong) {
        result.du_lieu.forEach(bn => {
            const row = document.createElement('tr');

            [
                bn.ma_benh_nhan,
                bn.ho_ten,
                bn.gioi_tinh === 'Nu' ? 'Nữ' : bn.gioi_tinh,
                bn.ngay_sinh || '',
                bn.so_dien_thoai || '',
                bn.dia_chi || ''
            ].forEach(value => {
                const cell = document.createElement('td');
                cell.textContent = value;
                row.appendChild(cell);
            });

            tbody.appendChild(row);
        });
    }
}

form.addEventListener('submit', async function(e) {
    e.preventDefault();

    const response = await fetch('../backend/benh-nhan/them.php', {
        method: 'POST',
        body: new FormData(form)
    });

    const result = await response.json();

    alert(result.thong_bao);

    if (result.thanh_cong) {
        form.reset();
        taiDanhSach();
    }
});

taiDanhSach();
</script>

</body>
</html>
