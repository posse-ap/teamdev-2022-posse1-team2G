<?php
require('./dbconnect.php');

//セッションを開始
session_start();
//エスケープ処理やデータチェックを行う関数のファイルの読み込み
require '../libs/functions.php';
//POSTされたデータをチェック
$_POST = checkInput($_POST);
//固定トークンを確認（CSRF対策）
if (isset($_POST['ticket'], $_SESSION['ticket'])) {
  $ticket = $_POST['ticket'];
  if ($ticket !== $_SESSION['ticket']) {
    //トークンが一致しない場合は処理を中止
    die('Access Denied!');
  }
} else {
  //トークンが存在しない場合は処理を中止（直接このページにアクセスするとエラーになる）
  die('Access Denied（直接このページにはアクセスできません）');
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

// 企業数のカウント
$cnt = count($companies);
$row = 0;

//企業名を入れたタイトルを表示するための準備
// $company_names = [];
// foreach ($companies as $company) :
//   if(next($companies)){
// 		echo $company['name'] . 'と'; // 最後の要素ではないとき
// 	}else {
//     echo $company['name'] . 'の';
//   }
// endforeach;

// echo "<pre>";
// print_r($company_names);
// echo "</pre>";


?>


<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>比較表ページ</title>
  <link rel="stylesheet" href="../css/compare_table.css">
  <link rel="stylesheet" href="../css/parts.css">
</head>

<body>
  <header>
    <div class="header_wrapper">
      <div class="header_logo">
        <img src="../img/boozer_logo.png" alt="logo">
      </div>
    </div>
    <nav class="header_nav">
      <ul>
        <li class="nav_item"><a href="./top.php#company">企業一覧</a></li>
        <li class="nav_item"><a href="./top.php#point">お悩みの方へ</a></li>
        <li class="nav_item"><a href="./top.php#merit">比較のメリット</a></li>
        <li class="nav_item"><a href="./top.php#question">よくある質問</a></li>
        <!-- 時間あったらモーダルにしてちょっと就活エージェントのこと書いて、就活の教科書の特集に飛ばせるかも -->
        <li class="nav_item"><a href="#">就活エージェントとは</a></li>
        <!-- ここまで -->
        <li class="nav_item"><a href="#">企業の方へ</a></li>
      </ul>
    </nav>
  </header>
  <main class="compare_wrapper">
    <h1>～<?php foreach ($companies as $company) :
            if (next($companies)) {
              echo $company['name'] . 'と'; // 最後の要素ではないとき
            } else {
              echo $company['name'] . 'の';
            }
          endforeach; ?>比較結果～</h1>
    <section>
      <div class="twrapper">
        <table>
            <!-- 基本情報 -->
            <tr>
              <td class="fill" colspan=<? echo $cnt + 1; ?>>基本情報</td>
            </tr>
            <!-- 企業名 -->
            <tr>
              <th class="fixcell">企業名</th>
              <?php foreach ($companies as $company) : ?>
                <td class="company_name" style="text-align:center"><?= $company['name']; ?></td>
              <?php endforeach; ?>
            </tr>
            <!-- 企業ロゴとお問い合わせチェックボックス -->
            <tr>
              <th class="fixcell">企業ロゴ</th>
              <?php foreach ($companies as $company) : ?>
                <td>
                  <div class="table_company_img">
                    <img src="\img\SHI95_sansyainsuizokukanoosuii.jpg" alt="企業ロゴ">
                    <!-- <img src="../img/'<? $company["logo"];?>'" alt="企業ロゴ"> -->
                  </div>
                </td>
              <?php endforeach; ?>
            </tr>
            <!-- お問い合わせ -->
            <tr>
              <th class="fixcell">お問い合わせ</th>
              <?php foreach ($companies as $company) : ?>
                <td>
                  <div class="company_box_check">
                    <!-- valueにデータを追加していくことで、一時表示ボックスに反映できる -->
                    <input type="checkbox" name="select_company_checkboxes" value="<?= $company['company_id']; ?><?= $company['name']; ?>" id="checked_box_<? echo $row; ?>" onchange="checked_counter()">
                    <label for="checked_box_<? echo $row; ?>">選択する</label>
                  </div>
                </td>
                <? $row += 1; ?>
              <?php endforeach; ?>
            </tr>
            <!-- 業界 -->
            <tr>
              <th class="fixcell">業界</th>
              <?php foreach ($companies as $company) : ?>
                <td class="text"><?= $company['industries']; ?><?= $company['industries']; ?><?= $company['industries']; ?><?= $company['industries']; ?></td>
              <?php endforeach; ?>
            </tr>
            <!-- おすすめの人 -->
            <tr>
              <th class="fixcell">おすすめの人</th>
              <?php foreach ($companies as $company) : ?>
                <td class="text"><?= $company['type']; ?><?= $company['type']; ?><?= $company['type']; ?><?= $company['type']; ?></td>
              <?php endforeach; ?>
            </tr>

            <!-- 実績 -->
            <tr>
              <td class="fill" colspan=<? echo $cnt + 1; ?>>実績</td>
            </tr>
            <tr>
              <th class="fixcell">求人数</th>
              <?php foreach ($companies as $company) : ?>
                <td><?= $company['job_offer_number']; ?></td>
              <?php endforeach; ?>
            </tr>
            <tr>
              <th class="fixcell">学生利用者数</th>
              <?php foreach ($companies as $company) : ?>
                <td><?= $company['user_count']; ?></td>
              <?php endforeach; ?>
            </tr>
            <tr>
              <th class="fixcell">内定率</th>
              <?php foreach ($companies as $company) : ?>
                <td><?= $company['informal_job_offer_rate']; ?></td>
              <?php endforeach; ?>
            </tr>
            <tr>
              <th class="fixcell">満足度</th>
              <?php foreach ($companies as $company) : ?>
                <td><?= $company['satisfaction_degrees']; ?></td>
              <?php endforeach; ?>
            </tr>

            <!-- サポート -->
            <tr>
              <td class="fill" colspan=<? echo $cnt + 1; ?>>サポート</td>
            </tr>
            <tr>
              <th class="fixcell">ES対策</th>
              <?php foreach ($companies as $company) : ?>
                <td>
                  <? if ($company['ES_correction'] = 1) : ?>
                    <div>〇</div>
                  <? else : ?>
                    <div>✕</div>
                  <? endif; ?>
                </td>
              <?php endforeach; ?>
            </tr>
            <tr>
              <th class="fixcell">面接対策</th>
              <?php foreach ($companies as $company) : ?>
                <td>
                  <? if ($company['interview'] = 1) : ?>
                    <div>〇</div>
                  <? else : ?>
                    <div>✕</div>
                  <? endif; ?>
                </td>
              <?php endforeach; ?>
            </tr>
            <tr>
              <th class="fixcell">限定講座</th>
              <?php foreach ($companies as $company) : ?>
                <td>
                  <? if ($company['limited_course'] = 1) : ?>
                    <div>〇</div>
                  <? else : ?>
                    <div>✕</div>
                  <? endif; ?>
                </td>
              <?php endforeach; ?>
            </tr>
            <tr>
              <th class="fixcell">適正診断</th>
              <?php foreach ($companies as $company) : ?>
                <td>
                  <? if ($company['competence_diagnosis'] = 1) : ?>
                    <div>〇</div>
                  <? else : ?>
                    <div>✕</div>
                  <? endif; ?>
                </td>
              <?php endforeach; ?>
            </tr>
            <tr>
              <th class="fixcell">特別選考</th>
              <?php foreach ($companies as $company) : ?>
                <td>
                  <? if ($company['special_selection'] = 1) : ?>
                    <div>〇</div>
                  <? else : ?>
                    <div>✕</div>
                  <? endif; ?>
                </td>
              <?php endforeach; ?>
            </tr>
            <tr>
              <th class="fixcell">インターン紹介</th>
              <?php foreach ($companies as $company) : ?>
                <td><?= $company['internship']; ?></td>
              <?php endforeach; ?>
            </tr>

            <!-- その他 -->
            <tr>
              <td class="fill" colspan=<? echo $cnt + 1; ?>>その他</td>
            </tr>
            <tr>
              <th class="fixcell">面談形態</th>
              <?php foreach ($companies as $company) : ?>
                <td class="text"><?= $company['interview_format']; ?></td>
              <?php endforeach; ?>
            </tr>
            <tr>
              <th class="fixcell">拠点</th>
              <?php foreach ($companies as $company) : ?>
                <td class=""><?= $company['interview_location']; ?><?= $company['interview_location']; ?><?= $company['interview_location']; ?><?= $company['interview_location']; ?><?= $company['interview_location']; ?></td>
              <?php endforeach; ?>
            </tr>
        </table>
      </div>
    </section>
    <section>
      <!-- お問い合わせチェックボタンついた会社を一時表示するボックス -->
      <div id="at_once_box" class="selected_company_box">
        <p class="box-title">✓選択済みエージェント会社</p>
        <form id="form" class="validationForm" action="./contact/contactform.php" method="post">
          <!-- お問い合わせチェックボタンついた会社の表示箇所 -->
          <div id="checked_company_box" class="self__checkbox"></div>
          <!-- 完了ページへ渡すトークンの隠しフィールド -->
          <input type="hidden" name="ticket" value="<?php echo h($ticket); ?>">
          <!-- お問い合わせするボタンを押すと、一時表示された会社の情報を比較表ページにpostする -->
          <button name="submitted" type="submit" class="contact_button">お問い合わせ画面へ</button>
        </form>
      </div>
    </section>
    </main>
  <footer>
    <div class="footer_wrapper">
      <div class="footer_student">
        <p>学生の方へ</p>
        <ul class="footer_list">
          <li><a href="#company">企業一覧</a></li>
          <li><a href="#problem">お悩みの方へ</a></li>
          <li><a href="#merit">比較のメリット</a></li>
          <li><a href="#question">よくある質問</a></li>
          <li><a href="#">就活エージェントとは</a></li>
        </ul>
      </div>
      <div class="footer_company">
        <p>企業の方へ</p>
        <ul class="footer_list">
          <li><a href="#">CRAFTについて</a></li>
          <li><a href="#">サイト掲載について</a></li>
        </ul>
      </div>
      <div class="footer_logo">
        <!-- <img src="" alt="logo"> -->
        <p>CRAFT</p>
      </div>
      <span class="footer_copyright">
        ©︎ 2022 CRAFT. All rights reserved.
      </span>
    </div>
  </footer>

  <script src="../js/compare_table.js"></script>
</body>

</html>