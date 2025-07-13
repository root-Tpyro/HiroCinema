<?php
$conn = new database();
$raps = $conn->xuatdulieu("SELECT * FROM cumrap"); // giả sử trả về array
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rạp chiếu phim Hiro</title>
    <style>
        .banner h1 {
            background: url('assets/images/banner4.jpg') no-repeat center center;
            background-size: cover;
            height: 400px;
            color: white;
            text-align: center;
            line-height: 400px;
            font-size: 45px;
            font-weight: bold;
        }
        .cinema-box {
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            height: 380px;
        }
        .cinema-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 10px;
        }
        h2.section-title {
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
    <div class="banner">
   <h1>RẠP CHIẾU</h1> 
</div>

<section class="container mt-5">
  <p class="text-center">
    Hiro là rạp chiếu phim hiện đại hàng đầu tại Việt Nam, nơi hội tụ của công nghệ trình chiếu tiên tiến và không gian giải trí đẳng cấp. Tại <a href="index.php?page=trangchu"><strong>Hiro</strong></a>, chúng tôi không chỉ mang đến những bộ phim hấp dẫn mà còn là trải nghiệm giải trí toàn diện, thoải mái và đầy cảm xúc. Với khẩu hiệu "Thắp sáng cảm xúc từng khung hình", <a href="index.php?page=trangchu"><strong>Hiro</strong></a> cam kết đem lại dịch vụ tận tâm, chất lượng hình ảnh - âm thanh vượt trội và một không gian thưởng thức điện ảnh lý tưởng.
  </p>
  <div class="row">
    <div class="col-md-6">
      <img src="assets/images/r1.jpg" width="600" class="img-fluid pt-4" alt="Phòng chiếu hiện đại của Hiro"/>
    </div>
    <div class="col-md-6 pt-5">
      <h3 class="text-center"><strong>Giá Trị Cốt Lõi</strong></h3>
      <ul class="pt-3">
        <li><strong>Chất lượng:</strong> Trang bị máy chiếu 4K, âm thanh vòm sống động và ghế ngồi thoải mái tiêu chuẩn quốc tế.</li>
        <li><strong>Sáng tạo:</strong> Luôn cập nhật những công nghệ mới và hình thức giải trí sáng tạo như rạp chiếu 3D, 4DX.</li>
        <li><strong>Khách hàng là trung tâm:</strong> Luôn lắng nghe và phục vụ tận tâm để mang lại trải nghiệm tối ưu nhất cho khán giả.</li>
        <li><strong>Tiện lợi:</strong> Hệ thống đặt vé online nhanh chóng, combo đồ ăn đa dạng và thủ tục vào rạp dễ dàng, hiện đại.</li>
      </ul>
    </div>
  </div>
</section>

<!-- Phần Carousel -->
<section class="carousel-section container mt-5">
  <h2 class="text-center"><b>PHIM ĐANG CHIẾU NỔI BẬT</b></h2>
  <div id="Carousel" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="assets/images/br2.jpg" class="d-block w-100" alt="Bom Tấn Hành Động"/>
        <div class="carousel-caption d-none d-md-block">
          <h5>Bom Tấn Hành Động</h5>
          <p>Phim hành động mãn nhãn với những pha rượt đuổi kịch tính và kỹ xảo đỉnh cao, đưa bạn vào thế giới của tốc độ và thử thách.</p>
        </div>
      </div>
      <div class="carousel-item">
        <img src="assets/images/br3.jpg" class="d-block w-100" alt="Phim Hoạt Hình Gia Đình" />
        <div class="carousel-caption d-none d-md-block">
          <h5>Phim Hoạt Hình Gia Đình</h5>
          <p>Câu chuyện nhẹ nhàng, hài hước và giàu ý nghĩa dành cho mọi lứa tuổi – lựa chọn hoàn hảo cho buổi xem phim cùng người thân.</p>
        </div>
      </div>
      <div class="carousel-item">
        <img src="assets/images/br1.jpeg" class="d-block w-100" alt="Tình Cảm Lãng Mạn" />
        <div class="carousel-caption d-none d-md-block">
          <h5>Phim Tình Cảm Lãng Mạn</h5>
          <p>Những mối tình đầy cảm xúc, gợi mở những cung bậc lãng mạn, khiến trái tim khán giả rung động qua từng khung hình.</p>
        </div>
      </div>
    </div>
    <a class="carousel-control-prev" href="#Carousel" role="button" data-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#Carousel" role="button" data-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
</section>

<!-- Giới thiệu rạp chiếu -->
<section class="store-intro container mt-4">
  <h2 class="text-center"><b>KHÔNG GIAN HIRO CINEMA</b></h2>
  <p class="text-center">
    Hệ thống rạp của *Hiro* được thiết kế hiện đại, ấm cúng và tiện nghi. Mỗi phòng chiếu là sự kết hợp giữa công nghệ và thẩm mỹ, mang đến trải nghiệm xem phim đỉnh cao trong một không gian thân thiện và gần gũi.
  </p>
  <div class="row">
    <div class="col-md-4">
      <img src="assets/images/r2.jpg" width="350" height="300" alt=""/>
      <h4 class="text-center pt-3">Phòng Chiếu Cao Cấp</h4>
    </div>
    <div class="col-md-4">
      <img src="assets/images/c1.jpg" width="350" height="300" alt=""/>
      <h4 class="text-center pt-3">Khu Vực Chờ Thoải Mái</h4>
    </div>
    <div class="col-md-4">
      <img src="assets/images/c2.jpg" width="350" height="300" alt=""/>
      <h4 class="text-center pt-3">Quầy Đồ Ăn Đa Dạng</h4>
    </div>
  </div>
</section>

<style>
.carousel-item img {
  transition: transform 0.5s ease;
}
.carousel-item img:hover {
  transform: scale(1.05);
}
</style>





<div class="container">
    <h2 class="section-title text-center">📍DANH SÁCH RẠP CHIẾU HIRO</h2>
    <div class="row">
        <?php if (is_array($raps) && count($raps) > 0): ?>
            <?php foreach ($raps as $rap): ?>
                <div class="col-sm-6 col-md-4">
                    <div class="cinema-box">
                        <img src="assets/images/<?php echo $rap['hinhanh']; ?>" class="cinema-image" alt="<?php echo $rap['tenrap']; ?>">
                        <h4 class="text-center pt-3"><?php echo $rap['tenrap']; ?></h4>
                        <p><strong>Địa chỉ:</strong> <?php echo $rap['diachi']; ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class='text-center'>Hiện tại chưa có rạp nào được thêm.</p>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
