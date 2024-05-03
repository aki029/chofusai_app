<?php
session_start();

require_once "opDB/operateDB.php";

use opDB\OperateDB\OperateDB;
use opDB\OperateUserData as User;


?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>ユーザー登録ページ</title>
        <link rel="stylesheet" href="style/input.css">
        <link rel="stylesheet" href="style/index.css">
        <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    </head>
    <body>
<?php require_once $_SERVER['DOCUMENT_ROOT']."Chofusai_app/common/header.html";//ヘッダー要素?>

<?php
$page_flag = 0;
if(!empty($_POST["btn_confirm"])){
    $page_flag = 1;
    unset($_POST["btn_confirm"]);
}elseif(!empty($_POST["btn_submit"])){
    $page_flag = 2;
}
?>
    <div class="Userform inputform">
        <h1>ユーザー登録フォーム</h1>
        <?php if($page_flag === 0):?>
            <form method="post">
                <p>メールアドレス：<input type="email" name="email" value=""></p>
                <p>
    </body>
</html>