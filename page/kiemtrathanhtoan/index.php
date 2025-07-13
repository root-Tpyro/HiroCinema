<?php
header('Content-Type: application/json; charset=utf-8');

$idsuat = $_GET['idsuatchieu'] ?? null;
$ds_ghe = $_GET['ds_ghe'] ?? null;

if (!$idsuat || !$ds_ghe) {
    echo json_encode(['status' => 'error', 'message' => 'Thiếu tham số']);
    exit;
}

$conn = new mysqli("localhost", "root", "", "cinema");
if ($conn->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Kết nối DB thất bại']);
    exit;
}

// Chuẩn hóa ds_ghe (đảm bảo giống định dạng trong DB, ví dụ: A1,A2)
$sql = "SELECT trang_thai FROM giaodich 
        WHERE idsuatchieu = ? AND ds_ghe = ? AND trang_thai = 'da_thanh_toan' LIMIT 1";

$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $idsuat, $ds_ghe);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'pending']);
}

$stmt->close();
$conn->close();
?>
