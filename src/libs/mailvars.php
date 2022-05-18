<?php
/* メールの作成 （to 学生）*/
//メール本文の用意
define('honbun', ''
      . "メールフォームよりお問い合わせがありました。\n\n"
      . "【お名前】\n"
      . $_SESSION['fullname'] . "\n\n"
      . "【メールアドレス】\n"
      . $_SESSION['mail'] . "\n\n"
      . "【お問い合わせ内容】\n"
      . "申し込みいただきありがとうございます。" . "\n"
      . "担当の者から連絡致しますので少々お待ちください。" . "\n\n");
// $honbun = ''
//   . "メールフォームよりお問い合わせがありました。\n\n"
//   . "【お名前】\n"
//   . $_SESSION['fullname'] . "\n\n"
//   . "【メールアドレス】\n"
//   . $_SESSION['mail'] . "\n\n"
//   . "【お問い合わせ内容】\n"
//   . "申し込みいただきありがとうございます。" . "\n"
//   . "担当の者から連絡致しますので少々お待ちください。" . "\n\n";

//メールの宛先（To）の Email アドレス
define('mail_to', "info@xxxxx.com");
//メールの宛先（To）の名前  
define('MAIL_TO_NAME', "宛先の名前 ");
//Cc の Email アドレス
define('MAIL_CC', 'xxxx@xxxxxx.com');
//Cc の名前
define('MAIL_CC_NAME', 'Cc宛先名');
//Bcc の Email アドレス
define('MAIL_BCC', 'xxxxx@xxxxx.com');
//Return-Pathに指定するメールアドレス
define('MAIL_RETURN_PATH', 'info@xxxxxx.com');
//自動返信の返信先名前（自動返信を設定する場合）
define('AUTO_REPLY_NAME', '返信先名前');