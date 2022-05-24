<?php

// define("TAX", 0.1);
// $money = 20000 * (1 + TAX);
// $money_json = json_encode($money);

require('../../dbconnect.php');

//   print_r($money);

// 件数とSELECT同時にする方法
// select *,(select count(*) from company) as count from company;


if (!empty($_GET['input'])) {
    $input = $_GET['input'];

    $sql = "select t1.*,t2.* from
(select * from company) as t1
left outer join 
(select count(*) as count_month, company_id from company_user where company_id IS NULL OR DATE_FORMAT(contact_datetime, '%Y%m')=DATE_FORMAT(NOW(), '%Y%m') group by company_id) as t2
on t1.id=t2.company_id
WHERE 
    t1.company_id LIKE '%{$input}%' 
    ORDER BY t1.company_id DESC ";

    $stmt = $db->prepare($sql);
    $stmt->execute();
    $result_array = $stmt->fetchAll();
} else {
    //  -----   company_userの自動id   ---------
    //                id: 3
    //           user_id: 2
    //        company_id: 1
    //  contact_datetime: 2022-05-06 00:00:00

    //   ----- companyの自動id      -----------
    //                id: 1
    //      company_name: 鈴木会社
    //      phone_number: 0120-3456-1987
    //      mail_contact: aaaaiiiiuuuu@gmail.com
    //      mail_manager: ssssmmmmllll@gmail.com
    // mail_notification: maruaaaamaruaaaa@gmail.com
    //    representative: 赤井
    //           address: 〇県△市
    //       company_url: marumaruurl.com
    //        delete_flg: 0

    //   -----    usersの自動id   --------
    //                id: 2
    //              name: 佐藤太郎
    //        university: 〇△大学
    //        department: 学部
    //         grad_year: 24年春
    //              mail: marusankaku@gmail.com
    //      phone_number: 080-5432-1988
    //           address: △県〇市
    //               rep: 未設定
    //        delete_flg: 0
    //             count: 2
    // $sql =  "select *,(select count(*) as count from company_user as t1 inner join company as t2 on t1.company_id = t2.id inner join users as t3 on t1.user_id = t3.id where company_id = 1 order by company_id desc) as count 
    // from company_user as t1 inner join company as t2 on t1.company_id = t2.id inner join users as t3 on t1.user_id 
    // = t3.id order by company_id desc";
    // $sql = "select t1.id, t1.company_name, t1.phone_number, t1.mail_contact, t1.mail_manager, t1.mail_notification, t1.representative, t1.address, t1.company_url, count(t1.id) as count from company as t1 inner join company_user as t2 on t1.id = t2.company_id group by t1.id order by t1.id";
    $sql = "select t1.*,t2.* from
(select * from company) as t1
left outer join 
(select count(*) as count_month, company_id from company_user where company_id IS NULL OR DATE_FORMAT(contact_datetime, '%Y%m')=DATE_FORMAT(NOW(), '%Y%m') group by company_id) as t2
on t1.id=t2.company_id
";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $result_array = $stmt->fetchAll();
}
// print_r($result_array);

//  select t1.id, t1.company_name, t1.phone_number, t1.mail_contact, t1.mail_manager, t1.mail_notification, t1.representative, t1.address, t1.company_url, count(t1.id) as count from company as t1 inner join company_user as t2 on t1.id = t2.company_id group by t1.id order by t1.id\G;

if ($result_array == true) {
    header('Content-type: application/json');
    echo json_encode($result_array);
} else {
    echo $return = "<h4>No Record Found</h4>";
}


// print_r($result_array);
// select *, (select count(*) from company_user as t2 where t1.user_id = t2.user_id) from company_user as t1;
// +------+---------+------------+---------------------+-------------------------------------------------------------------------+
// | id   | user_id | company_id | contact_datetime    | (select count(*) from company_user as t2 where t1.user_id = t2.user_id) |
// +------+---------+------------+---------------------+-------------------------------------------------------------------------+
// |    1 |       1 |          1 | 2022-04-30 00:00:00 |                                                                       2 ||    2 |       1 |          2 | 2022-05-03 00:00:00 |                                                                       2 ||    3 |       2 |          1 | 2022-05-06 00:00:00 |                                                                       1 ||    4 |       3 |          4 | 2022-05-06 00:00:00 |                                                                       1 ||    5 |       4 |          3 | 2022-05-10 00:00:00 |                                                                       1 ||    6 |       5 |          5 | 2022-06-01 00:00:00 |                                                                       1 |
// +------+---------+------------+---------------------+-------------------------------------------------------------------------+

// $sql = "select * from company";
// // $sql = "SELECT * FROM company";
// $stmt = $db->prepare($sql);
// $stmt->execute();
// $result_array = $stmt->fetchAll();
// // print_r($result_array);

// // $ssql="";
// // $ssql = "select company_id from company_user where DATE_FORMAT(contact_datetime, '%Y%m')=DATE_FORMAT(NOW(), '%Y%m') order by company_id desc";
// // $ssql = "select count(*) as count, company_id from company_user where company_id IS NULL OR DATE_FORMAT(contact_datetime, '%Y%m')=DATE_FORMAT(NOW(), '%Y%m') group by company_id";
// // $ssql = "select count(*) from (select company_user.company_id from company_user where company_user.company_id IS NULL OR DATE_FORMAT(contact_datetime, '%Y%m')=DATE_FORMAT(NOW(), '%Y%m') group by company_user.company_id) as t1 ";
// $ssql= "select count(*) as count_month, company_id from company_user where company_id IS NULL OR DATE_FORMAT(contact_datetime, '%Y%m')=DATE_FORMAT(NOW(), '%Y%m') group by company_id";
// $ssql = "select count(t1.id)as count , company_id from company as t1 inner join company_user as t2 on t1.id = t2.company_id group by t1.id order by t1.id";
// $ssql = "select t1.*,t2.* from 
// (select count(*) as count_month, company_id from company_user where company_id IS NULL OR DATE_FORMAT(contact_datetime, '%Y%m')=DATE_FORMAT(NOW(), '%Y%m') group by company_id) as t1
// right outer join 
// (select count(t1.id)as count , company_id from company as t1 inner join company_user as t2 on t1.id = t2.company_id group by t1.id order by t1.id) as t2
// on t1.company_id = t2.company_id
// ";
// // $ssql = "select t3.*, t4.* from
// // (select * from company) as t3
// // inner join
// // (select t1.*,t2.* from 
// // (select count(*) as count_month, company_id from company_user where company_id IS NULL OR DATE_FORMAT(contact_datetime, '%Y%m')=DATE_FORMAT(NOW(), '%Y%m') group by company_id) as t1
// // right outer join 
// // (select count(t1.id)as count , company_id from company as t1 inner join company_user as t2 on t1.id = t2.company_id group by t1.id order by t1.id) as t2
// // on t1.company_id = t2.company_id) as t4
// // on t3.id=t4.company_id
// // ";

// $ssql= "select t1.*,t2.* from
// (select * from company) as t1
// left outer join 
// (select count(*) as count_month, company_id from company_user where company_id IS NULL OR DATE_FORMAT(contact_datetime, '%Y%m')=DATE_FORMAT(NOW(), '%Y%m') group by company_id) as t2
// on t1.id=t2.company_id
// ";
// $ssql = "select t1.*,t2.* from
// (select * from company) as t1
// left outer join 
// (select count(*) as count_month, company_id from company_user where company_id IS NULL OR DATE_FORMAT(contact_datetime, '%Y%m')=DATE_FORMAT(NOW(), '%Y%m') group by company_id) as t2
// on t1.id=t2.company_id
// ";

// $st = $db->prepare($ssql);
// $st->execute();
// $result= $st->fetchAll();
// // print_r($result);
