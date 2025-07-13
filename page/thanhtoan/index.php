<?php
require_once("class/classdb.php");
$db = new database();

$idsuat = isset($_POST['idsuatchieu']) ? $_POST['idsuatchieu'] : null;
$ds_ghe = isset($_POST['ds_ghe']) ? $_POST['ds_ghe'] : '';
$combo_da_chon = isset($_POST['combo']) ? $_POST['combo'] : array();

if (!$idsuat || $ds_ghe == '') {
    echo "<div class='container mt-4'><div class='alert alert-danger'>Thiếu thông tin để thanh toán.</div></div>";
    return;
}

// Lấy thông tin suất chiếu và phim
$sql = "SELECT sc.idsuatchieu, sc.giobatdau, sc.ngaychieu, sc.idphim,
               p.tenphim, p.thoiluong, pc.tenphong, cr.tenrap, cr.diachi
        FROM suatchieu sc
        JOIN phongchieu pc ON sc.idphong = pc.idphong
        JOIN cumrap cr ON pc.idrap = cr.idrap
        JOIN phim p ON sc.idphim = p.idphim
        WHERE sc.idsuatchieu = $idsuat";

$thongtin = $db->laydong($sql);

// Lấy danh sách ghế
$arr_ghe_id = explode(',', $ds_ghe);
$ds_ghe_text = array();
$tong_tien_ve = 0;

foreach ($arr_ghe_id as $tenghe) {
    $tenghe = trim($tenghe);
    $ghe = $db->laydong("SELECT * FROM ghe WHERE tenghe = '$tenghe'");
    if ($ghe) {
        $ds_ghe_text[] = $ghe['tenghe'];
        $tong_tien_ve += (strtolower($ghe['loaighe']) == 'vip') ? 104000 : 85000;
    }
}

// Tính tiền combo
$tong_tien_combo = 0;
$combo_chi_tiet = array();
foreach ($combo_da_chon as $idcombo => $soluong) {
    $idcombo = intval($idcombo);
    $soluong = intval($soluong);
    if ($soluong > 0) {
        $combo = $db->laydong("SELECT * FROM combo WHERE idcombo = $idcombo");
        if ($combo) {
            $thanhtien = $combo['giacombo'] * $soluong;
            $tong_tien_combo += $thanhtien;
            $combo_chi_tiet[] = array(
                'tencombo' => $combo['tencombo'],
                'gia' => $combo['giacombo'],
                'soluong' => $soluong,
                'thanhtien' => $thanhtien
            );
        }
    }
}

$tong_tien = $tong_tien_ve + $tong_tien_combo;
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-4">
    <h3 class="text-center mb-4">🧾 <strong>THÔNG TIN THANH TOÁN</strong></h3>

    <div class="card mb-4">
        <div class="card-header bg-primary text-white"><strong>🎬 Thông tin suất chiếu</strong></div>
        <div class="card-body">
            <p><strong>Tên phim:</strong> <?php echo htmlspecialchars($thongtin['tenphim']); ?></p>
            <p><strong>Thời lượng:</strong> <?php echo $thongtin['thoiluong']; ?> phút</p>
            <p><strong>Suất chiếu:</strong> <?php echo date("d/m/Y", strtotime($thongtin['ngaychieu'])) . ' - ' . $thongtin['giobatdau']; ?></p>
            <p><strong>Phòng chiếu:</strong> <?php echo $thongtin['tenphong']; ?></p>
            <p><strong>Rạp:</strong> <?php echo $thongtin['tenrap']; ?></p>
            <p><strong>Địa chỉ:</strong> <?php echo $thongtin['diachi']; ?></p>
            <p><strong>Ghế đã chọn:</strong> <?php echo implode(', ', $ds_ghe_text); ?></p>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header bg-success text-white"><strong>💺 Vé xem phim</strong></div>
        <div class="card-body">
            <p><strong>Số lượng:</strong> <?php echo count($ds_ghe_text); ?> ghế</p>
            <p><strong>Thành tiền:</strong> <?php echo number_format($tong_tien_ve); ?> đ</p>
        </div>
    </div>

    <?php if (!empty($combo_chi_tiet)) : ?>
    <div class="card mb-4">
        <div class="card-header bg-warning"><strong>🥤 Đồ uống & Combo</strong></div>
        <div class="card-body">
            <ul class="list-group">
                <?php foreach ($combo_chi_tiet as $i => $cb) : ?>
                    <li class="list-group-item">
                        <?php echo $cb['tencombo']; ?> x <?php echo $cb['soluong']; ?> 
                        = <strong><?php echo number_format($cb['thanhtien']); ?> đ</strong>
                    </li>
                <?php endforeach; ?>
            </ul>
            <p class="mt-2"><strong>Thành tiền:</strong> <?php echo number_format($tong_tien_combo); ?> đ</p>
        </div>
    </div>
    <?php endif; ?>

    <div class="card mb-4">
        <div class="card-header bg-dark text-white"><strong>💰 Tổng thanh toán</strong></div>
        <div class="card-body">
            <h4 class="text-danger"><strong><?php echo number_format($tong_tien); ?> đ</strong></h4>
        </div>
    </div>

    <div class="text-center">
        <form action="index.php?page=chonhinhthuc" method="post">
   <input type="hidden" name="idsuatchieu" value="<?php echo $idsuat; ?>">
    <input type="hidden" name="ds_ghe" value="<?php echo $ds_ghe; ?>">
    <input type="hidden" name="tong_tien" value="<?php echo $tong_tien; ?>">
    <input type="hidden" name="ten_phim" value="<?php echo htmlspecialchars($thongtin['tenphim']); ?>">
    <input type="hidden" name="ten_rap" value="<?php echo htmlspecialchars($thongtin['tenrap']); ?>">
    <input type="hidden" name="phong" value="<?php echo htmlspecialchars($thongtin['tenphong']); ?>">
    <input type="hidden" name="ngay_chieu" value="<?php echo $thongtin['ngaychieu']; ?>">
    <input type="hidden" name="gio_chieu" value="<?php echo $thongtin['giobatdau']; ?>">
    
    <?php foreach ($combo_da_chon as $idcombo => $soluong): ?>
        <input type="hidden" name="combo[<?php echo $idcombo; ?>]" value="<?php echo $soluong; ?>">
    <?php endforeach; ?>
    
    <input type="hidden" name="phuong_thuc" value="quet_qr"> <!-- hoặc bạn lấy từ form chọn phương thức -->
<div class="pb-3"><button type="submit" class="btn btn-primary ms-2">Thanh toán ngay</button>
<a href="index.php" class="btn btn-secondary">← Quay về trang chủ</a>
</div>
</form>


    </div>
</div>
