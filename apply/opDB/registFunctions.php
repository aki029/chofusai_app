<?php
ini_set("displayerros",1);

class registDB{

    protected $pdo;

    public function __constract($dsn,$user,$password){
        $this -> pdo = connectDB($dsn,$user,$password);
    }

    public function registDatabase(\opDB\OperateUserData\InputOfUser $user,$tablename,$colparams){
        
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
    function SaveImage(\opDB\OperateUserData\InputOfUser $user){
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
    function registD(\PDO $pdo,\opDB\OperateUserData\Userdata $user,$tablename,$colparams) {
        $params = null;
        $keys = array_keys($colparams);
        foreach($keys as $key){
            $params .= ":{$key}";
            if(next($keys)){
                $params .= ",";
            }
        }
        if($user -> file) SaveImage($user);
        $user = Molddata($user);
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
}