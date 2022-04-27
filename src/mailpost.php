<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <title>メール送信完了｜メール送信フォーム</title>
</head>

<body>

  <?php
  /*******************************
 データの受け取り 
   *******************************/
  $namae    = $_POST["namae"];    //お名前
  $mailaddress  = $_POST["mailaddress"];  //メールアドレス
  $naiyou    = $_POST["naiyou"];    //お問合せ内容

  //危険な文字列を入力された場合にそのまま利用しない対策
  $namae    = htmlspecialchars($namae, ENT_QUOTES);
  $mailaddress  = htmlspecialchars($mailaddress, ENT_QUOTES);
  $naiyou    = htmlspecialchars($naiyou, ENT_QUOTES);

  /*******************************
 未入力チェック 
   *******************************/
  $errmsg = '';  //エラーメッセージを空にしておく
  if ($namae == '') {
    $errmsg = $errmsg . '<p>お名前が入力されていません。</p>';
  }
  if ($mailaddress == '') {
    $errmsg = $errmsg . '<p>メールアドレスが入力されていません。</p>';
  }
  if ($naiyou == '') {
    $errmsg = $errmsg . '<p>お問合せ内容が入力されていません。</p>';
  }

  /*******************************
 メール送信の実行
   *******************************/
  if ($errmsg != '') {
    //エラーメッセージが空ではない場合には、[前のページへ戻る]ボタンを表示する
    echo $errmsg;

    //[前のページへ戻る]ボタンを表示する
    echo '<form method="post" action="index.php">';
    echo '<input type="hidden" name="namae" value="' . $namae . '">';
    echo '<input type="hidden" name="mailaddress" value="' . $mailaddress . '">';
    echo '<input type="hidden" name="naiyou" value="' . $naiyou . '">';
    echo '<input type="submit" name="backbtn" value="前のページへ戻る">';
    echo '</form>';
  } else {
    //エラーメッセージが空の場合には、メール送信処理を実行する
    //メール本文の作成
    $honbun = '';
    $honbun .= "メールフォームよりお問い合わせがありました。\n\n";
    $honbun .= "【お名前】\n";
    $honbun .= $_SESSION['fullname'] . "\n\n";
    $honbun .= "【メールアドレス】\n";
    $honbun .= $_SESSION['mail'] . "\n\n";
    $honbun .= "【お問い合わせ内容】\n";
    $honbun .= "申し込みいただきありがとうございます。
    担当の者から連絡致しますので少々お待ちください。" . "\n\n";

    //エンコード処理
    mb_language("Japanese");
    mb_internal_encoding("UTF-8");

    //メールの作成
    $mail_to  = "rr.hh0207@keio.jp";      //送信先メールアドレス
    $mail_subject  = "craftのご利用";  //メールの件名
    $mail_body  = $honbun;        //メールの本文
    $mail_header  = "from:" . $_SESSION['mail'];      //送信元として表示されるメールアドレス

    //メール送信処理
    $mailsousin  = mb_send_mail($mail_to, $mail_subject, $mail_body, $mail_header);

    //メール送信結果
    if ($mailsousin == true) {
      echo '<p>お問い合わせメールを送信しました。</p>';
    } else {
      echo '<p>メール送信でエラーが発生しました。</p>';
    }
  }
  ?>

</body>

</html>