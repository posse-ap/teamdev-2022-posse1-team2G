<?php
$dsn = 'mysql:host=db;dbname=craft;charset=utf8;';
$user = 'craft';
$password = 'password';


try {
  $db = new PDO($dsn, $user, $password,[
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
  ]);
} catch (PDOException $e) {
  echo '接続失敗: ' . $e->getMessage();
  exit();
}
