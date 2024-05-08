<?php
require_once "registFunctions.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $uarray = $_POST["user"];
    $user = new \opDB\OperateUserData\InputOfUser($uarray["id"],$uarray["name"],$uarray["textdata"],$uarray["file"]);
    $registDB = new registDB($_POST["user"],$_POST["opdb"]);
    //$registDB -> registDatabase();
}

