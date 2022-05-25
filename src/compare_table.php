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
  $company_id_Condition[] = 'company_id = ' . $company_id;
}

// これをORでつなげて、文字列にする
$company_id_Condition = implode(' OR ', $company_id_Condition);

// あとはSELECT文にくっつける
$sql = 'SELECT * FROM company_posting_information WHERE ' . $company_id_Condition;
$stmt = $db->query($sql);
$stmt->execute();
$companies = $stmt->fetchAll();

// echo "<pre>";
// print_r($companies);
// echo "</pre>";
// [id] => 1
//             [company_id] => 1
//             [logo] => ./src/admin/img/logo/
//             [name] => 鈴木会社
//             [img] => ./src/admin/img/img/
//             [industries] => IT
//             [achievement] => 満足度９８％
//             [type] => 理系
//             [catch_copy] => dream
//             [information] => 鈴木会社は～で、実績が～で、…
//             [strength] => 強み
//             [job_offer_number] => 1千万人
//             [user_count] => 2千万人
//             [informal_job_offer_rate] => 90%
//             [satisfaction_degrees] => 89%
//             [finding_employment_target] => IT企業
//             [ES] => 1
//             [interview] => 1
//             [limited_course] => 1
//             [competence_diagnosis] => 1
//             [special_selection] => 1
//             [interview_style] => オンライン
//             [location] => オンライン
//             [delete_flg] => 0
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
        <h2>比較表</h2>        
      </div>
    </section>
  </main>

  <section>
  <div class="twrapper">
  	<table>
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

              <!-- 企業ロゴ -->
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

              <!-- サブタイトル -->
              <tr class="tr-sticky">
                  <td>基本情報</td>
              </tr>
              <tr>
                  <th>業界</th>
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
      <form id="form" class="validationForm" action="./contact/contactform.php?company_id=<?= htmlspecialchars($company['company_id']); ?>" method="post">
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
