<?php
session_start();
require('../dbconnect.php');
// print_r($_SERVER['PHP_SELF']);

if (!empty($_POST)) {
  $login = $db->prepare('SELECT * FROM admin WHERE email=? AND password=?');
  $login->execute(array(
    $_POST['email'],
    sha1($_POST['password'])
  ));
  $user = $login->fetch();



  if ($user) {
    $_SESSION = array();
    $_SESSION['id'] = $user['id'];
    $_SESSION['time'] = time();
    // $_SERVER['HTTP_HOST']=  localhost:8080
    header('Location: http://' . $_SERVER['HTTP_HOST'] . '/admin/logim.php');
    exit();
  } else {
    $error = 'fail';
  }
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./normalize.css">
  <link rel="stylesheet" href="admin.css">
  <title>再設定</title>
</head>

<body>
  <div>
    <h1>管理者ログイン</h1>
    <form action="/admin/reset.php" method="POST">
      メールアドレス<input type="email" name="email" required>
      パスワード<input type="password" required name="password">
      パスワード（確認）<input type="password" required name="password2">
      <input type="submit" value="ログイン">
    </form>
  </div>
</body>

</html>