<?php

require('../../dbconnect.php');

if (!empty($_GET['input'])) {
    $input = $_GET['input'];
// fname
    $sql = "SELECT * FROM users WHERE fname LIKE '%{$input}%' OR lname LIKE '%{$input}%'";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $result_array = $stmt->fetchAll();
 } else {
    $sql = "SELECT * FROM users";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $result_array = $stmt->fetchAll();
}


if ($result_array == true) {
    header('Content-type: application/json');
    echo json_encode($result_array);
} else {
    echo $return = "<h4>No Record Found</h4>";
}