<?php
    session_start();
    ini_set('display_errors',1);
    require_once 'operateDB.php';

    $err=false;
    $err_msg = null;
    if(!empty($_POST['btn_login'])){
        $opdb = new \opDB\OperateDB\pdoparams(CHOFUDB_DSN,CHOFUDB_USER,CHOFUDB_PW,'Users','name',[]);
        $id = $_POST['token_1'];
        $pass = $_POST['token_2'];
        $tmpuser = new \opDB\OperateUserData\Userdata($id,$pass,null);
        $opdb->connectDB();
        $result = $opdb->Serch($tmpuser,'id,password')[0];
        if($_POST['token_1']==$result['id']&&password_verify($_POST['token_2'],$result['password'])||$_POST['token_2']==$result['password']){
            $_SESSION['id'] = $_POST['token_1'];
            header('Location:../mypage/');
            exit();
        }else{
            $err_msg = 'IDまたはパスワードが異なります。';
            $err=true;
        }
    }elseif(isset($_SESSION['id'])){
        header('Location:../mypage/');
    }
    
?> 
<?php require_once 'header.php';?>
    <script>
        var title = document.createElement('title');
        title.innerHTML = 'ログインページ';
        var head = document.getElementsByTagName('head')[0];
        head.appendChild(title);
    </script>
    <article>
        <?php require_once 'sidebar.php'?>
        <main>
            <div class="loginform inputform">
                <h1>IDとパスワードを入力してください</h1>
                <?php if($err):?>
                <div class='disperror' style="background:pink;padding:20px;border-radius:10px;">
                    <?=$err_msg?>
                </div>
                <?php endif;?>
                <form action="" method="post">
                    <p class="input_explain">ユーザーID：<br>
                    <input name="token_1" type="text" required></p>
                    <p class="input_explain">パスワード：<br>
                    <input name="token_2" type="text" required></p>
                    <input type='submit' class="form-button" name="btn_login" value="ログイン">
                </form>
                <div class="forget_anytn">
                    <p>パスワードを忘れた方は<a href="">こちら</a></p>
                </div>
            </div>
        </main>
    </article>
<?php require_once 'footer.php'?>
