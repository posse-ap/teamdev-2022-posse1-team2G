<?php
session_start();
require('../../dbconnect.php');
$id = $_SESSION['id'];

if (!empty($_GET['input'])) {
  $input = $_GET['input'];
  // $id = $_SESSION['id'];
  // $id = $_SESSION['id'];
  // $sql = "SELECT * FROM users WHERE id = $id ORDER BY id DESC";

  // idは複数あるので検索対象に加えずにした（＊のところで他のidをselectしなければ大丈夫だけどその記述が長くなりそうなのでやめた）
  $sql = "SELECT * from users as t1 
    inner join company_user as t2 
    on t1.id = t2.user_id 
    inner join company t3 
    on t1.id=t3.id 
    where company_id='$id' 
    OR name LIKE '%{$input}%' 
    OR university LIKE '%{$input}%' 
    OR department LIKE '%{$input}%' 
    OR grad_year LIKE '%{$input}%' 
    OR mail LIKE '%{$input}%' 
    OR phone_number LIKE '%{$input}%' 
    OR address LIKE '%{$input}%' 
    ORDER BY t1.id DESC ";
  // fname
  // $sql = " SELECT * FROM users WHERE 
  // id LIKE '%{$input}%' 
  // OR name LIKE '%{$input}%' 
  // OR university LIKE '%{$input}%' 
  // OR department LIKE '%{$input}%' 
  // OR grad_year LIKE '%{$input}%' 
  // OR mail LIKE '%{$input}%' 
  // OR phone_number LIKE '%{$input}%' 
  // OR address LIKE '%{$input}%' 
  // ORDER BY id DESC ";

  $stmt = $db->prepare($sql);
  $stmt->execute();
  $result_array = $stmt->fetchAll();
} else {
  // $id = $_SESSION['id'];
  // $id = $_SESSION['id'];
  // $sql = "SELECT * FROM users WHERE id = $id ORDER BY id DESC";
  $sql = "SELECT * from users as t1 
    inner join company_user as t2 
    on t1.id = t2.user_id 
    inner join company t3 
    on t1.id=t3.id 
    where company_id='$id' 
    order by t1.id desc";
    
  $sql = "SELECT * from company_user as t1 
  inner join users as t2 
  on t1.user_id=t2.id 
  where t1.company_id = '$id'
  order by t1.id desc";

// *************************** 1. row ***************************
//               id: 3
//          user_id: 2
//       company_id: 1
//              rep: 未設定
// contact_datetime: 2022-05-06 00:00:00
//               id: 2
//             name: 佐藤太郎
//       university: 〇△大学
//       department: 学部
//        grad_year: 24年春
//             mail: marusankaku@gmail.com
//     phone_number: 080-5432-1988
//          address: △県〇市
//       delete_flg: 0
// *************************** 2. row ***************************
//               id: 1
//          user_id: 1
//       company_id: 1
//              rep: 未設定
// contact_datetime: 2022-04-30 00:00:00
//               id: 1
//             name: 鈴木花子
//       university: 〇〇大学
//       department: 学部
//        grad_year: 24年春
//             mail: marumaru@gmail.com
//     phone_number: 080-5432-1987
//          address: 〇県△市
//       delete_flg: 0


  $stmt = $db->prepare($sql);
  $stmt->execute();
  $result_array = $stmt->fetchAll();
}


if ($result_array == true) {
  header('Content-type: application/json');
  echo json_encode($result_array);
} else {
  echo $return =
    "<h4> $input </h4><p>に一致するデータはありませんでした</p> ";
}



//   if (!empty($_GET['input'])) {
//     $input = $_GET['input'];
//     // fname
//     $sql = " SELECT * FROM users WHERE 
//     id LIKE '%{$input}%' 
//     OR name LIKE '%{$input}%' 
//     OR university LIKE '%{$input}%' 
//     OR department LIKE '%{$input}%' 
//     OR grad_year LIKE '%{$input}%' 
//     OR mail LIKE '%{$input}%' 
//     OR phone_number LIKE '%{$input}%' 
//     OR address LIKE '%{$input}%' 
//     ORDER BY id DESC ";

// $stmt = $db->prepare($sql);
// $stmt->execute();
// $result_array = $stmt->fetchAll();
// } else {
//   $id = $_SESSION['id'];
//   // $id = $_SESSION['id'];
//     // $sql = "SELECT * FROM users WHERE id = $id ORDER BY id DESC";
//     $sql= "select * from users as t1 inner join company_user as t2 on t1.id = t2.user_id inner join company t3 on t1.id=t3.id where company_id='$id' order by t1.id desc";
//     $stmt = $db->prepare($sql);
//     $stmt->execute();
//     $result_array = $stmt->fetchAll();
//   }


// if ($result_array == true) {
//   header('Content-type: application/json');
//   echo json_encode($result_array);
// } else {
//   echo $return =
//     "<h4> $input </h4><p>に一致するデータはありませんでした</p> ";
// }
