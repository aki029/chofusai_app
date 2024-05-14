<?php
    session_start();

    ini_set('display_errors','1');

    $nametag = "comname";
    $imgstyle='';
    $params = [
        'メールアドレス' =>[
            'html'=>['input1'=>['input'=>['type'=>'email']]],
            'col'=>['email'=>"varchar(255) NOT NULL UNIQUE KEY"]],
        '会社名'=>[
            'html'=>['input1'=>['input'=>[
                'type'=>'text',
                'required'=>'required']]],
            'col'=>['comname'=>'varchar(255) NOT NULL']],
        '電話番号'=>[
            'html'=>['input1'=>['input'=>[
                'type'=>'tel',
                'placeholder'=>'ハイフン無し',
                'required'=>'required']]],
            'col'=>['tel'=>'char(11) NOT NULL UNIQUE KEY']],
        '郵便番号'=>[
            'html'=>['input1'=>['input'=>[
                'type'=>'text',
                'size'=>'10',
                'maxlength'=>'7',
                'onKeyUp'=>"AjaxZip3.zip2addr(this,'','adress','adress');",
                'placeholder'=>'ハイフン無し',
                'required'=>'required']]],
            'col'=>['zip'=>'char(7) NOT NULL']],
        '住所'=>[
            'html'=>['input1'=>['input'=>[
                'type'=>'text',
                'size'=>'40',
                'placeholder'=>'郵便番号で自動入力されます',
                'required'=>'required']]],
            'col'=>['adress'=>'varchar(255) NOT NULL']],
        '番地・建物名'=>[
            'html'=>['input1'=>['input'=>[
                'type'=>'text',
                'size'=>'40',
                'placeholder'=>'○○○-○○○ ××ビル△階',
                'required'=>'required']]],
            'col'=>['adressnum'=>'varchar(255) NOT NULL']],
        '金額'=>[
            'html'=>['input1'=>['input'=>[
                'type'=>'number',
                'required'=>'required']]],
            'col'=>['cash'=>'INT(6) NOT NULL']],
        '受け渡し方法'=>[
            'html'=>[
                'input1'=>[
                    'label'=>'対面',
                    'input'=>[
                        'type'=>'radio',
                        'value'=>'対面',
                        'required'=>'required']],
                'input2'=>[
                    'label'=>'銀行振込',
                    'input'=>[
                        'type'=>'radio',
                        'value'=>'銀行振込',
                        'required'=>'required']]],
            'col'=>['transway'=>'varchar(10)']],
        '受け渡し日時'=>[
            'html'=>['input1'=>['input'=>[
                'type'=>'datetime-local']]],
            'col'=>['transferdate'=>'DATETIME']],
        '広告ファイル'=>[
            'html'=>['input1'=>['input'=>[
                'type'=>'file',
                'class'=>'adfile']]],
            'col'=>['adfile'=>'text']],
        '会社ホームページURL'=>[
            'html'=>['input1'=>['input'=>[
                'type'=>'url',
                'class'=>'comurl']]],
            'col'=>['comurl'=>'text']]
        ]; 
    if($_POST['cash']){
        if($_POST["cash"] >= 5000 && $_POST["cash"] < 10000){$imgstyle = "width:148px;height:100px;";}
        elseif($_POST["cash"] >= 10000 && $_POST["cash"] < 20000){$imgstyle = "width:296px;height:100px;";}
        elseif($_POST["cash"] >= 20000 && $_POST["cash"] < 30000){$imgstyle = "width:296px;height:200px;";}
        else{$imgstyle = "width:296px;height:400px;";}
    }
    $year = date("Y");
    $kind = "sponsor";
    $tablename = $year.$kind;
    
    /**
     * 本スクリプトを使う際には以下の名前のパラメータを用意してください。
     * $nametag ユーザー名を表す連想配列のキー名
     * $imgstyle 入力内容によって画像サイズを変える際は条件式とともに指定
     * $params フォームの入力欄生成とデータベースの操作に使用
     * htmlキーとcolキーで指定すること。
     * $tablename 作成するテーブル名
     */

    require_once "operateDB.php";//DB操作オブジェクト生成用ファイル
    //DB操作用連想配列生成
    $colparams = [];
    foreach($params as $col){
        $colparams = array_merge($colparams,$col['col']);
    }

    $usercolumns = ['name'=>'varchar(255) not null unique key'];
    
    //ページ出力操作
    $page_flag = 0;
    if(!empty($_POST["btn_confirm"])){
        $page_flag = 1;
        
        unset($_POST["btn_confirm"]);  //unset value of submit-button
        $id = isset($_SESSION['id']) ? $_SESSION['id'] : null;
        $user = new \opDB\OperateUserData\InputOfUser($id,$_POST[$nametag],$_POST,$_FILES);
        $userbasic = new \opDB\OperateUserData\Userdata($id,$_POST[$nametag]);
    }elseif(!empty($_POST["btn_submit"])){
        $page_flag = 2;
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

        //$id = $useropdb -> registDB($userbasic);
        //var_dump($id);
        
        $user -> id = 1;
        $result = $opdb -> registDB($user);
        echo $result;
        
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
                            $opdb = new \opDB\OperateDB\pdoparams(CHOFUDB_DSN,CHOFUDB_USER,CHOFUDB_PW,$tablename,$colparams); 
                            $useropdb = new \opDB\OperateDB\pdoparams(CHOFUDB_DSN,CHOFUDB_USER,CHOFUDB_PW,'Users',$usercolumns);
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
                        <a class="tomypage" href="/app/user/">マイページへ</a>
                    </div>
                    <?php endif;?>
                </form>
            </div>
        </main>
    </article>
<?php require_once 'footer.php'?>
