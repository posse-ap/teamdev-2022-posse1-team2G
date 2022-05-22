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
    $sql = "select * from users as t1 inner join company_user as t2 on t1.id = t2.user_id inner join company t3 on t1.id=t3.id where company_id='$id' OR name LIKE '%{$input}%'  OR university LIKE '%{$input}%'  OR department LIKE '%{$input}%'  OR grad_year LIKE '%{$input}%'  OR mail LIKE '%{$input}%'  OR phone_number LIKE '%{$input}%'  OR address LIKE '%{$input}%'  ORDER BY id DESC ";
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
    $sql = "select * from users as t1 inner join company_user as t2 on t1.id = t2.user_id inner join company t3 on t1.id=t3.id where company_id='$id' order by t1.id desc";
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
