<?php
    class xuly extends database{

        public function themkhachhang($sql){
            return $this->dangky($sql);
        }

        public function selectchucvu($value=''){
            $str='';
            $sql="select * from loainv";
            $result=$this->xuatdulieu($sql);
            for($i=1;$i<count($result);$i++){
                if($result[$i]['MaLoai']==$value){
                    $str.= '<option selected value="'.$result[$i]['MaLoai'].'">'.$result[$i]['TenLoai'].'</option>';
                }
                else
                {
                    $str.= '<option value="'.$result[$i]['MaLoai'].'">'.$result[$i]['TenLoai'].'</option>';
                }
            }
            return $str;
        }

        public function xoacombo($id){
            $sql="delete from combo where idcombo='$id'";
            return $this->xoadulieu($sql);
        }

        public function xoarap($id){
            $sql="delete from cumrap where idrap='$id'";
            return $this->xoadulieu($sql);
        }
        public function xoaphim($id){
            $sql="delete from phim where idphim='$id'";
            return $this->xoadulieu($sql);
        }
        public function suanhanvien($sql){
            return $this->suadulieu($sql);
        }
        #########################
        public function danhsachsanpham($id='')
        {
            if($id)
                $sql="select * from combo where idcombo='$id'";
            else
                $sql="select * from combo";
            return $this->xuatdulieu($sql);
        }

        public function danhsachrapchieu($id='')
        {
            if($id)
                $sql="select * from cumrap where idrap='$id'";
            else
                $sql="select * from cumrap";
            return $this->xuatdulieu($sql);
        }

        public function danhsachphim($id='')
        {
            if($id)
                $sql="select * from phim where idphim='$id'";
            else
                $sql="select * from phim p join danhsachphim ds on p.idds=ds.idds";
            return $this->xuatdulieu($sql);
        }
        

        public function xoasanpham($id)
        {
            $sql="delete from combo where idcombo='$id'";
            return $this->xoadulieu($sql);
        }
        public function selectds($value='')
        {
            $str='';
            $sql="select * from danhsachphim";
            $arr=$this->xuatdulieu($sql);
            for($i=0;$i<count($arr);$i++)
            {
                if($arr[$i]["idds"]==$value)
                    $str.='<option selected value="'.$arr[$i]["idds"].'">'.$arr[$i]["ten"].'</option>';
                else
                $str.='<option value="'.$arr[$i]["idds"].'">'.$arr[$i]["ten"].'</option>';
            }
            return $str;
        }
        public function themsanpham($sql)
        {
            return $this->themdulieu($sql);
        }
        public function suasanpham($sql)
        {
            return $this->suadulieu($sql);
        }

        #########################################3

        public function danhsachkhachhang($id =''){
            if($id){
                $sql="select * from khachhang where idkh='$id'";
            }else{
                $sql="select * from khachhang";
            }
            return $this->xuatdulieu($sql);
        }

        public function xoakhachhang($id)
        {
            $sql="delete from khachhang where idkh='$id'";
            return $this->xoadulieu($sql);
        }

        
        
        

    }

?>
