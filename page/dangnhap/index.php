<?php
    if (isset($_POST['btnDN'])) {
    $tk = $_POST['tk'];
    $mk = $_POST['mk'];
    $obj = new database;

    // Đăng nhập khách hàng
    $khach = $obj->dangnhap($tk, $mk);

    if ($khach) {
        $_SESSION['dangnhap'] = true;
        $_SESSION['idkh'] = $khach['idkh'];
        $_SESSION['ho'] = $khach['hodem'];
        $_SESSION['ten'] = $khach['ten'];
        header("Location: index.php?page=trangchu");
        exit;
    }

    // Nếu không phải khách, thử admin
    $admin = $obj->dangnhap2($tk, $mk);
    if ($admin) {
        $_SESSION['dangnhap2'] = true;
        $_SESSION['hoten'] = $admin['hoten'];
        $_SESSION['taikhoan'] = $admin['taikhoan'];
        header("Location: index.php?page=trangchu");
        exit;
    }

    // Nếu không đúng cả 2
    echo "<script>alert('Đăng nhập không thành công!');</script>";
}

?>

<title>Đăng nhập</title>
<section style="background: url('assets/images/bg-cinema.jpg') no-repeat center center fixed; background-size: cover; min-height: 100vh;">
    <div class="container">
        <div class="row justify-content-center align-items-center" style="min-height: 100vh;">
            <div class="col-md-6 pt-4 pb-4">
                <div class="form-container">
                    <h3 class="text-center form-title"><strong>ĐĂNG NHẬP</strong></h3>
                    <p class="text-center text-muted">Chào mừng bạn đến với hệ thống rạp chiếu phim <strong>Hiro</strong> – nơi trải nghiệm điện ảnh đỉnh cao.</p>
                    <form id="loginForm" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="tendn"><b>Số điện thoại</b></label>
                            <input type="text" class="form-control" id="tendn" name="tk" placeholder="Nhập số điện thoại" required>
                            <span class="text-danger" id="errortk"></span>
                        </div>
                        <div class="form-group">
                            <label for="matkhau"><b>Mật khẩu</b></label>
                            <input type="password" class="form-control" id="matkhau" name="mk" placeholder="Nhập mật khẩu" required>
                            <span class="text-danger" id="errormk"></span>
                        </div>
                        <div class="text-center">
                            <button type="submit" name="btnDN" class="btn btn-primary mt-3 btn-custom">Đăng nhập</button>
                        </div>
                        <div class="text-center mt-3">
                            <small>Bạn chưa có tài khoản? <a href="index.php?page=dangky" class="text-primary"><strong>Đăng ký ngay</strong></a></small>
                        </div>
                    </form>
                    <hr>
                    <p class="text-center text-muted" style="font-size: 14px;">
                        Rạp phim <strong>Hiro</strong> cam kết mang đến cho bạn trải nghiệm điện ảnh hiện đại với phòng chiếu chất lượng cao, âm thanh sống động và dịch vụ chuyên nghiệp.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .form-container {
        background: rgba(255, 255, 255, 0.95);
        padding: 40px;
        border-radius: 15px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    }
    .form-title {
        margin-bottom: 20px;
        color: #333;
    }
    .form-control {
        border-radius: 30px;
        padding: 10px 20px;
    }
    .btn-custom {
        border-radius: 30px;
        padding: 10px 30px;
    }
</style>
