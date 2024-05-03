<?php
/**
 * The paramater for query of making table and registing to database
 * @var array $name_op [column name] => [column option]
 * @return array 
 */
$name_op = [
    "id" => "INT(10) UNSIGNED ZEROFILL NOT NULL PRIMARY KEY",
    "email" => "varchar(255) NOT NULL UNIQUE KEY",
    "comname" => "varchar(255) NOT NULL",
    "tel" => "char(11) NOT NULL UNIQUE KEY",
    "zip" => "char(7) NOT NULL",
    "adress" => "varchar(255) NOT NULL",
    "adressnum" => "varchar(255) NOT NULL",
    "cash" => "INT(6) NOT NULL",
    "transway" => "varchar(10)",
    "transferdate" => "DATETIME",
    "comurl" => "text",
    "adfile" => "text"];

return $name_op;