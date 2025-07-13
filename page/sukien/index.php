<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sự kiện - Rạp chiếu phim Hiro</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        .hero-banner {
            background: url('assets/images/banner4.jpg') no-repeat center center;
            background-size: cover;
            height: 400px;
            color: white;
            text-align: center;
            position: relative;
        }
        .hero-banner h1 {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 48px;
            font-weight: bold;
            text-shadow: 2px 2px 5px #000;
        }
        .section-title {
            margin: 40px 0 20px;
            text-align: center;
        }
        .event-card {
            transition: all 0.3s ease;
        }
        .event-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0,0,0,0.2);
        }
        .event-card img {
            height: 200px;
            object-fit: cover;
        }
        .event-caption {
            height: 160px;
        }
    </style>
</head>
<body>

<!-- Banner -->
<div class="hero-banner">
    <h1>SỰ KIỆN HIRO CINEMA</h1>
</div>

<!-- Nội dung sự kiện -->
<div class="container">
    <h2 class="section-title">Sự kiện đang diễn ra</h2>
    <div class="row">

        <!-- Sự kiện 1 -->
        <div class="col-sm-4">
            <div class="thumbnail event-card">
                <div class="text-center"><img src="assets/images/ta1.jpg" alt="Event 1"></div>
                <div class="caption event-caption">
                    <h3>Tặng Popcorn miễn phí</h3>
                    <p>Đặt vé online, nhận ngay combo bắp nước tại quầy!</p>
                    <p><a href="#" class="btn btn-danger">Chi tiết</a></p>
                </div>
            </div>
        </div>

        <!-- Sự kiện 2 -->
        <div class="col-sm-4">
            <div class="thumbnail event-card">
                <div class="text-center"><img src="assets/images/ta2.jpg" alt="Event 2"></div>
                <div class="caption event-caption">
                    <h3>Đêm cosplay Avengers</h3>
                    <p>Hóa thân thành siêu anh hùng & nhận quà từ Hiro!</p>
                    <p><a href="#" class="btn btn-danger">Tham gia ngay</a></p>
                </div>
            </div>
        </div>

        <!-- Sự kiện 3 -->
        <div class="col-sm-4">
            <div class="thumbnail event-card">
                <div class="text-center"><img src="assets/images/ta1.png" alt="Event 3"></div>
                <div class="caption event-caption">
                    <h3>Khuyến mãi Mua 1 Tặng 1</h3>
                    <p>Áp dụng khi mua vé vào thứ 4 hàng tuần tại mọi chi nhánh của Hiro.</p>
                    <p><a href="#" class="btn btn-danger">Xem chi tiết</a></p>
                </div>
            </div>
        </div>

    </div>
</div>
</body>
</html>
