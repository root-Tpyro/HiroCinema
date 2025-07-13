<title>Quản lý khách hàng</title>
<style>
  .form-container {
    max-width: 700px;
    margin: 0 auto;
    background-color: white;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  }

  h3 {
    text-align: center;
    color: #343a40;
    font-weight: bold;
  }

  .subtitle {
    text-align: center;
    font-size: 15px;
    color: #6c757d;
    margin-bottom: 25px;
  }

  .table-responsive {
    overflow-x: auto;
  }

  .table-hover tbody tr:hover {
    background-color: #f9f9f9;
  }
</style>

<?php
include("class/classxuly.php");
$obj = new xuly();
include("page/khachhang/xuly.php"); // File xử lý thêm/xóa khách hàng
?>

<section class="pt-4 pb-4">
  <div class="container mt-5">
    <h3><i class="fas fa-users"></i> QUẢN LÝ KHÁCH HÀNG</h3>
    <p class="subtitle">Danh sách khách hàng đang sử dụng hệ thống. Bạn có thể chỉnh sửa hoặc xóa thông tin tại đây.</p>

    <?php
    $dsKH = $obj->danhsachkhachhang();
    if ($dsKH) {
      echo '<form method="post" action="">
              <div class="table-responsive">
              <table class="table table-bordered table-hover table-striped">
              <thead class="thead-light">
                <tr class="text-center">
                  <th>STT</th>
                  <th>Họ tên</th>
                  <th>Email</th>
                  <th>SĐT</th>
                  <th>Ngày sinh</th>
                  <th>Thao tác</th>
                </tr>
              </thead>
              <tbody>';
      for ($i = 0; $i < count($dsKH); $i++) {
        echo '<tr>
                <td class="text-center">' . ($i + 1) . '</td>
                <td>' . htmlspecialchars($dsKH[$i]['hodem'] . ' ' . $dsKH[$i]['ten']) . '</td>
                <td>' . htmlspecialchars($dsKH[$i]['email']) . '</td>
                <td class="text-center">' . htmlspecialchars($dsKH[$i]['sdt']) . '</td>
                <td class="text-center">' . date("d/m/Y", strtotime($dsKH[$i]['ngaysinh'])) . '</td>
                <td class="text-center">
                  <a href="index.php?page=suakhachhang&cate='.$dsKH[$i]['idkh'].'" class="btn btn-warning btn-sm">Sửa</a>
                  <button type="submit" name="btnXoa" value="' . $dsKH[$i]['idkh'] . '" class="btn btn-danger btn-sm" onclick="return confirm(\'Bạn có chắc chắn muốn xóa khách hàng này?\');">
                    Xóa
                  </button>
                </td>
              </tr>';
      }
      echo '</tbody></table></div></form>';
    } else {
      echo '<div class="alert alert-warning text-center">Hiện chưa có khách hàng nào trong hệ thống.</div>';
    }
    ?>
  </div>
</section>

<!-- Font Awesome (để có icon) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
