<?php
//error_reporting(E_ALL);
ini_set('display_errors', 1);
    session_start();
    require("class/classdb.php");
    require("assets/header.php");
    if(isset($_GET['page'])){
        $page=$_GET['page'];
    }else{
        $page='trangchu';
    }
    if(isset($_GET['cate'])){
        $cate=$_GET['cate'];
    }
    if(file_exists("page/".$page."/index.php")){
        include("page/".$page."/index.php");
    }
    include("assets/footer.php");

?>