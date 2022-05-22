<?php
require('./dbconnect.php');

//セッションを開始
session_start();
//エスケープ処理やデータチェックを行う関数のファイルの読み込み
require './libs/functions.php';
//POSTされたデータをチェック
$_POST = checkInput( $_POST );
//固定トークンを確認（CSRF対策）
if ( isset( $_POST[ 'ticket' ], $_SESSION[ 'ticket' ] ) ) {
  $ticket = $_POST[ 'ticket' ];
  if ( $ticket !== $_SESSION[ 'ticket' ] ) {
    //トークンが一致しない場合は処理を中止
    die( 'Access Denied!' );
  }
} else {
  //トークンが存在しない場合は処理を中止（直接このページにアクセスするとエラーになる）
  die( 'Access Denied（直接このページにはアクセスできません）' );
}

//POSTされたデータを初期化して前後にあるホワイトスペースを削除
// $company_id = trim( (string) filter_input(INPUT_POST, 'id') );
$company_id =  $_POST['id'];

//POSTされたデータとエラーの配列をセッション変数に保存
// $_SESSION[ 'id' ] = $company_id;

print_r($company_id);


// if (isset($_POST['id']) && is_array($_POST['id'])) {
//   foreach( $_POST['id'] as $value ){
//       echo "{$value}, ";
//   }
// }

//
$stmt = $db->prepare("SELECT * FROM company_posting_information WHERE id = :id");
$id = $company_id;
$stmt->bindValue(':id', $id, PDO::PARAM_STR);
$stmt->execute();
$info = $stmt->fetch();

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