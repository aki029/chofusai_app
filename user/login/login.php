<?php
    session_start();

    const dbname = "chofusai";
    const user = "root";
    const dsn = "mysql:host=localhost;dbname=$dbname;charset=utf8";

    $login_sucess = false;

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>ログインページ</title>
        <link rel="stylesheet" href="style/input.css">
        <link rel="stylesheet" href="style/index.css">
        <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    </head>
    <body>
<?php
    if($_POST["btn_login"]){

    }        
?>
        <div class="loginform inputform">
            <h1>ログインしてください</h1>
            <form action="" method="post">
                <p class="input_explain">ユーザーIDまたはメールアドレス<br>
                <input name="token_1" type="text" required></p>
                <p class="input_explain">パスワード<br>
                <input name="token_2" type="text" required></p>
                <input class="form-button" name="btn_login" value="ログイン">
            </form>
            <div class="forget_anytn">
                <p>パスワードを忘れた方は<a href="">こちら</a></p>
            </div>
        </div>
<html>
