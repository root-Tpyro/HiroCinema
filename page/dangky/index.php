<title>Đăng ký</title>
<?php
    include("class/classxuly.php");
    $obj = new xuly;
    
    if (isset($_POST['btnDangKy'])) {
        $hodem = $_POST['hodem'];
        $ten= $_POST['ten'];
        $sdt = $_POST['sdt'];
        $mk = $_POST['mk'];
        $nlmk = $_POST['nlmk'];
        $email = $_POST['email'];
        $ngaysinh = $_POST['ngaysinh'];
        $diachi = $_POST['diachi'];

   
        $kiemtratk = "SELECT COUNT(*) FROM khachhang WHERE sdt = '$sdt'";
        $result = $obj->xuatdulieu($kiemtratk);
        
        if ($result && $result[0]['COUNT(*)'] > 0) {
            echo '<script>alert("Số điện thoại đã được sử dụng!");</script>';
        } else {
            
            $sql = "INSERT INTO khachhang(hodem,ten,sdt, matkhau ,email, ngaysinh, diachi) 
                    VALUES ('$hodem','$ten','$sdt' ,'$mk', '$email', '$ngaysinh' , '$diachi')";
            if ($obj->themkhachhang($sql)) {
                echo '<script>alert("Đăng ký thành công!");</script>';
            } else {
                echo '<script>alert("Đăng ký không thành công!");</script>';
            }
        }
    }
?>

<section>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="form-container">
                    <h3 class="text-center form-title"><strong>ĐĂNG KÝ TÀI KHOẢN</strong></h3>
                    <p class="text-center text-danger">Vui lòng nhập đầy đủ thông tin để đăng ký tài khoản</p>
                    <hr>

                    <form id="registrationForm" method="post" enctype="multipart/form-data" onsubmit="return validateRegistrationForm1()">
    <div class="form-group">
        <label><b>Họ đệm:</b></label>
        <input type="text" class="form-control" name="hodem" placeholder="Họ đệm" required>
        <span class="text-danger">*</span>
    </div>

    <div class="form-group">
        <label><b>Tên:</b></label>
        <input type="text" class="form-control" name="ten" placeholder="Tên" required>
        <span class="text-danger">*</span>
    </div>

    <div class="form-group">
        <label><b>Số điện thoại:</b></label>
        <input type="text" class="form-control" name="sdt" placeholder="Nhập số điện thoại" required>
        <span class="text-danger">*</span>
    </div>

    <div class="form-group">
        <label><b>Mật khẩu:</b></label>
        <input type="password" class="form-control" name="mk" placeholder="Nhập mật khẩu" required>
        <span class="text-danger">*</span>
    </div>

    <div class="form-group">
        <label><b>Xác nhận mật khẩu:</b></label>
        <input type="password" class="form-control" name="nlmk" placeholder="Xác nhận mật khẩu" required>
        <span class="text-danger">*</span>
    </div>

    <div class="form-group">
        <label><b>Email:</b></label>
        <input type="email" class="form-control" name="email" placeholder="Nhập email" required>
        <span class="text-danger">*</span>
    </div>

    <div class="form-group">
        <label><b>Ngày sinh:</b></label>
        <input type="date" class="form-control" name="ngaysinh" placeholder="Nhập ngày sinh" required>
        <span class="text-danger">*</span>
    </div>


    <div class="form-group">
        <label><b>Địa chỉ:</b></label>
        <input type="text" class="form-control" name="diachi" placeholder="Nhập địa chỉ" required>
        <span class="text-danger">*</span>
    </div>

    <div class="text-center"><input type="submit" name="btnDangKy" value="Đăng ký"></div>
</form>

                    <div class="text-center mt-3">Bạn đã có tài khoản? <a class="text-danger" href="index.php?page=dangnhap">Đăng nhập tại đây!</a></div>
                </div>
                <div class="text-center mt-3 pb-3">
                    <a href="index.php?page=trangchu"><button type="button" class="btn btn-danger back-btn">Quay lại trang chủ</button></a>
                </div>
            </div>
        </div>
    </section>

    <style>
        .form-container {
    background: #fff;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    margin-top: 50px;
}
.form-title {
    margin-bottom: 30px;
}
.form-control {
    border-radius: 30px;
}
.btn-custom {
    border-radius: 30px;
    width: 100%;
}
.back-btn {
    border-radius: 30px;
    width: 200px;
}
.error {
    font-size: 0.9em;
    color: red;
}
    </style>

<script>
    function validateRegistrationForm1() {
        var hodem = document.forms["registrationForm"]["hodem"].value;
        var ten = document.forms["registrationForm"]["ten"].value;
        var sdt = document.forms["registrationForm"]["sdt"].value;
        var matkhau = document.forms["registrationForm"]["mk"].value;
        var xacnhanmk = document.forms["registrationForm"]["nlmk"].value;
        var ngaysinh = document.forms["registrationForm"]["ngaysinh"].value;

        var rbho = /^[a-zA-Z\s]+$/;  // Kiểm tra họ tên chỉ chứa chữ và khoảng trắng
        var rbmk = /^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;  // Mật khẩu có ít nhất 1 chữ in hoa, 1 chữ số và 1 ký tự đặc biệt
        var rbsdt = /^(03|05|07|08|09)[0-9]{8}$/;  // Kiểm tra số điện thoại hợp lệ

        // Kiểm tra họ tên
        if (!hodem.match(rbho)) {
            alert("Tên không hợp lệ. Tên chỉ được chứa chữ cái và khoảng trắng.");
            return false;
        }

        if (!ten.match(rbho)) {
            alert("Tên không hợp lệ. Tên chỉ được chứa chữ cái và khoảng trắng.");
            return false;
        }

        // Kiểm tra số điện thoại
        if (!sdt.match(rbsdt)) {
            alert("Số điện thoại không hợp lệ.");
            return false;
        }

        // Kiểm tra mật khẩu
        if (!matkhau.match(rbmk)) {
            alert("Mật khẩu phải có ít nhất 8 ký tự, bao gồm ít nhất 1 chữ in hoa, 1 chữ số và 1 ký tự đặc biệt.");
            return false;
        }

        // Kiểm tra xác nhận mật khẩu
        if (matkhau !== xacnhanmk) {
            alert("Xác nhận mật khẩu không trùng khớp.");
            return false;
        }

        return true;  // Nếu tất cả các điều kiện đều đúng, cho phép gửi form
    }
</script>
