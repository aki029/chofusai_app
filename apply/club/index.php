<?php
    $nametag = "clubname";

    $imgstyle = "";

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
    ];