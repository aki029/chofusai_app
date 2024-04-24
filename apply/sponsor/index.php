<?php
    session_start();

    ini_set("display_errors",1);
    
    $year = date("Y");
    $kind = "sponsor";
    
    $tablename = "{$year}{$kind}";
    
    $dbname = "chofusai";
    $user = "chofusai";
    $password = "m207t222";
    $dsn = "mysql:host=db;dbname=$dbname;charset=utf8;";
    
    

    require_once "operateDB.php";//DB操作オブジェクト生成用ファイル

    $page_flag = 0;
    if(!empty($_POST["btn_confirm"])){
        $page_flag = 1;
        unset($_POST["btn_confirm"]);  //unset value of submit-button
    }elseif(!empty($_POST["btn_submit"])){
        $page_flag = 2;
        //データベース操作オブジェクトの宣言
        $colparams = require "./sp_mkquery.php";
        $opdb = new opDB\OperateDB\OperateDB($dsn,$user,$password,$tablename,$colparams);
        $opdb -> mktable(); //テーブル作成
        
        $sponsor = unserialize($_SESSION["Data"]);
        unset($_SESSION["Data"]);
        var_dump($sponsor);
        $opdb -> registDB($sponsor);
    }
?>
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
                <?php if($page_flag === 0): ?>
                    <form method="POST" enctype="multipart/form-data">
                        <p>メールアドレス：<input type="email" name="email" value=''></P>
                        <p>会社名：<input type="text" name="comname" required value=''></p>
                        <p>電話番号：<input type="tel" name="tel" placeholder="☎TEL:" required value=''></p>
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
                <form method='POST' enctype='multipart/form-data'>
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
                    <?php if($_POST["adfile"]):?>
                    <img src='<?=$sponsor -> tmppath["adfile"]?>' style="
                    <?php
                    if($_POST["cash"] >= 5000 && $_POST["cash"] < 10000){echo "width:74mm;height:50mm;";}
                    elseif($_POST["cash"] >= 10000 && $_POST["cash"] < 20000){echo "width:148mm;height:50mm;";}
                    elseif($_POST["cash"] >= 20000 && $_POST["cash"] < 30000){echo "width:148mm;height:100mm;";}
                    else{echo "width:148mm;height:200mm;";}
                    ?>
                    ">
                    <?php endif;?>
                    <p>会社ホームページURL：<?=htmlspecialchars($_POST['comurl'])?></p>
                    <input type="submit" name="btn_back" class="NO" value="戻る"/>
                    <input type="submit" name="btn_submit" class="yes" value="送信"/>
                    <?php endif; ?>     
                </div>
            </main>
        </article>
    <?php include_once 'footer.php'?>