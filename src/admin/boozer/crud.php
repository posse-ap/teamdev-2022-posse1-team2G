<?php
require('../../dbconnect.php');


if(isset($_POST['checking_add']))
{
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
