<?php
    session_start();
    require_once 'operateDB.php';
    
    $kind = $_POST['kind'];
    $user = new \opDB\OperateUserData\Userdata($_SESSION['id'],null,null);
    $opdb = new \opDB\OperateDB\pdoparams(CHOFUDB_DSN,CHOFUDB_USER,CHOFUDB_PW,'sponsor','comname',[]);
    $opdb -> connectDB();
    $result = $opdb -> Serch($user,'*')[0];
    
    $name = $result['comname'];
    $cash = $result['cash'];
    $zip = $result["zip"];
    $address = $result["adress"].$result["adressnum"];
    $transway = $result["transway"];
    
    if($transway == "銀行振込")
    $file = "bank_bill.pdf";
    else
    $bank = "hands_bill.pdf";

    