<?php
require_once "operateDB.php";

 $year = date("Y");
    $kind = "sponsor";
$dbname = "chofusai";
$user = "chofusai";
$password = "M207chofu";
$dsn = "mysql:host=db;dbname=$dbname;charset=utf8;";
$tablename = "test";
$name_op = ["test"=> 'aaa'];
    $test = file_get_contents('php://input');
    var_dump($test);
    $test=urldecode($test);
$opDB = new \opDB\OperateDB\OperateDB($dsn,$user,$password,$tablename,$name_op);
$opDB -> registDB($test);
