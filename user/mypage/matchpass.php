<?php
    session_start();
    require_once "operateDB.php";
    
    $opdb = new \opDB\OperateDB\pdoparams(CHOFUDB_DSN,CHOFUDB_USER,CHOFUDB_PW,"Users","name",[]);
    $user = new \opDB\OperateUserData\Userdata($_SESSION["id"],null,null);

    $opdb -> connectDB();

    $result = $opdb -> Serch($user,"*")[0];

    if(password_verify($_POST['oldpass'],$result['password'])||$_POST['oldpass']==$result['password'])
    echo "true";
    exit(0);