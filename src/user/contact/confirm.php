<?php
//セッションを開始
session_start();

//エスケープ処理やデータチェックを行う関数のファイルの読み込み
require '../../libs/functions.php';

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
//POSTされたデータを変数に格納（値の初期化とデータの整形：前後にあるホワイトスペースを削除）
$name = trim( filter_input(INPUT_POST, 'name') );
$university  = trim( filter_input(INPUT_POST, 'university') );
$department = trim( filter_input(INPUT_POST, 'department') );
$grad_year = trim( (string) filter_input(INPUT_POST, 'grad_year') );
$email = trim( (string) filter_input(INPUT_POST, 'email') );
$phone_number = trim( filter_input(INPUT_POST, 'phone_number') );
$address = trim( filter_input(INPUT_POST, 'address') );
$message = trim( filter_input(INPUT_POST, 'message')); 
$company_id_session = (array)$_POST['company_id_session'];
$_SESSION[ 'company_id' ] = $company_id_session;

// echo "<pre>";
// print_r($company_id_session);
// echo"</pre>";



//エラーメッセージを保存する配列の初期化
$error = array();
//値の検証（入力内容が条件を満たさない場合はエラーメッセージを配列 $error に設定）
if ( $name === '' ) {
  $error[ 'name' ] = '*お名前は必須項目です。';
  //制御文字でないことと文字数をチェック
} else if ( preg_match( '/\A[[:^cntrl:]]{1,30}\z/u', $name ) === 0 ) {
  $error[ 'name' ] = '*お名前は30文字以内でお願いします。';
}
if ( $university === '' ) {
  $error[ 'university' ] = '*大学名は必須です。';
  //制御文字でないことと文字数をチェック
} else if ( preg_match( '/\A[[:^cntrl:]]{1,30}\z/u', $university ) === 0 ) {
  $error[ 'university' ] = '*大学名は30文字以内でお願いします。';
}
if ( $department === '' ) {
  $error[ 'department' ] = '*学部学科は必須です。';
  //制御文字でないことと文字数をチェック
} else if ( preg_match( '/\A[[:^cntrl:]]{1,30}\z/u', $department ) === 0 ) {
  $error[ 'department' ] = '*学部学科は30文字以内でお願いします。';
}
if ( $grad_year === '' ) {
  $error[ 'grad_year' ] = '*卒業年は必須です。';
} 
if ( $email === '' ) {
  $error[ 'email' ] = '*メールアドレスは必須です。';
} else { //メールアドレスを正規表現でチェック
  $pattern = '/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/uiD';
  if ( !preg_match( $pattern, $email ) ) {
    $error[ 'email' ] = '*メールアドレスの形式が正しくありません。';
  }
}
if ( $phone_number != '' && preg_match( '/\A\(?\d{2,5}\)?[-(\.\s]{0,2}\d{1,4}[-)\.\s]{0,2}\d{3,4}\z/u', $phone_number ) === 0 ) {
  $error[ 'phone_number' ] = '*電話番号の形式が正しくありません。';
}
if ( $address === '' ) {
  $error[ 'address' ] = '*住所は必須です。';
  //制御文字でないことと文字数をチェック
} else if ( preg_match( '/\A[[:^cntrl:]]{1,100}\z/u', $address ) === 0 ) {
  $error[ 'address' ] = '*住所は100文字以内でお願いします。';
}

//POSTされたデータとエラーの配列をセッション変数に保存
$_SESSION[ 'name' ] = $name;
$_SESSION[ 'university' ] = $university;
$_SESSION[ 'department' ] = $department;
$_SESSION[ 'grad_year' ] = $grad_year;
$_SESSION[ 'email' ] = $email;
$_SESSION[ 'phone_number' ] = $phone_number;
$_SESSION[ 'address' ] = $address;
$_SESSION[ 'message' ] = $message;
$_SESSION[ 'error' ] = $error;

//チェックの結果にエラーがある場合は入力フォームに戻す
if ( count( $error ) > 0 ) {
  //エラーがある場合
  $dirname = dirname( $_SERVER[ 'SCRIPT_NAME' ] );
  $dirname = $dirname === DIRECTORY_SEPARATOR ? '' : $dirname;
  //サーバー変数 $_SERVER['HTTPS'] が取得出来ない環境用（オプション）
  if(isset($_SERVER['HTTP_X_FORWARDED_PROTO']) and $_SERVER['HTTP_X_FORWARDED_PROTO'] === "https") {
    $_SERVER[ 'HTTPS' ] = 'on';
  }

  //入力画面（contact.php）の URL
  $url = 'https://'. $_SERVER[ 'SERVER_NAME' ] . $dirname . '/contact.php';
  exit;
}


// 問い合わせ会社を表示させるためのSQL用意
require('../dbconnect.php');

// キーワードの数だけループして、LIKE句の配列を作る
$company_id_Condition = [];
foreach ($company_id_session as $company_id) {
  $company_id_Condition[] = 'company_id = ' . $company_id;
}

// これをORでつなげて、文字列にする
$company_id_Condition = implode(' OR ', $company_id_Condition);

// あとはSELECT文にくっつける
$sql = 'SELECT * FROM company_posting_information WHERE ' . $company_id_Condition;
$stmt = $db->query($sql);
$stmt->execute();
$companies = $stmt->fetchAll();
?>


<!-- ここからフロント側 -->
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>お問い合わせフォーム（確認）</title>
  <link rel="stylesheet" href="../../css/parts.css">
  <link rel="stylesheet" href="../../css/contact.css">
</head>
<body>
  <!-- ↑ヘッダー関数 -->

  <div class="confirm_container">
    <div class="confirm_title">
      <h1>お問い合わせ確認画面</h1>
    </div>
    
    <div class="contactform_each_container contactform_topic">
      <p>お問い合わせする会社</p>
    </div>
    <div class="contactform_contact_company">
      <div class="confirm_company_question">
        <p>会社名</p>
      </div>
      <div class="contactform_contact_company_name">
        <p>
          <?php foreach ($companies as $company) : ?>
             <?= h($company['name']) ?>
          <?php endforeach; ?>
        </p>
      </div>
    </div>
    <div class="confirm_chunk">
      <!-- <div class="confirm_chunk_title">
        <p>お問い合わせ内容</p>
      </div> -->
      <div class="contactform_each_container contactform_topic topic_info">
        <p>お客様情報</p>
      </div>
      <div class="confirm_each_container top_container">
        <div class="confirm_question">
          <p>お名前</p>
        </div>
        <div class="confirm_required">
          <p>必須</p>
        </div>
        <div class="confirm_answer">
          <p><?php echo h($name); ?></p>
        </div>
      </div>
      <div class="confirm_each_container">
        <div class="confirm_question">
          <p>大学</p>
        </div>
        <div class="confirm_required">
          <p>必須</p>
        </div>
        <div class="confirm_answer">
          <p><?php echo h($university); ?></p>
        </div>
      </div>
      <div class="confirm_each_container">
        <div class="confirm_question">
          <p>学部学科</p>
        </div>
        <div class="confirm_required">
          <p>必須</p>
        </div>
        <div class="confirm_answer">
          <p><?php echo h($department); ?></p>
        </div>
      </div>
      <div class="confirm_each_container">
        <div class="confirm_question">
          <p>卒業年</p>
        </div>
        <div class="confirm_required">
          <p>必須</p>
        </div>
        <div class="confirm_answer">
          <p><?php echo h($grad_year); ?></p>
        </div>
      </div>
      <div class="confirm_each_container">
        <div class="confirm_question">
          <p>メールアドレス</p>
        </div>
        <div class="confirm_required">
          <p>必須</p>
        </div>
        <div class="confirm_answer">
          <p><?php echo h($email); ?></p>
        </div>
      </div>
      <div class="confirm_each_container">
        <div class="confirm_question">
          <p>お電話番号</p>
        </div>
        <div class="confirm_required">
          <p>必須</p>
        </div>
        <div class="confirm_answer">
          <p><?php echo h($phone_number); ?></p>
        </div>
      </div>
      <div class="confirm_each_container">
        <div class="confirm_question">
          <p>住所</p>
        </div>
        <div class="confirm_required">
          <p>必須</p>
        </div>
        <div class="confirm_answer">
          <p><?php echo h($address); ?></p>
        </div>
      </div>
      <div class="confirm_each_container">
        <div class="confirm_question">
          <p>その他</p>
        </div>
        <div class="confirm_not_required">
          <p>任意</p>
        </div>
        <div class="confirm_answer">
          <p><?php echo nl2br(h($message)); ?></p>
        </div>
      </div>
    </div>

    <section class="btn_position">
       <form action="./contactform.php?company_id=<?= h($company_id);?>" method="post" class="confirm">
         <div class="return_position">
           <button type="submit" class="return">戻る</button>
         </div>
       </form>
       <form action="./thanks.php?company_id=<?= h($company_id);?>" method="post" class="confirm">
         <!-- 完了ページへ渡すトークンの隠しフィールド -->
         <input type="hidden" name="ticket" value="<?php echo h($ticket); ?>">
         <div class="contactform_submit">
           <input name="submitted" type="submit" value="送信">
         </div>
         <!-- <button type="submit" class="btn btn-success">送信</button> -->
       </form>
    </section>
  </div>
</body>

</html>

