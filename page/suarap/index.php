<title>Sửa rạp chiếu</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background: #f9f9f9;
    }

    h3 {
        margin-top: 30px;
        color: #333;
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
        background: #28a745;
        color: white;
        font-size: 16px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    input[type="submit"]:hover {
        background: #218838;
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
$rapchieu=$obj->danhsachrapchieu($cate);
?>
<h3 align="center"><strong>HIỆU CHỈNH RẠP CHIẾU PHIM</strong></h3>
<form method="post" enctype="multipart/form-data">
<table width="80%" style="border-collapse:collapse">
    <tr>
        <td width="30%">Tên rạp</td>
        <td><input type="text" name="TenSP" required value="<?php echo $rapchieu[0]['tenrap']?>" /></td>
    </tr>
    <tr>
        <td>Địa chỉ</td>
        <td><input type="text" name="MotaSP" required value="<?php echo $rapchieu[0]['diachi']?>" /></td>
    </tr>
    <tr>
        <td>Hình</td>
        <td><input type="file" name="img" /></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td><input type="submit" name="btnSua" value="Sửa" /></td>
    </tr>

</table></form>
<?php
if (isset($_POST['btnSua'])) {
    $TenSP = $_POST['TenSP'];
    $MotaSP = $_POST['MotaSP'];
    $img = $_FILES['img']['name'];

    // Upload hình ảnh (nếu có)
    if (!empty($img)) {
        $targetDir = "assets/images/";
        $targetFile = $targetDir . basename($img);
        move_uploaded_file($_FILES['img']['tmp_name'], $targetFile);
    } else {
        $img = $rapchieu[0]['hinhanh']; // Giữ nguyên hình ảnh cũ nếu không tải lên mới
    }

    // Cập nhật thông tin sản phẩm
    $sql = "UPDATE cumrap SET 
                tenrap = '$TenSP', 
                diachi = '$MotaSP', 
                hinhanh = '$img' 
            WHERE idrap = '$cate'";
    $obj->suasanpham($sql);

    // Thông báo và chuyển hướng
    echo "<script>alert('Cập nhật sản phẩm thành công!'); window.location.href='index.php?page=quanlyrap';</script>";
}
?>

