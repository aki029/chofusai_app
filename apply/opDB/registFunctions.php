<?php
ini_set("displayerros",1);
function mktable($colparams,$tablename,$pdo){
    $params = null;
    foreach($colparams as $key => $value){
        $params .= $key . " " . $value;
        if(next($colparams)){
            $params .= ",";
        }
    }
    $mktable = "CREATE TABLE IF NOT EXISTS {$tablename}({$params}) DEFAULT CHARSET=utf8;";
    $pdo -> prepare($mktable);
    $pdo -> execute();
}
function registDB(\opDB\OperateUserData\Userdata $user,$colparams) {
    $params = null;
    $keys = array_keys($colparams);
    foreach($keys as $key){
        $params .= ":{$key}";
        if(next($keys)){
            $params .= ",";
        }
    }
    if($user -> file)$user -> SaveImage();
    $user -> Molddata();
    $regist = "INSERT INTO {$this -> tablename} VALUES ({$params});";
    $prepared = $this -> pdo -> prepare($regist);
    $result = $prepared -> execute($user -> textdata);
    if($result){return $result;}
}