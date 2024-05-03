<?php

use function PHPSTORM_META\type;

    session_start();

    ini_set("display_errors",1);
    
    $params = [
        'メールアドレス' => [['type'=>'email']=>['email',"varchar(255) NOT NULL UNIQUE KEY"]],
        '会社名'=>[['type'=>'text']=>['comname','varchar(255) NOT NULL']],
        '電話番号'=>[['type'=>'tel']=>['tel','char(11) NOT NULL UNIQUE KEY']],
        '郵便番号'=>[['type'=>'text']=>['zip','char(7) NOT NULL']],
        '住所'=>[['text']=>['adress','varchar(255) NOT NULL']],
        '番地・建物名'=>[['text']=>['adressnum','varchar(255) NOT NULL']],
        '金額'=>[['number']=>['cash','INT(6) NOT NULL']],
        '受け渡し方法'=>[['text']=>['transway','varchar(10)']],
        '受け渡し日時'=>[['datetime-local']=>['transferdate','DATETIME']],
        '広告ファイル'=>[['file']=>['adfile','text']],
        '会社ホームページURL'=>[['url']=>['comurl','text']]]; 
    $year = date("Y");
    $kind = "sponsor";
    
<<<<<<< HEAD
    $tablename = "{$year}{$kind}";
    
    $dbname = "chofusai";
    $user = "chofusai";
    $password = "M207chofu";
    $dsn = "mysql:host=localhost;dbname=$dbname;charset=utf8;";
=======
    

    require_once "operateDB.php";//DB操作オブジェクト生成用ファイル
>>>>>>> ec28f8a9ac0c4a14fc6198014ea882aa061d06ce

    require_once "operateDB.php";
    
    $page_flag = 0;
<<<<<<< HEAD
    if(!empty($_POST["btn_confirm"])){
        $page_flag = 1;
        unset($_POST["btn_confirm"]);  //unset value of submit-button
=======
    var_dump($_POST);  
    $result = null;
    if(!empty($_POST["btn_confirm"])){
        $page_flag = 1;
        unset($_POST["btn_confirm"]);  //unset value of submit-button

>>>>>>> ec28f8a9ac0c4a14fc6198014ea882aa061d06ce
    }elseif(!empty($_POST["btn_submit"])){
        $page_flag = 2;
        //データベース操作オブジェクトの宣言
        /*$colparams = require "./sp_mkquery.php";
        $opdb = new opDB\OperateDB\OperateDB($dsn,$user,$password,$tablename,$colparams);
        $opdb -> mktable(); //テーブル作成
        
        $sponsor = unserialize($_SESSION["Data"]);
        unset($_SESSION["Data"]);
        $result = $opdb -> registDB($sponsor);*/
    $ch = curl_init();
    $testuser = unserialize($_SESSION['Data']);
    $postdata = json_encode(
        array(
            'user'=>http_build_query($testuser)
            )
        );
        
        $opts = array('http' =>
        array(
            'method'  => 'POST',
            'header'  => 'Content-type: application/x-www-form-urlencoded',
            'content' => $postdata
            )
        );
        $headers = [
            'Content-Type: application/x-www-form-urlencoded',
            'Accept-Charset: UTF-8',
        ];
        curl_setopt($ch, CURLOPT_URL, 'http://172.19.0.5/app/apply/opDB/registDB.php');
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $login_info_return_value = curl_exec($ch);
        echo $login_info_return_value;
        echo curl_error($ch);
    }
<<<<<<< HEAD
?>

=======
    ?>
>>>>>>> ec28f8a9ac0c4a14fc6198014ea882aa061d06ce
    <?php require_once "header.php";?>
    <!--insert title-->
    <script>
        var title = document.createElement('title');
        title.innerHTML = '協賛申請フォーム';
        var head = document.getElementsByTagName('head')[0];
        head.appendChild(title);
    </script>
    <article>
        <?php require_once 'sidebar.php';?>
        <main class="contents">
            <div class="sponsorform inputform">
                <h1>協賛申請フォーム</h1>
<<<<<<< HEAD
                <form method="POST" enctype="multipart/form-data">
                <?php
                    foreach($params as $title => $mold){
                        foreach($mold as $type => $col){
                            $html = '<p>'.$title.'：'.'<input type='.$type.' name='.$col[0].' placeholder='..'></p>';

                        }
                    }
=======
                <?php if($page_flag === 0): ?>
                    <form method="POST" enctype="multipart/form-data">
                        <p>メールアドレス：<input type="email" name="email" value=''></P>
                        <p>会社名：<input type="text" name="comname" required value=''></p>
                        <p>電話番号：<input type="tel" name="tel" placeholder="ハイフン無し" required value=''></p>
                        <!-- 郵便番号入力(7桁) -->
                        <p>郵便番号：<input type="text" name="zip" size="10" maxlength="7" onKeyUp="AjaxZip3.zip2addr(this,'','adress','adress');" placeholder="ハイフン無し" required value=''></p>
                        <!-- 住所入力(都道府県+以降の住所) -->
                        <p>住所：<input type="text" name="adress" size="40" placeholder="郵便番号で自動入力されます" required value=''></p>
                        <p>番地・建物名：<input type="text" size="40" name="adressnum" placeholder="○○○-○○○ ××ビル△階" required value=''></p>
                        <p>金額：<input type="number" name="cash" required></p>
                        <p>受け渡し方法：
                            <label><input type="radio" name="transway" value="対面" required value=''>対面</label>
                            <label><input type="radio" name="transway" value="銀行振込" required value=''>銀行振込</label>
                        </p>
                        <p>受け渡し日時：<input type="datetime-local" name="transferdate" value=''></p>
                        <p>広告ファイル：<input type="file" name="adfile" class="adfile" value=''></p>
                        <p>会社ホームページURL：<input type="url" name="comurl" class="comurl" value=''><br>
                        ※潮風祭Webページに掲載する場合は入力してください</p>
                        <input type="submit" name="btn_confirm" class="OK" value="決定"/>
                    </form>
                    <?php elseif($page_flag === 1): ?>
                    <?php
                    isset($_SESSION["id"]) ? $id = $_SESSION["id"] : $id = str_pad(random_int(0,pow(10,9)-1),10,0,STR_PAD_LEFT);
                    $sponsor = new opDB\OperateUserData\InputOfUser($id,$_POST["comname"],$_POST,$_FILES);
                    
                    $_SESSION["Data"] = serialize($sponsor);
                    ?>
                    <h2>入力内容を確認します。</h2>
                    <form method='POST' enctype='application/x-www-form-urlencoded'>
                        <p>メールアドレス：<?=htmlspecialchars($_POST['email'])?></p>
                        <p>会社名：<?=htmlspecialchars($_POST['comname'])?></p>
                        <p>電話番号：<?=htmlspecialchars($_POST['tel'])?></p>
                        <!-- 郵便番号入力(7桁) -->
                        <p>郵便番号：<?=htmlspecialchars($_POST['zip'])?></p>
                        <!-- 住所入力(都道府県+以降の住所) -->
                        <p>住所：<?=htmlspecialchars($_POST['adress'])?></p>
                        <p>番地・建物名：<?=htmlspecialchars($_POST['adressnum'])?></p>
                        <p>金額：<?=htmlspecialchars($_POST['cash'])?></p>
                        <p>受け渡し方法：<?=htmlspecialchars($_POST['transway'])?></p>
                        <p>受け渡し日時：<?=date('Y年n月j日 H:i',strtotime($_POST['transferdate']))?></p>        
                        <p>広告ファイル：</p>
                        <?php if($_FILES["adfile"]["type"]):?>
                        <?php
                        if($_POST["cash"] >= 5000 && $_POST["cash"] < 10000){$imgstyle = "width:74mm;height:50mm;";}
                        elseif($_POST["cash"] >= 10000 && $_POST["cash"] < 20000){$imgstyle = "width:148mm;height:50mm;";}
                        elseif($_POST["cash"] >= 20000 && $_POST["cash"] < 30000){$imgstyle = "width:148mm;height:100mm;";}
                        else{$imgstyle = "width:148mm;height:200mm;";}
                        ?>
                        <img src='<?=$sponsor -> tmppath["adfile"]?>' style="<?=$imgstyle?>">
                        <?php endif;?>
                        <p>会社ホームページURL：<?php if($_POST["comurl"]):?><?=htmlspecialchars($_POST['comurl'])?><?php endif;?></p>
                        <input type="submit" name="btn_back" class="NO" value="戻る"/>
                        <input type="submit" name="btn_submit" class="yes" value="送信"/>
                    <?php elseif($result):?>
                    <div class="endregist">
                        <p>正常に登録されました</p>
                        <a class="tomypage" href="/app/user/">マイページへ</a>
                    </div>
                    <?php endif; ?>     
                </div>
            </main>
        </article>
    <?php include_once 'footer.php'?>
>>>>>>> ec28f8a9ac0c4a14fc6198014ea882aa061d06ce
