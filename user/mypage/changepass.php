<?php
    session_start();
    ini_set("display_errors",1);
    require_once "operateDB.php";

    $opdb = new \opDB\OperateDB\pdoparams(CHOFUDB_DSN,CHOFUDB_USER,CHOFUDB_PW,"Users","name",["name"=>[],"password"=>[]]);
    $user = new \opDB\OperateUserData\Userdata($_SESSION["id"],null,null);

    $opdb -> connectDB();
    $name = $opdb -> Serch($user,"name")[0]["name"];//registDBを使う際のカラムのnot null　に合わせるため
    var_dump($name);
    $user -> name = $name;
    $user -> password = password_hash($_POST["newpass"],PASSWORD_DEFAULT);

    $opdb -> registDB($user);

    exit(0);