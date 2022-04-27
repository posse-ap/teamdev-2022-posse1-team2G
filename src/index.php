<?php
session_start();
require(dirname(__FILE__) . "/dbconnect.php");

// $stmt = $db->query('SELECT id, title FROM events');
// $events = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!-- ここまでPHP -->


<!-- ここからトップページのhtml -->
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./normalize.css">
    <link rel="stylesheet" href="style.css">
    <title>サンプル</title>
</head>
<!-- ここまでってところまで一応残しておいてね -->
<!-- <ul>
    <?php foreach ($events as $key => $event) : ?>
        <li>
            <?= $event["id"]; ?>:<?= $event["title"]; ?>
        </li>
    <?php endforeach; ?>
    <a href="/admin/index.php">管理者ページ</a>
</ul> -->
<!-- ここまで -->

<!-- ここから書いてね -->
<body>

<script src="style.js"></script>
</body>

</html>