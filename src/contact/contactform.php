<?php
//セッションを開始
session_start();
 
//セッションIDを更新して変更（セッションハイジャック対策）
session_regenerate_id( TRUE );
 
//エスケープ処理やデータチェックを行う関数のファイルの読み込み
require '../libs/functions.php';
 
//NULL 合体演算子を使ってセッション変数を初期化
$name = $_SESSION[ 'name' ] ?? NULL;
$university = $_SESSION[ 'university' ] ?? NULL;
$department = $_SESSION[ 'department' ] ?? NULL;
$grad_year = $_SESSION[ 'grad_year' ] ?? NULL;
$email = $_SESSION[ 'email' ] ?? NULL;
$phone_number = $_SESSION[ 'phone_number' ] ??  NULL;
$address = $_SESSION[ 'address' ] ?? NULL;
$message = $_SESSION[ 'message' ] ?? NULL;
$privacy = $_SESSION[ 'privacy' ] ?? NULL;
$error = $_SESSION[ 'error' ] ?? NULL;
 
//個々のエラーを NULL で初期化
$error_name = $error[ 'name' ] ?? NULL;
$error_university = $error[ 'university' ] ?? NULL;
$error_department = $error[ 'department' ] ?? NULL;
$error_grad_year = $error[ 'grad_year' ] ?? NULL;
$error_email = $error[ 'email' ] ?? NULL;
$error_phone_number = $error[ 'phone_number' ] ?? NULL;
$error_address = $error[ 'address' ] ?? NULL;
$error_message = $error[ 'message' ] ?? NULL;
$error_privacy = $error[ 'privacy' ] ?? NULL;
$company_id_session = $_SESSION[ 'company_id' ] ?? NULL;

//CSRF対策のトークンを生成
if ( !isset( $_SESSION[ 'ticket' ] ) ) {
  //セッション変数にトークンを代入
  $_SESSION[ 'ticket' ] = bin2hex(random_bytes(32));
}
//トークンを変数に代入（隠しフィールドに挿入する値）
$ticket = $_SESSION[ 'ticket' ];


// 問い合わせ会社を表示させるためのSQL用意
require('../dbconnect.php');

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
if ( !isset( $_SESSION[ 'company_id' ] ) ) {
  //セッション変数に代入
  $_SESSION[ 'company_id' ] = [];
  foreach ($companies as $company){
    array_push($_SESSION[ 'company_id' ],$company["id"]);
  }
}
// sessionを変数に代入
$company_id_sessions = $_SESSION[ 'company_id' ];
// print_r($company_id_session);

?>

<!-- ここからフロント側 -->
<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <title>お問い合わせフォーム</title>
</head>

<body>
<!-- ↑ヘッダー関数 -->

<div class="container">
  <!-- 会社情報 -->
  <h2>お問い合わせ会社</h2>
    <?php foreach ($companies as $company) : ?>
      <?= h($company['name']) ?>
    <?php endforeach; ?>
  <!-- フォーム -->
  <h1>お問い合わせフォーム</h1>
  <p>以下のフォームからお問い合わせください。</p>

  <form id="form" class="validationForm" action="./confirm.php" method="post" novalidate>
      <div>
        <p>名前</p>
        <input type="text" class="required maxlength" data-maxlength="30" id="name" name="name"
       data-error-required="お名前は必須です。" value="<?php echo $name; ?>">
      </div>
      <div>
        <p>大学</p>
        <input type="text" class="required maxlength" data-maxlength="30" id="university" name="university" 
       data-error-required="大学名は必須です。" value="<?php echo $university; ?>">
      </div>
      </div>
      <div>
        <p>学部学科</p>
        <input type="text" class="required maxlength" data-maxlength="30" id="department" name="department" 
       data-error-required="学部学科は必須です。" value="<?php echo $department; ?>">
      </div>
      <div>
        <p>卒業年</p>
        <label>23年春</label>
        <input type="radio" class="required" name="grad_year" data-error-required-radio="卒業年は必須です。" value="23年春">
        <label>23年秋</label>
        <input type="radio"  name="grad_year" data-error-required-radio="卒業年は必須です。" value="23年秋">
        <label>24年春</label>
        <input type="radio"  name="grad_year" data-error-required-radio="卒業年は必須です。" value="24年春">
        <label>24年秋</label>
        <input type="radio"  name="grad_year" data-error-required-radio="卒業年は必須です。" value="24年秋">
      </div>
      <div>
        <p>メールアドレス</p>
        <input type="email" class="required pattern" data-pattern="email" id="email" name="email" 
       data-error-required="Email アドレスは必須です。"  
      data-error-pattern="Email の形式が正しくないようですのでご確認ください" value="<?php echo $email; ?>">
      </div>
      <div>
        <p>お電話番号（半角英数字）</p>
        <input type="phone_number" class="required pattern" data-pattern="phone_number" id="phone_number" name="phone_number"
       data-error-pattern="電話番号の形式が正しくないようですのでご確認ください"  value="<?php echo $phone_number; ?>">
      </div>
      <div>
        <p>住所</p>
        <input type="text" class="required maxlength" data-maxlength="100" id="address" name="address"
       data-error-required="住所は必須です。"  value="<?php echo $address; ?>">
      </div>
      <div>
        <p>その他</p>
        <textarea cols="40" rows="8" class="maxlength" 
        placeholder="自由記述欄" data-maxlength="1000" id="message" name="message" rows="3"><?php echo $message; ?></textarea>
      </div>

      <div>
        <div>
          <a href="https://reashu.com/privacy/">プライバシーポリシー</a>をご確認の上、「同意する」にチェックしてください。
        </div>
        <div>
          <input type="checkbox" name="privacy" class="required" value="同意する">同意する
        </div>
      </div>

      <!--確認ページへトークンをPOSTする、隠しフィールド「ticket」-->
      <input type="hidden" name="ticket" value="<?php echo $ticket; ?>">
      <!-- 確認ページへトークンをPOSTする、隠しフィールド「company_id_session」-->
      <?php foreach ($companies as $company) : ?>
        <input type="hidden" name="company_id_session[]" value="<?php echo $company["id"]; ?>">
      <?php endforeach; ?>
      <button name="submitted" type="submit" class="btn btn-primary">確認画面へ</button>
    </form>
</div>
<!--  JavaScript の読み込み -->
<script src="./formValidation.js"></script> 


  <!-- フッター関数↓ -->
</body>
</html>