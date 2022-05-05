<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>メール送信</title>
</head>
<body>

<?php
  mb_language("Japanese");
  mb_internal_encoding("UTF-8");

/* 
   to($宛先):	送信先のメールアドレス 各アドレスをカンマで区切ると、複数の宛先をtoに指定できる。このパラメータは、自動的にはエンコードされない。
   Subject($件名):	メールの件名
   Message($本文):  メールの本文
   Headers($ヘッダー):	ヘッダー
*/
  $to = $_POST['to'];
  $title = $_POST['title'];
  $message = $_POST['message'];
  $headers= "from: ayaka1712pome@gmail.com\n";
  $headers .= "Return-Path: ayaka1712pome@gmail.com\n";  //fromと同じメアド

  if(mb_send_mail($to, $title, $message, $headers))
  {
    echo "メール送信成功です";
  }
  else
  {
    echo "メール送信失敗です";
  }
 ?>
  
</body>
</html>