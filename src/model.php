<?php

function getUserData($params)
{

  require('dbconnect.php');
  
  $params = filter_input(INPUT_GET, 'industries', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
  // print_r($params);

  $where = [];
  if (isset($params)) :
    foreach($params as $param):
    $where[] = "industries = '" . $param . "'";
    endforeach;
  endif;
  print_r($where);

  if ($where) {
    $whereSql = implode(' OR ', $where);
    $sql = 'select * from company_posting_information where  '. $whereSql ;
  } else {
    $sql = 'select * from company_posting_information';
  }

  $stmt = $db->prepare($sql);
  $stmt->execute();
  $result = $stmt->fetchAll();
  return $result;
}
