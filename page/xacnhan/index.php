<title>Thông tin vé</title>
<?php
class dt3 {
    public $conn;

    public function __construct() {
        $this->conn = new mysqli("localhost", "root", "", "cinema");

        if ($this->conn->connect_error) {
            die("Kết nối thất bại: " . $this->conn->connect_error);
        }

        $this->conn->set_charset("utf8");
    }

    public function thuchien($sql) {
        return $this->conn->query($sql);
    }

    public function laydong($sql) {
        $result = $this->conn->query($sql);
        return $result ? $result->fetch_assoc() : null;
    }

    public function xuatdulieu($sql) {
        return $this->conn->query($sql);
    }
}

$db = new dt3();

$idsuat = isset($_POST['idsuatchieu']) ? $_POST['idsuatchieu'] : null;
$ds_ghe = isset($_POST['ds_ghe']) ? $_POST['ds_ghe'] : '';
$tong_tien = isset($_POST['tong_tien']) ? $_POST['tong_tien'] : 0;
$tenphim = isset($_POST['ten_phim']) ? $_POST['ten_phim'] : '';
$tenrap = isset($_POST['ten_rap']) ? $_POST['ten_rap'] : '';
$tenphong = isset($_POST['phong']) ? $_POST['phong'] : '';
$ngaychieu = isset($_POST['ngay_chieu']) ? $_POST['ngay_chieu'] : '';
$giochieu = isset($_POST['gio_chieu']) ? $_POST['gio_chieu'] : '';
$combo_da_chon = isset($_POST['combo']) ? $_POST['combo'] : array();
$idkh = isset($_SESSION['idkh']) ? $_SESSION['idkh'] : null;
$ngaydat = date('Y-m-d');

if (!$idkh) {
    echo "<div class='alert alert-danger'>Bạn cần đăng nhập để lưu vé.</div>";
    return;
}

// Bước 1: lấy idphong từ idsuatchieu
$suat = $db->laydong("SELECT idphong FROM suatchieu WHERE idsuatchieu = $idsuat");
$idphong = isset($suat['idphong']) ? $suat['idphong'] : null;


if (!$idphong) {
    echo "<div class='alert alert-danger'>Không tìm thấy phòng chiếu.</div>";
    return;
}

$ds_ghe_text = explode(',', $ds_ghe);

// Bước 2: lưu từng vé theo tên ghế
foreach ($ds_ghe_text as $tenghe) {
    $tenghe = trim($tenghe);
    // Tìm idghe từ tenghe và idphong
    $ghe = $db->laydong("SELECT idghe FROM ghe WHERE tenghe = '$tenghe' AND idphong = $idphong");
    if (!$ghe) {
        echo "<div class='alert alert-warning'>Không tìm thấy ghế $tenghe trong phòng $idphong.</div>";
        continue;
    }

    $idghe = $ghe['idghe'];

    // Chèn vào bảng ve
    $sql = "INSERT INTO ve (idkh, idsuatchieu, idghe, tongtien, ngaydat) 
            VALUES ($idkh, $idsuat, $idghe, $tong_tien, '$ngaydat')";
    $db->xuatdulieu($sql);

    // Cập nhật trạng thái ghế
    $sql_update = "UPDATE ghe SET trangthai = '1' WHERE idghe = $idghe";
if (!$db->xuatdulieu($sql_update)) {
    echo "<div class='alert alert-danger'>Lỗi cập nhật trạng thái cho ghế $tenghe</div>";
}

}

if (!$idsuat || $ds_ghe == '') {
    echo "<div class='container mt-4'><div class='alert alert-danger'>Thiếu thông tin xác nhận.</div></div>";
    return;
}

$combo_chi_tiet = array();

foreach ($combo_da_chon as $idcombo => $soluong) {
    $combo = $db->laydong("SELECT * FROM combo WHERE idcombo = " . intval($idcombo));
    if ($combo && intval($soluong) > 0) {
        $thanhtien = intval($combo['giacombo']) * intval($soluong); // ✅ Tính thành tiền

        array_push($combo_chi_tiet, array(
            'tencombo' => $combo['tencombo'],
            'gia' => $combo['giacombo'],
            'soluong' => $soluong,
            'thanhtien' => $thanhtien
        ));
    }
}

$bd= date('d/m/Y', strtotime($ngaychieu));
// Tạo chuỗi thông tin để mã hóa QR (nếu cần)
$qr_text = "Phim: $tenphim\nRạp: $tenrap\nPhong: $tenphong\nNgay: $bd\nGiờ: $giochieu\nGhế: " . implode(', ', $ds_ghe_text) . "\nTotal: " . number_format($tong_tien) . "VND";

// Sử dụng API tạo QR miễn phí (ví dụ quickchart)
$qr_text_utf8 = mb_convert_encoding($qr_text, 'UTF-8', 'auto');
$qr_url = "https://quickchart.io/qr?text=" . rawurlencode($qr_text_utf8) . "&size=200";


?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-4">
    <h3 class="text-center mb-4 text-success">✅ <strong>XÁC NHẬN THANH TOÁN THÀNH CÔNG</strong></h3>

    <div class="card mb-4">
        <div class="card-header bg-primary text-white"><strong>🎬 Thông tin vé</strong></div>
        <div class="card-body">
            <p><strong>Phim:</strong> <?php echo htmlspecialchars($tenphim); ?></p>
            <p><strong>Rạp:</strong> <?php echo htmlspecialchars($tenrap); ?></p>
            <p><strong>Phòng chiếu:</strong> <?php echo htmlspecialchars($tenphong); ?></p>
            <p><strong>Ngày chiếu:</strong> <?php echo date('d/m/Y', strtotime($ngaychieu)); ?></p>
            <p><strong>Giờ chiếu:</strong> <?php echo $giochieu; ?></p>
            <p><strong>Ghế:</strong> <?php echo implode(', ', $ds_ghe_text); ?></p>
        </div>
    </div>


    <div class="card mb-4">
        <div class="card-header bg-dark text-white"><strong>💰 Tổng tiền đã thanh toán</strong></div>
        <div class="card-body">
            <h4 class="text-danger"><strong><?php echo number_format($tong_tien); ?> đ</strong></h4>
        </div>
    </div>

    <div class="text-center mt-4">
        <h5 class="mb-3">🎟️ Mã QR vé xem phim</h5>
        <img src="<?php echo $qr_url; ?>" alt="QR Code vé" class="border rounded" />
        <p class="mt-3">Vui lòng đưa mã này khi vào rạp để kiểm tra vé.</p>
    </div>

    <div class="text-center mt-4 pb-3">
        <a href="index.php" class="btn btn-success">🏠 Quay về trang chủ</a>
    </div>
</div>
