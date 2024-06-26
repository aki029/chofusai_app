<?php
namespace opDB;
/**
 * paramaters of database
 * Use these for default
 */
/**
 * @var $dbname databasename
 */
define("CHOFUDB_NAME","chofusai");
/**
 * @var $user always means "chofusai"
 */
define("CHOFUDB_USER","chofusai");
/**
 * @var $dsn database source name
 */
define("CHOFUDB_DSN","mysql:host=localhost;dbname=".CHOFUDB_NAME.";charset=utf8");

/**
 * @var $password always means "M207chofu"
 */
define("CHOFUDB_PW","M207chofu");

/**
 * データベース操作オブジェクトを格納した名前空間です。
 * @access public
 * @author Akihiko Kodachi <kodachi.akhko@gmail.com>
 * @copyright 2024 Akihiko Kodachi. APU Chofusai is reserved the rights to use and improve this system.
 */
namespace opDB\OperateDB;
/**
 * このクラスはデータベース操作用オブジェクトで、テーブルの作成と全カラムへの挿入を簡単に行えるようにします。
 * PDOobjectと接続用パラメータ、テーブルカラムの詳細を格納した配列と実行クエリ、テーブル名をメンバとして持ちます。
 * PDOobjectと接続用パラメータはインスタンス生成時とシリアライズを解除した時に使われます。
 */
class pdoparams{

    public $pdo;

    public $dsn,$user,$password;//接続用パラメータ

    public array $colparams;//テーブルを作成する際に使う。(column)
    public array $querys;//SQLクエリ    
    public $tablename; //SQL文実行で使うテーブル名
    public $nametag; //SQL文で使うネームカラム名

    /**
     * データベース操作オブジェクトの初期化を行います。
     * @param string $dsn Databese Source Name.
     * @param string $user Database User.
     * @param string|null $password Database Password.
     * @param string $tablename 本オブジェクトのmktable()メソッドにより作られるテーブルの名前.
     * @param array|null $colparams 上記メソッドで作られるテーブルのカラム(列)の名前をキー名、その型とその他設定を値とする連想配列.
     * 
     * Explain of $colparams
     * 
     * テーブルの列名にINT型で主キー、自動加算される"id"と可変長文字列型で全角１０文字以内の"name"という列を作成するとき、$colparamsの中身は以下のようにする必要があります.
     *
     *  $colparams = ["id" => INT PRIMARY KEY AUTO_INCREMENT,"name" => VARCHAR(20)]
     */
    public function __construct($dsn,$user,$password,$tablename,$nametag,array $colparams=NULL) {
        $this -> dsn = $dsn;
        $this -> user = $user;
        $this -> password = $password;
        $this -> tablename = $tablename;
        $this ->colparams = $colparams;
        $this -> nametag = $nametag;
    }
    
    /**
     * connect Database with pramas of this object
     */
    public function connectDB(){
        error_reporting(E_ALL);
        try{
            $this -> pdo = new \PDO($this -> dsn,$this -> user, $this -> password,[
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
            ]);
        }catch(\PDOException $e){
            echo "<p>Faild:" . $e->getMessage() . "</p>";
            exit("データベースに接続できませんでした");
        }
    }

    /**
     * Create table on the database easily.
     * This method uses SQL Query:"CREATE TABLE IF NOT EXISTS {$tablename} ({$params:joined strings,the keys of $colparams and its value}) DEFAULT CHARSET=utf8;"
     * So, if you want to make table more detailed, you should use $pdo:PDOobject in this class, and manually use method contained in it.
     */
    public function mktable(){
        $colparams = !isset($this -> colparams['id']) ? ['id'=>"INT(5) ZEROFILL PRIMARY KEY  AUTO_INCREMENT"] : $this -> colparams;
        foreach($this -> colparams as $key => $col){$colparams[$key] = $col;}
        $params = null;
        foreach($colparams as $key => $value){
            $params .= $key . " " . $value;
            if(next($colparams)){
                $params .= ",";
            }
        }
        $mktable = "CREATE TABLE IF NOT EXISTS {$this -> tablename}({$params}) DEFAULT CHARSET=utf8;";
        $this -> pdo -> query($mktable);
    }

    /**
     * Registing to database
     * Insert datas to table made with function: mktable() of this object.
     * This method uses SQL Query:"INSERT INTO {$tablename} VALUES ({$params:the keys of $colparams});"
     * If you want to insert datas into table, also you should use pdo.
     * @param \opDB\OperateUserData\InputOfUser $user contains Userdatas:id,name,posteddata
     * @see \opDB\OperateUserData\Imagehundler::SaveImage()
     * @see \opDB\OperateUserData\InputOfUser::Molddata()
     */
    public function registDB(\opDB\OperateUserData\Userdata $user) {
        $columns = null;
        $params = null;
        $keys = array_keys($this -> colparams);
        if($user -> tmppath)$user -> SaveImage();
        $user -> Molddata();
        if($this -> Detect_Avoid($user)){
            foreach($keys as $key){
                $params .= ":{$key}";
                $columns .= "{$key}";
                if(next($keys)){
                    $params .= ",";
                    $columns .= ",";
                }
            }
            $regist = "INSERT INTO {$this -> tablename} ({$columns}) VALUES ({$params});";
            $prepared = $this -> pdo -> prepare($regist);
            $prepared -> execute($user -> textdata);
        }else{
            $regist = "UPDATE {$this -> tablename} SET ";
            foreach($keys as $key){
                $regist .= "{$key} = :{$key}";
                if(next($keys)){
                    $regist .= ",";
                }
            }
            $regist .= " WHERE id = '{$user -> id}'";
            $prepared = $this -> pdo -> prepare($regist);
            $prepared -> execute($user -> textdata);
        }
        //ID get and return
        $id = $user -> getID($this);
        return $id;
    }

    public function Serch(\opDB\OperateUserData\Userdata $user,$target){
        $serch = "SELECT {$target} FROM {$this->tablename} ";
        if($user -> id != '*')$serch .= "WHERE id = '{$user -> id}' OR {$this->nametag} = '{$user -> name}'";
        $serch .= ";";
        $result = $this -> pdo -> query($serch);
        $data = $result -> fetchALL();
        return $data;
    }

    public function Detect_Avoid(\opDB\OperateUserData\Userdata $user):bool{
        $target = "id";
        $duplicate = $this -> Serch($user,$target);
        if(!$duplicate[0]){
            return true;
        }else{
            return false;
        }
    }

}
 
/**
 * ユーザーデータ管理用オブジェクトを格納した名前空間です。
*/
namespace opDB\OperateUserData;

/**
 * 画像データの一次的な保存・当該年度フォルダへの保存・画像バイナリデータの取得用関数を格納した関数のまとまりです。
 */
    trait Imagehundler{

        /**
         * @var array $tmppath 画像ファイルの一次保存先
         */
        public array $tmppath = [];

        /**
         * @var array $filepath 画像ファイルの最終保存先
         */
        public array $filepath = [];

        /**
         * 画像ファイルの一次保存を行います。
         */
        function setTemp(){
            $file = $this -> file;
            $tmp_dir = "./tmp/";
            if(!file_exists($tmp_dir)){
                mkdir($tmp_dir);
            }
            $filearray = array_keys($file);
            foreach($filearray as $key){
                $filename = $file[$key]["name"];
                $result = move_uploaded_file($file[$key]["tmp_name"], $tmp_dir . $filename);
                if($result){
                    $this -> tmppath[$key] = $tmp_dir . $filename;
                }
            }
        }
        
        /**
         * 一次保存先の画像ファイルを最終保存します。
         */
        function SaveImage(){
            $upload = "./upload/";
            $dirname = $upload.date("Y")."/";
            if(!file_exists($dirname)){
                mkdir($upload);
                mkdir($dirname);
            }
            foreach($this -> tmppath as $key => $value){
                $filename[$key] = $this -> name . "." . pathinfo($value,PATHINFO_EXTENSION);
                $this -> filepath[$key] = $dirname . $filename[$key];
                $result = rename($value,$this -> filepath[$key]);
                if(!$result){
                    exit("Failed to Upload");
                }
            }            
        }

        public abstract function Molddata();
    }
    
    /**
     * 基本的なユーザーデータを管理するオブジェクトです。
     */
    class Userdata{
        public $id;
        
        public $password;

        public $name;
        
        public array $textdata;
        /**
         * ユーザーオブジェクトの初期化を行います。
         * @param mixed $id ユーザーID
         * @param mixed $name　ユーザー名
         * @param array $textdata　データベース登録用のデータ配列
         */
        public function __construct($id,$password,$name){
            $this -> id = $id;
            $this -> password = $password;
            $this -> name = $name;  
        } 
        
        public function Molddata(){
            $this -> textdata['name'] = $this -> name;
            $this -> textdata["password"] = $this -> password;
        }

        public function getID(\opDB\OperateDB\pdoparams $pdoparams){
            $result = $pdoparams -> Serch($this,"id");
            return $result;
        }
    }
    
    /**
     * 申請されたデータを格納するオブジェクトです。Imagehundlerトレイトをインポートすることで画像の処理も可能になります。
     */
    class InputOfUser extends Userdata{
        use Imagehundler;
        
        public array $file;
        
        public array $textdata;
        /**
         * データ格納オブジェクトの初期化を行います。
         * $textdataには$_POST変数をそのまま代入できます。その場合、作成するデータベースのカラムに応じて送信ボタンのPOSTデータはunsetメソッドを通して削除する必要があります。
         * @param mixed $id user id
         * @param mixed $name user name
         * @param array $file array of posted file, but in most cases, it may contain only one file
         * @param array $textdata array of posted data
         * @see \opDB\OperateUserData\Imagehundler::setTemp()
         * @see \opDB\OperateUserData\Imagehundler::get_data()
         */
        public function __construct($id,$password,$name,array $textdata = NULL, $file = NULL){
            parent::__construct($id,$password,$name);
            $this -> textdata = $textdata;
            if($file){
                $this -> file = $file;
                $this -> setTemp();
            }
        }
        
        /**
         * データベースに保存するデータの成型を行います。
         * POSTされたデータのほかに、ユーザーID、存在する場合は$filedataを$textdataに格納します。
         * @param array|null $data it will add to $textdata manually
         */
        public function Molddata(array $data = NULL){
            //ファイルに関するデータの成型
            if(isset($this -> tmppath)){
            $keys = array_keys($this -> tmppath);
            foreach($keys as $key){
                $this -> textdata[$key] = $this -> filepath[$key];
            }}
            //手動で渡された引数を$textdataに追加
            if(isset($data)){
                foreach($data as $key => $value){
                    $this -> textdata[$key] = $value;
                }
            }
            $this -> textdata['id'] = $this -> id;
        }

    }
    
    
    