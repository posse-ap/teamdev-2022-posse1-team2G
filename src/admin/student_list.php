<?php
require('../dbconnect.php');

// session_start();
// session_regenerate_id(true);
// if (isset($_SESSION["login"]) === false) {
//   print "ログインしていません。<br><br>";
//   print "<a href='staff_login.html'>ログイン画面へ</a>";
//   exit();
// } else {
//   print $_SESSION["name"] . "さんログイン中";
//   print "<br><br>";
// }
// 
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>学生一覧</title>
</head>

<body>

  <h1>学生一覧</h1>


  <?php
  $sql = "SELECT * FROM users";
  $stmt = $db->query($sql);
  $stmt->execute();
  $students = $stmt->fetchAll();
  ?>
  <table>
    <tr>
      <th>ID</th>
      <th>日時</th>
      <th>名前</th>
      <th>大学</th>
      <th>メールアドレス</th>
    </tr>
    <?php foreach ($students as $student) : ?>
      <tr>
        <td><?= $student['id']; ?></td>
        <!-- 日時は未実装 -->
        <td><?= $student['id']; ?></td>
        <td><?= $student['name']; ?></td>
        <td><?= $student['university']; ?></td>
        <td><?= $student['mail']; ?></td>
      </tr>
    <?php endforeach; ?>
  </table>

</body>

</html>