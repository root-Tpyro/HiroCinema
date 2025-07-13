<!DOCTYPE html>
<html>
<head>
    <title>Phim chiếu rạp</title>
    <link rel="stylesheet" href="assets/css/sanpham.css?v=1"/>
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
</head>
<body>
    <div class="banner">
   <h1>PHIM CHIẾU RẠP</h1> 
</div>
</body>
</html>
<?php
$obj = new database();
$loaisp = $obj->xuatdulieu("SELECT * FROM danhsachphim");

if ($loaisp) {
    echo '<ul class="category-list">';
    
    // Hiển thị mục "Tất cả"
    echo '<li><a href="index.php?page=phim">Tất cả</a></li>';
    
    // Hiển thị các loại phim cụ thể
    for ($i = 0; $i < count($loaisp); $i++) {
        echo '<li><a href="index.php?page=phim&cate=' . $loaisp[$i]['idds'] . '">' . $loaisp[$i]['ten'] . '</a></li>';
    }
    
    echo '</ul>';
}

$obj = new database();
$search = isset($_GET['search']) ? $_GET['search'] : '';
if($cate)
    $sql = "SELECT * FROM phim WHERE idds='$cate'";
else
    $sql = "SELECT * FROM phim";
if (!empty($search)) {
    $sql .= " WHERE tenphim LIKE '%$search%'";
}
$sanpham = $obj->xuatdulieu($sql);

if($sanpham) {
    echo '<div class="product-container pb-3">'; // Thêm lớp container để áp dụng CSS flex
    for($i = 0; $i < count($sanpham); $i++) { // Hiển thị tất cả dữ liệu
        echo '
        <div class="sanpham">
            <div class="hinh">
                <img src="assets/images/' . $sanpham[$i]["poster"] . '" width="200" />
            </div>
            <div class="tensp">
                <a href="index.php?page=chitietphim&cate=' . $sanpham[$i]["idphim"] . '">' . $sanpham[$i]["tenphim"] . '</a>
            </div>
            <div style="text-align: left; font-size: 13px;"><strong>Thể loại:</strong> '.$sanpham[$i]['theloai'].'</div>
            <div style="text-align: left; font-size: 13px;"><strong>Thời lượng:</strong> '.$sanpham[$i]['thoiluong'].' phút</div>
            <div style="text-align: left; font-size: 13px;"><strong>Ngày khởi chiếu:</strong> ' . date("d-m-Y", strtotime($sanpham[$i]['ngaykhoichieu'])) . '</div>

        </div>';
    }
    echo '</div>'; // Kết thúc container
} else {
    echo "Hiện tại chưa có sản phẩm nào";
}
?>


<div style="clear:both"></div>
