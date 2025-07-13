<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="assets/css/home.css?v=1">
    <link rel="stylesheet" href="assets/css/carousel.css" />
    <script src="./assets/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery-3.7.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
      integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
</head>
<body>
    <header>
    <div class="container d-flex justify-content-between align-items-center">
        <a href="index.php?page=trangchu"><img src="assets/images/logo.png" height="190px"></a> 
        <nav>
            <a href="index.php?page=phim" class="mr-4 text-decoration-none">Phim</a>
            <a href="index.php?page=gocdienanh" class="mr-4 text-decoration-none">Góc điện ảnh</a>
            <a href="index.php?page=sukien" class="mr-4 text-decoration-none">Sự kiện</a>
            <a href="index.php?page=rap" class="mr-4 text-decoration-none">Rạp</a>
            <a href="index.php?page=tuyendung" class="mr-4 text-decoration-none">Tuyển dụng</a>
            <?php
                if(isset($_SESSION['dangnhap2']) && $_SESSION['dangnhap2'] == true){
                    echo '<li style="display: inline;">
                        <a href="index.php?page=quanly" class="text-decoration-none text-warning">
                        <i class="fa-solid fa-gears"></i> Quản lý
                        </a>
                        </li>';
                }
            ?>
        </nav>
        <nav>
            <?php
                if (isset($_SESSION['dangnhap']) && $_SESSION['dangnhap'] == true) {
                    echo '<span style="color: #efefef;"><b>Chào, </b>
                        <a href="index.php?page=thongtin&idkh=' . $_SESSION['idkh'] . '" style="color: yellow;">' 
                        . $_SESSION['ho'] . ' ' . $_SESSION['ten'] . 
                        '</a></span>';
                    echo '<li style="display: inline; padding-left: 20px;"><a href="index.php?page=dangxuat">Đăng xuất</a></li>';
                } elseif (isset($_SESSION['dangnhap2']) && $_SESSION['dangnhap2'] == true) {
                    echo '<span style="color: #efefef;"><b>Chào, </b>' . $_SESSION['taikhoan'] . '</span>';
                    echo '<li style="display: inline; padding-left: 20px;"><a href="index.php?page=dangxuat">Đăng xuất</a></li>';
                } else {
                    echo '<a href="index.php?page=dangnhap" class="mr-4 text-decoration-none"><i class="fa fa-user"></i> Đăng nhập</a>';
                    echo '<a class="mr-4 text-decoration-none" href="index.php?page=dangky"><i class="fa fa-user-plus"></i> Đăng ký</a>';
                }
            ?>
        </nav>
    </div>
</header>
