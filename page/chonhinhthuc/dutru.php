<?php
// Nhận dữ liệu từ trang thanh toán
$idsuat = isset($_POST['idsuatchieu']) ? $_POST['idsuatchieu'] : null;
$ds_ghe = isset($_POST['ds_ghe']) ? $_POST['ds_ghe'] : '';
$tong_tien = isset($_POST['tong_tien']) ? $_POST['tong_tien'] : 0;
$combo_da_chon = isset($_POST['combo']) ? $_POST['combo'] : array();
$tenphim = isset($_POST['ten_phim']) ? $_POST['ten_phim'] : '';
$tenrap = isset($_POST['ten_rap']) ? $_POST['ten_rap'] : '';
$tenphong = isset($_POST['phong']) ? $_POST['phong'] : '';
$ngaychieu = isset($_POST['ngay_chieu']) ? $_POST['ngay_chieu'] : '';
$giochieu = isset($_POST['gio_chieu']) ? $_POST['gio_chieu'] : '';



if (!$idsuat || !$ds_ghe) {
    echo "<div class='container mt-4'><div class='alert alert-danger'>Dữ liệu không hợp lệ!</div></div>";
    exit;
}
// Kết nối CSDL
$mysqli = new mysqli("localhost", "root", "", "cinema"); // sửa tên CSDL

if ($mysqli->connect_errno) {
    die("Lỗi kết nối CSDL: " . $mysqli->connect_error);
}

// Lấy idphong dựa vào idsuatchieu nếu chưa có sẵn
if (!isset($idphong)) {
    $sql_phong = "SELECT idphong FROM suatchieu WHERE idsuatchieu = ?";
    $stmt_phong = $mysqli->prepare($sql_phong);
    $stmt_phong->bind_param("i", $idsuat);
    $stmt_phong->execute();
    $stmt_phong->bind_result($idphong);
    $stmt_phong->fetch();
    $stmt_phong->close();
}

// Tách danh sách tên ghế (A1,B2,...)
$ds_ghe_arr = explode(',', $ds_ghe);

foreach ($ds_ghe_arr as $tenghe) {
    $tenghe = trim($tenghe);

    if ($tenghe !== '') {
        $sql = "UPDATE ghe SET trangthai = '1' WHERE tenghe = ? AND idphong = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("si", $tenghe, $idphong);
        if ($stmt->execute()) {
            echo "";
        } else {
            echo "❌ Lỗi cập nhật $tenghe: " . $stmt->error;
        }
        $stmt->close();
    }
}

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chọn phương thức thanh toán</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h3 class="text-center mb-4">🧾 <strong>CHỌN PHƯƠNG THỨC THANH TOÁN</strong></h3>

    <form action="index.php?page=xacnhan" method="post">
        <!-- Dữ liệu ẩn -->
        <input type="hidden" name="idsuatchieu" value="<?php echo $idsuat; ?>">
        <input type="hidden" name="ds_ghe" value="<?php echo htmlspecialchars($ds_ghe); ?>">
        <input type="hidden" name="tong_tien" value="<?php echo $tong_tien; ?>">

        <input type="hidden" name="ten_phim" value="<?php echo htmlspecialchars($tenphim); ?>">
        <input type="hidden" name="ten_rap" value="<?php echo htmlspecialchars($tenrap); ?>">
        <input type="hidden" name="phong" value="<?php echo htmlspecialchars($tenphong); ?>">
        <input type="hidden" name="ngay_chieu" value="<?php echo htmlspecialchars($ngaychieu); ?>">
        <input type="hidden" name="gio_chieu" value="<?php echo htmlspecialchars($giochieu); ?>">

        <?php foreach ($combo_da_chon as $idcombo => $soluong): ?>
            <input type="hidden" name="combo[<?php echo $idcombo; ?>]" value="<?php echo $soluong; ?>">
        <?php endforeach; ?>

        <div class="card">
            <div class="card-header bg-info text-white"><strong>💳 Chọn phương thức thanh toán</strong></div>
            <div class="card-body">
                <div class="form-check mb-3">
                    <input class="form-check-input" type="radio" name="phuong_thuc" id="pt_qr" value="qr" checked onclick="showMethod('qr')">
                    <label class="form-check-label" for="pt_qr">
                        Thanh toán bằng mã QR
                    </label>
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input" type="radio" name="phuong_thuc" id="pt_the" value="the" onclick="showMethod('the')">
                    <label class="form-check-label" for="pt_the">
                        Thanh toán bằng thẻ ngân hàng (ATM, Visa, MasterCard)
                    </label>
                </div>

                <div class="form-check mb-4">
                    <input class="form-check-input" type="radio" name="phuong_thuc" id="pt_taicho" value="tienmat" onclick="showMethod('tienmat')">
                    <label class="form-check-label" for="pt_taicho">
                        Thanh toán tại quầy (tiền mặt)
                    </label>
                </div>

                <!-- Giao diện QR -->
                <?php
    // Cấu hình tài khoản nhận tiền
    $so_tai_khoan = '101869204902';
    $ngan_hang = 'Vietinbank';       
    $ten_nguoi_nhan = 'HIRO CINEMA';
    $noi_dung = 'Thanh toan ve phim';

    // Tạo URL QR
    $qr_url = "https://img.vietqr.io/image/{$ngan_hang}-{$so_tai_khoan}-compact2.jpg?amount={$tong_tien}&addInfo=" . urlencode($noi_dung) . "&accountName=" . urlencode($ten_nguoi_nhan);
?>
<div id="method_qr" class="border rounded p-3 bg-light mb-3">
    <p>Vui lòng quét mã QR sau để thanh toán <strong><?php echo number_format($tong_tien); ?> VNĐ</strong>:</p>
    <div class="text-center">
        <img src="<?php echo $qr_url; ?>" alt="QR Code" class="img-fluid" style="max-width:200px;">
    </div>
    <p class="text-center mt-2 text-muted">Hệ thống sẽ xác nhận giao dịch sau khi bạn hoàn tất thanh toán.</p>
</div>


                <!-- Giao diện thẻ ngân hàng -->
                <div id="method_the" class="border rounded p-3 bg-light mb-3" style="display:none;">
                    <div class="mb-3">
                        <label for="so_the" class="form-label">Số thẻ</label>
                        <input type="text" class="form-control" id="so_the" name="so_the" placeholder="Nhập số thẻ...">
                    </div>
                    <div class="mb-3">
                        <label for="chu_the" class="form-label">Tên chủ thẻ</label>
                        <input type="text" class="form-control" id="chu_the" name="chu_the" placeholder="Nhập tên chủ thẻ...">
                    </div>
                    <div class="mb-3">
                        <label for="ngay_het_han" class="form-label">Ngày hết hạn</label>
                        <input type="text" class="form-control" id="ngay_het_han" name="ngay_het_han" placeholder="MM/YY">
                    </div>
                    <div class="mb-3">
                        <label for="cvv" class="form-label">CVV</label>
                        <input type="password" class="form-control" id="cvv" name="cvv" placeholder="***">
                    </div>
                </div>

                <!-- Giao diện thanh toán tiền mặt -->
                <div id="method_tienmat" class="border rounded p-3 bg-light mb-3" style="display:none;">
                    <p>Bạn sẽ thanh toán bằng tiền mặt tại quầy trước giờ chiếu. Vui lòng đến sớm ít nhất 15 phút.</p>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-success">✅ Tiếp tục thanh toán</button>
                </div>
            </div>
        </div>
    </form>

    <div class="text-center mt-4 pb-3">
        <a href="index.php" class="btn btn-secondary">← Quay về trang chủ</a>
    </div>
</div>

<script>
function showMethod(method) {
    document.getElementById('method_qr').style.display = (method === 'qr') ? 'block' : 'none';
    document.getElementById('method_the').style.display = (method === 'the') ? 'block' : 'none';
    document.getElementById('method_tienmat').style.display = (method === 'tienmat') ? 'block' : 'none';
}
</script>
</body>
</html>
<script>
let thanhToanXong = false;

setInterval(function () {
    if (!thanhToanXong && document.querySelector('input[name="phuong_thuc"]:checked').value === 'qr') {
        fetch('kiemtrathanhtoan.php?idsuatchieu=<?php echo $idsuat; ?>')
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    thanhToanXong = true;
                    alert('✅ Đã xác nhận thanh toán. Chuyển đến trang xác nhận...');
                    document.querySelector('form').submit();
                }
            })
            .catch(error => console.error('Lỗi kiểm tra thanh toán:', error));
    }
}, 5000);
</script>







<?php

$idsuat = $_POST['suat'];
$ds_ghe = $_POST['ds_ghe'];
$combo = $_POST['combo'];
$tong_tien = $_POST['tong_tien'];

// Kết nối DB
$mysqli = new mysqli("localhost", "root", "", "cinema");

// Kiểm tra nếu chưa có giao dịch thì chèn mới
$sql_check = "SELECT * FROM giaodich WHERE idsuatchieu = ? AND ds_ghe = ?";
$stmt_check = $mysqli->prepare($sql_check);
$stmt_check->bind_param("is", $idsuat, $ds_ghe);
$stmt_check->execute();
$stmt_check->store_result();
if ($stmt_check->num_rows === 0) {
    $sql_insert = "INSERT INTO giaodich (idsuatchieu, ds_ghe, tong_tien, trang_thai) VALUES (?, ?, ?, 'cho_thanh_toan')";
    $stmt_insert = $mysqli->prepare($sql_insert);
    $stmt_insert->bind_param("isd", $idsuat, $ds_ghe, $tong_tien);
    $stmt_insert->execute();
    $stmt_insert->close();
}

// Nhận dữ liệu từ trang thanh toán
$idsuat = isset($_POST['idsuatchieu']) ? $_POST['idsuatchieu'] : null;
$ds_ghe = isset($_POST['ds_ghe']) ? $_POST['ds_ghe'] : '';
$tong_tien = isset($_POST['tong_tien']) ? $_POST['tong_tien'] : 0;
$combo_da_chon = isset($_POST['combo']) ? $_POST['combo'] : array();
$tenphim = isset($_POST['ten_phim']) ? $_POST['ten_phim'] : '';
$tenrap = isset($_POST['ten_rap']) ? $_POST['ten_rap'] : '';
$tenphong = isset($_POST['phong']) ? $_POST['phong'] : '';
$ngaychieu = isset($_POST['ngay_chieu']) ? $_POST['ngay_chieu'] : '';
$giochieu = isset($_POST['gio_chieu']) ? $_POST['gio_chieu'] : '';



if (!$idsuat || !$ds_ghe) {
    echo "<div class='container mt-4'><div class='alert alert-danger'>Dữ liệu không hợp lệ!</div></div>";
    exit;
}
// Kết nối CSDL
$mysqli = new mysqli("localhost", "root", "", "cinema"); // sửa tên CSDL

if ($mysqli->connect_errno) {
    die("Lỗi kết nối CSDL: " . $mysqli->connect_error);
}

// Lấy idphong dựa vào idsuatchieu nếu chưa có sẵn
if (!isset($idphong)) {
    $sql_phong = "SELECT idphong FROM suatchieu WHERE idsuatchieu = ?";
    $stmt_phong = $mysqli->prepare($sql_phong);
    $stmt_phong->bind_param("i", $idsuat);
    $stmt_phong->execute();
    $stmt_phong->bind_result($idphong);
    $stmt_phong->fetch();
    $stmt_phong->close();
}

// Tách danh sách tên ghế (A1,B2,...)
$ds_ghe_arr = explode(',', $ds_ghe);

foreach ($ds_ghe_arr as $tenghe) {
    $tenghe = trim($tenghe);

    if ($tenghe !== '') {
        $sql = "UPDATE ghe SET trangthai = '1' WHERE tenghe = ? AND idphong = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("si", $tenghe, $idphong);
        if ($stmt->execute()) {
            echo "";
        } else {
            echo "❌ Lỗi cập nhật $tenghe: " . $stmt->error;
        }
        $stmt->close();
    }
}

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chọn phương thức thanh toán</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h3 class="text-center mb-4">🧾 <strong>CHỌN PHƯƠNG THỨC THANH TOÁN</strong></h3>

    <form action="index.php?page=xacnhan" method="post">
        <!-- Dữ liệu ẩn -->
        <input type="hidden" name="idsuatchieu" value="<?php echo $idsuat; ?>">
        <input type="hidden" name="ds_ghe" value="<?php echo htmlspecialchars($ds_ghe); ?>">
        <input type="hidden" name="tong_tien" value="<?php echo $tong_tien; ?>">

        <input type="hidden" name="ten_phim" value="<?php echo htmlspecialchars($tenphim); ?>">
        <input type="hidden" name="ten_rap" value="<?php echo htmlspecialchars($tenrap); ?>">
        <input type="hidden" name="phong" value="<?php echo htmlspecialchars($tenphong); ?>">
        <input type="hidden" name="ngay_chieu" value="<?php echo htmlspecialchars($ngaychieu); ?>">
        <input type="hidden" name="gio_chieu" value="<?php echo htmlspecialchars($giochieu); ?>">

        <?php foreach ($combo_da_chon as $idcombo => $soluong): ?>
            <input type="hidden" name="combo[<?php echo $idcombo; ?>]" value="<?php echo $soluong; ?>">
        <?php endforeach; ?>

        <div class="card">
            <div class="card-header bg-info text-white"><strong>💳 Chọn phương thức thanh toán</strong></div>
            <div class="card-body">
                <div class="form-check mb-3">
                    <input class="form-check-input" type="radio" name="phuong_thuc" id="pt_qr" value="qr" checked onclick="showMethod('qr')">
                    <label class="form-check-label" for="pt_qr">
                        Thanh toán bằng mã QR
                    </label>
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input" type="radio" name="phuong_thuc" id="pt_the" value="the" onclick="showMethod('the')">
                    <label class="form-check-label" for="pt_the">
                        Thanh toán bằng thẻ ngân hàng (ATM, Visa, MasterCard)
                    </label>
                </div>

                <div class="form-check mb-4">
                    <input class="form-check-input" type="radio" name="phuong_thuc" id="pt_taicho" value="tienmat" onclick="showMethod('tienmat')">
                    <label class="form-check-label" for="pt_taicho">
                        Thanh toán tại quầy (tiền mặt)
                    </label>
                </div>

                <!-- Giao diện QR -->
                <?php
    // Cấu hình tài khoản nhận tiền
    $so_tai_khoan = '106874938508';
    $ngan_hang = 'Vietinbank';       
    $ten_nguoi_nhan = 'HIRO CINEMA';
    $noi_dung = 'Ban dep qua cho minh lq';

    // Tạo URL QR
    $qr_url = "https://img.vietqr.io/image/{$ngan_hang}-{$so_tai_khoan}-compact2.jpg?amount={$tong_tien}&addInfo=" . urlencode($noi_dung) . "&accountName=" . urlencode($ten_nguoi_nhan);
?>
<div id="method_qr" class="border rounded p-3 bg-light mb-3">
    <p>Vui lòng quét mã QR sau để thanh toán <strong><?php echo number_format($tong_tien); ?> VNĐ</strong>:</p>
    <div class="text-center">
        <img src="<?php echo $qr_url; ?>" alt="QR Code" class="img-fluid" style="max-width:200px;">
    </div>
    <p class="text-center mt-2 text-muted">Hệ thống sẽ xác nhận giao dịch sau khi bạn hoàn tất thanh toán.</p>
</div>


                <!-- Giao diện thẻ ngân hàng -->
                <div id="method_the" class="border rounded p-3 bg-light mb-3" style="display:none;">
                    <div class="mb-3">
                        <label for="so_the" class="form-label">Số thẻ</label>
                        <input type="text" class="form-control" id="so_the" name="so_the" placeholder="Nhập số thẻ...">
                    </div>
                    <div class="mb-3">
                        <label for="chu_the" class="form-label">Tên chủ thẻ</label>
                        <input type="text" class="form-control" id="chu_the" name="chu_the" placeholder="Nhập tên chủ thẻ...">
                    </div>
                    <div class="mb-3">
                        <label for="ngay_het_han" class="form-label">Ngày hết hạn</label>
                        <input type="text" class="form-control" id="ngay_het_han" name="ngay_het_han" placeholder="MM/YY">
                    </div>
                    <div class="mb-3">
                        <label for="cvv" class="form-label">CVV</label>
                        <input type="password" class="form-control" id="cvv" name="cvv" placeholder="***">
                    </div>
                </div>

                <!-- Giao diện thanh toán tiền mặt -->
                <div id="method_tienmat" class="border rounded p-3 bg-light mb-3" style="display:none;">
                    <p>Bạn sẽ thanh toán bằng tiền mặt tại quầy trước giờ chiếu. Vui lòng đến sớm ít nhất 15 phút.</p>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-success">✅ Tiếp tục thanh toán</button>
                </div>
            </div>
        </div>
    </form>

    <div class="text-center mt-4 pb-3">
        <a href="index.php" class="btn btn-secondary">← Quay về trang chủ</a>
    </div>
</div>

<script>
function showMethod(method) {
    document.getElementById('method_qr').style.display = (method === 'qr') ? 'block' : 'none';
    document.getElementById('method_the').style.display = (method === 'the') ? 'block' : 'none';
    document.getElementById('method_tienmat').style.display = (method === 'tienmat') ? 'block' : 'none';
}
</script>
</body>
</html>
<script>
let thanhToanXong = false;

setInterval(function () {
    const phuongThuc = document.querySelector('input[name="phuong_thuc"]:checked').value;

    if (!thanhToanXong && phuongThuc === 'qr') {
        fetch('index.php?page=kiemtrathanhtoan&idsuatchieu=<?php echo $idsuat; ?>&ds_ghe=<?php echo urlencode($ds_ghe); ?>')
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    thanhToanXong = true;

                    // Chuyển hướng tới trang xác nhận, dùng form POST để truyền lại dữ liệu nếu cần
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = 'index.php?page=xacnhan';

                    const fields = {
                        idsuatchieu: '<?php echo $idsuat; ?>',
                        ds_ghe: '<?php echo htmlspecialchars($ds_ghe); ?>',
                        tong_tien: '<?php echo $tong_tien; ?>',
                        ten_phim: '<?php echo htmlspecialchars($tenphim); ?>',
                        ten_rap: '<?php echo htmlspecialchars($tenrap); ?>',
                        phong: '<?php echo htmlspecialchars($tenphong); ?>',
                        ngay_chieu: '<?php echo htmlspecialchars($ngaychieu); ?>',
                        gio_chieu: '<?php echo htmlspecialchars($giochieu); ?>',
                        phuong_thuc: 'qr'
                    };

                    // Thêm combo vào nếu có
                    <?php foreach ($combo_da_chon as $idcombo => $soluong): ?>
                        fields['combo[<?php echo $idcombo; ?>]'] = '<?php echo $soluong; ?>';
                    <?php endforeach; ?>

                    for (const key in fields) {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = key;
                        input.value = fields[key];
                        form.appendChild(input);
                    }

                    document.body.appendChild(form);
                    form.submit();
                }
            });
    }
}, 5000); // Kiểm tra mỗi 5 giây

document.addEventListener("DOMContentLoaded", function () {
    const urlParams = new URLSearchParams(window.location.search);
    const idsuatchieu = urlParams.get('idsuatchieu');
    const ds_ghe = urlParams.get('ds_ghe');

    console.log("Bắt đầu kiểm tra thanh toán...");
    console.log("idsuatchieu:", idsuatchieu, "ds_ghe:", ds_ghe);

    function checkPaymentStatus() {
        fetch(`kiemtrathanhtoan.php?idsuatchieu=${encodeURIComponent(idsuatchieu)}&ds_ghe=${encodeURIComponent(ds_ghe)}`)
            .then(response => response.json())
            .then(data => {
                console.log("Phản hồi từ server:", data);
                if (data.status && data.status.trim() === 'success') {
                    console.log("Thanh toán thành công! Chuyển trang...");
                    window.location.href = `index.php?page=xacnhan&idsuatchieu=${encodeURIComponent(idsuatchieu)}&ds_ghe=${encodeURIComponent(ds_ghe)}`;
                } else {
                    console.log("Chưa thanh toán, sẽ kiểm tra lại sau 5 giây...");
                    setTimeout(checkPaymentStatus, 5000);
                }
            })
            .catch(error => {
                console.error("Lỗi khi kiểm tra thanh toán:", error);
                setTimeout(checkPaymentStatus, 5000);
            });
    }

    if (idsuatchieu && ds_ghe) {
        checkPaymentStatus();
    } else {
        console.error("Thiếu tham số idsuatchieu hoặc ds_ghe");
    }
});

</script>
