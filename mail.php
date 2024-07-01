<?php
require "./vendor/autoload.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

$phpmailer = new PHPMailer(true);
$phpmailer->isSMTP();
$phpmailer->SMTPDebug = SMTP::DEBUG_LOWLEVEL;
$phpmailer->SMTPAuth = true;
$phpmailer->SMTPSecure = "tls";
$phpmailer->Host = "chofusai.akita-pu.ac.jp";
$phpmailer->Port = "587";
$phpmailer->Username = "chofusai";
$phpmailer->Password = "chofu";

$phpmailer->CharSet = "UTF-8";
$phpmailer->setFrom("chofusai@chofusai.akita-pu.ac.jp","潮風祭Webシステム");
$phpmailer->addAddress("b24p013@akita-pu.ac.jp","あきひこ");
$phpmailer->Subject = "テスト";
$phpmailer->Body = "テストは成功です";

$phpmailer->send();
