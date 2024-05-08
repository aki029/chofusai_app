<?php
    session_start();

    ini_set("display_errors",1);

    $nametag = "comname";
    $category = 11;
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
    $year = date("Y");
    $kind = "sponsor";
    $tablename = $year.$kind;
    
    

    require_once "operateDB.php";//DB操作オブジェクト生成用ファイル

    $colparams = ['id'=>'INT(7) PRIMARY KEY AUTO_INCREMENT'];
    foreach($params as $col){
        $colparams = array_merge($colparams,$col['col']);
    }
    
    
    $page_flag = 0;
    if(!empty($_POST["btn_confirm"])){
        $page_flag = 1;
        unset($_POST["btn_confirm"]);  //unset value of submit-button
        $id = $category.'0001';
        $user = new \opDB\OperateUserData\InputOfUser($id,$_POST[$nametag],$_POST,$_FILES);
        $user -> textdata["id"] = $id;
        if($_POST["cash"] >= 5000 && $_POST["cash"] < 10000){$imgstyle = "width:148px;height:100px;";}
        elseif($_POST["cash"] >= 10000 && $_POST["cash"] < 20000){$imgstyle = "width:296px;height:100px;";}
        elseif($_POST["cash"] >= 20000 && $_POST["cash"] < 30000){$imgstyle = "width:296px;height:200px;";}
        else{$imgstyle = "width:296px;height:400px;";}
    }elseif(!empty($_POST["btn_submit"])){
        $page_flag = 2;
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
                            $user_post = serialize($user);
                            $opdb_post = serialize($opdb);
                        ?>
                        <input type="submit" name="btn_back" class="NO" value="戻る"/>
                        <input type="button" name="btn_submit" class="yes" id="submit" value="送信"/>
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
    <script>
        $(function(){
            $("#submit").on("click",
            function(event){
                alert('送信します');
                var url = 'http://chofusai.com/app/apply/opDB/registDB.php';
                $.ajax({
                    url:url,
                    type:'POST',
                    dataType:'text',
                    data:{'user':<?=$user_post?>, 'opdb':<?=$opdb_post?>},
                    timeout:3000,
                }).done(function(data){
                    alert(data);
                    console.log(data);
                }).fail(function(XMLHttpRequest,textStatus,errorThrown){
                    alert(errorThrown);
                    event.preventDefault();
                })
            }
            )
        }
        )
    </script>
<?php require_once 'footer.php'?>
<?php 
function serialize_write(\opDB\OperateUserData\InputOfUser $user,\opDB\OperateDB\pdoparams $opdb){
    $uniqid = 
    $filepath = "ser_{$user -> name}_tmp";
    
}