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
        <div class="company_list">
          
        </div>
        <div>
          <!-- お問い合わせチェックボタンついた会社を一時表示するボックス -->
          <div class="selected_company_box">
            <p>お問い合わせするエージェント会社</p>
            <form id="form" class="validationForm" action="./compare_table.php" method="post">
              <!-- お問い合わせチェックボタンついた会社の表示箇所 -->
                 <div id="checked_company_box"></div>
              <!-- 完了ページへ渡すトークンの隠しフィールド -->
                 <input type="hidden" name="ticket" value="<?php echo h($ticket); ?>">
              <!-- お問い合わせするボタンを押すと、一時表示された会社の情報を比較表ページにpostする -->
                 <button name="submitted" type="submit" class="">お問い合わせ画面へ</button>
            </form>
          </div>
        </div>
      </div>
    </section>
  </main>

  <section>
  <div class="twrapper">
  	<table>
  		<tbody>
  			<tr>
  				<th scope="row" class="fixcell">企業</th>
  				<td>
            <!-- 一つの会社ボックス -->
            <?php foreach ($companies as $company) : ?>
              <div class="company_box outline">
                  <div class="company_info_second">
                      <img src="" alt="">
                      <p><?= $company['name']; ?></p>
                  </div>
                  
                  <div class="company_box_check">
                    <!-- valueにデータを追加していくことで、一時表示ボックスに反映できる -->
                    <label for="check"><input type="checkbox" name="select_company_checkboxes" value="<?= $company['company_id'];?>-<?= $company['name'];?>" onchange="checked_counter()">お問い合わせする</label>
                  </div>
                <!-- </a> -->
              </div>
            <?php endforeach; ?>
            <!-- ここまで -->
          </td>
  				<td>内容が入ります。<br>内容が入ります。</td>
  				<td>内容が入ります。<br>内容が入ります。</td>
  				<td>内容が入ります。<br>内容が入ります。</td>
  			</tr>
  			<tr>
  				<th scope="row" class="fixcell">項目</th>
  				<td>内容が入ります。<br>内容が入ります。</td>
  				<td>内容が入ります。<br>内容が入ります。</td>
  				<td>内容が入ります。<br>内容が入ります。</td>
  				<td>内容が入ります。<br>内容が入ります。</td>
  			</tr>
  			<tr>
  				<th scope="row" class="fixcell">項目</th>
  				<td>内容が入ります。<br>内容が入ります。</td>
  				<td>内容が入ります。<br>内容が入ります。</td>
  				<td>内容が入ります。<br>内容が入ります。</td>
  				<td>内容が入ります。<br>内容が入ります。</td>
  			</tr>
  		</tbody>
  	</table>
  </div>
    </section>
</body>
</html>
