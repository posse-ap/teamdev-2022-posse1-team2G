<?php
//セッションを開始
session_start();

//エスケープ処理やデータチェックを行う関数のファイルの読み込み
require '../libs/functions.php';

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
$privacy = trim( (string) filter_input(INPUT_POST, 'privacy') );

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
if ( $privacy === '' ) {
  $error[ 'privacy' ] = '*プライバシーポリシーの同意は必須です。';
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
$_SESSION[ 'privacy' ] = $message;
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
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>お問い合わせフォーム（確認）</title>
</head>
<body>
  <!-- ↑ヘッダー関数 -->

<div class="container">
  <h1>お問い合わせ確認画面</h1>
  <p>以下の内容でよろしければ「送信」をクリックしてください。<br>
    内容を変更する場合は「戻る」をクリックして入力画面にお戻りください。</p>
  <div class="table-responsive confirm_table">
    <!-- 会社情報 -->
    <h2>お問い合わせ会社</h2>
    <?= h($info['industries']) ?>

    <!-- フォーム内容 -->
    <table class="table table-bordered">
      <caption>ご入力内容</caption>
      <tr>
        <th>お名前</th>
        <td><?php echo h($name); ?></td>
      </tr>
      <tr>
        <th>大学</th>
        <td><?php echo h($university); ?></td>
      </tr>
      <tr>
        <th>学部学科</th>
        <td><?php echo h($department); ?></td>
      </tr>
      <tr>
        <th>卒業年</th>
        <td><?php echo h($grad_year); ?></td>
      </tr>
      <tr>
        <th>メールアドレス</th>
        <td><?php echo h($email); ?></td>
      </tr>
      <tr>
        <th>お電話番号</th>
        <td><?php echo h($phone_number); ?></td>
      </tr>
      <tr>
        <th>住所</th>
        <td><?php echo h($address); ?></td>
      </tr>
      <tr>
        <th>その他</th>
        <td><?php echo nl2br(h($message)); ?></td>
      </tr>
      <tr>
        <th>プライバシーポリシー</th>
        <td><?php echo h($privacy); ?></td>
      </tr>
    </table>
  </div>
  <form action="./contactform.php?company_id=<?= h($company_id);?>" method="post" class="confirm">
    <button type="submit" class="btn btn-secondary">戻る</button>
  </form>
  <form action="./thanks.php?company_id=<?= h($company_id);?>" method="post" class="confirm">
    <!-- 完了ページへ渡すトークンの隠しフィールド -->
    <input type="hidden" name="ticket" value="<?php echo h($ticket); ?>">
    <button type="submit" class="btn btn-success">送信</button>
  </form>
</div>
</body>
</html>