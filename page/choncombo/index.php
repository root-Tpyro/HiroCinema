<?php
require_once("class/classdb.php");
$db = new database();

// Kiểm tra dữ liệu POST gửi qua
$idsuat = isset($_POST['idsuatchieu']) ? $_POST['idsuatchieu'] : null;
$ds_ghe = isset($_POST['ds_ghe']) ? $_POST['ds_ghe'] : '';

if (!$idsuat || !$ds_ghe) {
    echo "<div class='container mt-4'><div class='alert alert-danger'>Dữ liệu không hợp lệ!</div></div>";
    exit;
}

// Lấy thông tin suất chiếu
$sql = "SELECT sc.idsuatchieu, sc.giobatdau, sc.ngaychieu, 
               pc.tenphong, cr.tenrap, cr.diachi
        FROM suatchieu sc
        JOIN phongchieu pc ON sc.idphong = pc.idphong
        JOIN cumrap cr ON pc.idrap = cr.idrap
        WHERE sc.idsuatchieu = $idsuat";
$thongtin = $db->laydong($sql);

// Lấy danh sách combo
$sql_combo = "SELECT * FROM combo ORDER BY tencombo ASC";
$dsCombo = $db->xuatdulieu($sql_combo);

// Tách ghế thành mảng nếu cần hiển thị từng ghế
$ds_ghe_array = explode(',', $ds_ghe);
?>

<!-- Giao diện Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-4">
    <h3 class="text-center">🍿 <strong>CHỌN COMBO ĐỒ ĂN</strong></h3>

    <p><strong>Rạp:</strong> <?php echo htmlspecialchars($thongtin['tenrap']); ?></p>
    <p><strong>Địa chỉ:</strong> <?php echo htmlspecialchars($thongtin['diachi']); ?></p>
    <p><strong>Phòng chiếu:</strong> <?php echo htmlspecialchars($thongtin['tenphong']); ?></p>
    <p><strong>Ngày:</strong> <?php echo date("d/m/Y", strtotime($thongtin['ngaychieu'])); ?> - 
       <strong>Giờ:</strong> <?php echo $thongtin['giobatdau']; ?></p>
    <p><strong>Ghế đã chọn:</strong> 
        <?php 
        echo implode(", ", array_map('trim', $ds_ghe_array)); 
        ?>
    </p>

    <form action="index.php?page=thanhtoan" method="post">
        <input type="hidden" name="idsuatchieu" value="<?php echo $idsuat; ?>">
        <input type="hidden" name="ds_ghe" value="<?php echo htmlspecialchars($ds_ghe); ?>">

        <div class="row">
            <?php
            if ($dsCombo) {
                foreach ($dsCombo as $combo) {
            ?>
            <div class="col-md-4 mb-4">
    <div class="card h-100 shadow-sm">
        <?php if (!empty($combo['hinhanh'])): ?>
            <img width="150" height="250" src="assets/images/<?php echo htmlspecialchars($combo['hinhanh']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($combo['tencombo']); ?>">
        <?php else: ?>
            <img src="images/combo/default.png" class="card-img-top" alt="Combo không có hình">
        <?php endif; ?>
        <div class="card-body">
            <h5 class="card-title text-center"><strong><?php echo htmlspecialchars($combo['tencombo']); ?></strong></h5>
            <p class="card-text"><?php echo htmlspecialchars($combo['mota']); ?></p>
            <p><strong>Giá:</strong> <?php echo number_format($combo['giacombo']); ?> đ</p>
            <div class="form-group">
                <label for="combo_<?php echo $combo['idcombo']; ?>">Số lượng:</label>
                <input type="number" class="form-control" name="combo[<?php echo $combo['idcombo']; ?>]" min="0" value="0">
            </div>
        </div>
    </div>
</div>

            <?php
                }
            } else {
                echo "<div class='alert alert-warning'>Không có combo nào khả dụng!</div>";
            }
            ?>
        </div>

        <div class="text-center mt-4 mb-4">
            <button type="submit" class="btn btn-primary">Tiếp tục thanh toán</button>
        </div>
    </form>
</div>
