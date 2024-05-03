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
    
    $tablename = "{$year}{$kind}";
    
    $dbname = "chofusai";
    $user = "chofusai";
    $password = "M207chofu";
    $dsn = "mysql:host=localhost;dbname=$dbname;charset=utf8;";

    require_once "operateDB.php";
    aa
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
        $result = $opdb -> registDB($sponsor);
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
                    foreach($params as $title => $mold){
                        foreach($mold as $type => $col){
                            $html = '<p>'.$title.'：'.'<input type='.$type.' name='.$col[0].' placeholder='..'></p>';

                        }
                    }