<?php

require('../../dbconnect.php');

// フリーワード（input）と会社(select)両方入力された場合、両方に一致する場合だけ表示
if (!empty($_GET['input'])&& !empty($_GET['select']) ) {
    $input = $_GET['input'];
    $select = $_GET['select'];

    $sql = " SELECT t1.contact_datetime, t2.id, t2.name, t2.university, t2.department, t2.grad_year, t2.mail, t2.phone_number, t2.address, t3.company_name 
    FROM company_user as t1 
    inner join users as t2 
    on t1.user_id=t2.id 
    inner join company as t3 
    on t1.company_id=t3.id
    WHERE 
    ( t2.id LIKE '%{$input}%' 
    OR t2.name LIKE '%{$input}%' 
    OR t2.university LIKE '%{$input}%' 
    OR t2.department LIKE '%{$input}%' 
    OR t2.grad_year LIKE '%{$input}%' 
    OR t2.mail LIKE '%{$input}%' 
    OR t2.phone_number LIKE '%{$input}%' 
    OR t2.address LIKE '%{$input}%' )
    -- 会社で検索
    AND t3.company_name LIKE '$select'
    ORDER BY t1.contact_datetime DESC";

    $stmt = $db->prepare($sql);
    $stmt->execute();
    $result_array = $stmt->fetchAll();
} 
// 会社だけ入力されていたら会社で検索
else if(empty($_GET['input']) && !empty($_GET['select'])){
    // $input = $_GET['input'];
    $select = $_GET['select'];
    $sql = " SELECT t1.contact_datetime, t2.id, t2.name, t2.university, t2.department, t2.grad_year, t2.mail, t2.phone_number, t2.address, t3.company_name 
    FROM company_user as t1 
    inner join users as t2 
    on t1.user_id=t2.id 
    inner join company as t3 
    on t1.company_id=t3.id
    WHERE 
    -- 会社で検索
    t3.company_name LIKE '$select'
    ORDER BY t1.contact_datetime DESC";

    $stmt = $db->prepare($sql);
    $stmt->execute();
    $result_array = $stmt->fetchAll();
} 
// 会社は選択されていないがフリーワードで検索
else if (!empty($_GET['input']) && empty($_GET['select'])) {
    $input = $_GET['input'];
    $select = $_GET['select'];
    $sql = " SELECT t1.contact_datetime, t2.id, t2.name, t2.university, t2.department, t2.grad_year, t2.mail, t2.phone_number, t2.address, t3.company_name 
    FROM company_user as t1 
    inner join users as t2 
    on t1.user_id=t2.id 
    inner join company as t3 
    on t1.company_id=t3.id
    WHERE 
    t2.id LIKE '%{$input}%' 
    OR t2.name LIKE '%{$input}%' 
    OR t2.university LIKE '%{$input}%' 
    OR t2.department LIKE '%{$input}%' 
    OR t2.grad_year LIKE '%{$input}%' 
    OR t2.mail LIKE '%{$input}%' 
    OR t2.phone_number LIKE '%{$input}%' 
    OR t2.address LIKE '%{$input}%'
    ORDER BY t1.contact_datetime DESC";

    $stmt = $db->prepare($sql);
    $stmt->execute();
    $result_array = $stmt->fetchAll();
}
else {
    // $sql = "SELECT * FROM users ORDER BY id DESC";
    $sql = "SELECT t1.contact_datetime, t2.id, t2.name, t2.university, t2.department, t2.grad_year, t2.mail, t2.phone_number, t2.address, t3.company_name 
    FROM company_user as t1 
    inner join users as t2 
    on t1.user_id=t2.id 
    inner join company as t3 
    on t1.company_id=t3.id 
    ORDER BY t1.contact_datetime DESC";
    //t1.repを削除した↑
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $result_array = $stmt->fetchAll();

//     *************************** 1. row ***************************
// contact_datetime: 2022-06-01 00:00:00
//               id: 5
//             name: 加藤ゆう
//       university: 〇〇大学
//       department: 学部
//        grad_year: 25年春
//             mail: marusankakubatu@gmail.com
//     phone_number: 080-5432-1991
//          address: 〇県〇市
//              rep: 未設定
//     company_name: 加藤会社
// *************************** 2. row ***************************
// contact_datetime: 2022-05-10 00:00:00
//               id: 4
//             name: 山田かな
//       university: △△大学
//       department: 学部
//        grad_year: 25年春
//             mail: sankakusankaku@gmail.com
//     phone_number: 080-5432-1990
//          address: △県△市
//              rep: 未設定
//     company_name: 田中会社
// *************************** 3. row ***************************
// contact_datetime: 2022-05-06 00:00:00
//               id: 2
//             name: 佐藤太郎
//       university: 〇△大学
//       department: 学部
//        grad_year: 24年春
//             mail: marusankaku@gmail.com
//     phone_number: 080-5432-1988
//          address: △県〇市
//              rep: 未設定
//     company_name: 鈴木会社
// *************************** 4. row ***************************
// contact_datetime: 2022-05-06 00:00:00
//               id: 3
//             name: 田中一郎
//       university: △〇大学
//       department: 学部
//        grad_year: 24年秋
//             mail: sankakumaru@gmail.com
//     phone_number: 080-5432-1989
//          address: △県〇市
//              rep: 未設定
//     company_name: 山田会社
// *************************** 5. row ***************************
// contact_datetime: 2022-05-03 00:00:00
//               id: 1
//             name: 鈴木花子
//       university: 〇〇大学
//       department: 学部
//        grad_year: 24年春
//             mail: marumaru@gmail.com
//     phone_number: 080-5432-1987
//          address: 〇県△市
//              rep: 未設定
//     company_name: 佐藤会社
// *************************** 6. row ***************************
// contact_datetime: 2022-04-30 00:00:00
//               id: 1
//             name: 鈴木花子
//       university: 〇〇大学
//       department: 学部
//        grad_year: 24年春
//             mail: marumaru@gmail.com
//     phone_number: 080-5432-1987
//          address: 〇県△市
//              rep: 未設定
//     company_name: 鈴木会社

   
}


if ($result_array == true) {
    header('Content-type: application/json');
    echo json_encode($result_array);
} else {
    echo $return =
        "<h4> 検索条件:$input  $select </h4><p>に一致するデータはありませんでした</p> ";
}

// SQL文の作成
// $sql = "SELECT t1.contact_datetime, t2.id, t2.name, t2.university, t2.department, t2.grad_year, t2.mail, t2.phone_number, t2.address, t2.rep, t3.company_name 
//     FROM company_user as t1 
//     inner join users as t2 
//     on t1.user_id=t2.id 
//     inner join company as t3 
//     on t1.company_id=t3.id 
//     ORDER BY t1.contact_datetime DESC";
// $sql = "SELECT *
//   FROM company_user as t1 
//   inner join users as t2 
//   on t1.user_id=t2.id 
//   inner join company as t3 
//   on t1.company_id=t3.id 
//   where t2.id=1 
//   ORDER BY t1.contact_datetime DESC";
// $stmt = $db->prepare($sql);
// $stmt->execute();
// $result_array = $stmt->fetchAll();
// print_r($result_array);