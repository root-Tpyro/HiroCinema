<?php
if(isset($_POST["btThem"]))
{
    $tenphim=$_POST["tenphim"];
    $theloai=$_POST["theloai"];
    $thoiluong=$_POST["thoiluong"];
    $daodien=$_POST["daodien"];
    $dienvien=$_POST["dienvien"];
    $mota=$_POST["mota"];
    $ngaykhoichieu=$_POST["ngaykhoichieu"];
    $dotuoi=$_POST["dotuoi"];
    $idds=$_POST["idds"];
    $filename_new=rand(111,999)."_".$_FILES["poster"]["name"];
    if(move_uploaded_file($_FILES["poster"]["tmp_name"],"assets/images/".$filename_new))
    {
        $sql="insert into phim(tenphim, theloai, thoiluong, daodien, dienvien, mota, ngaykhoichieu, dotuoi, poster, idds) values ('$tenphim','$theloai','$thoiluong','$daodien','$dienvien','$mota','$ngaykhoichieu','$dotuoi','$filename_new','$idds')";
        if($obj->themsanpham($sql))
            echo '<script>alert("Thêm thành công!");</script>';
        else
            echo '<script>alert("Thêm thất bại!");</script>';
    }
    else
        echo "Upload hình ảnh thất bại!";


}



?>

<?php
    if(isset($_POST['btnXoa'])){
        $idnv=$_POST['btnXoa'];
        if($obj->xoaphim($idnv)){
            echo '<script>alert("Xóa thành công!");</script>';
        }
        else{
            echo '<script>alert("Xóa thất bại!");</script>';
        }
    }

?>