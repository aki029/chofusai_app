<?php
require "./vendor/autoload.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

function sendmail($to,$name,$subject,$contents){
    $sign = file_get_contents("contents.txt",true);


    $phpmailer = new PHPMailer(true);
    $phpmailer->isSMTP();
    $phpmailer->SMTPDebug = SMTP::DEBUG_LOWLEVEL;
    $phpmailer->SMTPAuth = true;
    $phpmailer->SMTPSecure = "tls";
    $phpmailer->Host = "smtp.gmail.com";
    $phpmailer->Port = "587";
    $phpmailer->Username = "chofuapp.info@gmail.com";
    $phpmailer->Password = "vwaq jvyl mbis ccup";

    $phpmailer->CharSet = "UTF-8";
    $phpmailer->setFrom("chofuapp.info@gmail.com","潮風祭Webシステム");
    $phpmailer->addAddress($to,$name);
    $phpmailer->Subject = $subject;
    $phpmailer->Body = $contents;

    

    $phpmailer->send();

}