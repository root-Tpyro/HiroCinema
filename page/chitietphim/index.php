<title><?php echo isset($sanpham[0]["tenphim"]) ? $sanpham[0]["tenphim"] . ' - Chi tiết phim' : 'Chi tiết phim'; ?></title>
<style>
    .movie-info h1 {
        font-size: 2rem;
        font-weight: bold;
    }
    .movie-info p {
        font-size: 1rem;
    }
    .btn-ticket {
        font-size: 1.1rem;
        margin-top: 20px;
    }
    .movie-box {
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 10px;
        margin-bottom: 20px;
        transition: transform 0.3s ease;
        height: 100%;
    }
    .movie-box:hover {
        transform: translateY(-5px);
    }
    .movie-img {
        width: 100%;
        height: 300px;
        object-fit: cover;
    }
    .movie-title {
        font-size: 1.1rem;
        font-weight: bold;
        margin-top: 10px;
        margin-bottom: 10px;
        text-align: center;
    }
    .movie-btn {
        display: inline-block;
        margin-top: 5px;
        padding: 5px 10px;
        border: 1px solid #007bff;
        color: #007bff;
        text-decoration: none;
        border-radius: 3px;
        font-size: 0.9rem;
    }
    .movie-btn:hover {
        background-color: #007bff;
        color: #fff;
    }
</style>

<?php

$db = new database();
$sql = "SELECT * FROM phim p JOIN danhsachphim ds ON p.idds = ds.idds WHERE p.idphim = '$cate'";
$sanpham = $db->xuatdulieu($sql);

if ($sanpham) {
    echo '<div class="container mt-5 pb-4">';
    echo '<div class="row">';
    echo '<div class="col-md-4">
            <img src="assets/images/' . $sanpham[0]["poster"] . '" class="" width="340" height="500">
        </div>';
    echo '<div class="col-md-8 movie-info">
            <h1>' . $sanpham[0]["tenphim"] . '</h1>
            <p><strong>Đạo diễn:</strong> ' . $sanpham[0]["daodien"] . '</p>
            <p><strong>Diễn viên:</strong> ' . $sanpham[0]["dienvien"] . '</p>
            <p><strong>Thể loại:</strong> ' . $sanpham[0]["theloai"] . '</p>
            <p><strong>Thời lượng:</strong> ' . $sanpham[0]["thoiluong"] . ' phút</p>
            <p><strong>Khởi chiếu:</strong> ' . date("d-m-Y", strtotime($sanpham[0]['ngaykhoichieu'])) . '</p>
            <p><strong>Độ tuổi:</strong> ' . $sanpham[0]["dotuoi"] . '</p>
            <p><strong>Nội dung:</strong> ' . $sanpham[0]["mota"] . '</p>';

    // Kiểm tra quyền và hiển thị nút
    echo '<div class="text-center">';
    if (isset($_SESSION['dangnhap2'])) {
        echo '<button class="btn btn-warning btn-ticket" onclick="alert(\'Không được phép!\')">Đặt vé ngay</button>';
    } else {
        echo '<a href="index.php?page=datve&cate=' . $sanpham[0]['idphim'] . '" class="btn btn-warning btn-ticket">Đặt vé ngay</a>';
    }
    echo '</div>'; // text-center

    echo '</div>'; // col-md-8
    echo '</div>'; // row
    echo '</div>'; // container
}
?>

<?php
//phần đề xuất phim
$sql = "SELECT * FROM phim WHERE idds=2";
$phim = $db->xuatdulieu($sql);
if ($phim) {
    echo '<div class="container mb-5">';
    echo '<h2 class="mb-4 pt-3"><strong>PHIM HAY TUẦN NÀY</strong></h2>';
    echo '<div class="row">';

    foreach ($phim as $item) {
        echo '<div class="col-md-3">
                <div class="movie-box">
                    <img src="assets/images/' . $item["poster"] . '" class="movie-img" alt="' . $item["tenphim"] . '">
                    <div class="movie-title">' . $item["tenphim"] . '</div>
                    <div style="text-align: left; font-size: 13px;"><strong>Thể loại:</strong> '.$item['theloai'].'</div>
            <div style="text-align: left; font-size: 13px;"><strong>Thời lượng:</strong> '.$item['thoiluong'].' phút</div>
            <div style="text-align: left; font-size: 13px;"><strong>Ngày khởi chiếu:</strong> ' . date("d-m-Y", strtotime($item['ngaykhoichieu'])) . '</div>
                    <div style="text-align:center;"><a href="index.php?page=chitietphim&cate=' . $item['idphim'] . '" class="movie-btn">Xem chi tiết</a>
</div>
                </div>
              </div>';
    }

    echo '</div>'; // row
    echo '</div>'; // container
}
?>
