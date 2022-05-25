<?php
require('../../dbconnect.php');
session_start();
require('../../dbconnect.php');
// sessionに保存されたcompany_id
$id = $_SESSION['id'];

// view modal
if (isset($_POST['checking_view'])) {
  $stud_id = $_POST['stud_id'];
  $result = [];

  $query = "SELECT * FROM users WHERE id='$stud_id'";

  $query = "SELECT * from company_user as t1 
  inner join users as t2 
  on t1.user_id=t2.id 
  where t1.company_id = '$id'
  and t2.id='$stud_id'
  order by t1.id desc";

  $stmt = $db->prepare($query);
  $stmt->execute();
  $result = $stmt->fetchAll();

  if ($result == true) {

    header('Content-type: application/json');
    echo json_encode($result);
  } else {
    echo $return = "詳細画面開けません!";
  }
}

// edit modal
if (isset($_POST['checking_edit'])) {
  $stud_id = $_POST['stud_id'];

  // $query_edit = "SELECT * FROM users WHERE id='$stud_id' ";

  $query_edit = "SELECT * from company_user as t1 
  inner join users as t2 
  on t1.user_id=t2.id 
  where t1.company_id = '$id'
  AND t2.id='$stud_id'
  order by t1.id desc";

  $stmt_edit = $db->prepare($query_edit);
  $stmt_edit->execute();
  // print_r($stmt_edit);
  $result_edit = $stmt_edit->fetchAll();
  if ($result_edit == true) {
    header('Content-type: application/json');
    echo json_encode($result_edit);
  } else {
    echo $return = "編集画面開けません!";
  }
}

// 五本目　update 　二本目の新規挿入と近い
if (isset($_POST['checking_update'])) {
  $stud_id = $_POST['stud_id'];
  $rep = $_POST['rep'];
  // $name = $_POST['name'];
  // $university = $_POST['university'];
  // $department = $_POST['department'];
  // $grad_year = $_POST['grad_year'];
  // $mail = $_POST['mail'];
  // $phone_number = $_POST['phone_number'];
  // $address = $_POST['address'];

  $query = "UPDATE users SET rep = '$rep' WHERE id = '$stud_id'";

  $query = "UPDATE company_user SET rep = '$rep' WHERE user_id = '$stud_id' AND company_id='$id'";
  $stmt = $db->prepare($query);
  $stmt->execute();
  // print_r($stmt);
  $result = $stmt->fetchAll();

  // 更新していなくてもボタンを押すと更新になってしまう
  if (isset($result)) {
    echo $return  = "データを更新しました";
  } else {
    echo $return  = "データを更新できませんでした";
  }
}

