<?php
//セッションを開始
session_start();
 
//セッションIDを更新して変更（セッションハイジャック対策）
session_regenerate_id( TRUE );
 
//エスケープ処理やデータチェックを行う関数のファイルの読み込み
require '../libs/functions.php';
 
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





$mode = 'input';
$errormessage = array();
// 何もしない
if (isset($_POST['back']) && $_POST['back']) {

  // 確認画面のエラーメッセージ
} else if (isset($_POST['confirm']) && $_POST['confirm']) {

  // 名前
  if (!$_POST["fullname"]) {
    $errormessage[] = "名前を入力して下さい";
  } else if (mb_strlen($_POST["fullname"]) > 20) {
    $errormessage[] = "名前は20文字以内にして下さい";
  }
  $_SESSION["fullname"] = htmlspecialchars($_POST["fullname"], ENT_QUOTES);

  // 大学
  if (!$_POST["university"]) {
    $errormessage[] = "大学名を入力して下さい";
  } else if (mb_strlen($_POST["university"]) > 20) {
    $errormessage[] = "大学名は20文字以内にして下さい";
  }
  $_SESSION["university"] = htmlspecialchars($_POST["university"], ENT_QUOTES);

  // 学部学科
  if (!$_POST["department"]) {
    $errormessage[] = "学部を入力して下さい";
  } else if (mb_strlen($_POST["department"]) > 20) {
    $errormessage[] = "学部は20文字以内にして下さい";
  }
  $_SESSION["department"] = htmlspecialchars($_POST["department"], ENT_QUOTES);

  // 卒業年
  if (!$_POST["grad_year"]) {
    $errormessage[] = "卒業年を入力して下さい";
  }
  $_SESSION["grad_year"] = htmlspecialchars($_POST["grad_year"], ENT_QUOTES);

  // メールアドレス
  if (!$_POST["mail"]) {
    $errormessage[] = "メールアドレスを入力して下さい";
  } else if (mb_strlen($_POST["mail"]) > 200) {
    $errormessage[] = "メールアドレスは200文字以内にして下さい";
  } else if (!filter_var($_POST["mail"], FILTER_VALIDATE_EMAIL)) {
    $errormessage[] = "メールアドレスが不正です";
  }
  $_SESSION["mail"] = htmlspecialchars($_POST["mail"], ENT_QUOTES);

  // 電話番号
  if (!$_POST["tel"]) {
    $errormessage[] = "電話番号を入力して下さい";
  } else if (mb_strlen($_POST["tel"]) > 20) {
    $errormessage[] = "電話番号は20文字以内にして下さい";
  }
  $_SESSION["tel"] = htmlspecialchars($_POST["tel"], ENT_QUOTES);

  // 住所
  if (!$_POST["address"]) {
    $errormessage[] = "住所を入力して下さい";
  } else if (mb_strlen($_POST["address"]) > 100) {
    $errormessage[] = "住所は100文字以内にして下さい";
  }
  $_SESSION["address"] = htmlspecialchars($_POST["address"], ENT_QUOTES);

  // その他は任意なのでエラーメッセージは表示しない
  $_SESSION["message"] = htmlspecialchars($_POST["message"], ENT_QUOTES);

  // エラーが生じた場合→input(遷移しない)
  // エラーが生じなかった場合→confirm(確認画面に遷移)
  if ($errormessage) {
    $mode = 'input';
  } else {
    $mode = 'confirm';
  }
}
// 送信ボタンを押したとき 
else if (isset($_POST['send']) && $_POST['send']) {

  //エンコード処理
  mb_language("Japanese");
  mb_internal_encoding("UTF-8");

  /* メールの作成 （to 学生）*/
  //メール本文の用意
  $honbun = '';
  $honbun .= "メールフォームよりお問い合わせがありました。\n\n";
  $honbun .= "【お名前】\n";
  $honbun .= $_SESSION['fullname'] . "\n\n";
  $honbun .= "【メールアドレス】\n";
  $honbun .= $_SESSION['mail'] . "\n\n";
  $honbun .= "【お問い合わせ内容】\n";
  $honbun .= "申し込みいただきありがとうございます。" . "\n";
  $honbun .= "担当の者から連絡致しますので少々お待ちください。" . "\n\n";
  /* 
   mail_to($宛先):	送信先のメールアドレス 各アドレスをカンマで区切ると、複数の宛先をtoに指定できる。このパラメータは、自動的にはエンコードされない。
   mail_subject($件名):	メールの件名
   mail_body($本文):  メールの本文
   mail_header($ヘッダー):	ヘッダー
      from:  送信元として表示されるメールアドレス
      Return-Path:  fromと同じメアド
      以下headerの文字化け防止
        ・MIME-Version
        ・Content-Transfer-Encoding
        ・Content-Type
  */
  $mail_to  = $_SESSION['mail'];
  $mail_subject  = "craftのご利用";
  $mail_body  = $honbun . "\n\n";
  $mail_header = "from: ayaka1712pome@gmail.com\r\n"
    . "Return-Path: ayaka1712pome@gmail.com\r\n"
    . "MIME-Version: 1.0\r\n"
    . "Content-Transfer-Encoding: BASE64\r\n"
    . "Content-Type: text/plain; charset=UTF-8\r\n";

  //メール送信処理
  $mailsousin  = mb_send_mail($mail_to, $mail_subject, $mail_body, $mail_header);

  //メール送信結果
  if ($mailsousin == true) {
    echo '<p>お問い合わせメールを送信しました。</p>';
  } else {
    echo '<p>メール送信でエラーが発生しました。</p>';
  }


  /* メールの作成 （to エージェント）*/

  // お問い合わせページのPHP、選択された会社の情報の受け渡しはできる
    //（company_posting_informationテーブルからselectしてる）
  // メール送信する場合は、二つのテーブル紐づけて、
  // companyテーブルのmail_contactカラムから送信先とってくれば送信できる
    // 送られているかテストするなら、init.sqlのメールアドレス変えてやってみるといいと思う！

  //選択された会社のメールアドレス取得
  // $stmt = $db->prepare("SELECT * FROM company_posting_information WHERE id = :id");
  // $id = $company_id;
  // $stmt->bindValue(':id', $id, PDO::PARAM_STR);
  // $stmt->execute();
  // $info = $stmt->fetch();

  // SELECT文を変数に格納
  require('dbconnect.php');
  if (isset($_GET['company_id'])) {
    $company_id = $_GET['company_id'];
  }
  $id = $company_id;
  $sql = "SELECT
              company_posting_information.company_id AS company_id,
              company_posting_information.name AS company_name,
              company.mail_contact AS mail_contact
              FROM company_posting_information
              INNER JOIN company
              ON  company_posting_information.company_id = company.id
              WHERE company_posting_information.id = :id ";
  $stmt = $db->prepare($sql); 
  $stmt->bindValue(':id', $id, PDO::PARAM_STR);
  $stmt->execute();
  $contact_mail_info = $stmt->fetch();
  // $contact_mail_info = array();
  // while($contact_mail_info_raw = $stmt->fetch()) {
  // $contact_mail_info[]=array(
  // 'company_id' =>$contact_mail_info_raw['company_id'],
  // 'company_name' =>$contact_mail_info_raw['company_name'],
  // 'mail_contact' =>$contact_mail_info_raw['mail_contact']
  // );
  // }
  echo "<pre>";
  echo print_r($contact_mail_info);
  echo "</pre>";
  
  
  //メール本文の用意
  $honbun_agent = '';
  $honbun_agent .= "いつもboozer社craftをご利用いただきありがとうございます。\n\n";
  $honbun_agent .= "当サイトより学生ユーザーから貴社へのお問い合わせがあったので通知メールを送信いたしました。" . "\n";
  $honbun_agent .= "管理ページの申し込み一覧ページよりご確認ください。" . "\n\n";
  /* 
  変数用意
   mail_to_agent($宛先):	送信先のメールアドレス 各アドレスをカンマで区切ると、複数の宛先をtoに指定できる。このパラメータは、自動的にはエンコードされない。
   mail_subject_agent($件名):	メールの件名
   mail_body_agent($本文):  メールの本文
   mail_header_agent($ヘッダー):	ヘッダー
      from:  送信元として表示されるメールアドレス
      Return-Path:  fromと同じメアド
      以下headerの文字化け防止
        ・MIME-Version
        ・Content-Transfer-Encoding
        ・Content-Type
  */
  $mail_to_agent  = $contact_mail_info['mail_contact'];
  $mail_subject_agent  = "craft: 貴社への学生情報追加の通知について";
  $mail_body_agent  = $honbun_agent . "\n\n";
  $mail_header_agent = "from: ayaka1712pome@gmail.com\r\n"
    . "Return-Path: ayaka1712pome@gmail.com\r\n"
    . "MIME-Version: 1.0\r\n"
    . "Content-Transfer-Encoding: BASE64\r\n"
    . "Content-Type: text/plain; charset=UTF-8\r\n";

  //メール送信処理
  $mailsousin_agent  = mb_send_mail($mail_to_agent, $mail_subject_agent, $mail_body_agent, $mail_header_agent);

  //メール送信結果
  if ($mailsousin_agent == true) {
    echo '<p>エージェントへ通知メールを送信しました。</p>';
  } else {
    echo '<p>メール送信でエラーが発生しました。</p>';
  }


  $_SESSION = array();
  $mode = 'send';
} else {
  // 送信後は値をクリアにする（保持しない）
  $_SESSION['fullname'] = "";
  $_SESSION['university'] = "";
  $_SESSION['department'] = "";
  $_SESSION['grad_year'] = "";
  $_SESSION['mail']    = "";
  $_SESSION['tel'] = "";
  $_SESSION['address'] = "";
  $_SESSION['message']  = "";
}



// 問い合わせ会社を表示させるためのSQL用意

require('dbconnect.php');
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
  <!-- 会社情報 -->
  <h2>お問い合わせ会社</h2>
  <?= htmlspecialchars($info['industries']) ?>

  <!-- フォーム -->
  <h1>お問い合わせフォーム</h1>

  <?php if ($mode == 'input') { ?>
    <!-- エラーメッセージの表示 -->
    <?php if ($errormessage) { ?>
      <ul>
        <!-- $errorは連想配列なのでforeachで分解していく -->
        <?php foreach ($errormessage as $value) { ?>
          <li><?php echo $value; ?></li>
        <?php } ?>
        <!-- 分解したエラー文をlistの中に表示していく -->
      </ul>
    <?php } ?>

    <!-- 入力画面のフロント -->
    <form action="./contact/contactform.php" method="post">
      <div>
        <p>名前</p>
        <input type="text" class="required maxlength form-control" data-maxlength="30" id="name" name="name" 
      placeholder="氏名" data-error-required="お名前は必須です。" 
      value="<?php echo h($name); ?>">
      </div>
      <div>
        <p>大学</p>
        <!-- <input type="text" name="university" value="<?php echo $_SESSION['university'] ?>"> -->
        <input type="text" class="required maxlength form-control" data-maxlength="30" id="university" name="university" 
      placeholder="大学名" data-error-required="大学名は必須です。" 
      value="<?php echo h($university); ?>">
      </div>
      </div>
      <div>
        <p>学部学科</p>
        <!-- <input type="text" name="department" value="<?php echo $_SESSION['department'] ?>"> -->
        <input type="text" class="required maxlength form-control" data-maxlength="30" id="department" name="department" 
      placeholder="学部学科" data-error-required="学部学科は必須です。" 
      value="<?php echo h($department); ?>">
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
      data-error-pattern="Email の形式が正しくないようですのでご確認ください" value="<?php echo h($email); ?>">
      </div>
      <div>
        <p>お電話番号</p>
        <!-- <input type="tel" name="tel" value="<?php echo $_SESSION['tel'] ?>"> -->
        <input type="tel" class="pattern form-control" data-pattern="tel" id="tel" name="tel"
       placeholder="お電話番号" data-error-pattern="電話番号の形式が正しくないようですのでご確認ください"  value="<?php echo h($tel); ?>">
      </div>
      <div>
        <p>住所</p>
        <!-- <input type="text" name="address" value="<?php echo $_SESSION['address'] ?>"> -->
        <input type="text" class="pattern form-control" data-pattern="address" id="address" name="address"
       placeholder="お電話番号" data-error-pattern="電話番号の形式が正しくないようですのでご確認ください"  value="<?php echo h($address); ?>">
      </div>
      <div>
        <p>その他</p>
        <!-- <textarea cols="40" rows="8" name="message"><?php echo $_SESSION['message'] ?></textarea><br> -->
        <textarea cols="40" rows="8" class="required maxlength showCount form-control" data-maxlength="1000" id="message" name="message" rows="3"><?php echo h($message); ?></textarea>
      </div>

      <!-- <input type="submit" name="confirm" value="確認" /> -->
      <button name="submitted" type="submit" class="btn btn-primary">確認画面へ</button>
    </form>


    <!-- 確認画面のフロント -->
  <?php } else if ($mode == 'confirm') { ?>
    <!-- <?php var_dump($_POST['grad_year']); ?> -->
    <form action="./contact/contactform.php" method="post">
      <div>
        <p>名前</p>
        <p><?php echo $_SESSION['fullname'] ?></p>
      </div>
      <div>
        <p>大学</p>
        <p><?php echo $_SESSION['university'] ?></p>
      </div>
      <div>
        <p>学部学科</p>
        <p><?php echo $_SESSION['department'] ?></p>
      </div>
      <div>
        <p>卒業年</p>
        <p><?php echo $_SESSION['grad_year'] ?></p>
      </div>
      <div>
        <p>メールアドレス</p>
        <p><?php echo $_SESSION['mail'] ?></p>
      </div>
      <div>
        <p>電話番号</p>
        <p><?php echo $_SESSION['tel'] ?></p>
      </div>
      <div>
        <p>住所</p>
        <p><?php echo $_SESSION['address'] ?></p>
      </div>
      <div>
        <p>その他</p>
        <p><?php echo nl2br($_SESSION['message']) ?></p>
      </div>
      <input type="submit" name="back" value="戻る" />
      <input type="submit" name="send" value="送信" />
    </form>

    <!-- 完了画面 -->
  <?php } else { ?>
    <!-- 送信しました。お問い合わせありがとうございました。<br> -->
    <?php require_once('thanks.php') ?>

  <?php } ?>

  <div class="container">
  <!-- 会社情報 -->
  <h2>お問い合わせ会社</h2>
  <?= htmlspecialchars($info['industries']) ?>

  <!-- フォーム -->
  <h1>お問い合わせフォーム</h1>
  <p>以下のフォームからお問い合わせください。</p>
  
  <!-- <form id="form" class="validationForm" method="post" action="confirm.php" novalidate>
    <div class="form-group">
      <label for="name">お名前（必須） 
        <span class="error-php"><?php echo h( $error_name ); ?></span>
      </label>
      <input type="text" class="required maxlength form-control" data-maxlength="30" id="name" name="name" 
      placeholder="氏名" data-error-required="お名前は必須です。" 
      value="<?php echo h($name); ?>">
    </div>
    <div class="form-group">
      <label for="email">Email（必須） 
        <span class="error-php"><?php echo h( $error_email ); ?></span>
      </label>
      <input type="email" class="required pattern form-control" data-pattern="email" id="email" name="email" 
      placeholder="Email アドレス" data-error-required="Email アドレスは必須です。"  
      data-error-pattern="Email の形式が正しくないようですのでご確認ください" value="<?php echo h($email); ?>">
    </div>
    <!-- <div class="form-group">
      <label for="email_check">Email（確認用 必須） 
        <span class="error-php"><?php echo h( $error_email_check ); ?></span>
      </label>
      <input type="email" class="form-control equal-to required" data-equal-to="email" data-error-equal-to="メールアドレスが異なります" id="email_check" name="email_check" placeholder="Email アドレス（確認用 必須）" value="<?php echo h($email_check); ?>">
     </div> --
    <div class="form-group">
      <label for="tel">お電話番号（半角英数字） 
        <span class="error-php"><?php echo h( $error_tel ); ?></span>
      </label>
      <input type="tel" class="pattern form-control" data-pattern="tel" id="tel" name="tel"
       placeholder="お電話番号" data-error-pattern="電話番号の形式が正しくないようですのでご確認ください"  value="<?php echo h($tel); ?>">
    </div>
    <div class="form-group">
      <label for="subject">件名（必須） 
        <span class="error-php"><?php echo h( $error_subject ); ?></span> 
      </label>
      <input type="text" class="required maxlength form-control" data-maxlength="100" id="subject" name="subject" placeholder="件名" value="<?php echo h($subject); ?>">
    </div>
    <div class="form-group">
      <label for="body">お問い合わせ内容（必須） 
        <span class="error-php"><?php echo h( $error_body ); ?></span>
      </label>
      <textarea class="required maxlength showCount form-control" data-maxlength="1000" id="body" name="body" placeholder="お問い合わせ内容（1000文字まで）をお書きください" rows="3"><?php echo h($body); ?></textarea>
    </div>


    <!--確認ページへトークンをPOSTする、隠しフィールド「ticket」--
    <input type="hidden" name="ticket" value="<?php echo h($ticket); ?>">
    <button name="submitted" type="submit" class="btn btn-primary">確認画面へ</button>
  </form> -->
  <form id="form" class="validationForm" action="./confirm.php" method="post" novalidate>
      <div>
        <p>名前</p>
        <input type="text" class="required maxlength form-control" data-maxlength="30" id="name" name="name" 
      placeholder="氏名" data-error-required="お名前は必須です。" 
      value="<?php echo h($name); ?>">
      </div>
      <div>
        <p>大学</p>
        <!-- <input type="text" name="university" value="<?php echo $_SESSION['university'] ?>"> -->
        <input type="text" class="required maxlength form-control" data-maxlength="30" id="university" name="university" 
      placeholder="大学名" data-error-required="大学名は必須です。" 
      value="<?php echo h($university); ?>">
      </div>
      </div>
      <div>
        <p>学部学科</p>
        <!-- <input type="text" name="department" value="<?php echo $_SESSION['department'] ?>"> -->
        <input type="text" class="required maxlength form-control" data-maxlength="30" id="department" name="department" 
      placeholder="学部学科" data-error-required="学部学科は必須です。" 
      value="<?php echo h($department); ?>">
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
        <input type="email" class="required pattern form-control" data-pattern="email" id="email" name="mail" 
      placeholder="Email アドレス" data-error-required="Email アドレスは必須です。"  
      data-error-pattern="Email の形式が正しくないようですのでご確認ください" value="<?php echo h($mail); ?>">
      </div>
      <div>
        <p>お電話番号</p>
        <!-- <input type="tel" name="tel" value="<?php echo $_SESSION['tel'] ?>"> -->
        <input type="tel" class="pattern form-control" data-pattern="tel" id="tel" name="tel"
       placeholder="お電話番号" data-error-pattern="電話番号の形式が正しくないようですのでご確認ください"  value="<?php echo h($tel); ?>">
      </div>
      <div>
        <p>住所</p>
        <!-- <input type="text" name="address" value="<?php echo $_SESSION['address'] ?>"> -->
        <input type="text" class="pattern form-control" data-pattern="address" id="address" name="address"
       placeholder="お電話番号" data-error-pattern="電話番号の形式が正しくないようですのでご確認ください"  value="<?php echo h($address); ?>">
      </div>
      <div>
        <p>その他</p>
        <!-- <textarea cols="40" rows="8" name="message"><?php echo $_SESSION['message'] ?></textarea><br> -->
        <textarea cols="40" rows="8" class="required maxlength showCount form-control" data-maxlength="1000" id="message" name="message" rows="3"><?php echo h($message); ?></textarea>
      </div>

      <!--確認ページへトークンをPOSTする、隠しフィールド「ticket」-->
      <input type="hidden" name="ticket" value="<?php echo h($ticket); ?>">
      <!-- <input type="submit" name="confirm" value="確認" /> -->
      <button name="submitted" type="submit" class="btn btn-primary">確認画面へ</button>
    </form>
</div>
<!-- 検証用 JavaScript の読み込み -->
<script src="./formValidation.js"></script> 

  <!-- フッター関数↓ -->
</body>


</html>