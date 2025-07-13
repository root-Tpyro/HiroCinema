<title>Quản lý phim</title>
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
include("page/quanlyphim/xuly.php");
?>
<section class="pt-4 pb-4">
<div class="form-container">
    <h3><i class="fa-solid fa-plus"></i> Thêm Phim</h3>
    <form method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="tenphim" class="form-label">Tên phim</label>
            <input type="text" class="form-control" name="tenphim" id="tenphim" required>
        </div>
        <div class="mb-3">
            <label for="theloai" class="form-label">Thể loại</label>
            <input type="text" class="form-control" name="theloai" id="theloai" required>
        </div>
        <div class="mb-3">
            <label for="thoiluong" class="form-label">Thời lượng</label>
            <input type="number" class="form-control" name="thoiluong" id="thoiluong" required>
        </div>
        <div class="mb-3">
            <label for="daodien" class="form-label">Đạo diễn phim</label>
            <input type="text" class="form-control" name="daodien" id="daodien" required>
        </div>
        <div class="mb-3">
            <label for="dienvien" class="form-label">Diễn viên chính</label>
            <input type="text" class="form-control" name="dienvien" id="dienvien" required>
        </div>
        <div class="mb-3">
            <label for="mota" class="form-label">Mô tả</label>
            <input type="text" class="form-control" name="mota" id="mota" required>
        </div>
        <div class="mb-3">
            <label for="ngaykhoichieu" class="form-label">Ngày khởi chiếu</label>
            <input type="date" class="form-control" name="ngaykhoichieu" id="ngaykhoichieu" required>
        </div>
        <div class="mb-3">
            <label for="dotuoi" class="form-label">Độ tuổi cho phép</label>
            <input type="number" class="form-control" name="dotuoi" id="dotuoi" required>
        </div>
        <div class="mb-3">
            <label for="poster" class="form-label">Hình ảnh</label>
            <input type="file" class="form-control" name="poster" id="poster" required>
        </div>
        <div class="mb-3">
            <label for="dm" class="form-label">Danh mục phim</label>
        <td>
            <select name="idds" required>
                <?php echo $obj->selectds(); ?>
            </select>
        </td>
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
$phim=$obj->danhsachphim();
if($phim)
{
    echo '<form method="post" action="">
                <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tên phim</th>
                        <th>Thể loại</th>
                        <th>Thời lượng</th>
                        <th>Đạo diễn</th>
                        <th>Diễn viên</th>
                        
                        <th>Ngày khởi chiếu</th>
                        <th>Lứa tuổi</th>
                        <th>Hình ảnh</th>
                        <th>Danh mục</th>
                        <th>Thao Tác</th>
                    </tr>
                </thead>';
        for($i=0;$i<count($phim);$i++){
            echo '<tr>
            <td>'.($i+1).'</td>
            <td><a href="index.php?page=suaphim&cate='.$phim[$i]['idphim'].'">'.$phim[$i]['tenphim'].'</a></td>
            <td>'.$phim[$i]['theloai'].'</td>
            <td>'.$phim[$i]['thoiluong'].'</td>
            <td>'.$phim[$i]['daodien'].'</td>
            <td>'.$phim[$i]['dienvien'].'</td>
            <td>'.date('d-m-Y', strtotime($phim[$i]['ngaykhoichieu'])).'</td>
            <td>'.$phim[$i]['dotuoi'].'</td>
            <td><img src="assets/images/'.$phim[$i]['poster'].'" width="100" height="100" /></td>
            <td>'.$phim[$i]['ten'].'</td>
            
            <td>
                <button type="submit" name="btnXoa" value="'.$phim[$i]['idphim'].'" class="btn btn-danger btn-sm"  onclick="return confirm(\'Bạn có chắc chắn muốn xóa rạp này?\');");">Xóa</button>
            </td>
        </tr>';
        }
        echo '</table>
        </form>';
}
?>
</div>
</section>