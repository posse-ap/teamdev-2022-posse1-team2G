<?php

function getUserData($params)
{
  //DBの接続情報
  require('dbconnect.php');

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
  if (!empty($params['industries'])) {
    $where[] = "industries = '$params[industries]'";
  }
  // Array ( [0] => name like '%平野隆二%' [1] => sex = 1 [2] => age <= 19 AND age >= 10 ) 
  // print_r($where);
  if ($where) {
    $whereSql = implode(' AND ', $where);
    // print_r($whereSql);
    // name like '%平野隆二%' AND sex = 1 AND age <= 19 AND age >= 10
    $sql = 'select * from company_posting_information where  '. 'industries = ' . $whereSql ;
  } else {
    $sql = 'select * from company_posting_information';
  }

  
  //SQL文を実行する
  // print_r($sql);
  $stmt = $db->prepare($sql);
  $stmt->execute();
  // $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  // print_r($result);
  // print_r(($UserDataSet));
  //扱いやすい形に変える
  $result = [];
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $result[] = $row;
  }
  // print_r($result);
  return $result;
  // return $UserDataSet;
}
