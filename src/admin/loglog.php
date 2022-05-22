<?php
session_start();
require('../dbconnect.php');
if (isset($_SESSION['id']) && $_SESSION['time'] + 10 > time()) {
  $_SESSION['time'] = time();

  // if (!empty($_POST)) {

  //     header('Location: http://' . $_SERVER['HTTP_HOST'] . '/admin/index.php');
  //     exit();
  // }

  // user_idがない、もしくは一定時間を過ぎていた場合
} else {
  header('Location: http://' . $_SERVER['HTTP_HOST'] . '/admin/login.php');
  exit();
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ログイン画面</title>
</head>

<body>

  <h2>ログインフォーム</h2>
  <form action="login.php" method="POST">
    <div>
      <label for="email">メールアドレス：</label>
      <input type="email" name="email">

  </div>
  <div>
    <label for="password">パスワード：</label>
    <input type="password" name="password">
</div>
<p>
  <input type="submit" name='login' value="ログイン">
</p>
  </form>


  </form>

</body>

</html>