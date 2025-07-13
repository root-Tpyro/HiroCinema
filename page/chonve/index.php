<?php
require_once("class/classdb.php");
$db = new database();

if (!isset($_GET['suat'])) {
    echo "<div class='container mt-4'><div class='alert alert-danger'>Không tìm thấy suất chiếu!</div></div>";
    return;
}

$idsuat = intval($_GET['suat']);

$sql = "SELECT sc.idsuatchieu, sc.giobatdau, sc.ngaychieu, 
               pc.tenphong, cr.tenrap, cr.diachi, pc.idphong
        FROM suatchieu sc
        JOIN phongchieu pc ON sc.idphong = pc.idphong
        JOIN cumrap cr ON pc.idrap = cr.idrap
        WHERE sc.idsuatchieu = $idsuat";
$thongtin = $db->laydong($sql);

if (!$thongtin) {
    echo "<div class='container mt-4'><div class='alert alert-danger'>Không tìm thấy thông tin suất chiếu!</div></div>";
    return;
}

$sql_ghe = "SELECT * FROM ghe WHERE idphong = {$thongtin['idphong']} ORDER BY tenghe ASC";
$ghe = $db->xuatdulieu($sql_ghe);

// Hàm hiển thị ghế
function hienGhe($g) {
    $loaiGhe = strtolower(trim($g['loaighe']));
    $malop = $loaiGhe == 'vip' ? 'vip' : '';
    $dadat = $g['trangthai'] == 1 ? 'da-chon' : '';
    $trangthai = $g['trangthai'];

    echo "<div class='ghe border $malop $dadat' 
              data-id='{$g['idghe']}'
              data-loai='{$loaiGhe}'
              data-trangthai='{$trangthai}'>
              {$g['tenghe']}
          </div>";
}
?>

<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
.ghe {
    width: 50px;
    height: 50px;
    margin: 5px;
    background-color: #ccc;
    border-radius: 5px;
    text-align: center;
    line-height: 50px;
    cursor: pointer;
    font-weight: bold;
}
.ghe.vip { background-color: yellow; }
.ghe.da-chon { background-color: red; cursor: not-allowed; }
.ghe.duoc-chon { background-color: green; color: white; }
.ghe.invisible { visibility: hidden; }
.screen {
    background: linear-gradient(to right, #999, #ccc);
    color: #000;
    font-weight: bold;
    border-radius: 8px;
    width: fit-content;
    border: 2px solid #666;
    font-size: 16px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.2);
}
</style>

<div class="container mt-4">
    <h3 class="text-center">🎟 <strong>THÔNG TIN SUẤT CHIẾU</strong></h3>
    <p><strong>Rạp:</strong> <?php echo $thongtin['tenrap']; ?></p>
    <p><strong>Địa chỉ:</strong> <?php echo $thongtin['diachi']; ?></p>
    <p><strong>Phòng chiếu:</strong> <?php echo $thongtin['tenphong']; ?></p>
    <p><strong>Ngày:</strong> <?php echo date("d/m/Y", strtotime($thongtin['ngaychieu'])); ?> - <strong>Giờ:</strong> <?php echo $thongtin['giobatdau']; ?></p>

    <hr>
    <h4 class="pb-4">🪑 <strong>SƠ ĐỒ GHẾ</strong></h4>
    <div class="text-center mb-3">
        <div class="screen px-4 py-2 mx-auto">MÀN HÌNH</div>
    </div>

    <div class="d-flex mb-2">
        <div class="me-3"><div class="ghe border"></div> Ghế thường</div>
        <div class="me-3"><div class="ghe vip border"></div> Ghế VIP</div>
        <div><div class="ghe da-chon border"></div> Đã đặt</div>
    </div>

    <form id="formGhe" method="post" action="index.php?page=choncombo">
        <input type="hidden" name="idsuatchieu" value="<?php echo $idsuat; ?>">

        <div class="d-flex flex-column gap-2" id="gheContainer">
        <?php
        if ($ghe) {
            $hangGhe = array();

            foreach ($ghe as $g) {
                $hang = strtoupper(substr($g['tenghe'], 0, 1));
                if (!isset($hangGhe[$hang])) {
                    $hangGhe[$hang] = array();
                }
                $hangGhe[$hang][] = $g;
            }

            foreach ($hangGhe as $hang => $dsGhe) {
                echo "<div class='d-flex justify-content-center align-items-center'>";

                for ($i = 0; $i < 6; $i++) {
                    if (isset($dsGhe[$i])) {
                        hienGhe($dsGhe[$i]);
                    } else {
                        echo "<div class='ghe border invisible'></div>";
                    }
                }

                echo "<div style='width:20px'></div>";

                for ($i = 6; $i < 19; $i++) {
                    if (isset($dsGhe[$i])) {
                        hienGhe($dsGhe[$i]);
                    } else {
                        echo "<div class='ghe border invisible'></div>";
                    }
                }

                echo "<div style='width:20px'></div>";

                for ($i = 19; $i < 25; $i++) {
                    if (isset($dsGhe[$i])) {
                        hienGhe($dsGhe[$i]);
                    } else {
                        echo "<div class='ghe border invisible'></div>";
                    }
                }

                echo "</div>";
            }
        } else {
            echo "<div class='alert alert-warning'>Không tìm thấy ghế trong phòng này!</div>";
        }
        ?>
        </div>

        <div class="mt-4">
            <h5>🎫 Ghế đã chọn: <span id="gheDaChon">Không</span></h5>
            <h5>💰 Tổng tiền: <span id="tongTien">0</span> đ</h5>
            <input type="hidden" name="ds_ghe" id="ds_ghe">
            <div class="text-center pb-4">
                <button type="submit" class="btn btn-success mt-2">Tiếp tục</button>
            </div>
        </div>
    </form>
</div>

<script>
    const gheEls = document.querySelectorAll('.ghe:not(.da-chon):not(.invisible)');
    const gheDaChonEl = document.getElementById('gheDaChon');
    const tongTienEl = document.getElementById('tongTien');
    const dsGheInput = document.getElementById('ds_ghe');

    var gheDaChon = [];

    gheEls.forEach(function(ghe) {
        ghe.addEventListener('click', function() {
            var id = ghe.getAttribute('data-id');
            var loai = ghe.getAttribute('data-loai');
            var ten = ghe.innerText;

            var index = -1;
            for (var i = 0; i < gheDaChon.length; i++) {
                if (gheDaChon[i].id === id) {
                    index = i;
                    break;
                }
            }

            if (index !== -1) {
                ghe.classList.remove('duoc-chon');
                gheDaChon.splice(index, 1);
            } else {
                ghe.classList.add('duoc-chon');
                gheDaChon.push({ id: id, ten: ten, loai: loai });
            }

            capNhatThongTin();
        });
    });

    function capNhatThongTin() {
        var tenGhe = gheDaChon.map(function(g) { return g.ten; }).join(', ');
        if (tenGhe === "") tenGhe = "Không";
        var tong = 0;
        gheDaChon.forEach(function(g) {
            tong += (g.loai === 'vip') ? 104000 : 85000;
        });

        gheDaChonEl.innerText = tenGhe;
        tongTienEl.innerText = tong.toLocaleString();
        dsGheInput.value = gheDaChon.map(function(g) { return g.ten; }).join(',');
    }
</script>
