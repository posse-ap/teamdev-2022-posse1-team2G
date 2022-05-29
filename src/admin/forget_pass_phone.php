<?php
session_start();
require('../dbconnect.php');

$errormessage = array();


if (isset($_SESSION['name'])) {
  // $_SESSION['times'] = time();
  // user_idがない、もしくは一定時間を過ぎていた場合
  $name = $_SESSION['name'];

  //   $sql = "SELECT rep FROM company_user";
  //   $sql = "SELECT t2.name from company as t1 
  // inner join admin as t2 
  // on t1.id=t2.company_id
  // where t1.id='$id';";
  //   $stmt = $db->prepare($sql);
  //   $stmt->execute();
  //   $names = $stmt->fetchAll();
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
  <link rel="stylesheet" href="./normalize.css">
  <link rel="stylesheet" href="./parts.css">
  <link rel="stylesheet" href="../admin/admin_style.css">
  <title>パスワードをお忘れの方へ</title>
</head>

<body class='login_body'>
  <header>
    <div class="header_wrapper">
      <div class="header_logo">
        <img src="../../img/boozer_logo.png" alt="logo">
      </div>
    </div>
  </header>
  <div class=' empty'>
  </div>
  <div class='login_container'>
    <div class='login_title'>
      <h1>パスワード変更</h1>
    </div>
    <div class='login_phone'>
      <p>お手数をおかけしますが、以下の宛先にご連絡ください</p>
      <p>090-1111-1111</p>
    </div>
    <div class='login_phone_back'>
      <a href="./login.php">ログイン画面に戻る</a>
    </div>


    <!-- <a href="/index.php">イベント一覧</a> -->
  </div>
</body>


<!-- <body>
  <p><?= $name ?>さん、hello world!</p>
  <a href="./login.php">ログイン画面に戻る</a>
</body> -->

</html>