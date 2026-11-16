
<?php
header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../cau-hinh/ket-noi.php';

try {
    $sql = "
        SELECT
            ba.ma_benh_an,
            ba.ma_so_benh_an,
            ba.ma_benh_nhan,
            bn.ho_ten AS ten_benh_nhan,
            ba.ma_bac_si,
            tk.dia_chi_vi,
            ba.trieu_chung,
            ba.chan_doan,
            ba.phuong_phap_dieu_tri,
            ba.ma_bam,
            ba.ma_giao_dich,
            ba.ngay_tao
        FROM benh_an ba
        INNER JOIN benh_nhan bn
            ON ba.ma_benh_nhan = bn.ma_benh_nhan
        INNER JOIN tai_khoan tk
            ON ba.ma_bac_si = tk.ma_tai_khoan
        ORDER BY ba.ma_benh_an DESC
    ";

    $stmt = $conn->query($sql);

    echo json_encode([
        'thanh_cong' => true,
        'du_lieu' => $stmt->fetchAll()
    ], JSON_UNESCAPED_UNICODE);

} catch (Throwable $e) {
    http_response_code(500);

    echo json_encode([
        'thanh_cong' => false,
        'thong_bao' => 'Không thể tải danh sách bệnh án'
    ], JSON_UNESCAPED_UNICODE);
}
