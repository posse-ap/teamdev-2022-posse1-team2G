<?php
session_start();
require('../../dbconnect.php');
if (isset($_SESSION['id']) && $_SESSION['time'] + 60 * 60 > time()) {
  $_SESSION['time'] = time();

  $id = $_SESSION['id'];
  // T使う参考サイト　https://zukucode.com/2017/08/sql-join-where.html
  // $sql = "SELECT * FROM company WHERE id='$id' ORDER BY id DESC";
  // $sql = "select * from company as t1 inner join company_posting_information as t2 on t1.id = t2.company_id  where t1.id='$id' order by t1.id desc";
  $sql = "select * 
  from company as t1 
  inner join company_posting_information as t2 
    on t1.id = t2.company_id 
  inner join company_achievement as t3 
    on t1.id=t3.company_id 
  inner join company_service 
    as t4 on t1.id=t4.company_id 
  inner join company_feature 
    as t5 on t1.id=t5.company_id 
  inner join company_overview 
    as t6 on t1.id=t6.company_id 
  where t1.id='$id' order by t1.id";

  $stmt = $db->prepare($sql);
  $stmt->execute();
  $result_array = $stmt->fetchAll();
  // print_r($result_array);

  // 二次元配列になっていたものを一次元に変換
  $result = array_reduce($result_array, 'array_merge', array());


  // user_idがない、もしくは一定時間を過ぎていた場合
} else {
  header('Location: http://' . $_SERVER['HTTP_HOST'] . '/admin/login.php');
  exit();
}

function correctness_decision($val)
{
  if ($val == true) {
    echo '〇';
  } else {
    echo '✕';
  }
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>各企業詳細掲載ページ</title>
  <link rel="stylesheet" href="../admin_index.css">
  <link rel="stylesheet" href="../admin_style.css">
  <!-- ↓この_header.phpから見たparts.cssの位置ではなく、このphpファイルが読み込まれるファイルから見た位置を指定してあげる必要がある -->
  <link rel="stylesheet" href="../parts.css">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
  <!-- icon用 -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css">
</head>

<!-- header関数読み込み -->
<?php
include('./_parts_agent/_header_agent.php');
?>
<div class="container_contents">

  <div class='company_information_titie'>
    <h1><?= $result['company_name'] ?>掲載情報</h1>
  </div>
  <div class="company_contract_information">
    <p>契約情報</p>
    <dl class='company_information_list'>
      <dt>会社名</dt>
      <dd><?= $result['company_name'] ?></dd>
      <dt>電話番号</dt>
      <dd><?= $result['phone_number'] ?></dd>
      <dt>メールアドレス（contact）</dt>
      <dd><?= $result['mail_contact'] ?></dd>
      <dt>メールアドレス（manager）</dt>
      <dd><?= $result['mail_manager'] ?></dd>
      <dt>メールアドレス（notification）</dt>
      <dd><?= $result['mail_notification'] ?></dd>
      <dt>代表者</dt>
      <dd><?= $result['representative'] ?></dd>
      <dt>住所</dt>
      <dd><?= $result['address'] ?></dd>
      <dt>会社のURL</dt>
      <dd><?= $result['company_url'] ?></dd>
    </dl>
  </div>
  <div class="company_posting_information">
    <p>掲載基本情報</p>
    <dl class='company_information_list'>
      <dt>ロゴ</dt>
      <dd><?= $result['logo'] ?></dd>
      <dt>写真</dt>
      <dd class='img_dd'><img src="../../img/<?=$result['img']?>" alt="まきこさん"></dd>
      <dt>業種</dt>
      <dd><?= $result['industries'] ?></dd>
      <dt>実績</dt>
      <dd><?= $result['achievement'] ?></dd>
      <dt>タイプ</dt>
      <dd><?= $result['type'] ?></dd>
    </dl>
  </div>
  <div class="company_achievement">
    <p>掲載基本情報（実績）</p>
    <dl class='company_information_list'>
      <dt>求人数</dt>
      <dd><?= $result['job_offer_number'] ?></dd>
      <dt>紹介企業数</dt>
      <dd><?= $result['company_number'] ?></dd>
      <dt>利用学生数</dt>
      <dd><?= $result['user_count'] ?></dd>
      <dt>昨年の利用学生数</dt>
      <dd><?= $result['user_count_last_year'] ?></dd>
      <dt>内定率</dt>
      <dd><?= $result['informal_job_offer_rate'] ?></dd>
      <dt>満足度</dt>
      <dd><?= $result['satisfaction_degrees'] ?></dd>
    </dl>
  </div>
  <div class="company_service">
    <p>掲載基本情報（サービス）</p>
    <dl class='company_information_list'>
      <dt>ES添削</dt>
      <dd><?php correctness_decision($result['ES_correction']);
          ?></dd>
      <dt>面談</dt>
      <dd><?php correctness_decision($result['interview']); ?></dd>
      <dt>インターンシップ</dt>
      <dd><?php correctness_decision($result['internship']); ?></dd>
      <dt>セミナー</dt>
      <dd><?php correctness_decision($result['seminar']); ?></dd>
      <dt>研修</dt>
      <dd><?php correctness_decision($result['training']); ?></dd>
      <dt>地方学生支援</dt>
      <dd><?php correctness_decision($result['regional_student_support']); ?></dd>
      <dt>限定講座</dt>
      <dd><?php correctness_decision($result['limited_course']); ?></dd>
      <dt>適性診断</dt>
      <dd><?php correctness_decision($result['competence_diagnosis']); ?></dd>
      <dt>特別選考</dt>
      <dd><?php correctness_decision($result['special_selection']); ?></dd>
    </dl>
  </div>
  <div class="company_feature">
    <p>掲載説明</p>
    <dl class='company_information_list'>
      <dt>特徴➀</dt>
      <dd><?= $result['feature_first'] ?></dd>
      <dt>特徴➀補足</dt>
      <dd><?= $result['feature_second'] ?></dd>
      <dt>特徴➁</dt>
      <dd><?= $result['feature_third'] ?></dd>
      <dt>特徴➁補足</dt>
      <dd><?= $result['feature_sub_first'] ?></dd>
      <dt>特徴➂</dt>
      <dd><?= $result['feature_sub_second'] ?></dd>
      <dt>特徴➂補足</dt>
      <dd><?= $result['feature_sub_third'] ?></dd>
      <dt>メッセージ</dt>
      <dd><?= $result['message'] ?></dd>
    </dl>
  </div>
  <div class="company_overview">
    <p>会社概要、取り扱い</p>
    <dl class='company_information_list'>
      <dt>歴史</dt>
      <dd><?= $result['history'] ?></dd>
      <dt>従業員数</dt>
      <dd><?= $result['employee_number'] ?></dd>
      <dt>資本金</dt>
      <dd><?= $result['capital'] ?>-22</dd>
      <dt>取り扱い地域</dt>
      <dd><?= $result['handling_area'] ?></dd>
      <dt>取り扱い業種</dt>
      <dd><?= $result['handling_industries'] ?></dd>
      <dt>取り扱い職種</dt>
      <dd><?= $result['handling_job_category'] ?></dd>
      <dt>主な就職先</dt>
      <dd><?= $result['main_finding_employment_target'] ?></dd>
      <dt>面談形式</dt>
      <dd><?= $result['interview_format'] ?></dd>
      <dt>面談場所</dt>
      <dd><?= $result['interview_location'] ?></dd>
    </dl>
  </div>
</div>
</div>
<!-- ↓footer関数の読み込み -->
<?php
include('../_footer.php');
?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
<script src="./user_list.js"></script>

</body>

</html>