<title>Quản lý cụm rạp</title>
    <style>
        .form-container {
            max-width: 700px;
            margin: 0 auto;
            background-color: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        h3 {
            text-align: center;
            color: #343a40;
        }
    </style>



<?php
include("class/classxuly.php");
$obj = new xuly();
include("page/quanlyrap/xuly.php");
?>
<section class="pt-4 pb-4">
<div class="form-container">
    <h3><i class="fa-solid fa-plus"></i> Thêm Cụm Rạp</h3>
    <form method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="TenSP" class="form-label">Tên rạp</label>
            <input type="text" class="form-control" name="TenSP" id="TenSP" required>
        </div>
        <div class="mb-3">
            <label for="MotaSP" class="form-label">Địa chỉ</label>
            <input type="text" class="form-control" name="MotaSP" id="MotaSP" required>
        </div>
        <div class="mb-3">
            <label for="img" class="form-label">Hình ảnh</label>
            <input type="file" class="form-control" name="img" id="img" required>
        </div>
        <div class="text-center">
            <button type="submit" name="btThem" class="btn btn-primary">
                <i class="fa fa-plus-circle"></i> Thêm Rạp
            </button>
        </div>
    </form>
</div>
<section></section>
<div class="container mt-5">
<?php
$rapchieu=$obj->danhsachrapchieu();
if($rapchieu)
{
    echo '<form method="post" action="">
                <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tên Rạp</th>
                        <th>Địa chỉ</th>
                        <th>Hình ảnh</th>
                        <th>Thao Tác</th>
                    </tr>
                </thead>';
        for($i=0;$i<count($rapchieu);$i++){
            echo '<tr>
            <td>'.($i+1).'</td>
            <td><a href="index.php?page=suarap&cate='.$rapchieu[$i]['idrap'].'">'.$rapchieu[$i]['tenrap'].'</a></td>
            <td>'.$rapchieu[$i]['diachi'].'</td>
            <td><img src="assets/images/'.$rapchieu[$i]['hinhanh'].'" width="100" height="100" /></td>
            <td>
                <button type="submit" name="btnXoa" value="'.$rapchieu[$i]['idrap'].'" class="btn btn-danger btn-sm"  onclick="return confirm(\'Bạn có chắc chắn muốn xóa rạp này?\');");">Xóa</button>
            </td>
        </tr>';
        }
        echo '</table>
        </form>';
}
?>
</div>
</section>