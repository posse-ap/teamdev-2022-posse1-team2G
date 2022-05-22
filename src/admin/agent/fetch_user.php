<?php

require('../../dbconnect.php');

if (!empty($_GET['input'])) {
  $input = $_GET['input'];
  // fname
  $sql = " SELECT * FROM users WHERE 
    id LIKE '%{$input}%' 
    OR name LIKE '%{$input}%' 
    OR university LIKE '%{$input}%' 
    OR department LIKE '%{$input}%' 
    OR grad_year LIKE '%{$input}%' 
    OR mail LIKE '%{$input}%' 
    OR phone_number LIKE '%{$input}%' 
    OR address LIKE '%{$input}%' 
    ORDER BY id DESC ";

  $stmt = $db->prepare($sql);
  $stmt->execute();
  $result_array = $stmt->fetchAll();
} else {
  // $id = $_SESSION['user_id'];
  // $sql = "SELECT * FROM users WHERE id = $id ORDER BY id DESC";
  $sql = "SELECT * FROM users ORDER BY id DESC";
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
