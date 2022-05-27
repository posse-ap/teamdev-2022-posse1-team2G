<?php
session_start();
require('../dbconnect.php');

$errormessage = array();

if (!empty($_POST)) {
  $login = $db->prepare('SELECT * FROM admin WHERE email = :email AND flag = 2');
  $login->bindValue('email', $_POST['email']);
  // $login->bindValue('password', sha1($_POST['password']));
  $login->execute();
  $agent = $login->fetch();

  if (!empty($agent)) {
    $_SESSION = array();
    $_SESSION['name'] = $agent['name'];
    // $_SESSION['times'] = time();
    // $_SESSION = array();
    // $_SESSION['id'] = $agent['company_id'];
    // $_SESSION['time'] = time();

    header('Location: http://' . $_SERVER['HTTP_HOST'] . '/admin/forget_pass_phone.php');
  } else {
    $errormessage[] = "入力されたメールアドレスは登録されていません";
  }
}



?>


<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../admin/admin_style.css">
  <title>パスワードお忘れページ</title>
</head>

<body>
  <?php if ($errormessage) { ?>
    <ul class='login_error'>
      <!-- $errorは連想配列なのでforeachで分解していく -->
      <?php foreach ($errormessage as $value) { ?>
        <li><?php echo $value; ?></li>
      <?php } ?>
      <!-- 分解したエラー文をlistの中に表示していく -->
    </ul>
  <?php } ?>

  <form action="/admin/forget_pass.php" method="POST">
    <div class='login_form'>
      <div class='login_forget_mail'>
        <div>
          <p>メールアドレス</p>
        </div>
        <div class='forget_mail_container'>
          <input type="email" name="email">
        </div>
      </div>
      <div class='login_forget_submit'>
        <input type="submit" value="送信">
      </div>
    </div>
  </form>
</body>

</html>