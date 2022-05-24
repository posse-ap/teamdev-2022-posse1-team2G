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

  // $query = "SELECT * FROM users WHERE id='$stud_id' ";
  $query = "SELECT t1.contact_datetime, t2.id, t2.name, t2.university, t2.department, t2.grad_year, t2.mail, t2.phone_number, t2.address, t2.rep, t3.company_name 
  FROM company_user as t1 
  inner join users as t2 
  on t1.user_id=t2.id 
  inner join company as t3 
  on t1.company_id=t3.id 
  where t2.id='$stud_id' 
  ORDER BY t1.contact_datetime DESC";
  $stmt = $db->prepare($query);
  $stmt->execute();
  $result = $stmt->fetchAll();
  // print_r($result);

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
  $query_edit = "SELECT t1.contact_datetime, t2.id, t2.name, t2.university, t2.department, t2.grad_year, t2.mail, t2.phone_number, t2.address, t2.rep, t3.company_name 
  FROM company_user as t1 
  inner join users as t2 
  on t1.user_id=t2.id 
  inner join company as t3 
  on t1.company_id=t3.id 
  where t2.id='$stud_id' 
  ORDER BY t1.contact_datetime DESC";
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

  // updateできるのはuserの内容だけ（会社情報は変更できない）
  $query = "UPDATE users 
  SET name='$name', university='$university', department='$department', grad_year='$grad_year', mail='$mail', phone_number='$phone_number', address='$address' WHERE id='$id'";
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
  $company_name = $_POST['stud_company_name'];

$query = "select t1.company_id, t2.id, t2.name, t3.company_name from company_user as t1 inner join users as t2 on t1.user_id=t2.id inner join company as t3 on t1.company_id=t3.id where t2.id='$id' AND company_name='$company_name'";
// +------------+----+--------------+--------------+
// | company_id | id | name         | company_name |
// +------------+----+--------------+--------------+
// |          1 |  1 | 鈴木花子     | 鈴木会社     |
// |          2 |  1 | 鈴木花子     | 佐藤会社     |
// +------------+----+--------------+--------------+


  $query = "DELETE FROM company_user WHERE company_id = (select t1.company_id from company_user as t1 inner join users as t2 on t1.user_id=t2.id inner join company as t3 on t1.company_id=t3.id where t2.id='$id' AND company_name='$company_name') ";

  $query = "DELETE from company_user where company_user.company_id in ( 
  select t1.company_id from company_user as t1 inner join users as t2 on t1.user_id=t2.id inner join company as t3 on t1.company_id=t3.id where t2.id='$id' AND company_name='$company_name'
) ";


"DELETE from company_user 
where company_user.company_id in ( 
  select (
    
  )
  select t1.company_id from company_user as t1 inner join users as t2 on t1.user_id=t2.id inner join company as t3 on t1.company_id=t3.id where t2.id='$id' AND company_name='$company_name'";
  // $query = "DELETE FROM users WHERE id = '$id' ";
  $stmt = $db->prepare($query);
  $stmt->execute();
  $result = $stmt->fetchAll();
  // print_r($result);

  // where文で会社IDとも一致させればできそう
  // $q = "DELETE FROM company_user WHERE user_id = '$id' ";

  if (isset($result)) {
    echo $return  = "データを削除しました";
  } else {
    echo $return  = "データを削除できませんでした";
  }
}
