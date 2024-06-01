<?php
    session_start();
    ini_set('display_errors',1);
    require_once 'operateDB.php';

    $nametags = ["sponsor"=>'comname','event'=>'clubname','market'=>'clubname'];
    $kind = $_POST['kind'];
    $userbasic = new \opDB\OperateUserData\Userdata($_SESSION['id'],null,null);
    //過去の年度とpdoparams
    $prevyear = $_POST['year'];
    $prevtable = $prevyear.$kind;
    $prevopdb = new \opDB\OperateDB\pdoparams(CHOFUDB_DSN,CHOFUDB_USER,CHOFUDB_PW,$prevtable,$nametags[$kind],[]);

    $inputofuser;//データ挿入用オブジェクト
    try{
        $prevopdb -> connectDB();
        $result = $prevopdb -> Serch($userbasic,'*')[0];
        $userbasic -> name = $result[$nametags[$kind]];
        var_dump($result);
        $inputofuser = new \opDB\OperateUserData\InputOfUser($_SESSION['id'],null,$result[$nametags[$kind]],$result,null);
        $detect_path = "|\.\/.*\/.*\/.*\.*|";
        foreach($result as $key => $val){
            if(preg_match($detect_path,$val))$inputofuser -> tmppath[$key] = $val;
        }
        $_SESSION['user'] = serialize($inputofuser);
        $_SESSION['userbasic'] = serialize($userbasic);
        $_SESSION['clear'] = true;
        exit('データを登録します');
    }catch(PDOException){
        exit('データが存在しません');
    }

    

    
    
