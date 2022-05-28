<?php
session_start(); 
require('../../dbconnect.php');
//エスケープ処理やデータをチェックする関数を記述したファイルの読み込み
require '../../libs/functions.php'; 
 
if (isset($_SESSION['id']) && $_SESSION['time'] + 10 > time()) {
  $_SESSION['time'] = time();
  // user_idがない、もしくは一定時間を過ぎていた場合
  $id = $_SESSION['id'];
  $sql = "SELECT company_name, mail_contact from company where id='$id';";
  $stmt = $db->prepare($sql);
  $stmt->execute();
  $company_name_arr = $stmt->fetchAll();
} else {
  header('Location: http://' . $_SERVER['HTTP_HOST'] . '/admin/login.php');
  exit();
}
$company_name = $company_name_arr[0]["company_name"];
$company_mail = $company_name_arr[0]["mail_contact"];

//お問い合わせ日時を日本時間に
date_default_timezone_set('Asia/Tokyo'); 
 
//POSTされたデータをチェック
$_POST = checkInput( $_POST );
 
//固定トークンを確認（CSRF対策）
if ( isset( $_POST[ 'ticket' ], $_SESSION[ 'ticket' ] ) ) {
  $ticket = $_POST[ 'ticket' ];
  if ( $ticket !== $_SESSION[ 'ticket' ] ) {
    //トークンが一致しない場合は処理を中止
    die( 'Access denied' );
  }
} else {
  //トークンが存在しない場合（入力ページにリダイレクト）
  //die( 'Access Denied（直接このページにはアクセスできません）' ); //処理を中止する場合
  $dirname = dirname( $_SERVER[ 'SCRIPT_NAME' ] );
  $dirname = $dirname === DIRECTORY_SEPARATOR ? '' : $dirname;
  //サーバー変数 $_SERVER['HTTPS'] が取得出来ない環境用（オプション）
  if(isset($_SERVER['HTTP_X_FORWARDED_PROTO']) and $_SERVER['HTTP_X_FORWARDED_PROTO'] === "https") {
    $_SERVER[ 'HTTPS' ] = 'on';
  }
  $url = ( empty( $_SERVER[ 'HTTPS' ] ) ? 'http://' : 'https://' ) . $_SERVER[ 'SERVER_NAME' ] . $dirname . '/contact.php';
  header( 'HTTP/1.1 303 See Other' );
  header( 'location: ' . $url );
  exit; //忘れないように
}

//POSTされたデータを変数に格納（値の初期化とデータの整形：前後にあるホワイトスペースを削除）
$purpose = trim( (string) filter_input(INPUT_POST, 'purpose') );
$message = trim( filter_input(INPUT_POST, 'message')); 
//POSTされたデータとエラーの配列をセッション変数に保存
$_SESSION[ 'purpose' ] = $purpose;
$_SESSION[ 'message' ] = $message;
 
//変数にエスケープ処理したセッション変数の値を代入
$purpose = h( $_SESSION[ 'purpose' ] );
$message = h( $_SESSION[ 'message' ] );

/* メールの作成 （to 小笹さん）*/
//メール本文の組み立て
$honbun = '';
$honbun .= "申請フォームよりお問い合わせがありました。\n\n";
$honbun .= "【企業名】\n";
$honbun .= $company_name . "\n\n";
$honbun .= "【企業様のメールアドレス】\n";
$honbun .= $company_mail . "\n\n";
$honbun .= "【お問い合わせ目的】\n";
$honbun .= $purpose . "\n\n";
$honbun .= "【お問い合わせ内容】\n";
$honbun .= $message . "\n\n";
  
//-------- sendmail（mb_send_mail）を使ったメールの送信処理------------
/* 
 mail_to($宛先):	送信先のメールアドレス 
 returnMail:  Return-Pathに指定するメールアドレス
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
// 下記のemail変数に小笹さんのコンタクトメールをお書きください
$email = 'ozasasan@gmail.com';
$mail_to  = $email;
$returnMail  = $email;
$mail_subject  = "エージェント会社から申請フォームが送られました";
$mail_body  = $honbun . "\n\n";
$mail_header = "from: testmail@gmail.com\r\n"
             . "Return-Path: testmail@gmail.com\r\n"
             . "MIME-Version: 1.0\r\n"
             . "Content-Transfer-Encoding: BASE64\r\n"
             . "Content-Type: text/plain; charset=UTF-8\r\n";

//メール送信処理
$mailsousin  = mb_send_mail($mail_to, $mail_subject, $mail_body, $mail_header);
$result = $mailsousin;

?>



<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>申請フォーム完了画面</title>
  <link rel="stylesheet" href="../parts.css">
  <link rel="stylesheet" href="../admin_index.css">
  <link rel="stylesheet" href="../admin_style.css">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
  <!-- icon用 -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css">
</head>
<!-- header関数読み込み -->
<?php
include('./_parts_agent/_header_agent.php');  
?>

  <div class="container">
    <section id="contact">
      <!-- ページメイン -->
      <div class="contact_wrapper form_card">
        <p class="sub_subtitle">contact</p>
        <h1>お問い合わせフォーム</h1>
        <div class="contents">
           <?php if ( $result ): ?>
              <p class="result">お問い合わせ完了</p>
              <p>お問い合わせいただきありがとうございます。</p>
              <p>boozer社より担当者が折り返しご連絡させていただきますので</p>
              <p>今しばらくお待ちください。</p>
              <p>万が一連絡がこない場合は、お手数をおかけしますが下記のメールアドレスまでご連絡ください。</p>
              <p class="mail"><?php echo h($email); ?></p>
           <?php else: ?>
              <p class="result">申し訳ございませんが、送信に失敗しました。</p>
              <p>しばらくしてもう一度お試しになるか、下記のメールにてご連絡ください。</p>
              <p>ご迷惑をおかけして誠に申し訳ございません。</p>
              <p class="mail"><?php echo h($email); ?></p>
           <?php endif; ?>
        </div>
      </div>
      
    </section>
    </div>
    </main>


<!-- ↓footer関数の読み込み -->
<?php
include('../_footer.php');  
?>
</body>