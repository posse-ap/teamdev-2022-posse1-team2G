<?php
session_start();
require('../dbconnect.php');

$errormessage = array();
// print_r($_SERVER['PHP_SELF']);

if (!empty($_POST)) {
  $login = $db->prepare('SELECT * FROM admin WHERE email = :email AND password = :password');
  $login->bindValue('email', $_POST['email']);
  $login->bindValue('password', sha1($_POST['password']));
  // $login->execute(
  //   array(
  //   $_POST['email'],
  //   sha1($_POST['password'])
  // ));
  $login->execute();
  $user = $login->fetch();
  // print_r($login);

  if ($user) {
    $_SESSION = array();
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['time'] = time();
    // $_SERVER['HTTP_HOST']=  localhost:8080
    header('Location: http://' . $_SERVER['HTTP_HOST'] . '/admin/index.php');
    exit();
  } else {
    if (!$_POST["email"]) {
      $errormessage[] = "メールアドレスを入力して下さい";
    }
    if (!$_POST["password"]) {
      $errormessage[] = "パスワードを入力して下さい";
    }
    if (sha1($_POST['password']) !== ) {
      $errormessage[] = "パスワードが違います";
    }

    // echo 'メールアドレスを入力してください';
    // exit;
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
  <title>管理者ログイン</title>
</head>

<body>
  <div>
    <h1>管理者ログイン</h1>

    <?php if ($errormessage) { ?>
      <ul>
        <!-- $errorは連想配列なのでforeachで分解していく -->
        <?php foreach ($errormessage as $value) { ?>
          <li><?php echo $value; ?></li>
        <?php } ?>
        <!-- 分解したエラー文をlistの中に表示していく -->
      </ul>
    <?php } ?>

    <form action="/admin/login.php" method="POST">
      メールアドレス<input type="email" name="email" >
      パスワード<input type="password"name="password">
      <input type="submit" value="ログイン">
    </form>
    <!-- <a href="/index.php">イベント一覧</a> -->
    <a href="./forgetPass.php">パスワードをお忘れの方</a>
  </div>
</body>

</html>