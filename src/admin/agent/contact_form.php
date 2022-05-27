<?php
session_start();
require('../../dbconnect.php');
//エスケープ処理やデータチェックを行う関数のファイルの読み込み
require '../../libs/functions.php';

if (isset($_SESSION['id']) && $_SESSION['time'] + 10 > time()) {
  $_SESSION['time'] = time();
  // user_idがない、もしくは一定時間を過ぎていた場合
  $id = $_SESSION['id'];
  // echo $id;
  // $sql = "SELECT rep FROM company_user";
  $sql = "SELECT company_name from company where id='$id';";
  $stmt = $db->prepare($sql);
  $stmt->execute();
  $company_name = $stmt->fetchAll();
} else {
  header('Location: http://' . $_SERVER['HTTP_HOST'] . '/admin/login.php');
  exit();
}
// echo "<pre>";
// print_r($company_name);
// echo "</pre>";
// Array
// (
//     [0] => Array
//         (
//             [company_name] => 鈴木会社
//         )
// )
// echo $company_name[0]["company_name"]; //鈴木会社

//NULL 合体演算子を使ってセッション変数を初期化
$purpose = $_SESSION[ 'purpose' ] ?? NULL;
$message = $_SESSION[ 'message' ] ?? NULL;
$error = $_SESSION[ 'error' ] ?? NULL;
 
//個々のエラーを NULL で初期化
$error_address = $error[ 'purpose' ] ?? NULL;
$error_message = $error[ 'message' ] ?? NULL;
$company_name_session = $_SESSION[ 'company_name' ] ?? NULL;

//CSRF対策のトークンを生成
if ( !isset( $_SESSION[ 'ticket' ] ) ) {
  //セッション変数にトークンを代入
  $_SESSION[ 'ticket' ] = bin2hex(random_bytes(32));
}
//トークンを変数に代入（隠しフィールドに挿入する値）
$ticket = $_SESSION[ 'ticket' ];

// print_r($id);

// // //company_nameのsessionを生成
// if ( !isset( $_SESSION[ 'company_name' ] ) ) {
//   //セッション変数に代入
//   $_SESSION[ 'company_name' ] = [];
//   foreach ($companies as $company){
//     array_push($_SESSION[ 'company_name' ],$company_name[0]["company_name"]);
//   }
// }
// // sessionを変数に代入
// $company_name_sessions = $_SESSION[ 'company_name' ];

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>申請フォーム画面</title>
  <!-- ↓この_header.phpから見たparts.cssの位置ではなく、このphpファイルが読み込まれるファイルから見た位置を指定してあげる必要がある -->
  <link rel="stylesheet" href="../parts.css">
  <link rel="stylesheet" href="../admin_index.css">

</head>
<body>
  <header>
    <div class="header_wrapper">
      <div class="header_logo">
        <img src="../../img/boozer_logo.png" alt="logo">
        <!-- <a href="#">CRAFT</a> -->
      </div>
    </div>
    <nav class="header_nav">
      <ul>
        <li class="nav_item"><a href="../user_list.php">申し込み一覧</a></li>
        <li class="nav_item"><a href="../information_posting.php">登録情報</a></li>
        <li class="nav_item"><a href="../contact_form.php">申請</a></li>
      </ul>
    </nav>
  </header>
  <main>

<div class="container">

  <!-- フォーム -->
  <h1>ー申請フォームー</h1>
  <p>以下のフォームからお問い合わせください。</p>

  <form id="form" class="validationForm" action="./thanks.php" method="post" novalidate>
 
      <div>
        <p>目的</p>
        <label>無効申請</label>
        <input type="radio"  name="purpose" data-error-required-radio="目的は必須です。" value="無効申請">
        <label>登録情報の変更</label>
        <input type="radio"  name="purpose" data-error-required-radio="目的は必須です。" value="登録情報の変更">
        <label>その他</label>
        <input type="radio"  name="purpose" data-error-required-radio="目的は必須です。" value="その他">
      </div>
      
      <div>
        <p>内容</p>
        <textarea cols="40" rows="8" class="maxlength" 
        placeholder="自由記述欄" data-maxlength="1000" id="message" name="message" rows="3"><?php echo $message; ?></textarea>
      </div>


      <!--確認ページへトークンをPOSTする、隠しフィールド「ticket」-->
      <input type="hidden" name="ticket" value="<?php echo $ticket; ?>">
      <!-- 確認ページへトークンをPOSTする、隠しフィールド「company_id_session」-->
      <!-- <?php foreach ($companies as $company) : ?> -->
        <input type="hidden" name="company_id_session[]" value="<?php echo $company["id"]; ?>">
      <!-- <?php endforeach; ?> -->
      <button name="submitted" type="submit" class="btn btn-primary">確認画面へ</button>
    </form>
</div>


<!-- ↓footer関数の読み込み -->
</main>

<footer class="footer">
  <div id="footer-menu">
    <div>
      <a class="footer-menu__btn dfont" id="footerlogo" href="https://reashu.com"><img src="../../img/shukatsu_logo.png" alt="就活の教科書 | 新卒大学生向け就職活動サイト"></a>
      <p class="site_description futo">23卒/22卒の内定者と運営する、新しい就活情報サイト</p>
    </div>
    <nav>
      <div class="footer-links cf">
        <ul id="menu-%e3%83%95%e3%83%83%e3%82%bf%e3%83%bc%e3%83%a1%e3%83%8b%e3%83%a5%e3%83%bc" class="nav footer-nav cf">
          <li id="menu-item-13320" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-13320"><a href="https://reashu.com/what-is-reashu/">就活の教科書とは</a></li>
          <li id="menu-item-67013" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-67013"><a href="https://reashu.com/?page_id=49113">運営責任者（監修者）</a></li>
          <li id="menu-item-94658" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-94658"><a href="https://reashu.com/recruit/">ライター募集中</a></li>
          <li id="menu-item-68279" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-68279"><a href="https://synergy-career.co.jp">運営会社</a></li>
          <li id="menu-item-12448" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-12448"><a href="https://reashu.com/privacy/">プライバシーポリシー</a></li>
          <li id="menu-item-12449" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-12449"><a href="https://reashu.com/contact/">広告等のお問い合わせ</a></li>
          <li id="menu-item-12446" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-12446"><a href="https://reashu.com/sitemap/">サイトマップ</a></li>
        </ul>
      </div>
    </nav>
    <p class="copyright dfont">
      &copy; 2022 株式会社Synergy Career All rights reserved.
    </p>
  </div>
</footer>

<!--  JavaScript の読み込み -->
<script src="../../contact/formValidation.js"></script> 
</body>