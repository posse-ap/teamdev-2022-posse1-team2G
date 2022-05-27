<?php

function getUserData($params)
{

  require('dbconnect.php');
  
  // 選択肢が複数になり、$paramsが複数必要なので使わない
  // $params = filter_input(INPUT_GET, 'industries', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
  // $types = filter_input(INPUT_GET, 'type', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
  // print_r($params);

  // 業種を押したときの挙動
//   $ind = [];
//   if (isset($params['industries'])) :
//     foreach($params['industries'] as $param):
//     $ind[] = "industries = '" . $param . "'";
//     endforeach;
//   endif;
//   $indSql = implode(' OR ', $ind);
//   // 検索結果
//   // print_r($indSql);
//   // industries = 'サービス' or industries = 'IT'


//   // タイプを押したときの挙動
//   $typ = [];
//   if (isset($params['types'])) :
//     foreach ($params['types'] as $param) :
//       $typ[] = "type= '" . $param . "'";
//     endforeach;
//   endif;
//   $typSql = implode(' OR ', $typ);
//   // 検索結果
//   // print_r($typSql);
//   // type = '文系' or type = '理系'

// // ふたつの条件を結合する
//   $join = '('. $indSql . ')' .' AND ' . '(' . $typSql . ')';
//   // 検索結果
//   //  print_r($join);
//   // (industries = 'サービス' or industries = 'IT') and (type = '文系')
  
// // 空の際の挙動
//   if (isset($params['industries']) && isset($params['types'])) {
//     $sql = 'select * from company_posting_information where  '. $join;
//   }else if(isset($params['industries'])){
//     $sql = 'select * from company_posting_information where  ' . $indSql;
//   } else if(isset($params['types'])){
//     $sql = 'select * from company_posting_information where  ' . $typSql;
//   } else {
//     $sql = 'select * from company_posting_information';
//   }
// // print_r($sql);
//   $stmt = $db->prepare($sql);
//   $stmt->execute();
//   $result = $stmt->fetchAll();
//   // print_r($result);
//   return $result;










//     //  select * from company_posting_information where FIND_IN_SET('商社', industries) OR FIND_IN_SET('金融', industries)\G

//   $ind = [];
//   if (isset($params['industries'])) :
//     // print_r($params['industries']);
//     foreach ($params['industries'] as $param) :
//       // $ind[] = "industries = '" . $param . "'";
//       $ind[] = "FIND_IN_SET('$param',industries)";
//       // $ind= "$param,";
//       // print_r($ind);
//     endforeach;

//   endif;
//   // ORで連結
//   // print_r($ind);
//   $indSql = implode(' OR ', $ind);
//   // print_r($indSql);
//   // industries = 'IT'

//   // タイプを押したときの挙動
//   $typ = [];
//   if (isset($params['types'])) :
//     foreach ($params['types'] as $param) :
//       $typ[] = "FIND_IN_SET('$param',type)";
//     endforeach;
//   endif;
//   $typSql = implode(' OR ', $typ);
//   // print_r($typSql);
//   // type = '文系'

//   // select * from company_posting_information where FIND_IN_SET('商社', industries) OR FIND_IN_SET('金融', industries) AND FIND_IN_SET('理系', type);
//   // ふたつの条件を結合する
//   $join = "( $indSql ) AND ($typSql)";
//   // print_r($join);
//   // (industries = 'サービス' or industries = 'IT') and (type = '文系')

//   // 空の際の挙動
//   if (isset($params['industries']) && isset($params['types'])) {
//     // もともと一つの業種しかなかった場合
//     $sql = 'select * from company_posting_information where '. $join;

    
//     $sql = "select * from company_posting_information where FIND_IN_SET('. $join .' , industries)";
//   } elseif (isset($params['industries']) && empty($params['types'])) {
//     $sql = 'select * from company_posting_information where ' . $indSql;
//     // print_r($sql);

//     // select * from company_posting_information where FIND_IN_SET('商社', industries);

//     // -------------- 理想形  ----------------
//     //  select * from company_posting_information where FIND_IN_SET('商社', industries) OR FIND_IN_SET('金融', industries)\G

//     // 空文字でも入力された方だけ適用され結果は返せる
//     //  select * from company_posting_information where FIND_IN_SET('商社', industries) OR FIND_IN_SET('', industries)\G
//     // $sql = 'select * from company_posting_information where  ' . $indSql;


//     // これでいける
//     // select * from company_posting_information where concat(",", `industries`, ",") REGEXP ",(商社|金融),"
//     // $sql="select * from company_posting_information where concat(',', `industries`, ',') REGEXP ',(商社|金融),'";


//     // 商社 | 金融 | 
//     // foreach ($params['industries'] as $param) :
      
//     //   $a = "$param|";
//       // $sql="select * from company_posting_information where concat(',', `industries`, ',') REGEXP ',($param . '|'),'";
//       // print_r($a);
//       // echo $a;
//     // endforeach;
//     // print_r($a);
//     // echo $a;
    
//       // $sql="select * from company_posting_information where concat(',', `industries`, ',') REGEXP ',($a),'";
//       // print_r($sql);


//   } elseif (empty($params['industries']) && isset($params['types'])) {
//     $sql = 'select * from company_posting_information where  ' . $typSql;

// //-------------- 理想形  ----------------
// // select * from company_posting_information where FIND_IN_SET('留学', type) OR FIND_IN_SET('理系', type)\G
//   } else {
//     $sql = 'select * from company_posting_information';
//   }

//   $stmt = $db->prepare($sql);
//   $stmt->execute();
//   $result = $stmt->fetchAll();
//   return $result;











  $ind = [];
  if (isset($params['industries'])) :
    // print_r($params['industries']);
    foreach ($params['industries'] as $param) :
      // $ind[] = "industries = '" . $param . "'";
      $ind[] = "FIND_IN_SET('$param',industries)";
    endforeach;

  endif;
  $indSql = implode(' OR ', $ind);

  $typ = [];
  if (isset($params['types'])) :
    foreach ($params['types'] as $param) :
      $typ[] = "FIND_IN_SET('$param',type)";
    endforeach;
  endif;
  $typSql = implode(' OR ', $typ);

  $join = "( $indSql ) AND ($typSql)";

  if (isset($params['industries']) && isset($params['types'])) {
    $sql = 'select * from company_posting_information where ' . $join;

  } elseif (isset($params['industries']) && empty($params['types'])) {
    $sql = 'select * from company_posting_information where ' . $indSql;
 
  } elseif (empty($params['industries']) && isset($params['types'])) {
    $sql = 'select * from company_posting_information where  ' . $typSql;
  }else{
    $sql = 'select * from company_posting_information';
  }
  $stmt = $db->prepare($sql);
  $stmt->execute();
  $result = $stmt->fetchAll();
  return $result;
}


