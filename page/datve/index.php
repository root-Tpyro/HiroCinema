<style>
        .banner h1 {
            background: url('assets/images/banner4.jpg') no-repeat center center;
            background-size: cover;
            height: 400px;
            color: white;
            text-align: center;
            line-height: 400px;
            font-size: 45px;
            font-weight: bold;
        }
    </style>
<div class="banner">
   <h1>SUẤT CHIẾU</h1> 
</div>
<?php
// Kiểm tra đăng nhập
if (!isset($_SESSION['dangnhap'])) {
    header("Location: index.php?page=dangnhap");
    exit();
}



require_once("class/classdb.php");
$db = new database();

// Kiểm tra có truyền id phim qua biến cate không
if (!isset($_GET['cate'])) {
    echo "<div class='container mt-4'><div class='alert alert-danger'>Không tìm thấy phim!</div></div>";
    return;
}

$idphim = intval($_GET['cate']);

// Lấy danh sách các ngày chiếu trong tháng hiện tại
$month = date('m');
$year = date('Y');
$sql_ngay = "SELECT DISTINCT DATE(ngaychieu) AS ngay
             FROM suatchieu
             WHERE idphim = $idphim
               AND MONTH(ngaychieu) = $month
               AND YEAR(ngaychieu) = $year
             ORDER BY ngaychieu ASC";
$ngay_chieu = $db->xuatdulieu($sql_ngay);
?>

<div class="container mt-5">
    <h2 class="mb-4">🎬 <b>NGÀY CHIẾU</b></h2>
    <div class="row">
        <?php
        if ($ngay_chieu) {
            foreach ($ngay_chieu as $ngay) {
                $d = $ngay['ngay'];
                // ✅ Định dạng ngày từ Y-m-d → d/m/Y
                $hienthi = date("d/m/Y", strtotime($d));

                echo "<div class='col-md-2 mb-2'>
                        <a href='index.php?page=datve&cate=$idphim&ngay=$d' class='btn btn-outline-primary btn-block'>$hienthi</a>
                      </div>";
            }
            
        } else {
            echo "<div class='col-12'><div class='alert alert-warning'>Hiện chưa có suất chiếu trong tháng này.</div></div>";
            
        }
        ?>
    </div>
</div>

<?php
// Nếu người dùng chọn ngày chiếu
if (isset($_GET['ngay'])) {
    $ngay = $_GET['ngay'];

    // ✅ Hiển thị ngày ở định dạng dd/mm/yyyy
    $ngay_hienthi = date("d/m/Y", strtotime($ngay));

    $sql_cumrap = "SELECT DISTINCT cr.idrap, cr.tenrap, cr.diachi
                   FROM suatchieu sc
                   JOIN phongchieu pc ON sc.idphong = pc.idphong
                   JOIN cumrap cr ON pc.idrap = cr.idrap
                   WHERE sc.idphim = $idphim AND DATE(sc.ngaychieu) = '$ngay'";
    $raps = $db->xuatdulieu($sql_cumrap);

    echo "<div class='container mt-5'><h3>📍 Rạp chiếu và khung giờ ngày <strong>$ngay_hienthi</strong></h3>";

    if ($raps) {
        foreach ($raps as $rap) {
            echo "<div class='card mb-3 p-3'>
                    <h5>{$rap['tenrap']} - {$rap['diachi']}</h5>
                    <div class='d-flex flex-wrap'>";

            // Lấy giờ chiếu cho rạp đó
            $sql_gio = "SELECT sc.idsuatchieu, sc.giobatdau
                        FROM suatchieu sc
                        JOIN phongchieu pc ON sc.idphong = pc.idphong
                        WHERE sc.idphim = $idphim AND DATE(sc.ngaychieu) = '$ngay'
                              AND pc.idrap = {$rap['idrap']}
                        ORDER BY sc.giobatdau ASC";
            $suats = $db->xuatdulieu($sql_gio);

            if ($suats) {
                foreach ($suats as $suat) {
                   echo "<a href='index.php?page=chonve&suat={$suat['idsuatchieu']}' class='btn btn-outline-success m-1'>{$suat['giobatdau']}</a>";
                }
            } else {
                echo "<p class='text-muted'>Không có suất chiếu.</p>";
            }

            echo "</div></div>";
        }
    } else {
        echo "<div class='alert alert-warning'>Không tìm thấy cụm rạp cho ngày đã chọn.</div>";
    }

    echo "</div>";
}
?>
