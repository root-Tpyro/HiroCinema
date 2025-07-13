
    <title>Quản lý combo</title>
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
            margin-bottom: 25px;
            color: #343a40;
        }
    </style>

<?php
include("class/classxuly.php");
$obj = new xuly();
include("page/themcombo/xuly.php");
?>
<section class="pt-4 pb-4">
<div class="form-container">
    <h3><i class="fa-solid fa-plus"></i> Thêm combo thức ăn</h3>
    <form method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="TenSP" class="form-label">Tên combo</label>
            <input type="text" class="form-control" name="TenSP" id="TenSP" required>
        </div>
        <div class="mb-3">
            <label for="MotaSP" class="form-label">Mô tả</label>
            <input type="text" class="form-control" name="MotaSP" id="MotaSP" required>
        </div>
        <div class="mb-3">
            <label for="dongia" class="form-label">Giá</label>
            <input type="number" class="form-control" name="dongia" id="dongia" required>
        </div>
        <div class="mb-3">
            <label for="img" class="form-label">Hình ảnh</label>
            <input type="file" class="form-control" name="img" id="img" required>
        </div>
        <div class="text-center">
            <button type="submit" name="btThem" class="btn btn-primary">
                <i class="fa fa-plus-circle"></i> Thêm sản phẩm
            </button>
        </div>
    </form>
</div>

<div class="container mt-5">
<?php
    $sp=$obj->danhsachsanpham();
    if($sp){
          echo '<form method="post" action="">
                <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tên Combo</th>
                        <th>Giá</th>
                        <th>Mô tả</th>
                        <th>Hình ảnh</th>
                        <th>Thao Tác</th>
                    </tr>
                </thead>';
        for($i=0;$i<count($sp);$i++){
            echo '<tr>
            <td>'.($i+1).'</td>
            <td>'.$sp[$i]['tencombo'].'</td>
            <td>'.$sp[$i]['giacombo'].'</td>
            <td>'.$sp[$i]['mota'].'</td>
            <td><img src="assets/images/'.$sp[$i]['hinhanh'].'" width="100" height="100" /></td>
            <td>
                <a href="index.php?page=suacombo&cate='.$sp[$i]['idcombo'].'" class="btn btn-warning btn-sm">Sửa</a>
                <button type="submit" name="btnXoa" value="'.$sp[$i]['idcombo'].'" class="btn btn-danger btn-sm"  onclick="return confirm(\'Bạn có chắc chắn muốn xóa nhân viên này?\');");">Xóa</button>
            </td>
        </tr>';
        }
        echo '</table>
        </form>';
    }
?>
    </div>
</section>

