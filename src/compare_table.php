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


$company_ids =  $_POST['id'];

// echo "<pre>";
// print_r($company_ids); //Array ( [0] => 1 [1] => 5 )
// echo "</pre>";


// キーワードの数だけループして、LIKE句の配列を作る
$company_id_Condition = [];
foreach ($company_ids as $company_id) {
  $company_id_Condition[] = 'company_id = ' . $company_id;
}

// echo "<pre>";
// print_r($company_id_Condition); 
// echo "</pre>";


// これをORでつなげて、文字列にする
$company_id_Condition = implode(' OR ', $company_id_Condition);

// あとはSELECT文にくっつけてできあがり♪
$sql = 'SELECT * FROM company_posting_information WHERE ' . $company_id_Condition;
$stmt = $db->query($sql);
$stmt->execute();
$companies = $stmt->fetchAll();

// echo "<pre>";
// print_r($companies);
// echo "</pre>";

// $stmt = $db->prepare("SELECT * FROM company_posting_information WHERE id = :id");
// $id = $company_id;
// $stmt->bindValue(':id', $id, PDO::PARAM_STR);
// $stmt->execute();
// $info = $stmt->fetch();

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
        <!-- <div class="company_list">
          <!-- 一つの会社ボックス --
          <?php foreach ($companies as $company) : ?>
              <div class="company_box outline">
                  <div class="company_info_second">
                      <img src="" alt="">
                      <p><?= $company['name']; ?></p>
                  </div>
                  
                  <div class="company_box_check">
                    <!-- valueにデータを追加していくことで、一時表示ボックスに反映できる --
                    <label for="check"><input type="checkbox" name="select_company_checkboxes" value="<?= $company['company_id'];?>-<?= $company['name'];?>" onchange="checked_counter()">お問い合わせする</label>
                  </div>
                <!-- </a> --
              </div>
            <?php endforeach; ?>
            <!-- ここまで --
        </div> -->
        
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
                  <th width="5px">企業名</th>
                    <?php foreach ($companies as $company) : ?>
                       <td class="p-0" style="text-align:center" ><?= $company['name']; ?></td>
                    <?php endforeach; ?>
                  <!-- <td class="p-0" style="text-align:center" >企業</td> -->
              </tr>
          </thead>

              <!-- start title -->
              <tr>
                <th class="text-center" width="5px">企業ロゴ</th>
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

              <!-- start img -->
              <tr>
                  <th width="5px">企業イメージ</th>
                  <td class="" style="text-align:center">
                      <a href = "/ec_shopping/ec/compareItem/4549995250022" onclick="ga('send', 'event', 'link_ec_shopping_specs_compare', 'click', 'ec_shopping_compare_specs_link_{key(4549995250022)}', 1);">
                          <div class="img-outer row m-0">
                              <div class="img-container text-center col-xs-12">
                                  <img class="compare-img" src="http://thumbnail.image.rakuten.co.jp/@0_gold/gigamedia/img/sba/pc/ip2021s256_sbht.jpg?_ex=128x128" alt="5/30 受付まで iPad 10.2インチ 第9世代 Wi-Fi 256GB 2021年秋モデル MK2P3J/A + SoftBank 光 ソフトバンク光 セット 送料無料 新品 WiFi">
                              </div>
                          </div>
                          <div>
                              <p class="pt-1 text-center"><span class="price pinkred h4" itemprop="price" content="38980"> ¥38,980                                    </span> </p>
                              <div class="text-center">
                                  <button class="btn hikaku text-banner">価格比較をする</button>
                              </div>
                          </div>
                      </a>
                  </td>
                  <td class="p-0" style="text-align:center">
                      <a href = "/ec_shopping/ec/compareItem/4549995250015" onclick="ga('send', 'event', 'link_ec_shopping_specs_compare', 'click', 'ec_shopping_compare_specs_link_{key(4549995250015)}', 1);">
                          <div class="img-outer row m-0">
                              <div class="img-container text-center col-xs-12">
                                  <img class="compare-img" src="http://thumbnail.image.rakuten.co.jp/@0_gold/gigamedia/img/sba/pc/ip2021g256_sbht.jpg?_ex=128x128" alt="5/30 受付まで iPad 10.2インチ 第9世代 Wi-Fi 256GB 2021年秋モデル MK2N3J/A + SoftBank 光 ソフトバンク光 セット 送料無料 新品 WiFi">
                              </div>
                          </div>
                          <div>
                              <p class="pt-1 text-center"><span class="price pinkred h4" itemprop="price" content="38980"> ¥38,980                                    </span> </p>
                              <div class="text-center">
                                  <button class="btn hikaku text-banner">価格比較をする</button>
                              </div>
                          </div>
                      </a>
                  </td>
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
