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







// if (!empty($_POST)) {
//   $login = $db->prepare('SELECT * FROM admin WHERE email = :email AND flag = 2');
//   $login->bindValue('email', $_POST['email']);
//   // $login->bindValue('password', sha1($_POST['password']));
//   $login->execute();
//   $agent = $login->fetch();

//   if (!empty($agent)) {
//     $_SESSION = array();
//     $_SESSION['name'] = $agent['name'];
//     // $_SESSION['time'] = time();
//     // $_SESSION = array();
//     // $_SESSION['id'] = $agent['company_id'];
//     // $_SESSION['time'] = time();

//     header('Location: http://' . $_SERVER['HTTP_HOST'] . '/admin/forget_pass_phone.pho');
//   } else {
//     $errormessage[] = "入力されたメールアドレスは登録されていません";
//   }
// }

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>パスワードをお忘れの方へ</title>
</head>
<body>
<p><?= $name?>さん、hello world!</p>  


<a href="./login.php">ログイン画面に戻る</a>
</body>
</html>
