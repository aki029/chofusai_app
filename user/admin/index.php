<?php
    session_start();
    //ini_set("display_errors", 1);
    require_once 'operateDB.php';

    if($_POST["logout"])unset($_SESSION["id"]);

    if(!isset($_SESSION["id"])){
        header("Location: ../login/index.php");
        exit();
    }

    $year = $_POST["year"] ? $_POST["year"]:date("Y");
    $sp = "sponsor";
    $event = "event";
    $market = "market";

    $spopdb = new \opDB\OperateDB\pdoparams(CHOFUDB_DSN,CHOFUDB_USER,CHOFUDB_PW,$year.$sp,"comname",[]);
    $eventopdb = new \opDB\OperateDB\pdoparams(CHOFUDB_DSN,CHOFUDB_USER,CHOFUDB_PW,$year.$event,"eventname",[]);
    $marketopdb = new \opDB\OperateDB\pdoparams(CHOFUDB_DSN,CHOFUDB_USER,CHOFUDB_PW,$year.$market,"marketname",[]);

    $spopdb -> connectDB();
    $eventopdb -> connectDB();
    $marketopdb -> connectDB();

    $user = new \opDB\OperateUserData\Userdata('*',null,null);

    $imgstyle = "width:148px;height:100px;";
    //表示用連想配列
    $spparams = ["email"=>"メールアドレス","comname"=>"会社名","tel"=>"電話番号","zip"=>"郵便番号","adress"=>"住所","adressnum"=>"番地・建物名","cash"=>"金額","transway"=>"受け渡し方法","transferdate"=>"受け渡し日時","adfile"=>"広告ファイル","comurl"=>"会社ホームページURL"];
    $eventparams = ["email"=>"メールアドレス","eventname"=>"団体名","tel"=>"電話番号","kind"=>"団体種類","imagefile"=>"イメージ画像","exhibitname"=>"出展名"];
    $marketparams = ["email"=>"メールアドレス","eventname"=>"団体名","tel"=>"電話番号","kind"=>"団体種類","imagefile"=>"イメージ画像","exhibitname"=>"出展名"];
?>
<?php require_once 'header.php';?>
<script>
    var title = document.createElement('title');
    title.innerHTML = '管理者ページ';
    var mypage_js = document.createElement('script');
    mypage_js.setAttribute('src','../js/admin.js');
    var head = document.getElementsByTagName('head')[0];
    head.appendChild(title);
    head.appendChild(mypage_js);
</script>
<article>
    <main>
        <div class="mypage">
            <h1>管理者ページ</h1>
            <div class="commands">
                <ul style="list-style:none;padding:0;">
                    <li><a class="getdatas" href="#">申請データ取得</a></li>
                    <li><a class="getimages" href="#">画像データ取得</a></li>
                </ul>
            </div>   
            <div class="Tables">
                <div class="Users">
                    
                </div>
            </div>
        </div>
    </main>
</article>
<?php require_once 'footer.php';?>