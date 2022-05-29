<?php
require('../../dbconnect.php');

// view modal
if (isset($_POST['checking_view'])) {
  $stud_id = $_POST['stud_id'];
  $stud_company_name = $_POST['stud_company_name'];
  $result = [];

  $query = "SELECT t1.contact_datetime, t2.id, t2.name, t2.university, t2.department, t2.grad_year, t2.mail, t2.phone_number, t2.address, t3.company_name 
  FROM company_user as t1 
  inner join users as t2 
  on t1.user_id=t2.id 
  inner join company as t3 
  on t1.company_id=t3.id 
  where t2.id='$stud_id' 
  AND t3.company_name='$stud_company_name' 
  ORDER BY t1.contact_datetime DESC";
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
  $stud_company_name = $_POST['stud_company_name'];

  $sql = "SELECT t1.contact_datetime, t2.id, t2.name, t2.university, t2.department, t2.grad_year, t2.mail, t2.phone_number, t2.address, t3.company_name 
  FROM company_user as t1 
  inner join users as t2 
  on t1.user_id=t2.id 
  inner join company as t3 
  on t1.company_id=t3.id 
  where t2.id='$stud_id' 
  AND t3.company_name='$stud_company_name' 
  ORDER BY t1.contact_datetime DESC";

  $stmt_edit = $db->prepare($sql);
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

  // updateできるのはuserの内容だけ（会社情報は変更できない）
  $sql = "UPDATE users 
  SET name='$name', university='$university', department='$department', grad_year='$grad_year', mail='$mail', phone_number='$phone_number', address='$address' WHERE id='$id'";
  $stmt = $db->prepare($sql);
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
  $company_name = $_POST['stud_company_name'];

$query= "DELETE t1 from company_user as t1 
inner join company as t2 
on t1.company_id=t2.id 
inner join users as t3 
on t1.user_id=t3.id 
where t1.user_id='$id' AND t2.company_name='$company_name';";
  $stmt = $db->prepare($query);
  $stmt->execute();
  $result = $stmt->fetchAll();

  if (isset($result)) {
    echo $return  = "データを削除しました";
  } else {
    echo $return  = "データを削除できませんでした";
  }
}
