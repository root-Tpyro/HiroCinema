 <title>Quản lý hệ thống</title>
 <style>
        body {
            background-color: #f4f6f9;
        }
        .admin-container {
            max-width: 1000px;
            margin: 40px auto;
        }
        .admin-card {
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            padding: 25px;
            background: white;
            margin-bottom: 20px;
            transition: 0.3s;
        }
        .admin-card:hover {
            background-color: #f0f8ff;
        }
        .admin-card a {
            text-decoration: none;
            font-size: 18px;
            color: #333;
        }
        .admin-card i {
            margin-right: 10px;
            color: #007bff;
        }
    </style>

<div class="container admin-container">
    <h2 class="text-center mb-4">🎬 <strong>TRANG QUẢN LÝ HỆ THỐNG</strong></h2>

    <div class="admin-card">
        <a href="index.php?page=themcombo"><i class="fa-solid fa-utensils"></i> Quản lý Combo</a>
    </div>
    <div class="admin-card">
        <a href="index.php?page=quanlyrap"><i class="fa-solid fa-building"></i> Quản lý Cụm Rạp</a>
    </div>
    <div class="admin-card">
        <a href="index.php?page=khachhang"><i class="fa-solid fa-users"></i> Quản lý Khách Hàng</a>
    </div>
    <div class="admin-card">
        <a href="index.php?page=quanlyphim"><i class="fa-solid fa-film"></i> Quản lý Phim</a>
    </div>
    <div class="admin-card">
        <a href="index.php?page=thietlaplich"><i class="fa-solid fa-door-open"></i> Thiết lập Lịch Chiếu</a>
    </div>
    <div class="admin-card">
        <a href="index.php?page=lichsu"><i class="fa-solid fa-ticket-alt"></i> Lịch sử đặt vé của khách hàng</a>
    </div>

    <div class="text-center mt-4">
        <a href="../index.php?page=trangchu" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Quay về trang chủ</a>
    </div>
</div>