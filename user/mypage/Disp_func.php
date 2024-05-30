<?php
require_once "operateDB.php";

function Display_data(\opDB\OperateDB\pdoparams $opdb,\opDB\OperateUserData\Userdata $user,$kindparams,$kind,$imgstyle){
    $html = "";
    try{
        $result = $opdb -> Serch($user,"*")[0];
        //過去データ適用用のデータ成形
        $_POST = $result;
        unset($_POST["id"]);


        $params = ["id"=>"ユーザーID"];
        $params += $kindparams;

        $detectpath = "|.*\/.*\/.*\/.*|";//正規表現　画像パスを検知
        $detectTime = '|\d{4}\-\d{1,2}\-\d{1,2} \d{1,2}\:\d{1,2}|';//正規表現　タイムスタンプを検知
        foreach($result as $key => $row){
            if(preg_match($detectpath,$row)){
                $row = str_replace("./","",$row);
                $path = "/app/apply/{$kind}/$row";
                $html .= "<p>".$params[$key]."：</p><img src='{$path}' style='{$imgstyle}'>";
            }elseif(preg_match($detectTime,$row)){
                $html.="<p>".$params[$key]."：".date('Y年n月j日 H:i',strtotime($row))."</p>";    
            }else{
                $html .= "<p>".$params[$key]."：".htmlspecialchars($row)."</p>";
            }
        }
        echo $html;
    }catch(PDOException){
        $html .= "<p>データの取得に失敗しました</p>";
        echo $html;
    }
}