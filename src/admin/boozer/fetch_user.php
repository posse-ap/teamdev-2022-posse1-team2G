<?php
session_start();
require('../../dbconnect.php');
if (isset($_SESSION['user_id']) && $_SESSION['time'] + 10 > time()) {
    $_SESSION['time'] = time();

    if (!empty($_POST)) {

        header('Location: http://' . $_SERVER['HTTP_HOST'] . '/admin/index.php');
        exit();
    }

    // user_idがない、もしくは一定時間を過ぎていた場合
} else {
    header('Location: http://' . $_SERVER['HTTP_HOST'] . '/admin/login.php');
    exit();
}
?>

<?php

// require('../../dbconnect.php');

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
    $id = $_SESSION['user_id'];
    $sql = "SELECT * FROM users WHERE id = $id ORDER BY id DESC";
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
