<?php
require('../../dbconnect.php');

// 新規追加
if (isset($_POST['checking_add'])) {
  $company_name = $_POST['company_name'];
  $phone_number = $_POST['phone_number'];
  $mail_contact = $_POST['mail_contact'];
  $mail_manager = $_POST['mail_manager'];
  $mail_notification = $_POST['mail_notification'];
  $representative = $_POST['representative'];
  $address = $_POST['address'];
  $company_url = $_POST['company_url'];

  $query = "INSERT INTO 
    company 
    (company_name,phone_number,mail_contact,mail_manager,mail_notification,representative,address,company_url) 
    VALUES 
    ('$company_name','$phone_number','$mail_contact','$mail_manager','$mail_notification','$representative','$address','$company_url')";
  $stmt = $db->prepare($query);
  $stmt->execute();
  $result = $stmt->fetchAll();

  if (isset($result)) {
    echo $return  = "データを挿入しました";
  } else {
    echo $return  = "Something Went Wrong.!";
  }
}

// view modal
if (isset($_POST['checking_view'])) {
  $stud_id = $_POST['stud_id'];
  $result = [];

  $query = "SELECT * FROM company WHERE id='$stud_id' ";
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

  $query_edit = "SELECT * FROM company WHERE id='$stud_id' ";
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
  $company_name = $_POST['company_name'];
  $phone_number = $_POST['phone_number'];
  $mail_contact = $_POST['mail_contact'];
  $mail_manager = $_POST['mail_manager'];
  $mail_notification = $_POST['mail_notification'];
  $representative = $_POST['representative'];
  $address = $_POST['address'];
  $company_url = $_POST['company_url'];

  $query = "UPDATE company SET company_name='$company_name', phone_number='$phone_number', mail_contact='$mail_contact', mail_manager='$mail_manager', mail_notification='$mail_notification', representative='$representative', address='$address', company_url='$company_url' WHERE id='$id'";
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
if (isset($_POST['checking_delete'])) {
  $id = $_POST['stud_id'];
  $query = "DELETE FROM company WHERE id = '$id' ";
  $stmt = $db->prepare($query);
  $stmt->execute();
  $result = $stmt->fetchAll();

  if (isset($result)) {
    echo $return  = "データを削除しました";
  } else {
    echo $return  = "データを削除できませんでした";
  }
}