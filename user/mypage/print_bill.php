<?php
    session_start();
    require_once 'operateDB.php';
    
    $kind = $_POST['kind'];
    $user = new \opDB\OperateUserData\Userdata($_SESSION['id'],null,null);
    $opdb = new \opDB\OperateDB\pdoparams(CHOFUDB_DSN,CHOFUDB_USER,CHOFUDB_PW,'User','name',[]);
    $opdb -> connectDB();
    $result = $opdb -> Serch($user,'*')[0];
    
    