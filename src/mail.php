<!-- <?php
      mail('longerpingye66@gmail.com', 'メールテスト', 'メールが正しく届くかテストをします\r\n改行')
      ?> -->


<?php
mb_language("Japanese");
mb_internal_encoding("UTF-8");

$to = $_POST['to'];
$title = $_POST['title'];
$message = $_POST['message'];
$headers = "From: uudodo0207@icloud.com";

$mail_send = mb_send_mail($to, $title, $message, $headers);
if ($mail_send == true) {
  echo "メール送信成功です";
} else {
  echo "メール送信失敗です";
}
?>
<html>

<head>
  <meta charset="utf-8" />
</head>

<body>
  <form action="./test_mail.php" method="post">
    <p>送り先</p><input type="text" name="to">
    <p>件名</p><input type="text" name="title">
    <p>メッセージ</p><textarea name="content" cols="60" rows="10"></textarea>
    <p><input type="submit" name="send" value="送信"></p>
  </form>
</body>

</html>