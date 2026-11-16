
<?php
header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../cau-hinh/ket-noi.php';

try {
    $sql = "SELECT * FROM benh_nhan ORDER BY ma_benh_nhan DESC";
    $stmt = $conn->query($sql);

    echo json_encode([
        'thanh_cong' => true,
        'du_lieu' => $stmt->fetchAll()
    ], JSON_UNESCAPED_UNICODE);

} catch (Throwable $e) {
    http_response_code(500);

    echo json_encode([
        'thanh_cong' => false,
        'thong_bao' => $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
}
