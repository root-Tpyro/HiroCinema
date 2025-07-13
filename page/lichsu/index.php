<title>Lịch sử đặt vé</title>
<?php
$db = new database();
?>

<div class="container my-5">
  <div class="card shadow-lg border-0">
    <div class="card-header bg-primary text-white text-center">
      <h3 class="mb-0">LỊCH SỬ ĐẶT VÉ</h3>
    </div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-bordered table-hover mb-0 text-center">
          <thead class="thead-light">
            <tr>
              <th scope="col">STT</th>
              <th scope="col" class="text-left">Họ tên</th>
              <th scope="col" class="text-left">Tên phim</th>
              <th scope="col">Ghế</th>
              <th scope="col" class="text-left">Rạp</th>
              <th scope="col" class="text-left">Phòng</th>
              <th scope="col" class="text-left">Suất chiếu</th>
              <th scope="col" class="text-left">Ngày đặt</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $sql = "SELECT 
          CONCAT(khachhang.hodem, ' ', khachhang.ten) AS hoten,
          phim.tenphim,
          GROUP_CONCAT(ghe.tenghe ORDER BY ghe.tenghe SEPARATOR ', ') AS ds_ghe,
          cumrap.tenrap,
          phongchieu.tenphong,
          suatchieu.giobatdau,ngaydat
        FROM ve
        JOIN khachhang ON ve.idkh = khachhang.idkh
        JOIN suatchieu ON ve.idsuatchieu = suatchieu.idsuatchieu
        JOIN phim ON suatchieu.idphim = phim.idphim
        JOIN ghe ON ve.idghe = ghe.idghe
        JOIN phongchieu ON ghe.idphong = phongchieu.idphong
        JOIN cumrap ON phongchieu.idrap = cumrap.idrap
        GROUP BY ve.idkh, ve.idsuatchieu, phim.tenphim, cumrap.tenrap, phongchieu.tenphong, suatchieu.giobatdau
        ORDER BY suatchieu.giobatdau DESC";


            $result = $db->xuatdulieu($sql);
            $stt = 1;
foreach ($result as $row) {
  echo '<tr>';
  echo '<td>'.$stt++.'</td>';
  echo '<td class="text-left">'.htmlspecialchars($row['hoten']).'</td>';
  echo '<td class="text-left">'.htmlspecialchars($row['tenphim']).'</td>';
  echo '<td>'.htmlspecialchars($row['ds_ghe']).'</td>';
  echo '<td class="text-left">'.htmlspecialchars($row['tenrap']).'</td>';
  echo '<td class="text-left">'.htmlspecialchars($row['tenphong']).'</td>';
  echo '<td class="text-left">'.htmlspecialchars($row['giobatdau']).'</td>';
  echo '<td class="text-left">'.date('d-m-Y', strtotime($row['giobatdau'])).'</td>';

  echo '</tr>';
}

            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
