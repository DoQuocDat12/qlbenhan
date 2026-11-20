
<?php
header('Content-Type: application/json; charset=utf-8');
//file kết nối
require_once __DIR__ . '/../cau-hinh/ket-noi.php';

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        throw new Exception('Phương thức không hợp lệ');
    }

    $data = json_decode(file_get_contents('php://input'), true);

    if (!is_array($data)) {
        throw new Exception('Dữ liệu gửi lên không hợp lệ');
    }

    $maSoBenhAn = trim($data['ma_so_benh_an'] ?? '');
    $maBenhNhan = (int)($data['ma_benh_nhan'] ?? 0);
    $trieuChung = trim($data['trieu_chung'] ?? '');
    $chanDoan = trim($data['chan_doan'] ?? '');
    $phuongPhap = trim($data['phuong_phap_dieu_tri'] ?? '');
    $diaChiVi = strtolower(trim($data['dia_chi_vi'] ?? ''));
    $maBam = strtolower(trim($data['ma_bam'] ?? ''));
    $maGiaoDich = strtolower(trim($data['ma_giao_dich'] ?? ''));

    if (
        $maSoBenhAn === '' ||
        $maBenhNhan <= 0 ||
        $chanDoan === ''
    ) {
        throw new Exception('Vui lòng nhập đầy đủ thông tin bệnh án');
    }

    if (!preg_match('/^0x[a-f0-9]{40}$/', $diaChiVi)) {
        throw new Exception('Địa chỉ ví không hợp lệ');
    }

    if (!preg_match('/^[a-f0-9]{64}$/', $maBam)) {
        throw new Exception('Mã SHA-256 không hợp lệ');
    }

    if (!preg_match('/^0x[a-f0-9]{64}$/', $maGiaoDich)) {
        throw new Exception('Mã giao dịch không hợp lệ');
    }

    $conn->beginTransaction();

    // Tìm hoặc tạo tài khoản bác sĩ theo địa chỉ ví
    $sqlTaiKhoan = "
        INSERT INTO tai_khoan (dia_chi_vi, ho_ten)
        VALUES (:dia_chi_vi, 'Bác sĩ MetaMask')
        ON DUPLICATE KEY UPDATE
            ma_tai_khoan = LAST_INSERT_ID(ma_tai_khoan)
    ";

    $stmtTaiKhoan = $conn->prepare($sqlTaiKhoan);
    $stmtTaiKhoan->execute([
        ':dia_chi_vi' => $diaChiVi
    ]);

    $maBacSi = (int)$conn->lastInsertId();

    // Lưu bệnh án
    $sql = "
        INSERT INTO benh_an (
            ma_so_benh_an,
            ma_benh_nhan,
            ma_bac_si,
            trieu_chung,
            chan_doan,
            phuong_phap_dieu_tri,
            ma_bam,
            ma_giao_dich
        ) VALUES (
            :ma_so_benh_an,
            :ma_benh_nhan,
            :ma_bac_si,
            :trieu_chung,
            :chan_doan,
            :phuong_phap_dieu_tri,
            :ma_bam,
            :ma_giao_dich
        )
    ";

    $stmt = $conn->prepare($sql);

    $stmt->execute([
        ':ma_so_benh_an' => $maSoBenhAn,
        ':ma_benh_nhan' => $maBenhNhan,
        ':ma_bac_si' => $maBacSi,
        ':trieu_chung' => $trieuChung,
        ':chan_doan' => $chanDoan,
        ':phuong_phap_dieu_tri' => $phuongPhap,
        ':ma_bam' => $maBam,
        ':ma_giao_dich' => $maGiaoDich
    ]);

    $conn->commit();

    echo json_encode([
        'thanh_cong' => true,
        'thong_bao' => 'Tạo bệnh án thành công',
        'ma_so_benh_an' => $maSoBenhAn,
        'ma_bam' => $maBam,
        'ma_giao_dich' => $maGiaoDich
    ], JSON_UNESCAPED_UNICODE);

} catch (Throwable $e) {

    if ($conn->inTransaction()) {
        $conn->rollBack();
    }

    http_response_code(400);

    echo json_encode([
        'thanh_cong' => false,
        'thong_bao' => $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
}
