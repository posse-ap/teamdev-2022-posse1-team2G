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
$grad_year = trim( filter_input(INPUT_POST, 'grad_year') );
$email = trim( filter_input(INPUT_POST, 'email') );
$tel = trim( filter_input(INPUT_POST, 'tel') );
$address = trim( filter_input(INPUT_POST, 'address') );
// $message = trim( filter_input(INPUT_POST, 'subject'));//任意なのでエラー表示しない

//エラーメッセージを保存する配列の初期化
$error = array();
//値の検証（入力内容が条件を満たさない場合はエラーメッセージを配列 $error に設定）
if ( $name == '' ) {
  $error[ 'name' ] = '*お名前は必須項目です。';
  //制御文字でないことと文字数をチェック
} else if ( preg_match( '/\A[[:^cntrl:]]{1,30}\z/u', $name ) == 0 ) {
  $error[ 'name' ] = '*お名前は30文字以内でお願いします。';
}
if ( $university == '' ) {
  $error[ 'university' ] = '*大学名は必須です。';
  //制御文字でないことと文字数をチェック
} else if ( preg_match( '/\A[[:^cntrl:]]{1,30}\z/u', $university ) == 0 ) {
  $error[ 'university' ] = '*大学名は30文字以内でお願いします。';
}
if ( $department == '' ) {
  $error[ 'department' ] = '*学部学科は必須です。';
  //制御文字でないことと文字数をチェック
} else if ( preg_match( '/\A[[:^cntrl:]]{1,30}\z/u', $department ) == 0 ) {
  $error[ 'department' ] = '*学部学科は30文字以内でお願いします。';
}
if ( $grad_year == '' ) {
  $error[ 'grad_year' ] = '*卒業年は必須です。';
} 
if ( $email == '' ) {
  $error[ 'email' ] = '*メールアドレスは必須です。';
} else { //メールアドレスを正規表現でチェック
  $pattern = '/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/uiD';
  if ( !preg_match( $pattern, $email ) ) {
    $error[ 'email' ] = '*メールアドレスの形式が正しくありません。';
  }
}
if ( $tel != '' && preg_match( '/\A\(?\d{2,5}\)?[-(\.\s]{0,2}\d{1,4}[-)\.\s]{0,2}\d{3,4}\z/u', $tel ) == 0 ) {
  $error[ 'tel' ] = '*電話番号の形式が正しくありません。';
}
if ( $address == '' ) {
  $error[ 'address' ] = '*住所は必須です。';
  //制御文字でないことと文字数をチェック
} else if ( preg_match( '/\A[[:^cntrl:]]{1,100}\z/u', $address ) == 0 ) {
  $error[ 'address' ] = '*住所は100文字以内でお願いします。';
}

//POSTされたデータとエラーの配列をセッション変数に保存
$_SESSION[ 'name' ] = $name;
$_SESSION[ 'university' ] = $university;
$_SESSION[ 'department' ] = $department;
$_SESSION[ 'grad_year' ] = $grad_year;
$_SESSION[ 'email' ] = $email;
$_SESSION[ 'tel' ] = $tel;
$_SESSION[ 'address' ] = $address;
$_SESSION[ 'message' ] = $message;
$_SESSION[ 'error' ] = $error;
//チェックの結果にエラーがある場合は入力フォームに戻す
if ( count( $error ) > 0 ) {
  //エラーがある場合
  $dirname = dirname( $_SERVER[ 'SCRIPT_NAME' ] );
  $dirname = $dirname == DIRECTORY_SEPARATOR ? '' : $dirname;
  //サーバー変数 $_SERVER['HTTPS'] が取得出来ない環境用（オプション）
  if(isset($_SERVER['HTTP_X_FORWARDED_PROTO']) and $_SERVER['HTTP_X_FORWARDED_PROTO'] === "https") {
    $_SERVER[ 'HTTPS' ] = 'on';
  }
  //入力画面（contact.php）の URL
  $url = ( empty( $_SERVER[ 'HTTPS' ] ) ? 'http://' : 'https://' ) . $_SERVER[ 'SERVER_NAME' ] . $dirname . '/contact.php';
  header( 'HTTP/1.1 303 See Other' );
  header( 'location: ' . $url );
  exit;
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>コンタクトフォーム（確認）</title>
<link href="../bootstrap.min.css" rel="stylesheet">
<link href="../style.css" rel="stylesheet">
</head>
</head>
<body>
<div class="container">
  <h2>お問い合わせ確認画面</h2>
  <p>以下の内容でよろしければ「送信する」をクリックしてください。<br>
    内容を変更する場合は「戻る」をクリックして入力画面にお戻りください。</p>
  <div class="table-responsive confirm_table">
    <table class="table table-bordered">
      <caption>ご入力内容</caption>
      <tr>
        <th>お名前</th>
        <td><?php echo h($name); ?></td>
      </tr>
      <tr>
        <th>Email</th>
        <td><?php echo h($email); ?></td>
      </tr>
      <tr>
        <th>お電話番号</th>
        <td><?php echo h($tel); ?></td>
      </tr>
      <tr>
        <th>件名</th>
        <td><?php echo h($subject); ?></td>
      </tr>
      <tr>
        <th>お問い合わせ内容</th>
        <td><?php echo nl2br(h($body)); ?></td>
      </tr>
    </table>
  </div>
  <form action="contact.php" method="post" class="confirm">
    <button type="submit" class="btn btn-secondary">戻る</button>
  </form>
  <form action="complete.php" method="post" class="confirm">
    <!-- 完了ページへ渡すトークンの隠しフィールド -->
    <input type="hidden" name="ticket" value="<?php echo h($ticket); ?>">
    <button type="submit" class="btn btn-success">送信する</button>
  </form>
</div>
</body>
</html>