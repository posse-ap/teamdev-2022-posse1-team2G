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

// chart.js用
$sss = [];
for ($i = 1; $i <= 31; $i++) {
  $padding[$i] = (str_pad(date("$i"), 2, 0, STR_PAD_LEFT));
  $sql_graph = "SELECT count(*) as count from company_user where DATE_FORMAT(contact_datetime, '%Y%m%d') = '202205$padding[$i]' group by '202205$padding[$i]';";
  $sql_graph = "SELECT count(*) as today ,DATE_FORMAT(NOW(), '%Y%m$padding[$i]') as date from company_user where DATE_FORMAT(contact_datetime, '%Y%m$padding[$i]')=DATE_FORMAT(contact_datetime, '%Y%m%d')";
  $stmt_graph = $db->prepare($sql_graph);
  $stmt_graph->execute();
  $result_graph = $stmt_graph->fetchAll();
  $reduce_graph = array_reduce($result_graph, 'array_merge', array());
  array_push($sss, $reduce_graph['today']);
}
print_r($sss);



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
  <link rel="stylesheet" href="../admin_index.css">
  <link rel="stylesheet" href="../parts.css">
  <title>topページ</title>
</head>
<!-- header関数読み込み -->
<?php
include('./_parts_boozer/_header_boozer.php');
?>
<div class="container_contents">
  <div class='https://blog.8bit.co.jp/?p=11410'>
    <div class='sales_status_title'>
      <h1>売り上げ状況</h1>
    </div>
    <div class='sales_status_container'>
      <div class='sales_status_month each_dept'>
        <p>今月の売上高/売り上げ件数</p>
        <h2>￥<?= number_format($month['month'] * $price) ?>/<?= $month['month'] ?><small>件</small></h2>
      </div>
      <div class='sales_status_today each_dept'>
        <p>今日の売上高/売り上げ件数</p>
        <h2>￥<?= number_format($today['today'] * $price) ?>/<?= $today['today'] ?><small>件</small></h2>
      </div>
      <div class='sales_status_yesterday each_dept'>
        <p>昨日の売上高/売り上げ件数</p>
        <h2>￥<?= number_format($yesterday['yesterday'] * $price) ?>/<?= $yesterday['yesterday'] ?><small>件</small></h2>
      </div>
    </div>
  </div>
  <div>
    <div class='graph_title_month'>
      <p>月間</p>
    </div>
  </div>
  <div class='sales_status_graph'>
    <canvas id="myBarChart">
    </canvas>
  </div>
</div>

<!-- ↓footer関数の読み込み -->
<?php
include('../_footer.php');
?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.js"></script>



<script>
  var ctx = document.getElementById("myBarChart");
  var myBarChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31],
      datasets: [{
        label: '勉強時間',
        data: [
          <?php
          for ($i = 0; $i < count($sss); $i++) {
            echo $sss[$i] . ',';
          }
          ?>
        ],
        backgroundColor: "#76cff3"
      }]
    },
    options: {
      legend: {
        display: false
      },
      scales: {
        xAxes: [{
          gridLines: {
            display: false
          },
          ticks: {
            maxRotation: 0,
            minRotation: 0,
          }
        }],
        yAxes: [{
          gridLines: {
            display: false
          },
          ticks: {
            suggestedMax: 6,
            suggestedMin: 0,
            stepSize: 1,
          }
        }]
      },
      maintainAspectRatio: false,
    }
  });
</script>
<script src="../graph.js"></script>

</body>

</html>