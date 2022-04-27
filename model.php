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

  //SQL文を実行する
  $UserDataSet = $dbh->prepare($sql);
  $UserDataSet->execute();
  // print_r(($UserDataSet));
  //扱いやすい形に変える
  $result = [];
  while ($row = $UserDataSet->fetch(PDO::FETCH_ASSOC)) {
    $result[] = $row;
  }
  // print_r($result);
  return $result;
}
