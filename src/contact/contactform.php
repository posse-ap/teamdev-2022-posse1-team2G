<?php
//セッションを開始
session_start();
 
//セッションIDを更新して変更（セッションハイジャック対策）
session_regenerate_id( TRUE );
 
//エスケープ処理やデータチェックを行う関数のファイルの読み込み
// require '../libs/functions.php';
 
//NULL 合体演算子を使ってセッション変数を初期化
$name = $_SESSION[ 'fullname' ] ?? NULL;
$university = $_SESSION[ 'university' ] ?? NULL;
$department = $_SESSION[ 'department' ] ?? NULL;
$grad_year = $_SESSION[ 'grad_year' ] ?? NULL;
$email = $_SESSION[ 'email' ] ?? NULL;
$tel = $_SESSION[ 'tel' ] ??  NULL;
$address = $_SESSION[ 'address' ] ?? NULL;
$message = $_SESSION[ 'message' ] ?? NULL;
$error = $_SESSION[ 'error' ] ?? NULL;
 
//個々のエラーを NULL で初期化
$error_name = $error[ 'fullname' ] ?? NULL;
$error_university = $error[ 'university' ] ?? NULL;
$error_department = $error[ 'department' ] ?? NULL;
$error_grad_year = $error[ 'grad_year' ] ?? NULL;
$error_email = $error[ 'email' ] ?? NULL;
$error_tel = $error[ 'tel' ] ?? NULL;
$error_address = $error[ 'address' ] ?? NULL;
$error_message = $error[ 'message' ] ?? NULL;

 
//CSRF対策のトークンを生成
if ( !isset( $_SESSION[ 'ticket' ] ) ) {
  //セッション変数にトークンを代入
  $_SESSION[ 'ticket' ] = bin2hex(random_bytes(32));
}
//トークンを変数に代入（隠しフィールドに挿入する値）
$ticket = $_SESSION[ 'ticket' ];


// 問い合わせ会社を表示させるためのSQL用意
require('../dbconnect.php');
// https://hirashimatakumi.com/blog/311.html
// URLパラメーターから値を取得
// http://localhost:8080/contactform.php?company_id=3
// のようなパラメータで問い合わせフォームが表示されるのでこれの3の部分を取得するための挙動
if (isset($_GET['company_id'])) {
  $company_id = $_GET['company_id'];
}

$stmt = $db->prepare("SELECT * FROM company_posting_information WHERE id = :id");
$id = $company_id;
$stmt->bindValue(':id', $id, PDO::PARAM_STR);
$stmt->execute();
$info = $stmt->fetch();
?>
<!-- <pre><? echo $company_id;?></pre> -->

<!-- ここからフロント側 -->
<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <title>お問い合わせフォーム</title>
</head>

<body>
<!-- ↑ヘッダー関数 -->


  <!-- 入力画面 -->  
<div class="container">
  <!-- 会社情報 -->
  <h2>お問い合わせ会社</h2>
  <?= htmlspecialchars($info['industries']) ?>

  <!-- フォーム -->
  <h1>お問い合わせフォーム</h1>
  <p>以下のフォームからお問い合わせください。</p>
  
  <form id="form" class="validationForm" action="./confirm.php?company_id=<?= htmlspecialchars($company_id);?>" method="post" novalidate>
      <div>
        <p>名前</p>
        <input type="text" class="required maxlength form-control" data-maxlength="30" id="name" name="name"
      placeholder="氏名" data-error-required="お名前は必須です。" 
      value="<?php echo $name; ?>">
      </div>
      <div>
        <p>大学</p>
        <!-- <input type="text" name="university" value="<?php echo $_SESSION['university'] ?>"> -->
        <input type="text" class="required maxlength form-control" data-maxlength="30" id="university" name="university" 
      placeholder="大学名" data-error-required="大学名は必須です。" 
      value="<?php echo $university; ?>">
      </div>
      </div>
      <div>
        <p>学部学科</p>
        <!-- <input type="text" name="department" value="<?php echo $_SESSION['department'] ?>"> -->
        <input type="text" class="required maxlength form-control" data-maxlength="30" id="department" name="department" 
      placeholder="学部学科" data-error-required="学部学科は必須です。" 
      value="<?php echo $department; ?>">
      </div>
      <div>
        <p>卒業年</p>
        <div>
          <input type="radio" name="grad_year" value="23年春">23年春
        </div>
        <div>
          <input type="radio" name="grad_year" value="23年秋">23年秋
        </div>
        <div>
          <input type="radio" name="grad_year" value="24年春">24年春
        </div>
        <div>
          <input type="radio" name="grad_year" value="24年秋">24年秋
        </div>
      </div>
      <div>
        <p>メールアドレス</p>
        <!-- <input type="mail" name="mail" value="<?php echo $_SESSION['mail'] ?>"> -->
        <input type="email" class="required pattern form-control" data-pattern="email" id="email" name="email" 
      placeholder="Email アドレス" data-error-required="Email アドレスは必須です。"  
      data-error-pattern="Email の形式が正しくないようですのでご確認ください" value="<?php echo $email; ?>">
      </div>
      <div>
        <p>お電話番号</p>
        <!-- <input type="tel" name="tel" value="<?php echo $_SESSION['tel'] ?>"> -->
        <input type="tel" class="pattern form-control" data-pattern="tel" id="tel" name="tel"
       placeholder="お電話番号" data-error-pattern="電話番号の形式が正しくないようですのでご確認ください"  value="<?php echo $tel; ?>">
      </div>
      <div>
        <p>住所</p>
        <!-- <input type="text" name="address" value="<?php echo $_SESSION['address'] ?>"> -->
        <input type="text" class="required maxlength form-control" data-maxlength="100" id="address" name="address"
       placeholder="住所" data-error-pattern="住所の形式が正しくないようですのでご確認ください"  value="<?php echo $address; ?>">
      </div>
      <div>
        <p>その他</p>
        <!-- <textarea cols="40" rows="8" name="message"><?php echo $_SESSION['message'] ?></textarea><br> -->
        <textarea cols="40" rows="8" class="required maxlength form-control" data-maxlength="1000" id="message" name="message" rows="3"><?php echo $message; ?></textarea>
      </div>

      <!--確認ページへトークンをPOSTする、隠しフィールド「ticket」-->
      <input type="hidden" name="ticket" value="<?php echo $ticket; ?>">
      <!-- <input type="submit" name="confirm" value="確認" /> -->
      <button name="submitted" type="submit" class="btn btn-primary">確認画面へ</button>
    </form>
</div>
<!-- 検証用 JavaScript の読み込み -->
<script src="./formValidation.js"></script> 

  <!-- フッター関数↓ -->
</body>


</html>