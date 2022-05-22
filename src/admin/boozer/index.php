<?php

require('../../dbconnect.php');
// 今月
$sql_month = "select count(*) as month from company_user where DATE_FORMAT(contact_datetime, '%Y%m')=DATE_FORMAT(NOW(), '%Y%m')";
$stmt_month = $db->prepare($sql_month);
$stmt_month->execute();
$result_month = $stmt_month->fetchAll();
$month = array_reduce($result_month, 'array_merge', array());

// 今日
$sql_today = "select count(*) as today from company_user where DATE_FORMAT(contact_datetime, '%Y%m%d')=DATE_FORMAT(NOW(), '%Y%m%d')";
$stmt_today = $db->prepare($sql_today);
$stmt_today->execute();
$result_today = $stmt_today->fetchAll();
$today = array_reduce($result_today, 'array_merge', array());

// 昨日
$sql_yesterday = "select count(*) as yesterday from company_user where DATE_FORMAT(contact_datetime, '%Y%m%d')=DATE_FORMAT(NOW() - INTERVAL 1 DAY, '%Y%m%d')";
$stmt_yesterday  = $db->prepare($sql_yesterday);
$stmt_yesterday->execute();
$result_yesterday  = $stmt_yesterday->fetchAll();
$yesterday = array_reduce($result_yesterday, 'array_merge', array());


$tax = 0.1;
$unit_price = 20000;
$price = $unit_price * (1 + $tax);

?>
<!doctype html>
<html lang="ja">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.23/datatables.min.css" />
  <link rel="stylesheet" href="../admin_style.css">

  <title>topページ</title>
</head>

<body>
  <div>
    <div>
      <p>売り上げ状況</p>
    </div>
    <div>
      <div class=''>
        <p>￥<?= number_format($month['month'] * $price) ?>/<?= $month['month'] ?>件</p>
        <small>今月の売上高/売り上げ件数</small>
      </div>
      <div>
        <p>￥<?= number_format($yesterday['yesterday'] * $price) ?>/<?= $yesterday['yesterday'] ?>件</p>
        <small>昨日の売上高/売り上げ件数</small>
      </div>
      <div>
        <p>￥<?= number_format($today['today'] * $price) ?>/<?= $today['today'] ?>件</p>
        <small>今日の売上高/売り上げ件数</small>
      </div>
    </div>

  </div>


  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <!-- <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



  <!-- <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script> -->
  <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script> -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>

  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>


  <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.23/datatables.min.js"></script>

  <script src="../user_list.js"></script>


</body>

</html>