<?php
session_start();
require('../dbconnect.php');

$errormessage = array();
// print_r($_SERVER['PHP_SELF']);

if (!empty($_POST)) {
  $login = $db->prepare('SELECT * FROM admin WHERE email = :email AND password = :password AND flag = 2');
  $login->bindValue('email', $_POST['email']);
  $login->bindValue('password', sha1($_POST['password']));
  $login->execute();
  // print_r($login);
  $agent = $login->fetch();

  $loginBoozer = $db->prepare('SELECT * FROM admin WHERE email = :email AND password = :password AND flag = 1');
  $loginBoozer->bindValue('email', $_POST['email']);
  $loginBoozer->bindValue('password', sha1($_POST['password']));
  $loginBoozer->execute();
  $boozer = $loginBoozer->fetch();

  // print_r($agent);
  // print_r($boozer);
  //  Array ( [id] => 1 [email] => test@posse-ap.com [password] => 5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8 [flag] => 1 [company_id] => [created_at] => 2022-05-19 18:19:48 [updated_at] => 2022-05-19 18:19:48 )

  // !emptyではなく、issetとすると空の配列をfalseと判定する
  // https://access-jp.co.jp/blogs/development/42
  if (!empty($agent)) {
    $_SESSION = array();
    $_SESSION['id'] = $agent['company_id'];
    $_SESSION['time'] = time();
    // $_SERVER['HTTP_HOST']=  localhost:8080
    // header('Location: http://' . $_SERVER['HTTP_HOST'] . '/admin/index.php');
    // header('Location: http://' . $_SERVER['HTTP_HOST'] .'/admin/boozer/fetch.php?company_id=' . $_SESSION['id']);
    header('Location: http://' . $_SERVER['HTTP_HOST'] . '/admin/agent/information_posting.php');
    // header('Location: http://' . $_SERVER['HTTP_HOST'] .'/admin/index.php/' . $_SESSION['id']);
    // exit();
  } else if (empty($agent) && !empty($boozer)) {
    $_SESSION = array();
    // 1をセッションのuser_idに追加
    $_SESSION['id'] = $boozer['id'];
    $_SESSION['time'] = time();
    // $_SERVER['HTTP_HOST']=  localhost:8080
    header('Location: http://' . $_SERVER['HTTP_HOST'] . '/admin/boozer/company_list.php');
    // exit();
  } else {
    // if (!$_POST["email"]) {
    //   $errormessage[] = "メールアドレスを入力して下さい";
    // }
    // if (!$_POST["password"]) {
    //   $errormessage[] = "パスワードを入力して下さい";
    // }
    $errormessage[] = "パスワードもしくはメールアドレスが間違っています";
    // exit;
  }
}
// print_r($boozer);
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./normalize.css">
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

    <form action="/admin/login.php" method="POST" class='box'>
      <h1>Login</h1>
      <input type="email" name="email" placeholder="Username">
      パスワード<input type="password" name="password" placeholder="password">
      <input type="submit" value="ログイン">
    </form>
    <!-- <a href="/index.php">イベント一覧</a> -->
    <a href="./forgetPass.php">パスワードをお忘れの方</a>
  </div>
</body>


<form class="box" action="index.htyml" method="post">
  <h1>Login</h1>
  <input type="text" name="" placeholder="Username">
  <input type="password" name="" placeholder="Password">
  <input type="submit" name="" value="Login">
</form>


</html>