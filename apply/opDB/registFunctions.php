<?php
ini_set("displayerros",1);

/**
 * データベース送信用オブジェクト
 */
class registDB{

    protected $pdo;

    public $user;

    public $opdbparams;

    public function __constract(\opDB\OperateUserData\InputOfUser $userdata,\opDB\OperateDB\pdoparams $opdbparams){
        $dsn = $opdbparams -> dsn;
        $user = $opdbparams -> user;
        $password = $opdbparams -> password;
        $this -> pdo = connectDB($dsn,$user,$password);
        $this -> user = $userdata;
        $this -> opdbparams = $opdbparams;
    }

    public function registDatabase(){
        mktable($this -> opdbparams -> colparams,$this -> opdbparams -> tablename,$this -> pdo);
        SaveImage($this -> user);
        registDB($this -> pdo,$this -> user,$this -> opdbparams -> tablename,$this -> opdbparams -> colparams);
    }
}
    
function connectDB($dsn,$user,$password){
    error_reporting(E_ALL);
    $pdo = null;
    try{
        $pdo = new \PDO($dsn,$user, $password,[
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
        ]);
        return $pdo;
    }catch(\PDOException $e){
        echo "<p>Faild:" . $e->getMessage() . "</p>";
        exit("データベースに接続できませんでした");
    }
}


function mktable($colparams,$tablename,\PDO $pdo){
    $params = null;
    foreach($colparams as $key => $value){
        $params .= $key . " " . $value;
        if(next($colparams)){
            $params .= ",";
        }
    }
    $mktable = "CREATE TABLE IF NOT EXISTS {$tablename}({$params}) DEFAULT CHARSET=utf8;";
    $prepared = $pdo -> prepare($mktable);
    $prepared -> execute();
}
function SaveImage(\opDB\OperateUserData\InputOfUser $user){
    if($user -> file){
        $upload = "./upload/";
        $dirname = $upload.date("Y")."/";
        if(!file_exists($dirname)){
            mkdir($upload);
            mkdir($dirname);
        }
        foreach($user -> tmppath as $key => $value){
            $filename[$key] = $user -> name . "." . pathinfo($value,PATHINFO_EXTENSION);
            $user -> filepath[$key] = $dirname . $filename[$key];
            $result = rename($value,$user -> filepath[$key]);
            if(!$result){
                exit("Failed to Upload");
            }
        }            
    }
}
function registDB(\PDO $pdo,\opDB\OperateUserData\InputOfUser $user,$tablename,$colparams) {
    $params = null;
    $keys = array_keys($colparams);
    foreach($keys as $key){
        $params .= ":{$key}";
        if(next($keys)){
            $params .= ",";
        }
    }
    SaveImage($user);
    $regist = "INSERT INTO {$tablename} VALUES ({$params});";
    $prepared = $pdo -> prepare($regist);
    $result = $prepared -> execute($user -> textdata);
    if($result){return $result;}
}
function Molddata(\opDB\OperateUserData\InputOfUser $user,array $data = NULL){
    //ファイルに関するデータの成型
    if(isset($user -> file)){
        $keys = array_keys($user -> file);
        foreach($keys as $key){
            $user -> textdata[$key] = $user -> filepath[$key];
        }}
        //手動で渡された引数を$textdataに追加
    if(isset($data)){
        foreach($data as $key => $value){
            $user -> textdata[$key] = $value;
        }
    }
}