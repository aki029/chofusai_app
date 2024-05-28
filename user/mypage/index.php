<?php
    session_start();
    ini_set("display_errors", 1);
    require_once 'operateDB.php';

    if(!isset($_SESSION["id"])){
        header("Location: login/index.php");
        exit();
    }

    $year = date("Y");
    $sp = "sponsor";
    $event = "event";
    $market = "market";

    $spopdb = new \opDB\OperateDB\pdoparams(CHOFUDB_DSN,CHOFUDB_USER,CHOFUDB_PW,$year.$sp,"comname",[]);
    $eventopdb = new \opDB\OperateDB\pdoparams(CHOFUDB_DSN,CHOFUDB_USER,CHOFUDB_PW,$year.$event,"eventname",[]);
    $marketopdb = new \opDB\OperateDB\pdoparams(CHOFUDB_DSN,CHOFUDB_USER,CHOFUDB_PW,$year.$market,"marketname",[]);

    $spopdb -> connectDB();
    $eventopdb -> connectDB();
    $marketopdb -> connectDB();

    $user = new \opDB\OperateUserData\Userdata($_SESSION["id"],null,null);

    $page_flag = 0;
    $imgstyle = "width:148px;height:100px;";
    //表示用連想配列
    $spparams = ["email"=>"メールアドレス","comname"=>"会社名","tel"=>"電話番号","zip"=>"郵便番号","adress"=>"住所","adressnum"=>"番地・建物名","cash"=>"金額","transway"=>"受け渡し方法","transferdate"=>"受け渡し日時","adfile"=>"広告ファイル","comurl"=>"会社ホームページURL"];
    $eventparams = ["email"=>"メールアドレス","eventname"=>"団体名","tel"=>"電話番号","kind"=>"団体種類","imagefile"=>"イメージ画像","exhibitname"=>"出展名"];
?>

<?php require_once 'header.php';?>
<script>
    var title = document.createElement('title');
    title.innerHTML = 'マイページ';
    var mypage_js = document.createElement('script');
    mypage_js.setAttribute('src','../js/mypage.js');
    var head = document.getElementsByTagName('head')[0];
    head.appendChild(title);
    head.appendChild(mypage_js);
</script>
<article>
    <?php require_once 'sidebar.php';?>
    <main>
        <div class="mypage">
            <div class="log">
                <p>アクセスログ</p>
            </div>
            <div class="RegistedContents">
                <div class="tab_wrap">
                    <input id="sponsor" type='radio' name="check" checked>
                    <label for="sponsor" class="tab_sp tabs">協賛</label>
                    <input id="event" type='radio' name="check">
                    <label for="event" class="tab_club tabs">イベント</label>
                    <input id="market" type="radio" name="check">
                    <label for="market" class="tab_market tabs">模擬店</label>
                </div>
                <div class="ShowList">
                    <div class="sponsor">
                        <?php
                            Display_data($spopdb,$user,$spparams,$sp,$imgstyle);
                        ?>
                    </div>
                    <div class="event" style="display:none">
                        <?php
                            Display_data($eventopdb,$user,$eventparams,$event,$imgstyle);
                        ?>
                    </div>
                    <div class="market" style="display:none;">
                        <?php
                            Display_data($marketopdb,$user,$eventparams,$market,$imgstyle);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </main>
</article>
<?php 
    require_once 'footer.php';
    function Display_data(\opDB\OperateDB\pdoparams $opdb,\opDB\OperateUserData\Userdata $user,$kindparams,$kind,$imgstyle){
        $html = "";
        try{
            $result = $opdb -> Serch($user,"*")[0];
            $params = ["id"=>"ユーザーID"];
            $params += $kindparams;

            $detected = "|.*\/.*\/.*\/.*|";//正規表現　画像パスを検知
            foreach($result as $key => $row){
                if(preg_match($detected,$row)){
                    $row = str_replace("./","",$row);
                    $path = "/app/apply/{$kind}/$row";
                    $html .= "<img src='{$path}' style='{$imgstyle}'>";
                }else{
                    $html .= "<p>".$params[$key]."：".htmlspecialchars($row)."</p>";
                }
            }
            echo $html;
        }catch(PDOException){
            $html .= "<p>データの取得に失敗しました</p>";
            echo $html;
        }
    }