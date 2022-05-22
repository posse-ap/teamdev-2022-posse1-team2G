<?php
require('../../dbconnect.php');

// 新規追加
// if (isset($_POST['checking_add'])) {
//   $name = $_POST['name'];
//   $university = $_POST['university'];
//   $department = $_POST['department'];
//   $grad_year = $_POST['grad_year'];
//   $mail = $_POST['mail'];
//   $phone_number = $_POST['phone_number'];
//   $address = $_POST['address'];

//   $query = "INSERT INTO 
//     users 
//     (name,university,department,grad_year,mail,phone_number,address) 
//     VALUES 
//     ('$name','$university','$department','$grad_year','$mail','$phone_number','$address')";
//   $stmt = $db->prepare($query);
//   $stmt->execute();
//   $result = $stmt->fetchAll();

//   if (isset($result)) {
//     echo $return  = "データを挿入しました";
//   } else {
//     echo $return  = "Something Went Wrong.!";
//   }
// }

// view modal
if (isset($_POST['checking_view'])) {
  $stud_id = $_POST['stud_id'];
  $result = [];

  $query = "SELECT * FROM users WHERE id='$stud_id' ";
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

  $query_edit = "SELECT * FROM users WHERE id='$stud_id' ";
  $stmt_edit = $db->prepare($query_edit);
  $stmt_edit->execute();
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
  $id = $_POST['stud_id'];
  $name = $_POST['name'];
  $university = $_POST['university'];
  $department = $_POST['department'];
  $grad_year = $_POST['grad_year'];
  $mail = $_POST['mail'];
  $phone_number = $_POST['phone_number'];
  $address = $_POST['address'];
  // $company_url = $_POST['company_url'];

  $query = "UPDATE users SET name='$name', university='$university', department='$department', grad_year='$grad_year', mail='$mail', phone_number='$phone_number', address='$address' WHERE id='$id'";
  $stmt = $db->prepare($query);
  $stmt->execute();
  $result = $stmt->fetchAll();

  // 更新していなくてもボタンを押すと更新になってしまう
  if (isset($result)) {
    echo $return  = "データを更新しました";
  } else {
    echo $return  = "データを更新できませんでした";
  }
}

// delete modal
// if (isset($_POST['checking_delete'])) {
//   $id = $_POST['stud_id'];
//   $query = "DELETE FROM users WHERE id = '$id' ";
//   $stmt = $db->prepare($query);
//   $stmt->execute();
//   $result = $stmt->fetchAll();

//   if (isset($result)) {
//     echo $return  = "データを削除しました";
//   } else {
//     echo $return  = "データを削除できませんでした";
//   }
// }
