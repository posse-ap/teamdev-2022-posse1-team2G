<?php
//セッションを開始
session_start();

//セッションIDを更新して変更（セッションハイジャック対策）
session_regenerate_id(TRUE);

//エスケープ処理やデータチェックを行う関数のファイルの読み込み
require '../../libs/functions.php';

//NULL 合体演算子を使ってセッション変数を初期化
$name = $_SESSION['name'] ?? NULL;
$university = $_SESSION['university'] ?? NULL;
$department = $_SESSION['department'] ?? NULL;
$grad_year = $_SESSION['grad_year'] ?? NULL;
$email = $_SESSION['email'] ?? NULL;
$phone_number = $_SESSION['phone_number'] ??  NULL;
$address = $_SESSION['address'] ?? NULL;
$message = $_SESSION['message'] ?? NULL;
$privacy = $_SESSION['privacy'] ?? NULL;
$error = $_SESSION['error'] ?? NULL;

//個々のエラーを NULL で初期化
$error_name = $error['name'] ?? NULL;
$error_university = $error['university'] ?? NULL;
$error_department = $error['department'] ?? NULL;
$error_grad_year = $error['grad_year'] ?? NULL;
$error_email = $error['email'] ?? NULL;
$error_phone_number = $error['phone_number'] ?? NULL;
$error_address = $error['address'] ?? NULL;
$error_message = $error['message'] ?? NULL;
$error_privacy = $error['privacy'] ?? NULL;
$company_id_session = $_SESSION['company_id'] ?? NULL;

//CSRF対策のトークンを生成
if (!isset($_SESSION['ticket'])) {
  //セッション変数にトークンを代入
  $_SESSION['ticket'] = bin2hex(random_bytes(32));
}
//トークンを変数に代入（隠しフィールドに挿入する値）
$ticket = $_SESSION['ticket'];


// 問い合わせ会社を表示させるためのSQL用意
require('../../dbconnect.php');


if (isset($_GET['company_id'])) {
  // 一社だけの場合（TOPページからの挙動）
  //company_idを取得
  $stmt = $db->prepare("SELECT * FROM company_posting_information WHERE id = :id");
  $company_id = $_GET['company_id'];
  $stmt->bindValue(':id', $company_id, PDO::PARAM_STR);
  $stmt->execute();
  $company = $stmt->fetch();
  // //Company_idのsessionを生成
  if (!isset($_SESSION['company_id'])) {
    //セッション変数に代入
    $_SESSION['company_id'] = [];
    array_push($_SESSION['company_id'], $company["id"]);
  }
} else {
  // 複数の会社の場合 (比較表ページからの挙動)
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
  // //Company_idのsessionを生成
  if (!isset($_SESSION['company_id'])) {
    //セッション変数に代入
    $_SESSION['company_id'] = [];
    foreach ($companies as $company) {
      array_push($_SESSION['company_id'], $company["id"]);
    }
  }
}

// sessionを変数に代入
$company_id_sessions = $_SESSION['company_id'];
// print_r($company_id_session);


?>


<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../../css/parts.css">
  <link rel="stylesheet" href="../../css/contact.css">
  <title>お問い合わせフォーム</title>
</head>

<body>
  <header>
    <div class="header_wrapper">
      <div class="header_logo">
        <img src="../../img/boozer_logo.png" alt="logo">
      </div>
    </div>
    <nav class="header_nav">
      <ul>
        <!-- <li class="nav_item"><a href="./top.php#company">企業一覧</a></li> -->
        <li class="nav_item"><a href="../../user/top.php#company">企業一覧</a></li>
        <li class="nav_item"><a href="../../user/top.php#point">お悩みの方へ</a></li>
        <li class="nav_item"><a href="../../user/top.php#merit">比較のメリット</a></li>
        <li class="nav_item"><a href="../../user/top.php#question">よくある質問</a></li>
        <!-- 時間あったらモーダルにしてちょっと就活エージェントのこと書いて、就活の教科書の特集に飛ばせるかも -->
        <li class="nav_item"><a href="#">就活エージェントとは</a></li>
        <!-- ここまで -->
        <li class="nav_item"><a href="#">企業の方へ</a></li>
      </ul>
    </nav>
  </header>
  <main class="main_wrapper">
    <!-- ↑ヘッダー関数 -->

    <div class="contactform_container">
      <!-- 入力画面 -->
      <div class="contactform_title">
        <h1>お問い合わせフォーム</h1>
      </div>
      <div class="contactform_each_container contactform_topic">
        <p>お問い合わせする会社</p>
      </div>

      <?php if (isset($_GET['company_id'])) : ?>
        <div class="contactform_contact_company">
          <div class="contactform_contact_company_img">
            <img src="../src/img/<?= h($company['logo']) ?>" alt="">
            <!-- <img src="../src/img/shukatsu_logo.png" alt=""> -->
          </div>
          <div class="contactform_contact_company_name">
            <p><?= h($company['name']) ?></p>
          </div>
        </div>
      <?php else : ?>
        <?php foreach ($companies as $company) : ?>
          <div class="contactform_contact_company">
            <div class="contactform_contact_company_img">
              <img src="../src/img/<?= h($company['logo']) ?>" alt="">
              <!-- <img src="../src/img/shukatsu_logo.png" alt=""> -->
            </div>
            <div class="contactform_contact_company_name">
              <p><?= h($company['name']) ?></p>
            </div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>

      <!-- 入力画面のフロント -->
      <form id="form" class="validationForm" action="./confirm.php" method="post" novalidate>
        <div class="contactform_each_container contactform_topic topic_info">
          <p>お客様情報</p>
        </div>
        <div class="contactform_each_container top_container">
          <div class="contactform_question">
            <p>名前</p>
          </div>
          <div class="contactform_required">
            <p>必須</p>
          </div>
          <div class="contactform_input">
            <input type="text" class="required maxlength" data-maxlength="30" id="name" name="name" data-error-required="お名前は必須です。" value="<?php echo $name; ?>">
          </div>
        </div>
        <div class="contactform_each_container">
          <div class="contactform_question">
            <p>大学</p>
          </div>
          <div class="contactform_required">
            <p>必須</p>
          </div>
          <div class="contactform_input">
            <input type="text" class="required maxlength" data-maxlength="30" id="university" name="university" data-error-required="大学名は必須です。" value="<?php echo $university; ?>">
          </div>
        </div>
        <div class="contactform_each_container">
          <div class="contactform_question">
            <p>学部学科</p>
          </div>
          <div class="contactform_required">
            <p>必須</p>
          </div>
          <div class="contactform_input">
            <input type="text" class="required maxlength" data-maxlength="30" id="department" name="department" data-error-required="学部学科は必須です。" value="<?php echo $department; ?>">
          </div>
        </div>
        <div class="contactform_each_container">
          <div class="contactform_question">
            <p>卒業年</p>
          </div>
          <div class="contactform_required">
            <p>必須</p>
          </div>
          <div class="contactform_input_radio">
            <input type="radio" class="required" name="grad_year" data-error-required-radio="卒業年は必須です。" value="23年春">
            <label>23年春</label>
            <input type="radio" name="grad_year" data-error-required-radio="卒業年は必須です。" value="23年秋">
            <label>23年秋</label><br>
            <input type="radio" name="grad_year" data-error-required-radio="卒業年は必須です。" value="24年春">
            <label>24年春</label>
            <input type="radio" name="grad_year" data-error-required-radio="卒業年は必須です。" value="24年秋">
            <label>24年秋</label>
          </div>
        </div>
        <div class="contactform_each_container">
          <div class="contactform_question">
            <p>メールアドレス</p>
          </div>
          <div class="contactform_required">
            <p>必須</p>
          </div>
          <div class="contactform_input">
            <input type="email" class="required pattern" data-pattern="email" id="email" name="email" data-error-required="Email アドレスは必須です。" data-error-pattern="Email の形式が正しくないようですのでご確認ください" value="<?php echo $email; ?>">
          </div>
        </div>
        <div class="contactform_each_container">
          <div class="contactform_question">
            <p>お電話番号 <br>(半角英数字)</p>
          </div>
          <div class="contactform_required">
            <p>必須</p>
          </div>
          <div class="contactform_input">
            <input type="phone_number" class="required pattern" data-pattern="phone_number" id="phone_number" name="phone_number" data-error-pattern="電話番号の形式が正しくないようですのでご確認ください" value="<?php echo $phone_number; ?>">
          </div>
        </div>
        <div class="contactform_each_container">
          <div class="contactform_question">
            <p>住所</p>
          </div>
          <div class="contactform_required">
            <p>必須</p>
          </div>
          <div class="contactform_input">
            <input type="text" class="required maxlength" data-maxlength="100" id="address" name="address" data-error-required="住所は必須です。" value="<?php echo $address; ?>">
          </div>
        </div>
        <div class="contactform_each_container textarea">
          <div class="contactform_question">
            <p>その他</p>
          </div>
          <div class="contactform_not_required">
            <p>任意</p>
          </div>
          <div class="contactform_input_textarea">
            <textarea cols="40" rows="8" class="maxlength" placeholder="自由記述欄" data-maxlength="1000" id="message" name="message" rows="3"><?php echo $message; ?></textarea>
          </div>
        </div>
        <div class="contactform_each_container">
          <div class="contactform_question">
            <p><a href="https://reashu.com/privacy/">プライバシーポリシー</a></p>
          </div>
          <div class="contactform_required">
            <p>必須</p>
          </div>
          <div class="contactform_input">
            <input type="checkbox" name="privacy" class="required" value="同意する">同意する
          </div>
        </div>
    </div>

    <!--確認ページへトークンをPOSTする、隠しフィールド「ticket」-->
    <input type="hidden" name="ticket" value="<?php echo $ticket; ?>">
    <!-- 確認ページへトークンをPOSTする、隠しフィールド「company_id_session」-->
    <?php if (isset($_GET['company_id'])) : ?>
      <input type="hidden" name="company_id_session[]" value="<?php echo $company["id"]; ?>">
    <?php else : ?>
      <?php foreach ($companies as $company) : ?>
        <input type="hidden" name="company_id_session[]" value="<?php echo $company["id"]; ?>">
      <?php endforeach; ?>
    <?php endif; ?>

    <div class="contactform_submit">
      <input name="submitted" type="submit" name="confirm" value="内容を確認">
    </div>

    </form>
    </div>
  </main>
  <footer>
    <div class="footer_wrapper">
      <div class="footer_student">
        <p>学生の方へ</p>
        <ul class="footer_list">
          <li class="nav_item"><a href="../top.php#company">企業一覧</a></li>
          <li class="nav_item"><a href="../top.php#point">お悩みの方へ</a></li>
          <li class="nav_item"><a href="../top.php#merit">比較のメリット</a></li>
          <li class="nav_item"><a href="../top.php#question">よくある質問</a></li>
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
  <!--  JavaScript の読み込み -->
  <script src="../../js/formValidation.js"></script>



  </div>
</body>

</html>