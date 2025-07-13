<?php

// Kết nối CSDL
class dt {
    public $conn;

    public function __construct() {
        $this->conn = new mysqli("localhost", "root", "", "cinema"); // Sửa theo thông tin CSDL thật
        $this->conn->set_charset("utf8");
        if ($this->conn->connect_error) {
            die("Kết nối CSDL thất bại: " . $this->conn->connect_error);
        }
    }

    public function xuatdulieu($sql) {
        $result = $this->conn->query($sql);
        $data = array();
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        return $data;
    }

    public function thucthi($sql) {
        return $this->conn->query($sql);
    }
}

// Khởi tạo database
$db = new dt();

// Kiểm tra đăng nhập
if (!isset($_SESSION['idkh'])) {
    header("Location: index.php?page=dangnhap");
    exit();
}

$idkh = $_SESSION['idkh'];
$thongbao = "";

// Lấy thông tin khách hàng
$sql_kh = "SELECT * FROM khachhang WHERE idkh = '$idkh'";
$khachhangs = $db->xuatdulieu($sql_kh);
$khachhang = !empty($khachhangs) ? $khachhangs[0] : null;

if (!$khachhang) {
    session_destroy();
    header("Location: index.php?page=dangnhap");
    exit();
}

// Xử lý đổi mật khẩu
if (isset($_POST['doimatkhau'])) {
    $matkhau_cu = $_POST['matkhau_cu'];
    $matkhau_moi = $_POST['matkhau_moi'];
    $nhap_lai = $_POST['nhap_lai'];

    if ($matkhau_cu !== $khachhang['matkhau']) {
        $thongbao = "❌ Mật khẩu hiện tại không đúng.";
    } elseif ($matkhau_moi !== $nhap_lai) {
        $thongbao = "❌ Mật khẩu mới nhập lại không khớp.";
    } elseif (!preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/', $matkhau_moi)) {
        $thongbao = "❌ Mật khẩu mới không đủ mạnh (ít nhất 8 ký tự, 1 chữ in hoa, 1 số, 1 ký tự đặc biệt).";
    } else {
        $sql_update = "UPDATE khachhang SET matkhau = '$matkhau_moi' WHERE idkh = '$idkh'";
        $db->thucthi($sql_update);
        $thongbao = "✅ Đổi mật khẩu thành công.";
        $khachhang['matkhau'] = $matkhau_moi;
    }
}

// Lấy lịch sử đặt vé
$sql_ve = "
    SELECT 
          CONCAT(khachhang.hodem, ' ', khachhang.ten) AS hoten,
          phim.tenphim,
          GROUP_CONCAT(ghe.tenghe ORDER BY ghe.tenghe SEPARATOR ', ') AS ds_ghe,
          cumrap.tenrap,
          phongchieu.tenphong,
          suatchieu.giobatdau,ngaydat,ngaychieu
        FROM ve
        JOIN khachhang ON ve.idkh = khachhang.idkh
        JOIN suatchieu ON ve.idsuatchieu = suatchieu.idsuatchieu
        JOIN phim ON suatchieu.idphim = phim.idphim
        JOIN ghe ON ve.idghe = ghe.idghe
        JOIN phongchieu ON ghe.idphong = phongchieu.idphong
        JOIN cumrap ON phongchieu.idrap = cumrap.idrap
        WHERE ve.idkh = '$idkh'
        GROUP BY ve.idkh, ve.idsuatchieu, phim.tenphim, cumrap.tenrap, phongchieu.tenphong, suatchieu.giobatdau
        ORDER BY suatchieu.giobatdau DESC";
$lichsu = $db->xuatdulieu($sql_ve);

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thông tin khách hàng</title>
    <style>
        .formdep { max-width: 900px; margin: 40px auto; font-family: Arial, sans-serif; }
        h2 { margin-bottom: 20px; }
        .section-title { margin-top: 40px; font-weight: bold; font-size: 1.5rem; }
        .error { color: red; }
        .success { color: green; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table, th, td { border: 1px solid #ccc; padding: 10px; }
        input[type="password"] { padding: 5px; width: 300px; }
        button { padding: 10px 20px; margin-top: 10px; }
    </style>
</head>
<body>
<div class="formdep">
    <h2><strong>THÔNG TIN CÁ NHÂN</strong></h2>
    <p><strong>Họ tên:</strong> <?php echo $khachhang['hodem'] . ' ' . $khachhang['ten'] ?></p>
    <p><strong>Email:</strong> <?php echo $khachhang['email'] ?></p>
    <p><strong>Số điện thoại:</strong> <?php echo $khachhang['sdt'] ?></p>
    <p><strong>Ngày sinh:</strong> <?php echo date("d/m/Y", strtotime($khachhang['ngaysinh'])) ?></p>
    <p><strong>Địa chỉ:</strong> <?php echo $khachhang['diachi'] ?></p>

    <div class="section-title">ĐỔI MẬT KHẨU</div>
    <form method="post">
        <div>
            <label>Mật khẩu hiện tại:</label><br>
            <input type="password" name="matkhau_cu" required>
        </div>
        <div>
            <label>Mật khẩu mới:</label><br>
            <input type="password" name="matkhau_moi" required>
        </div>
        <div>
            <label>Nhập lại mật khẩu mới:</label><br>
            <input type="password" name="nhap_lai" required>
        </div>
        <button type="submit" name="doimatkhau">Đổi mật khẩu</button>
        <?php if ($thongbao): ?>
            <p class="<?= strpos($thongbao, '✅') !== false ? 'success' : 'error' ?>"><?= $thongbao ?></p>
        <?php endif; ?>
    </form>

    <div class="section-title">LỊCH SỬ ĐẶT VÉ</div>
    <?php if (!empty($lichsu)): ?>
        <table>
            <thead>
                <tr>
                    <th>Tên phim</th>
                    <th>Ngày chiếu</th>
                    <th>Giờ bắt đầu</th>
                    <th>Phòng</th>
                    <th>Ghế</th>
                    <th>Rạp</th>
                    <th>Ngày đặt</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($lichsu as $item): ?>
                    <tr>
                        <td><?php echo $item['tenphim'] ?></td>
                        <td><?php echo date("d/m/Y", strtotime($item['ngaychieu'])) ?></td>
                        <td><?php echo $item['giobatdau'] ?></td>
                        <td><?php echo $item['tenphong'] ?></td>
                        <td><?php echo $item['ds_ghe'] ?></td>
                        <td><?php echo $item['tenrap'] ?></td>
                        <td><?php echo date("d/m/Y", strtotime($item['ngaydat'])) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>⚠️ Bạn chưa có vé nào đã đặt.</p>
    <?php endif; ?>
    
</div>
</body>
</html>


<style>
    .formdep {
        max-width: 900px;
        margin: 40px auto;
        padding: 20px;
    }

    h2 {
        margin-bottom: 20px;
        color: #007bff;
    }

    .section-title {
        margin-top: 40px;
        font-weight: 600;
        font-size: 1.5rem;
        color: #343a40;
        border-bottom: 2px solid #dee2e6;
        padding-bottom: 8px;
        margin-bottom: 20px;
    }

    .form-group label {
        font-weight: 500;
        margin-bottom: 5px;
        display: block;
    }

    .form-control {
        width: 100%;
        padding: 0.375rem 0.75rem;
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
        margin-bottom: 15px;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
        padding: 0.5rem 1rem;
        font-weight: 500;
        border-radius: 0.25rem;
    }

    .btn-primary:hover {
        background-color: #0069d9;
        border-color: #0062cc;
    }

    .success {
        color: #28a745;
        font-weight: 500;
    }

    .error {
        color: #dc3545;
        font-weight: 500;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    table th, table td {
        padding: 10px;
        border: 1px solid #dee2e6;
        text-align: center;
        vertical-align: middle !important;
    }

    .thead-dark th {
        background-color: #343a40;
        color: #fff;
    }

    @media (max-width: 768px) {
        .formdep {
            padding: 10px;
        }

        .section-title {
            font-size: 1.25rem;
        }

        table th, table td {
            font-size: 0.9rem;
            padding: 8px;
        }
    }
</style>
