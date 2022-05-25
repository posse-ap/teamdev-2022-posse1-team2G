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
$company_ids =  $_POST['id'];

//POSTされたデータとエラーの配列をセッション変数に保存
// $_SESSION[ 'id' ] = $company_id;

// $keywords = ['A', 'B', 'C', 'D', 'E']; 

echo "<pre>";
print_r($company_ids); //Array ( [0] => 1 [1] => 5 )
echo "</pre>";

// echo "<pre>";
// print_r($keywords); 
// echo "</pre>";

// キーワードの数だけループして、LIKE句の配列を作る
$company_id_Condition = [];
// foreach ($company_ids as $company_id) {
//     $company_id_Condition[] = 'company_id LIKE "%' . $company_id . '%"';
// }
foreach ($company_ids as $company_id) {
  $company_id_Condition[] = 'company_id = ' . $company_id;
}

echo "<pre>";
print_r($company_id_Condition); 
echo "</pre>";


// これをORでつなげて、文字列にする
$company_id_Condition = implode(' OR ', $company_id_Condition);

// あとはSELECT文にくっつけてできあがり♪
$sql = 'SELECT * FROM company_posting_information WHERE ' . $company_id_Condition;
$stmt = $db->query($sql);
$stmt->execute();
$companies = $stmt->fetchAll();

echo "<pre>";
print_r($companies);
echo "</pre>";

// $stmt = $db->prepare("SELECT * FROM company_posting_information WHERE id = :id");
// $id = $company_id;
// $stmt->bindValue(':id', $id, PDO::PARAM_STR);
// $stmt->execute();
// $info = $stmt->fetch();

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