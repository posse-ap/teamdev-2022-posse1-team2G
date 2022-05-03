<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>メール送信テスト</title>
</head>
<body>

  <form action="./test_mail.php" method="post">
    <p>送り先</p><input type="text" name="to">
    <p>件名</p><input type="text" name="title">
    <p>メッセージ</p><textarea name="message" cols="60" rows="10"></textarea>
    <p><input type="submit" name="send" value="送信"></p>
  </form>
  
</body>
</html>