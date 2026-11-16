
<?php
header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../cau-hinh/ket-noi.php';

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Phuong thuc khong hop le');
    }

    $hoTen = trim($_POST['ho_ten'] ?? '');
    $gioiTinh = $_POST['gioi_tinh'] ?? 'Khac';
    $ngaySinh = $_POST['ngay_sinh'] ?? '';
    $soDienThoai = trim($_POST['so_dien_thoai'] ?? '');
    $diaChi = trim($_POST['dia_chi'] ?? '');

    if ($hoTen === '') {
        throw new Exception('Vui long nhap ho ten');
    }

    if (!in_array($gioiTinh, ['Nam', 'Nu', 'Khac'], true)) {
        throw new Exception('Gioi tinh khong hop le');
    }

    $sql = "INSERT INTO benh_nhan
            (ho_ten, gioi_tinh, ngay_sinh, so_dien_thoai, dia_chi)
            VALUES (?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    $stmt->execute([
        $hoTen,
        $gioiTinh,
        $ngaySinh ?: null,
        $soDienThoai ?: null,
        $diaChi ?: null
    ]);

    echo json_encode([
        'thanh_cong' => true,
        'thong_bao' => 'Them benh nhan thanh cong',
        'ma_benh_nhan' => $conn->lastInsertId()
    ], JSON_UNESCAPED_UNICODE);

} catch (Throwable $e) {
    http_response_code(400);

    echo json_encode([
        'thanh_cong' => false,
        'thong_bao' => $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
}
