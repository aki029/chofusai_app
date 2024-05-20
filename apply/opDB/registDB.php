<?php
 /**
         * 本スクリプトを使う際には以下の名前のパラメータを用意してください。
         * $nametag ユーザー名を表す連想配列のキー名
         * $imgstyle 入力内容によって画像サイズを変える際は条件式とともに指定
         * $params フォームの入力欄生成とデータベースの操作に使用
         * htmlキーとcolキーで指定すること。
         * $tablename 作成するテーブル名
         */
        
    session_start();
    require_once "operateDB.php";//DB操作オブジェクト生成用ファイル
    //DB操作用連想配列生成
    $colparams = ['id'=>"INT(5) ZEROFILL PRIMARY KEY"];
    foreach($params as $col){
        $colparams = array_merge($colparams,$col['col']);
    }

    $usercolumns = ['name'=>'varchar(255) not null unique key',
    "password" => "varchar(20) not null"];

    $str = '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPUQRSTUVWXYZ';
    //ページ出力操作
    $page_flag = 0;
    if(!empty($_POST["btn_confirm"])){
        $page_flag = 1;
        
        $_SESSION["clear"] = true;
        $useropdb = new \opDB\OperateDB\pdoparams(CHOFUDB_DSN,CHOFUDB_USER,CHOFUDB_PW,'Users','name',$usercolumns);
        $userpass = substr(str_shuffle($str),0,10);
        unset($_POST["btn_confirm"]);  //unset value of submit-button
        $id = isset($_SESSION['id']) ? $_SESSION['id'] : null;
        $user = new \opDB\OperateUserData\InputOfUser($id,NULL,$_POST[$nametag],$_POST,$_FILES);
        $userbasic = new \opDB\OperateUserData\Userdata($id,$userpass,$_POST[$nametag]);
    }elseif(!empty($_POST["btn_submit"])){
        //順を追って手続きしていれば処理、再読み込み等をすると最初から
        if($_SESSION["clear"]){
            $page_flag = 2;

            unset($_SESSION["clear"]);
            $user = unserialize($_SESSION["user"]);
            $opdb = unserialize($_SESSION["opdb"]);
            $opdb -> connectDB();
            unset($_SESSION["user"]);
            unset($_SESSION["opdb"]);
            $opdb -> mktable();

            $userbasic = unserialize($_SESSION['userbasic']);
            $useropdb = unserialize($_SESSION['useropdb']);
            $useropdb -> connectDB();
            unset($_SESSION['userbasic']);
            unset($_SESSION['useropdb']);
            $useropdb -> mktable();

            //パスワードの上書を回避
            $userpass = $useropdb -> Serch($userbasic,"password")[0]["password"];
            $userbasic -> password = $userpass;

            $id = $useropdb -> registDB($userbasic)[0]["id"];
            $user -> id = $id;
            $_SESSION["id"] = $id;
            $result = $opdb -> registDB($user);
        }
        
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
                <form method="POST" enctype="multipart/form-data">
                    <?php
                    $opdb = null;
                    foreach($params as $title => $mold){
                        $html = "<p>{$title}：";
                        if($page_flag == 0){
                            foreach($mold['html'] as $group){
                                $wrap='';
                                $wrapend='';
                                foreach($group as $tag => $attrs){
                                    if($tag == 'label'){
                                        $wrap = "<{$tag}>";
                                        $wrapend = "</{$tag}>";
                                        $html .= $wrap.$attrs;
                                    }else{
                                        $html .= "<{$tag}";
                                        foreach($attrs as $name => $value){
                                            $html .= ' '.$name.'="'.$value.'"';
                                        }
                                        $html .= " name=".array_keys($mold['col'])[0].">";
                                    }
                                }
                                $html .= $wrapend. " ";
                            }
                            $html .= "</p>";
                            echo $html;   
                        }elseif($page_flag == 1){
                            $array_key = array_keys($mold['col']);
                            if(!$_POST[$array_key[0]])$html.="</p><img src=".$user->tmppath[$array_key[0]].' style='.$imgstyle.">";
                            else $html .= $_POST[$array_key[0]]."</p>";
                            echo $html;
                        }
                    }
                    ?>
                    <?php if($page_flag===0):?>
                        <input type="submit" name="btn_confirm" class="OK" value="決定"/>
                    <?php elseif($page_flag===1):?>
                        <?php 
                            $opdb = new \opDB\OperateDB\pdoparams(CHOFUDB_DSN,CHOFUDB_USER,CHOFUDB_PW,$tablename,$nametag,$colparams); 
                            $_SESSION["user"] = serialize($user);
                            $_SESSION["opdb"] = serialize($opdb);
                            $_SESSION['useropdb'] = serialize($useropdb);
                            $_SESSION['userbasic'] = serialize($userbasic);
                        ?>
                        <input type="submit" name="btn_back" class="NO" value="戻る"/>
                        <input type="submit" name="btn_submit" class="yes"  value="送信"/>
                    <?php elseif($page_flag===2):?>
                    <div class="endregist">
                        <p>正常に登録されました</p>
                        <p>ユーザーid : <?= $_SESSION["id"] ?></p>
                        <p>パスワード : <?= $useropdb -> Serch($userbasic,"password")[0]["password"]?></p>
                        <a class="tomypage" href="/app/user/">マイページへ</a>
                    </div>
                    <?php endif;?>
                </form>
            </div>
        </main>
    </article>
<?php require_once 'footer.php'?>


