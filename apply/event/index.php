<?php
    $nametag = "eventname";

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
            "col"=>["eventname"=>"varchar(255) NOT NULL"]
        ],
        "電話番号"=>[
            "html"=>["input1"=>["input"=>[
                "type"=>"tel",
                "required"=>"required"]]],
            "col"=>["tel"=>"char(11) NOT NULL UNIQUE KEY"]
        ],
        '団体種類'=>[
            'html'=>[
                'input1'=>[
                    'label'=>'学内団体',
                    'input'=>[
                        'type'=>'radio',
                        'value'=>'学内団体',
                        'required'=>'required']],
                'input2'=>[
                    'label'=>'学外団体',
                    'input'=>[
                        'type'=>'radio',
                        'value'=>'学外団体',
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
    $kind = 'event';
    $tablename = $year.$kind;
    require '../opDB/registDB.php';