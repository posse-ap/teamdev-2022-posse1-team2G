<?php

require('../../dbconnect.php');

if (!empty($_GET['input'])) {
    $input = $_GET['input'];
    // fname
    $sql = " SELECT * FROM company_user as t1 inner join users as t2 on t1.user_id=t2.id inner join company as t3 on t1.company_id=t3.id
    WHERE 
    t2.id LIKE '%{$input}%' 
    OR t2.name LIKE '%{$input}%' 
    OR t2.university LIKE '%{$input}%' 
    OR t2.department LIKE '%{$input}%' 
    OR t2.grad_year LIKE '%{$input}%' 
    OR t2.mail LIKE '%{$input}%' 
    OR t2.phone_number LIKE '%{$input}%' 
    OR t2.address LIKE '%{$input}%' 
    ORDER BY t2.id DESC ";

    $stmt = $db->prepare($sql);
    $stmt->execute();
    $result_array = $stmt->fetchAll();
} else {
    // $sql = "SELECT * FROM users ORDER BY id DESC";
    $sql = "SELECT * FROM company_user as t1 inner join users as t2 on t1.user_id=t2.id inner join company as t3 on t1.company_id=t3.id ORDER BY t2.id DESC";

    $stmt = $db->prepare($sql);
    $stmt->execute();
    $result_array = $stmt->fetchAll();
    // print_r($result_array);
}


if ($result_array == true) {
    header('Content-type: application/json');
    echo json_encode($result_array);
} else {
    echo $return =
        "<h4> $input </h4><p>に一致するデータはありませんでした</p> ";
}
