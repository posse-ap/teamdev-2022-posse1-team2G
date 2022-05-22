<?php
require('./dbconnect.php');

//エスケープ処理やデータをチェックする関数を記述したファイルの読み込み
require './libs/functions.php'; 

//比較ボタンの挙動（company_idの受け渡し）を記述したファイルの読み込み
require './to_compare_table.php'; 

$sql = 'SELECT * FROM company_posting_information';
$stmt = $db->query($sql);
$stmt->execute();
$companies = $stmt->fetchAll();


//セッションを開始
session_start();

//エスケープ処理やデータチェックを行う関数のファイルの読み込み
require '../libs/functions.php';

//POSTされたデータをチェック
$_POST = checkInput( $_POST );

//POSTされたデータを変数に格納（値の初期化とデータの整形：前後にあるホワイトスペースを削除）
$name = trim( filter_input(INPUT_POST, 'name') );

?>


<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>比較表ページ</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <p>比較表</p>
</body>
</html>