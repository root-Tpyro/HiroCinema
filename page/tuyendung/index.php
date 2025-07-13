<title>Tuyển dụng</title>
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
</style>

<div class="hero-banner">
    <h1>TUYỂN DỤNG</h1>
</div>

<!-- Recruitment Section for Hiro Cinema -->
<div class="container" style="margin-top: 40px;">
    <div class="row">
        <div class="col-md-12 text-center">
            <h2 class=""><strong>GIA NHẬP ĐỘI NGŨ HIRO CINEMA</strong></h2>
            <p class="lead">Chúng tôi đang tìm kiếm những cá nhân năng động, nhiệt huyết và đam mê điện ảnh.</p>
            <hr>
        </div>
    </div>

    <!-- Job Positions -->
    <div class="row">
        <!-- Job Card 1 -->
        <div class="col-sm-6 col-md-4">
            <div class="thumbnail">
                <img src="assets/images/td1.jpg" alt="Thu ngân" class="img-responsive" width="350" height="250">
                <div class="caption">
                    <h5 class="text-center pt-2"><strong>Nhân viên Thu ngân</strong></h5>
                    <p>
                        <strong>Thời gian:</strong> Ca xoay linh hoạt<br>
                        <strong>Lương:</strong> 6.000.000 - 8.000.000 VNĐ/tháng<br>
                        <strong>Mô tả:</strong> Hỗ trợ khách hàng thanh toán vé và combo.
                    </p>
                    <p><a href="#formApply" class="btn btn-primary btn-block" role="button">Ứng tuyển ngay</a></p>
                </div>
            </div>
        </div>

        <!-- Job Card 2 -->
        <div class="col-sm-6 col-md-4">
            <div class="thumbnail">
                <img src="assets/images/td2.jpg" alt="Thu ngân" class="img-responsive" width="350" height="250">
                <div class="caption">
                    <h5 class="text-center pt-2"><strong>Nhân viên Phục vụ rạp</strong></h5>
                    <p>
                        <strong>Thời gian:</strong> Ca tối và cuối tuần<br>
                        <strong>Lương:</strong> 6.500.000 VNĐ/tháng + phụ cấp<br>
                        <strong>Mô tả:</strong> Hướng dẫn chỗ ngồi, dọn dẹp, hỗ trợ khách trong rạp.
                    </p>
                    <p><a href="#formApply" class="btn btn-primary btn-block" role="button">Ứng tuyển ngay</a></p>
                </div>
            </div>
        </div>

        <!-- Job Card 3 -->
        <div class="col-sm-6 col-md-4">
            <div class="thumbnail">
                <img src="assets/images/td3.jpg" alt="Thu ngân" class="img-responsive" width="350" height="250">
                <div class="caption">
                    <h5 class="text-center pt-2"><strong>Kỹ thuật viên máy chiếu</strong></h5>
                    <p>
                        <strong>Thời gian:</strong> Full-time<br>
                        <strong>Lương:</strong> 9.000.000 VNĐ/tháng<br>
                        <strong>Mô tả:</strong> Vận hành, kiểm tra, bảo trì máy chiếu và hệ thống âm thanh.
                    </p>
                    <p><a href="#formApply" class="btn btn-primary btn-block" role="button">Ứng tuyển ngay</a></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Application Form -->
    <div class="row" id="formApply" style="margin-top: 50px; padding-bottom: 30px">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-info">
                <div class="panel-heading text-center"><strong><h3><b>FORM ỨNG TUYỂN</b></h3></strong></div>
                <div class="panel-body">
                    <form action="process_application.php" method="post">
                        <div class="form-group">
                            <label for="fullname">Họ và tên:</label>
                            <input type="text" class="form-control" name="fullname" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Số điện thoại:</label>
                            <input type="text" class="form-control" name="phone" required>
                        </div>
                        <div class="form-group">
                            <label for="position">Vị trí ứng tuyển:</label>
                            <select class="form-control" name="position" required>
                                <option value="">-- Chọn vị trí --</option>
                                <option value="Thu ngân">Nhân viên Thu ngân</option>
                                <option value="Phục vụ rạp">Nhân viên Phục vụ rạp</option>
                                <option value="Kỹ thuật viên">Kỹ thuật viên máy chiếu</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="message">Giới thiệu bản thân:</label>
                            <textarea class="form-control" name="message" rows="4"></textarea>
                        </div>
                        <button type="submit" class="btn btn-success btn-block">Gửi</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-4 pt-3">
            <div><img src="assets/images/nv1.jpg" width="400" alt=""></div>
            <div><img src="assets/images/td4.jpg" width="400" alt=""></div>
        </div>
    </div>
</div>
