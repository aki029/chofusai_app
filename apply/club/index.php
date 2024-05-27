<?php
    $nametag = "clubname";

    $imgstyle = "width:148px;height:100px;";

    $params = [
        "代表者または団体メールアドレス" =>[
            "html"=>["input1"=>["input"=>["type"=>"email"]]],
            "col"=>["email"=>"varchar(255) NOT NULL UNIQUE KEY"]
        ],
        "団体名" =>[
            "html"=>["input1"=>["input"=>[
                "type"=>"text",
                "required"=>"required"]]],
            "col"=>["clubname"=>"varchar(255) NOT NULL"]
        ],
        "電話番号"=>[
            "html"=>["input1"=>["input"=>[
                "type"=>"tel",
                "required"=>"required"]]],
            "col"=>["tel"=>"char(11) NOT NULL UNIQUE KEY"]
        ],
        '出展種類'=>[
            'html'=>[
                'input1'=>[
                    'label'=>'模擬店',
                    'input'=>[
                        'type'=>'radio',
                        'value'=>'模擬店',
                        'required'=>'required']],
                'input2'=>[
                    'label'=>'イベント',
                    'input'=>[
                        'type'=>'radio',
                        'value'=>'イベント',
                        'required'=>'required']]],
            'col'=>['kind'=>'varchar(10)']
        ],
        'イメージ画像'=>[
            'html'=>[
                'input1'=>[
                    'input'=>[
                        'type'=>'file',
                        'class'=>'imagefile']]],
            'col'=>['imagefile'=>'text']
        ],
        '出展名'=>[
            'html'=>[
                'input1'=>[
                    'input'=>[
                        'type'=>'text',
                        'required'=>'required']]],
            'col'=>['exhibitname'=>'varchar(255)']
        ]
    ];
    $year = date('Y');
    $kind = 'club';
    $tablename = $year.$kind;
    require '../opDB/registDB.php';