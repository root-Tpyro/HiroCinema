<title>Sửa phim</title>
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
$phim=$obj->danhsachphim($cate);
?>
<h3 align="center"><strong>HIỆU CHỈNH PHIM</strong></h3>
<form method="post" enctype="multipart/form-data">
<table width="80%" style="border-collapse:collapse">
    <tr>
        <td width="30%">Tên rạp</td>
        <td><input type="text" class="form-control" name="tenphim" id="tenphim"  required required value="<?php echo $phim[0]['tenphim']?>"></td>
    </tr>
    <tr>
        <td>Thể loại</td>
        <td><input type="text" name="theloai" required value="<?php echo $phim[0]['theloai']?>" /></td>
    </tr>
    <tr>
        <td>Thời lượng</td>
        <td><input type="number" name="thoiluong" required value="<?php echo $phim[0]['thoiluong']?>" /></td>
    </tr>
    <tr>
        <td>Đạo diễn</td>
        <td><input type="text" name="daodien" required value="<?php echo $phim[0]['daodien']?>" /></td>
    </tr>
    <tr>
        <td>Diễn viên</td>
        <td><input type="text" name="dienvien" required value="<?php echo $phim[0]['dienvien']?>" /></td>
    </tr>
    <tr>
        <td>Mô tả</td>
        <td><input type="text" name="mota" required value="<?php echo $phim[0]['mota']?>" /></td>
    </tr>
    <tr>
        <td>Ngày khởi chiếu</td>
        <td><input type="date" name="ngaykhoichieu" required value="<?php echo $phim[0]['ngaykhoichieu']?>" /></td>
    </tr>
    <tr>
        <td>Độ tuổi</td>
        <td><input type="number" name="dotuoi" required value="<?php echo $phim[0]['dotuoi']?>" /></td>
    </tr>
    <tr>
        <td>Poster</td>
        <td><input type="file" name="poster" /></td>
    </tr>
    <tr>
        <td>Thể loại</td>
        <td>
            <select name="idds" required>
                <option value="">- Danh mục phim -</option>
                <?php echo $obj->selectds($phim[0]['idds']); ?>
            </select>
        </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td><input type="submit" name="btnSua" value="Sửa" /></td>
    </tr>

</table></form>


<?php
if (isset($_POST['btnSua'])) {
    $tenphim=$_POST["tenphim"];
    $theloai=$_POST["theloai"];
    $thoiluong=$_POST["thoiluong"];
    $daodien=$_POST["daodien"];
    $dienvien=$_POST["dienvien"];
    $mota=$_POST["mota"];
    $ngaykhoichieu=$_POST["ngaykhoichieu"];
    $dotuoi=$_POST["dotuoi"];
    $idds=$_POST["idds"];
    $poster = $_FILES['poster']['name'];

    // Upload hình ảnh (nếu có)
    if (!empty($poster)) {
        $targetDir = "assets/images/";
        $targetFile = $targetDir . basename($poster);
        move_uploaded_file($_FILES['poster']['tmp_name'], $targetFile);
    } else {
        $poster = $phim[0]['poster']; // Giữ nguyên hình ảnh cũ nếu không tải lên mới
    }

    // Cập nhật thông tin sản phẩm
    $sql = "UPDATE phim SET 
                tenphim = '$tenphim',
                theloai = '$theloai',
                thoiluong = '$thoiluong',
                daodien = '$daodien',
                dienvien = '$dienvien',
                mota = '$mota',
                ngaykhoichieu = '$ngaykhoichieu',
                dotuoi = '$dotuoi',
                poster = '$poster',
                idds = '$idds'
            WHERE idphim = '$cate'";
    $obj->suasanpham($sql);

    // Thông báo và chuyển hướng
    echo "<script>alert('Cập nhật sản phẩm thành công!'); window.location.href='index.php?page=quanlyphim';</script>";
}
?>
