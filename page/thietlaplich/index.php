<title>Thiết lập suất chiếu</title>

<?php
// Kết nối CSDL Cinema
class database1 {
    public $conn;

    public function __construct() {
        $this->conn = new mysqli("localhost", "root", "", "cinema");
        if ($this->conn->connect_error) {
            die("Kết nối thất bại: " . $this->conn->connect_error);
        }
        $this->conn->set_charset("utf8"); // Thiết lập UTF-8 để tránh lỗi tiếng Việt
    }
}

$db = new database1();

if (isset($_POST['submit'])) {
    $idphim = $_POST['idphim'];
    $ngaychieu = $_POST['ngaychieu'];
    $giobatdau = $_POST['giobatdau'];
    $idrap = $_POST['idrap'];
    $tenphong = $_POST['tenphong'];

    // 1. Kiểm tra phòng đã tồn tại chưa (cùng tên và rạp)
    $sqlPhongCheck = "SELECT idphong FROM phongchieu WHERE tenphong = '$tenphong' AND idrap = '$idrap'";
    $resultPhong = $db->conn->query($sqlPhongCheck);

    if ($resultPhong->num_rows > 0) {
        $rowPhong = $resultPhong->fetch_assoc();
        $idphong = $rowPhong['idphong'];
    } else {
        $sqlPhong = "INSERT INTO phongchieu (tenphong, idrap) VALUES ('$tenphong', '$idrap')";
        if ($db->conn->query($sqlPhong) === TRUE) {
            $idphong = $db->conn->insert_id;
        } else {
            echo "<script>alert('Lỗi khi thêm phòng chiếu!');</script>";
            exit;
        }
    }

    // 2. Kiểm tra trùng suất chiếu
    $sqlCheckSuat = "SELECT * FROM suatchieu WHERE idphong = '$idphong' AND ngaychieu = '$ngaychieu' AND giobatdau = '$giobatdau'";
    $resultSuat = $db->conn->query($sqlCheckSuat);

    if ($resultSuat->num_rows > 0) {
        echo "<script>alert('Đã có suất chiếu khác trong phòng này vào cùng giờ!');</script>";
    } else {
        $sqlSuat = "INSERT INTO suatchieu (idphim, idphong, ngaychieu, giobatdau) 
                    VALUES ('$idphim', '$idphong', '$ngaychieu', '$giobatdau')";
        if ($db->conn->query($sqlSuat) !== TRUE) {
            echo "Lỗi khi thêm suất chiếu: " . $db->conn->error;
        }

        $sqlCheckGhe = "SELECT COUNT(*) as total FROM ghe WHERE idphong = $idphong";
        $resultGhe = $db->conn->query($sqlCheckGhe);
        $row = $resultGhe->fetch_assoc();

        if ($row['total'] == 0) {
            $loaiThuong = array('A','B','C','D');
            $loaiVip = array('E','F','G','H');
            $allRows = array_merge($loaiThuong, $loaiVip);

            $values = array();
            foreach ($allRows as $row) {
                for ($i = 1; $i <= 25; $i++) {
                    $col = str_pad($i, 2, '0', STR_PAD_LEFT);
                    $tenGhe = $row . $col;
                    $loai = in_array($row, $loaiThuong) ? 'Thuong' : 'Vip';
                    $values[] = "($idphong, '$tenGhe', '$loai', 0)";
                }
            }

            $valueString = implode(',', $values);
            $sqlGhe = "INSERT INTO ghe (idphong, tenghe, loaighe, trangthai) VALUES $valueString";
            if ($db->conn->query($sqlGhe) !== TRUE) {
                echo "Lỗi khi tạo ghế: " . $db->conn->error;
            } else {
                echo "<script>alert('Thiết lập suất chiếu thành công!'); window.location='index.php?page=thietlaplich';</script>";
            }
        } else {
            echo "<script>alert('Suất chiếu đã thêm, phòng này đã có ghế.'); window.location='index.php?page=thietlaplich';</script>";
        }
    }
}
?>

<!-- Giao diện sử dụng Bootstrap 4 -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<div class="container mt-5">
    <h2 class="mb-4">Thiết lập phim khởi chiếu</h2>
    <form method="POST">
        <div class="form-group">
            <label>Chọn phim:</label>
            <select name="idphim" class="form-control" required>
                <?php
                $result = $db->conn->query("SELECT idphim, tenphim FROM phim");
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='{$row['idphim']}'>{$row['tenphim']}</option>";
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label>Ngày chiếu:</label>
            <input type="date" name="ngaychieu" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Giờ bắt đầu:</label>
            <input type="time" name="giobatdau" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Chọn rạp:</label>
            <select name="idrap" class="form-control" required>
                <?php
                $result = $db->conn->query("SELECT idrap, tenrap FROM cumrap");
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='{$row['idrap']}'>{$row['tenrap']}</option>";
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label>Tên phòng:</label>
            <select name="tenphong" class="form-control" required>
                <option value="A">Phòng A</option>
                <option value="B">Phòng B</option>
                <option value="C">Phòng C</option>
            </select>
        </div>

        <div class="pb-3"><button type="submit" name="submit" class="btn btn-primary">Thiết lập suất chiếu</button></div>
    </form>
</div>
