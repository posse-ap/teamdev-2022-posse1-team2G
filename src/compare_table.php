<?php
require('./dbconnect.php');

//セッションを開始
session_start();
//エスケープ処理やデータチェックを行う関数のファイルの読み込み
require './libs/functions.php';
//POSTされたデータをチェック
$_POST = checkInput( $_POST );
//固定トークンを確認（CSRF対策）
if ( isset( $_POST[ 'ticket' ], $_SESSION[ 'ticket' ] ) ) {
  $ticket = $_POST[ 'ticket' ];
  if ( $ticket !== $_SESSION[ 'ticket' ] ) {
    //トークンが一致しない場合は処理を中止
    die( 'Access Denied!' );
  }
} else {
  //トークンが存在しない場合は処理を中止（直接このページにアクセスするとエラーになる）
  die( 'Access Denied（直接このページにはアクセスできません）' );
}

//company_idを取得
$company_ids =  $_POST['id'];

// キーワードの数だけループして、LIKE句の配列を作る
$company_id_Condition = [];
foreach ($company_ids as $company_id) {
  $company_id_Condition[] = 'company_posting_information.company_id = ' . $company_id;
}

// これをORでつなげて、文字列にする
$company_id_Condition = implode(' OR ', $company_id_Condition);

// あとはSELECT文にくっつける
// $sql = 'SELECT * FROM company_posting_information WHERE ' . $company_id_Condition;
$sql = 'SELECT
          company_posting_information.company_id AS company_id,
          company_posting_information.name AS name,
          company_posting_information.industries AS industries,
          company_posting_information.type AS type,
          company_achievement.job_offer_number AS job_offer_number,
          company_achievement.user_count AS user_count,
          company_achievement.informal_job_offer_rate AS informal_job_offer_rate,
          company_achievement.user_count AS user_count,
          company_achievement.satisfaction_degrees AS satisfaction_degrees,
          company_service.ES_correction AS ES_correction,
          company_service.interview AS interview,
          company_service.limited_course AS limited_course,
          company_service.competence_diagnosis AS competence_diagnosis,
          company_service.special_selection AS special_selection,
          company_service.internship AS internship,
          company_overview.interview_format AS interview_format,
          company_overview.interview_location AS interview_location
          FROM company_posting_information
          INNER JOIN company_achievement
          ON  company_posting_information.company_id = company_achievement.company_id
          INNER JOIN company_service
          ON  company_posting_information.company_id = company_service.company_id 
          INNER JOIN company_overview
          ON  company_posting_information.company_id = company_overview.company_id
          WHERE ' . $company_id_Condition;
$stmt = $db->query($sql);
$stmt->execute();
$companies = $stmt->fetchAll();

// 企業数のカウント,数値を文字列に型変換する
$cnt = (string)count($companies);
echo $cnt;

// echo "<pre>";
// print_r($companies);
// echo "</pre>";

?>


<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>比較表ページ</title>
  <link rel="stylesheet" href="compare_table.css">
</head>

<body>
  <main>
    <section id="company">
      <div class="company_wrapper">
        <h1>比較表</h1>        
      </div>
    </section>
  </main>

  <section>
  <div class="twrapper">
  	<table class="colap">
  		<tbody>

          <thead>
              <!-- 企業名 -->
              <tr class="tr-sticky">
                  <th>企業名</th>
                    <?php foreach ($companies as $company) : ?>
                       <td class="p-0" style="text-align:center" ><?= $company['name']; ?></td>
                    <?php endforeach; ?>
                  <!-- <td class="p-0" style="text-align:center" >企業</td> -->
              </tr>
          </thead>

              <!-- 企業ロゴとお問い合わせチェックボックス -->
              <tr>
                <th class="text-center">企業ロゴ</th>
                <?php foreach ($companies as $company) : ?>
                  <td class="">
                      <div class="table_company_img">
                       <img src="\img\SHI95_sansyainsuizokukanoosuii.jpg" alt="企業ロゴ">
                      </div>
                      <div class="company_box_check">
                      <!-- valueにデータを追加していくことで、一時表示ボックスに反映できる -->
                      <label for="check"><input type="checkbox" name="select_company_checkboxes" value="<?= $company['company_id'];?>-<?= $company['name'];?>" onchange="checked_counter()">お問い合わせする</label>
                  </div>
                  </td>
                <?php endforeach; ?>
              </tr>

              <!-- 基本情報 -->
              <tr class="tr-sticky">
                  <!-- <th></th> -->
                  <td colspan= <? echo $cnt+1;?>>基本情報</td>
              </tr>
              <tr>
                  <th>業界</th>
                  <?php foreach ($companies as $company) : ?>
                    <td class=""><?= $company['industries']; ?></td>
                  <?php endforeach; ?>
              </tr>
              <tr>
                  <th>おすすめの人</th>
                  <?php foreach ($companies as $company) : ?>
                    <td class=""><?= $company['type']; ?></td>
                  <?php endforeach; ?>
              </tr>

              <!-- 実績 -->
              <tr class="tr-sticky">
                  <td>実績</td>
              </tr>
              <tr>
                  <th>求人数</th>
                  <?php foreach ($companies as $company) : ?>
                    <td class=""><?= $company['job_offer_number']; ?></td>
                  <?php endforeach; ?>
              </tr>
              <tr>
                  <th>学生利用者数</th>
                  <?php foreach ($companies as $company) : ?>
                    <td class=""><?= $company['user_count']; ?></td>
                  <?php endforeach; ?>
              </tr>
              <tr>
                  <th>内定率</th>
                  <?php foreach ($companies as $company) : ?>
                    <td class=""><?= $company['informal_job_offer_rate']; ?></td>
                  <?php endforeach; ?>
              </tr>
              <tr>
                  <th>満足度</th>
                  <?php foreach ($companies as $company) : ?>
                    <td class=""><?= $company['satisfaction_degrees']; ?></td>
                  <?php endforeach; ?>
              </tr>

              <!-- サポート -->
              <tr class="tr-sticky">
                  <td>サポート</td>
              </tr>
              <tr>
                  <th>ES対策</th>
                  <?php foreach ($companies as $company) : ?>
                    <td class="">
                      <? if($company['industries'] = 1):?>
                      <div>〇</div> 
                      <?else: ?>
                      <div>✕</div> 
                     <?endif; ?></td>
                  <?php endforeach; ?>
              </tr>
              <tr>
                  <th>面接対策</th>
                  <?php foreach ($companies as $company) : ?>
                    <td class=""><?= $company['industries']; ?></td>
                  <?php endforeach; ?>
              </tr>
              <tr>
                  <th>限定講座</th>
                  <?php foreach ($companies as $company) : ?>
                    <td class=""><?= $company['industries']; ?></td>
                  <?php endforeach; ?>
              </tr>
              <tr>
                  <th>適正診断</th>
                  <?php foreach ($companies as $company) : ?>
                    <td class=""><?= $company['industries']; ?></td>
                  <?php endforeach; ?>
              </tr>
              <tr>
                  <th>特別選考</th>
                  <?php foreach ($companies as $company) : ?>
                    <td class=""><?= $company['industries']; ?></td>
                  <?php endforeach; ?>
              </tr>
              <tr>
                  <th>インターン紹介</th>
                  <?php foreach ($companies as $company) : ?>
                    <td class=""><?= $company['industries']; ?></td>
                  <?php endforeach; ?>
              </tr>

              <!-- その他 -->
              <tr class="tr-sticky">
                  <td>その他</td>
              </tr>
              <tr>
                  <th>面談形態</th>
                  <?php foreach ($companies as $company) : ?>
                    <td class=""><?= $company['industries']; ?></td>
                  <?php endforeach; ?>
              </tr>
              <tr>
                  <th>拠点</th>
                  <?php foreach ($companies as $company) : ?>
                    <td class=""><?= $company['industries']; ?></td>
                  <?php endforeach; ?>
              </tr>
  	</table>
  </div>
  </section>
  <section>
    <!-- お問い合わせチェックボタンついた会社を一時表示するボックス -->
    <div class="selected_company_box">
      <p>お問い合わせするエージェント会社</p>
      <form id="form" class="validationForm" action="./contact/contactform.php" method="post">
        <!-- お問い合わせチェックボタンついた会社の表示箇所 -->
           <div id="checked_company_box"></div>
        <!-- 完了ページへ渡すトークンの隠しフィールド -->
           <input type="hidden" name="ticket" value="<?php echo h($ticket); ?>">
        <!-- お問い合わせするボタンを押すと、一時表示された会社の情報を比較表ページにpostする -->
           <button name="submitted" type="submit" class="">お問い合わせ画面へ</button>
      </form>
    </div>
  </section>
  <script src="./to_compare_table.js"></script>
</body>
</html>
