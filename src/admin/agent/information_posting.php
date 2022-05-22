<?php
session_start();
require('../../dbconnect.php');
if (isset($_SESSION['id']) && $_SESSION['time'] + 1000000 > time()) {
  $_SESSION['time'] = time();

  $id = $_SESSION['id'];
  // T使う参考サイト　https://zukucode.com/2017/08/sql-join-where.html
  // $sql = "SELECT * FROM company WHERE id='$id' ORDER BY id DESC";
  $sql = "select * from company as t1 inner join company_posting_information as t2 on t1.id = t2.company_id  where t1.id='$id' order by t1.id desc";

  // 以下のSELECT分の結果
  // select * from company as t1 inner join company_posting_information as t2 on t1.id = t2.company_id  where t1.id=1 order by t1.id desc\G 
//   id: 1
//              company_name: 鈴木会社
//              phone_number: 0120-3456-1987
//              mail_contact: aaaaiiiiuuuu@gmail.com
//              mail_manager: ssssmmmmllll@gmail.com
//         mail_notification: maruaaaamaruaaaa@gmail.com
//            representative: 赤井
//                   address: 〇県△市
//               company_url: marumaruurl.com
//                delete_flg: 0
//                        id: 1
//                company_id: 1
//                      logo: ./src/admin/img/logo/
//                      name: 鈴木会社
//                       img: ./src/admin/img/img/
//                industries: IT
//               achievement: 満足度９８％
//                      type: 理系
//                catch_copy: dream
//               information: 鈴木会社は～で、実績が～で、…
//                  strength: 強み
//          job_offer_number: 1千万人
//                user_count: 2千万人
//   informal_job_offer_rate: 90%
//      satisfaction_degrees: 89%
// finding_employment_target: IT企業
//                        ES: 1
//                 interview: 1
//            limited_course: 1
//      competence_diagnosis: 1
//         special_selection: 1
//           interview_style: オンライン
//                  location: オンライン
//                delete_flg: 0
  $stmt = $db->prepare($sql);
  $stmt->execute();
  $result_array = $stmt->fetchAll();
  // print_r($result_array);

  // 二次元配列になっていたものを一次元に変換
  $result = array_reduce($result_array, 'array_merge', array());
// print_r($result);

  // user_idがない、もしくは一定時間を過ぎていた場合
} else {
  header('Location: http://' . $_SERVER['HTTP_HOST'] . '/admin/login.php');
  exit();
}
?>
<pre>
  <?PHP print_r($result);?>
</pre>


<!doctype html>
<html lang="ja">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.23/datatables.min.css" />



  <!-- <link rel="stylesheet" href="../../style.css"> -->
  <link rel="stylesheet" href="../admin.css">


  <title>各企業詳細掲載ページ</title>
</head>

<body>
  <div>
    <div class='outline'>
      <h1 class='aaa'>企業掲載情報</h1>
    </div>

    <div>
      <h2>会社情報</h2>
      <dl class="row">
        <dt class="col-sm-3">会社名</dt>
        <dd class="col-sm-9">○○会社</dd>
        <dt class="col-sm-3">メールアドレス</dt>
        <dd class="col-sm-9">
          <p>a@cavav.com</p>
          <p>a@dva.com</p>
        </dd>
        <dt class="col-sm-3">別の用語</dt>
        <dd class="col-sm-9">この別の用語の定義。</dd>
        </dd>
      </dl>
    </div>

    <dl class="row">
      <dt class="col-sm-3">説明リスト</dt>
      <dd class="col-sm-9">説明リストは、用語を定義するのに最適。</dd>
      <dt class="col-sm-3">用語</dt>
      <dd class="col-sm-9">
        <p>用語の定義。</p>
        <p>同じ用語の2番目の定義。</p>
      </dd>
      <dt class="col-sm-3">別の用語</dt>
      <dd class="col-sm-9">この別の用語の定義。</dd>
      </dd>
    </dl>


  </div>



  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.23/datatables.min.js"></script>
  <script src="./user_list.js"></script>


</body>

</html>