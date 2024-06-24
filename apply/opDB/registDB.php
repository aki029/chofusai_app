<?php
    /**
     * 本スクリプトを使う際には以下の名前のパラメータを用意してください。
     * $nametag ユーザー名を表す連想配列のキー名
     * $imgstyle 入力内容によって画像サイズを変える際は条件式とともに指定
     * $params フォームの入力欄生成とデータベースの操作に使用
     * htmlキーとcolキーで指定すること。
     * 形式：$params = [title=>
     * 'html'=>[input(number)=>[tagname=>[attribute=>value]]]
     * 'col'=>['name'=>'explain']],...]
     * $tablename 作成するテーブル名
    */
    session_start();
    //ini_set('display_errors',1);
    $kindarray = ["sponsor"=>"協賛","event"=>"イベント","market"=>"模擬店"];//メール送信とページタイトルに使用

    require_once "operateDB.php";//DB操作オブジェクト生成用ファイル
    //DB操作用連想配列生成
    $colparams = ['id'=>"INT(5) ZEROFILL PRIMARY KEY"];
    foreach($params as $col){
        $colparams = array_merge($colparams,$col['col']);
    }

    $usercolumns = ['name'=>'varchar(255) not null unique key',
    "password" => "text not null"];
    //パスワード格納用変数
    $userpass = null;
    //ページ出力操作
    $page_flag = 0;

    //ログイン状態で入力欄にあらかじめ値を入れるための変数
    $connection;
    if(empty($_POST['btn_confirm']&&empty($_POST['btn_submit'])))
    if(!empty($_SESSION['id'])){
        try{
            $opdb = new \opDB\OperateDB\pdoparams(CHOFUDB_DSN,CHOFUDB_USER,CHOFUDB_PW,$tablename,$nametag,[]);
            $user = new \opDB\OperateUserData\Userdata($_SESSION['id'],null,null);
            $opdb -> connectDB();
            $data = $opdb->Serch($user,'*')[0];
            $connection = true;
        }catch(PDOException){
            $connection = false;
        }
    }
    if(!empty($_POST["btn_confirm"])){
        $page_flag = 1;
        
        unset($_POST["btn_confirm"]);  //unset value of submit-button
        $id = isset($_SESSION['id']) ? $_SESSION['id'] : null;
        $user = new \opDB\OperateUserData\InputOfUser($id,NULL,$_POST[$nametag],$_POST,$_FILES);
        $userbasic = new \opDB\OperateUserData\Userdata($id,null,$_POST[$nametag]);     
        $_SESSION['clear'] = true;
    }elseif(!empty($_POST["btn_submit"])){
        //順を追って手続きしていれば処理、再読み込み等をすると最初から
        if($_SESSION["clear"]){
            $page_flag = 2;
            
            unset($_SESSION["clear"]);
            $user = unserialize($_SESSION["user"]);
            $opdb = new \opDB\OperateDB\pdoparams(CHOFUDB_DSN,CHOFUDB_USER,CHOFUDB_PW,$tablename,$nametag,$colparams); 
            $opdb -> connectDB();
            unset($_SESSION["user"]);
            unset($_SESSION["opdb"]);
            $opdb -> mktable();
            
            $userbasic = unserialize($_SESSION['userbasic']);
            $userpass = substr(bin2hex(random_bytes(7)),0,5);
            $userbasic -> password = password_hash($userpass,PASSWORD_DEFAULT);
            $useropdb = new \opDB\OperateDB\pdoparams(CHOFUDB_DSN,CHOFUDB_USER,CHOFUDB_PW,'Users','name',$usercolumns);
            $useropdb -> connectDB();
            unset($_SESSION['userbasic']);
            $useropdb -> mktable();

            //パスワードの上書を回避
            $tmppass = $userpass;
            $userpass = $useropdb -> Serch($userbasic,"password")[0]["password"];
            if($userpass){
                $userbasic -> password = password_hash($userpass,PASSWORD_DEFAULT);
                $userpass = '既に登録済みです。';
            }else{
                $userpass = $tmppass;
            }

            $id = $useropdb -> registDB($userbasic)[0]["id"];
            $user -> id = $id;
            $_SESSION["id"] = $id;
            $result = $opdb -> registDB($user);

            //メール送信
            $sendmail = "java -classpath ../items/javax.mail.jar:../items/javax.activation.jar:../items/ MailSender ".$user -> textdata["email"]." ".$kindarray[$kind]." ".$userbasic -> id." ".$userpass;
            shell_exec("export LANG=C.UTF-8;".$sendmail);
        }
    }
?>

    <?php require_once "header.php";?>

    <!--insert title-->
    <script>
        var title = document.createElement('title');
        title.innerHTML = '<?=$kindarray[$kind]?>申請フォーム';
        var head = document.getElementsByTagName('head')[0];
        head.appendChild(title);
    </script>
    <article>
        <?php require_once 'sidebar.php';?>
        <main class="contents">
            <div class="inputform">
                <h1><?=$kindarray[$kind]?>申請フォーム</h1>
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
                                        //ログイン状態では過去のデータから値を入力済みにする
                                        if(!empty($_SESSION['id'])&&$connection){
                                            $html .= ' value="'.$data[array_keys($mold['col'])[0]].'"';
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
                            if($_FILES[$array_key[0]])$html.="</p><img src=".$user->tmppath[$array_key[0]].' style='.$imgstyle.">";
                            if(preg_match('|\d{4}\-\d{1,2}\-\d{1,2}T\d{1,2}\:\d{1,2}|',$_POST[$array_key[0]]))$html.=date('Y年n月j日 H:i',strtotime($_POST[$array_key[0]])).'</p>';//正規表現でタイムスタンプ検知、年月日表示に変換
                            else $html .= $_POST[$array_key[0]]."</p>";
                            echo $html;
                        }
                    }
                    ?>
                    <?php if($page_flag===0):?>
                        <input type="submit" name="btn_confirm" class="OK" value="決定"/>
                    <?php elseif($page_flag===1):?>
                        <?php 
                            $_SESSION["user"] = serialize($user);
                            $_SESSION['useropdb'] = serialize($useropdb);
                            $_SESSION['userbasic'] = serialize($userbasic);
                        ?>
                        <input type="submit" name="btn_back" class="NO" value="戻る"/>
                        <input type="submit" name="btn_submit" class="yes"  value="送信"/>
                    <?php elseif($page_flag===2):?>
                    <div class="endregist">
                        <p>正常に登録されました</p>
                        <p>ご登録のメールアドレスにユーザーIDとパスワードを送信いたしました。</p>
                        <p>ユーザーid : <?= $_SESSION["id"] ?></p>
                        <p>パスワード : <?= $userpass?></p>
                        <a class="tomypage" href="/app/user/mypage">マイページへ</a>
                    </div>
                    <?php endif;?>
                </form>
            </div>
        </main>
    </article>
<?php require_once 'footer.php'?>


