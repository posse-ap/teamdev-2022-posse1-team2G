<?php
// echo 'hello';
require('../../dbconnect.php');
if (isset($_POST['input'])) {
  $input = $_POST['input'];
  $sql = "SELECT * FROM students WHERE fname LIKE '%{$input}%'";
  $stmt = $db->prepare($sql);
  $stmt->execute();
  $result = $stmt->fetchAll();

  if ($result == true) {

    header('Content-type: application/json');
    echo json_encode($result);
  } else {
    echo $return = "<h4>No Record Found</h4>";
  }

}
