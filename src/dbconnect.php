<?php
$dsn = 'mysql:host=db;dbname=craft;charset=utf8;';
$user = 'craft';
$password = 'craft';


try {
  $db = new PDO($dsn, $user, $password,[
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    // indexの値を表示させないようにする
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    // 型を正しく設定(intがstringにならない)
    PDO::ATTR_EMULATE_PREPARES => false,
  ]);
} catch (PDOException $e) {
  echo '接続失敗: ' . $e->getMessage();
  exit();
}


