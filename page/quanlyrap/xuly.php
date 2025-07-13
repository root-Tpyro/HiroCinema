<?php
if(isset($_POST["btThem"]))
{
    $tensp=$_POST["TenSP"];
    $mota=$_POST["MotaSP"];
    $filename_new=rand(111,999)."_".$_FILES["img"]["name"];
    if(move_uploaded_file($_FILES["img"]["tmp_name"],"assets/images/".$filename_new))
    {
        $sql="insert into cumrap(tenrap,diachi,hinhanh) values ('$tensp','$mota','$filename_new')";
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
        if($obj->xoarap($idnv)){
            echo '<script>alert("Xóa thành công!");</script>';
        }
        else{
            echo '<script>alert("Xóa thất bại!");</script>';
        }
    }

?>