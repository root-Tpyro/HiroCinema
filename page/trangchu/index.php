<title>Trang chủ</title>
<?php
$db = new database();
$sql = "SELECT * FROM phim";
$products = $db->xuatdulieu($sql);
?> 
 <section>
        <div id="demo" class="carousel slide" data-ride="carousel">
        <ul class="carousel-indicators">
          <li data-target="#demo" data-slide-to="0" class="active"></li>
          <li data-target="#demo" data-slide-to="1"></li>
          <li data-target="#demo" data-slide-to="2"></li>
        </ul>
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src="assets/images/poster1.jpg" alt="" width="1400" height="700" />
          </div>
          <div class="carousel-item">
            <img src="assets/images/poster2.jpg" alt="" width="1400" height="700" />
          </div>
          <div class="carousel-item">
            <img src="assets/images/poster3.jpg" alt="" width="1400" height="700" />
          </div>
        </div>
        <a class="carousel-control-prev" href="#demo" data-slide="prev">
          <span class="carousel-control-prev-icon"></span>
        </a>
        <a class="carousel-control-next" href="#demo" data-slide="next">
          <span class="carousel-control-next-icon"></span>
        </a>
      </div>


    <div class="section-title pb-3">PHIM HOT TUẦN</div>
    <div class="row">
    <div class="col-md-12">
      <div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="0">
        <ol class="carousel-indicators">
          <!-- Thêm các indicator động dựa trên số lượng slide -->
          <?php 
          $totalSlides = ceil(count($products) / 4);
          for ($i = 0; $i < $totalSlides; $i++) {
            echo '<li data-target="#myCarousel" data-slide-to="' . $i . '" class="' . ($i == 0 ? 'active' : '') . '"></li>';
          }
          ?>
        </ol>
        <div class="carousel-inner">
          <!-- Lặp qua sản phẩm và nhóm chúng thành 4 sản phẩm mỗi slide -->
          <?php 
          $chunkedProducts = array_chunk($products, 4); // Chia sản phẩm thành các nhóm 4
          foreach ($chunkedProducts as $index => $productChunk) { ?>
            <div class="carousel-item <?php echo $index == 0 ? 'active' : ''; ?>">
              <div class="row">
                <?php foreach ($productChunk as $product) { ?>
                  <div class="col-sm-3">
                    <div class="thumb-wrapper">
                      <span class="wish-icon"><i class="fa fa-heart-o"></i></span>
                      <div class="img-box">
                        <img src="assets/images/<?php echo $product['poster']; ?>" class="" alt="" />
                      </div>
                      <div class="thumb-content">
                        <h4><?php echo $product['tenphim']; ?></h4>
                        <p class="item-price"><span><?php echo number_format($product['thoiluong'], 0, ',', '.'); ?> phút</span></p>
                        <a href="index.php?page=chitietphim&cate=<?php echo $product['idphim']; ?>" class="btn btn-primary">Xem thêm</a>
                      </div>
                    </div>
                  </div>
                <?php } ?>
              </div>
            </div>
          <?php } ?>
        </div>
        <a class="carousel-control-prev" href="#myCarousel" data-slide="prev">
          <i class="fa fa-angle-left"></i>
        </a>
        <a class="carousel-control-next" href="#myCarousel" data-slide="next">
          <i class="fa fa-angle-right"></i>
        </a>
      </div>
    </div>
  </div>

    <div class="section-title">SỰ KIỆN ƯU ĐÃI</div>
<div class="container my-4">
  <div class="row justify-content-center">
    <div class="col-md-4 mb-4">
      <div class="event-card shadow-sm">
        <img src="assets/images/e1.png" class="event-img" alt="Sự kiện 1">
        <div class="event-caption">Ưu đãi vé 1 tặng 1 cuối tuần!</div>
      </div>
    </div>
    <div class="col-md-4 mb-4">
      <div class="event-card shadow-sm">
        <img src="assets/images/e2.jpg" class="event-img" alt="Sự kiện 2">
        <div class="event-caption">Combo bắp nước chỉ 49k!</div>
      </div>
    </div>
    <div class="col-md-4 mb-4">
      <div class="event-card shadow-sm">
        <img src="assets/images/e3.jpg" class="event-img" alt="Sự kiện 3">
        <div class="event-caption">Thứ 4 vui vẻ – giá vé chỉ 39k</div>
      </div>
    </div>
  </div>
</div>



    <div class="row justify-content-center bg-light mt-5 mb-5 px-4">
  <div class="col-lg-8 col-md-10">
    <div class="pricing-card shadow p-4 rounded text-center">
      <h3 class="section-heading"><i class="fa fa-ticket-alt mr-2"></i>GIÁ VÉ</h3>
      <p class="text-muted mb-3">Tham khảo bảng giá vé hiện tại của hệ thống</p>
      <img src="assets/images/bangve.png" alt="Bảng giá vé" class="img-fluid rounded price-img mt-3 mb-2" />
    </div>
  </div>
</div>


      </section> 

      <style>
        /* Phần ảnh phim đứng */
.carousel .carousel-item .img-box {
    height: 380px; /* Cao hơn để ảnh phim hiển thị rõ */
    width: 100%;
    position: relative;
    overflow: hidden;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.carousel .carousel-item img {
    width: 100%;
    height: 100%;
    object-fit: cover; /* Giữ ảnh đúng tỷ lệ không méo */
    position: absolute;
    top: 0;
    left: 0;
    transition: transform 0.3s ease;
}

.carousel .carousel-item img:hover {
    transform: scale(1.05); /* Hiệu ứng zoom nhẹ khi hover */
}

/* Căn giữa và spacing đẹp hơn */
.carousel .thumb-wrapper {
    padding: 10px;
    background: #fff;
    border-radius: 8px;
    margin: 10px;
    transition: box-shadow 0.3s;
}

.carousel .thumb-wrapper:hover {
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
}

/* Tiêu đề phim */
.carousel .thumb-content h4 {
    font-size: 16px;
    font-weight: bold;
    margin: 10px 0 5px;
    color: #333;
    height: 40px;
    overflow: hidden;
}

/* Nút xem thêm */
.carousel .thumb-content .btn {
    font-size: 12px;
    padding: 6px 14px;
    background-color: #007bff;
    color: #fff;
    border: none;
    text-transform: uppercase;
    border-radius: 20px;
}

.carousel .thumb-content .btn:hover {
    background-color: #0056b3;
}

/* Giá/Thời lượng phim */
.carousel .item-price span {
    font-size: 13px;
    color: #777;
}
/* Mũi tên chuyển trái/phải */
.carousel-control-prev, .carousel-control-next {
    width: 40px;
    height: 100%;
    top: 0;
    bottom: 0;
    opacity: 0.8;
    color: #333;
    background: none;
    border: none;
    z-index: 10;
    transition: all 0.3s ease;
}

.carousel-control-prev:hover, .carousel-control-next:hover {
    opacity: 1;
}

/* Icon mũi tên */
.carousel-control-prev i, .carousel-control-next i {
    font-size: 36px;
    line-height: 100%;
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    color: rgba(0, 0, 0, 0.8);
}

.carousel-control-prev i {
    left: 10px;
}

.carousel-control-next i {
    right: 10px;
}

/* Căn chỉnh các chấm tròn dưới */
.carousel-indicators {
    position: absolute;
    bottom: -20px; /* Điều chỉnh vị trí thấp hơn cho đẹp */
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 0;
}

.carousel-indicators li {
    width: 12px;
    height: 12px;
    margin: 4px;
    border-radius: 50%;
    background-color: rgba(0, 0, 0, 0.2);
    border: none;
    transition: background-color 0.3s ease;
}

.carousel-indicators li.active {
    background-color: rgba(0, 0, 0, 0.6);
}
.section-title {
    text-align: center;
    font-size: 28px;
    font-weight: bold;
    margin-bottom: 30px;
    text-transform: uppercase;
    color: #333;
}

.event-card {
    background: #fff;
    border-radius: 10px;
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    cursor: pointer;
    text-align: center;
}

.event-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
}

.event-img {
    width: 100%;
    height: 230px;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.event-card:hover .event-img {
    transform: scale(1.05);
}

.event-caption {
    padding: 15px 10px;
    font-size: 16px;
    color: #444;
    font-weight: 500;
    background: #f8f8f8;
}
.section-heading {
    font-size: 28px;
    font-weight: 700;
    text-transform: uppercase;
    color: #2c3e50;
    border-bottom: 3px solid #f39c12;
    display: inline-block;
    padding-bottom: 6px;
    margin-bottom: 10px;
}

.pricing-card {
    background: #ffffff;
    border-radius: 16px;
    transition: transform 0.3s ease;
}

.pricing-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 25px rgba(0, 0, 0, 0.1);
}

.price-img {
    max-height: 400px;
    object-fit: contain;
    border: 1px solid #eee;
}

      </style>