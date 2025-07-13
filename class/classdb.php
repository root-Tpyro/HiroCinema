<?php
    class database{

        private function ketnoi(){
            $conn=new mysqli("localhost","root","","cinema");
            if($conn->connect_error){
                echo "Kết nối thất bại!";
                exit();
            }
            else{
                $conn->set_charset("utf8");
                return $conn;
            }
        }
        //Lê Quang Khoa
        public function xuatdulieu($sql){
            $link=$this->ketnoi();
            $arr=array();
            $result=$link->query($sql);
            if($result->num_rows){
                while($row=$result->fetch_assoc())
                $arr[]=$row;
            return $arr;
            }
            else{
                return 0;
            }
        }

        public function dangky($sql){
            $link=$this->ketnoi();
            if($link->query($sql)){
                return 1;
            }
            else{
                return 0;
            }
        }

        public function dangnhap($tk, $mk){
    $link = $this->ketnoi();
    $sql = "SELECT * FROM khachhang WHERE sdt='$tk' AND matkhau='$mk'";
    $result = $link->query($sql);
    if($result->num_rows){
        return $result->fetch_assoc(); // Trả về toàn bộ thông tin khách hàng
    } else {
        return 0;
    }
}

        public function dangnhap2($tk, $mk){
    $link = $this->ketnoi();
    $sql = "SELECT * FROM quantrivien WHERE taikhoan='$tk' AND matkhau='$mk'";
    $result = $link->query($sql);
    if($result->num_rows){
        return $result->fetch_assoc(); // Trả về toàn bộ thông tin 
    } else {
        return 0;
    }
}


        public function xoadulieu($sql){
            $link=$this->ketnoi();
            if($link->query($sql)){
                return 1;
            }
            else
            {
                return 0;
            }
        }

        public function themdulieu($sql){
            $link=$this->ketnoi();
            if($link->query($sql)){
                return 1;
            }
            else
            {
                return 0;
            }
        }

        public function suadulieu($sql){
            $link=$this->ketnoi();
            if($link->query($sql)){
                return 1;
            }
            else{
                return 0;
            }
        } 

        public function laydong($sql) {
    $result = mysqli_query($this->ketnoi(), $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        return mysqli_fetch_assoc($result);
    }
    return null;
}



    }

?>

