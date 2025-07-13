<?php
if(isset($_POST["btThem"]))
{
    $tensp=$_POST["TenSP"];
    $mota=$_POST["MotaSP"];
    $gia=$_POST["dongia"];
    $filename_new=rand(111,999)."_".$_FILES["img"]["name"];
    if(move_uploaded_file($_FILES["img"]["tmp_name"],"assets/images/".$filename_new))
    {
        $sql="insert into combo(tencombo,giacombo,mota,hinhanh) values ('$tensp','$gia','$mota','$filename_new')";
        if($obj->themsanpham($sql))
            echo "Them thanh cong";
        else
            echo "Them that bai";
    }
    else
        echo "upload that bait";


}



?>

<?php
    if(isset($_POST['btnXoa'])){
        $idnv=$_POST['btnXoa'];
        if($obj->xoacombo($idnv)){
            echo '<script>alert("Xóa thành công!");</script>';
        }
        else{
            echo '<script>alert("Xóa thất bại!");</script>';
        }
    }

?>