<?php

function getUserData($params)
{
  //DBの接続情報
  include_once('dbconnect.php');

  //DBコネクタを生成
  $dbh = new PDO($dsn, $user, $password);
  // if ($dbh->connect_error) {
  // 	error_log($dbh->connect_error);
  // 	exit;
  // }

  // あああ
  //入力された検索条件からSQl文を生成
  $where = [];
  if (!empty($params['name'])) {
    $where[] = "name like '%{$params['name']}%'";
  }
  if (!empty($params['sex'])) {
    $where[] = 'sex = ' . $params['sex'];
  }
  if (!empty($params['age'])) {
    $where[] = 'age <= ' . ((int)$params['age'] + 9) . ' AND age >= ' . (int)$params['age'];
  }
  if ($where) {
    $whereSql = implode(' AND ', $where);
    $sql = 'select * from userss where ' . $whereSql;
  } else {
    $sql = 'select * from userss';
  }
  
// print_r($where);
// print_r($whereSql);


  //SQL文を実行する
  $UserDataSet = $dbh->prepare($sql);
  $UserDataSet->execute();
  $result = $UserDataSet->fetchAll(PDO::FETCH_ASSOC);
  print_r($result);
  return $result;
}
?>

<!-- radioで成功した例 -->
<?php
// 関数名変更
function getUsrData($params)
{
  //DBの接続情報
  require('dbconnect.php');
  
  $params = filter_input(INPUT_GET, 'industries[]');
  print_r($params);
// print_r($params);
  //DBコネクタを生成
  // $dbh = new PDO($dsn, $user, $password);
  // if ($dbh->connect_error) {
  // 	error_log($dbh->connect_error);
  // 	exit;
  // }

  // あああ
  //入力された検索条件からSQl文を生成
  // $where = [];
  // if (!empty($params['name'])) {
  //   $where[] = "name like '%{$params['name']}%'";
  // }
 
  // if (!empty($params['sex'])) {
  //   $where[] = 'sex = ' . $params['sex'];
  // }
  // if (!empty($params['sex'])) {
  //   $where[] = 'sex = ' . $params['sex'];
  // }
  // if (!empty($params['industries'])) {
  //   $where[] = 'industries = ' . $params['industries'];
  // }
  // if (!empty($params['age'])) {
  //   $where[] = 'age <= ' . ((int)$params['age'] + 9) . ' AND age >= ' . (int)$params['age'];
  // }

  $where = [];
  if (isset($params)) {
    $where[] = "industries = '" . $params . "'";
  }
  // if (isset($params['industries'])) {
  //   $where[] = 'industries = ' . $params['industries'];
  // }
  // Array ( [0] => name like '%平野隆二%' [1] => sex = 1 [2] => age <= 19 AND age >= 10 ) 
  // print_r($where);
  if ($where) {
    $whereSql = implode(' AND ', $where);
    // print_r($whereSql);
    // name like '%平野隆二%' AND sex = 1 AND age <= 19 AND age >= 10
    $sql = 'select * from company_posting_information where  '. $whereSql ;
  } else {
    $sql = 'select * from company_posting_information';
  }

  
  //SQL文を実行する
  // print_r($sql);
  $stmt = $db->prepare($sql);
  $stmt->execute();
  $result = $stmt->fetchAll();
  // print_r($result);
  return $result;
}

