<?php
$to = "b24p013@akita-pu.ac.jp"; // 宛先のメールアドレス
$subject = "テストメール"; // メールの件名
$message = "これはテストメールです。"; // メールの本文
$from = "b24p013@akita-pu.ac.jp"; // 送信元のメールアドレス
$headers = "From:" . $from; // 送信元のヘッダー

// メールを送信
if(mb_send_mail($to, $subject, $message, $headers)){
    echo "メールが送信されました。";
} else {
    echo "メールの送信に失敗しました。";
}

