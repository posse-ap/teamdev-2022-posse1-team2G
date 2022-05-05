<?php

function getUserData($params)
{

  require('dbconnect.php');
  
  // 選択肢が複数になり、$paramsが複数必要なので使わない
  // $params = filter_input(INPUT_GET, 'industries', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
  // $types = filter_input(INPUT_GET, 'type', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
  // print_r($params);

  // 業種を押したときの挙動
  $ind = [];
  if (isset($params['industries'])) :
    foreach($params['industries'] as $param):
    $ind[] = "industries = '" . $param . "'";
    endforeach;
  endif;
  $indSql = implode(' OR ', $ind);
  // print_r($indSql);
  // industries = 'IT'

  // タイプを押したときの挙動
  $typ = [];
  if (isset($params['types'])) :
    foreach ($params['types'] as $param) :
      $typ[] = "type= '" . $param . "'";
    endforeach;
  endif;
  $typSql = implode(' OR ', $typ);
  // print_r($typSql);
  // type = '文系'

// ふたつの条件を結合する
   $join = '('. $indSql . ')' .' AND ' . '(' . $typSql . ')';
  //  print_r($join);
  // (industries = 'サービス' or industries = 'IT') and (type = '文系')
  
// 空の際の挙動
  if (!empty($params['industries']) && !empty($params['types'])) {
    $sql = 'select * from company_posting_information where  '. $join;
  }else if(empty($params['industries'])){
    $sql = 'select * from company_posting_information where  ' . $typSql;
  } else if(empty($params['types'])){
    $sql = 'select * from company_posting_information where  ' . $indSql;
  } else {
    $sql = 'select * from company_posting_information';
  }
// print_r($sql);
  $stmt = $db->prepare($sql);
  $stmt->execute();
  $result = $stmt->fetchAll();
  return $result;
}
