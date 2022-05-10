<?php
session_start();
require('../dbconnect.php');
if (isset($_SESSION['user_id']) && $_SESSION['time'] + 10 > time()) {
    $_SESSION['time'] = time();

    if (!empty($_POST)) {
        // $stmt = $db->prepare('INSERT INTO events SET title=?');
        // $stmt->execute(array(
        //     $_POST['title']
        // ));

        header('Location: http://' . $_SERVER['HTTP_HOST'] . '/admin/index.php');
        exit();
    }
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
    <link rel="stylesheet" href="./normalize.css">
    <link rel="stylesheet" href="admin.css">
    <title>管理者ログイン</title>
</head>

<body>
    <div>
        <h1>管理者ページ</h1>
        <form action="/admin/index.php" method="POST">
            イベント名：<input type="text" name="title" required>
            <input type="submit" value="登録する">
        </form>
        <a href="/index.php">イベント一覧</a>
    </div>
</body>

</html>