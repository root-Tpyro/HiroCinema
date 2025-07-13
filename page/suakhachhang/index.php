<title>Hiệu chỉnh khách hàng</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background: #f0f2f5;
    }

    h3 {
        margin-top: 30px;
        color: #2c3e50;
        font-size: 24px;
    }

    form {
        margin: 20px auto;
        width: 60%;
        background: #fff;
        padding: 25px 40px;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
    }

    table {
        width: 100%;
    }

    td {
        padding: 12px 8px;
        font-size: 16px;
        color: #333;
    }

    input[type="text"],
    input[type="email"],
    input[type="file"] {
        width: 100%;
        padding: 10px;
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 6px;
        box-sizing: border-box;
    }

    input[type="submit"] {
        padding: 10px 20px;
        background: #007bff;
        color: white;
        font-size: 16px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    input[type="submit"]:hover {
        background: #0056b3;
    }

    @media screen and (max-width: 768px) {
        form {
            width: 90%;
            padding: 20px;
        }
    }
</style>

<?php
include("class/classxuly.php");
$obj = new xuly();
$khachhang = $obj->danhsachkhachhang($cate); // $cate là idkh được truyền qua URL
?>

<h3 align="center"><strong>HIỆU CHỈNH THÔNG TIN KHÁCH HÀNG</strong></h3>
<form method="post" enctype="multipart/form-data">
    <table style="border-collapse:collapse">
        <tr>
            <td width="30%">Họ khách hàng</td>
            <td><input type="text" name="hokh" required value="<?php echo $khachhang[0]['hodem']; ?>" /></td>
        </tr>
        <tr>
            <td width="30%">Tên khách hàng</td>
            <td><input type="text" name="tenkh" required value="<?php echo $khachhang[0]['ten']; ?>" /></td>
        </tr>
        <tr>
            <td>Ngày sinh</td>
            <td><input type="date"  name="ngaysinh" required value="<?php echo $khachhang[0]['ngaysinh']; ?>" /></td>
        </tr>
        <tr>
            <td>Email</td>
            <td><input type="email" name="email" required value="<?php echo $khachhang[0]['email']; ?>" /></td>
        </tr>
        <tr>
            <td>Số điện thoại</td>
            <td><input type="text" disabled name="sdt" required value="<?php echo $khachhang[0]['sdt']; ?>" /></td>
        </tr>
        <tr>
            <td>Mật khẩu</td>
            <td><input type="password" disabled  name="pass" required value="<?php echo $khachhang[0]['matkhau']; ?>" /></td>
        </tr>
        <tr>
            <td>Địa chỉ</td>
            <td><input type="text" name="diachi" required value="<?php echo $khachhang[0]['diachi']; ?>" /></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td><input type="submit" name="btnSuaKH" value="Cập nhật" /></td>
        </tr>
    </table>
</form>

<?php
if (isset($_POST['btnSuaKH'])) {
    $hokh = $_POST['hokh'];
    $tenkh = $_POST['tenkh'];
    $email = $_POST['email'];
    $sdt = $_POST['sdt'];
    $ngaysinh=$_POST['ngaysinh'];
    $diachi = $_POST['diachi'];

    // Cập nhật DB
    $sql = "UPDATE khachhang SET 
                hodem = '$hokh',
                ten = '$tenkh', 
                email = '$email',
                ngaysinh = '$ngaysinh',
                diachi = '$diachi'
            WHERE idkh = '$cate'";
    $obj->suadulieu($sql);

    // Thông báo
    echo "<script>alert('Cập nhật khách hàng thành công!'); window.location.href='index.php?page=khachhang';</script>";
}
?>
