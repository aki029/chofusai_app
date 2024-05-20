<?php
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
    require_once "../opDB/registDB.php";
        
       