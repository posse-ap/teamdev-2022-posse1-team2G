<?php
session_start(); 
require('../../dbconnect.php');
//エスケープ処理やデータをチェックする関数を記述したファイルの読み込み
require '../../libs/functions.php'; 
 
if (isset($_SESSION['id']) && $_SESSION['time'] + 10 > time()) {
  $_SESSION['time'] = time();
  // user_idがない、もしくは一定時間を過ぎていた場合
  $id = $_SESSION['id'];
  // echo $id;
  // $sql = "SELECT rep FROM company_user";
  $sql = "SELECT company_name, mail_contact from company where id='$id';";
  $stmt = $db->prepare($sql);
  $stmt->execute();
  $company_name_arr = $stmt->fetchAll();
} else {
  header('Location: http://' . $_SERVER['HTTP_HOST'] . '/admin/login.php');
  exit();
}
echo $company_name_arr[0]["company_name"]; //鈴木会社
echo $company_name_arr[0]["mail_contact"]; //
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
 
//変数にエスケープ処理したセッション変数の値を代入
$purpose = h( $_SESSION[ 'purpose' ] );
$message = h( $_SESSION[ 'message' ] );
// $company_name_session = $_SESSION[ 'company_name' ];
  // echo "<pre>";
  // print_r($company_name_session);
  // echo"</pre>";

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



// //メール送信の結果判定
// if ( $result && $result_agent) {
//   //成功した場合はセッションを破棄
//   $_SESSION = array(); //空の配列を代入し、すべてのセッション変数を消去 
//   session_destroy(); //セッションを破棄
// } else {
//   //送信失敗時（もしあれば）
// }
?>
<!-- ここまでPHP -->


<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>申請フォーム完了画面</title>
  <!-- ↓この_header.phpから見たparts.cssの位置ではなく、このphpファイルが読み込まれるファイルから見た位置を指定してあげる必要がある -->
  <link rel="stylesheet" href="../parts.css">
  <link rel="stylesheet" href="../admin_index.css">
  <link rel="stylesheet" href="../admin_style.css">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
  <!-- icon用 -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css">

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
        <li class="nav_item"><a href="./user_list.php">申し込み一覧</a></li>
        <li class="nav_item"><a href="./information_posting.php">登録情報</a></li>
        <li class="nav_item"><a href="./contact_form.php">申請</a></li>
      </ul>
    </nav>
  </header>
  <main>
    <section id="contact">
      <!-- ページメイン -->
      <div class="contact_wrapper">
        <p>contact</p>
        <h2>お問い合わせフォーム</h2>
        <?php if ( $result ): ?>
        <h1>お問い合わせ完了</h1>
        <p>お問い合わせいただきありがとうございます。</p>
        <p>boozer社より担当者が折り返しご連絡させていただきますので</p>
        <p>今しばらくお待ちください。</p>
        <p>万が一連絡がこない場合は、お手数をおかけしますが下記のメールアドレスまでご連絡ください。</p>
        <p><?php echo h($email); ?></p>
        <?php else: ?>
        <p>申し訳ございませんが、送信に失敗しました。</p>
        <p>しばらくしてもう一度お試しになるか、メールにてご連絡ください。</p>
        <p>ご迷惑をおかけして誠に申し訳ございません。</p>
        <?php endif; ?>
      </div>
      
      <!-- 戻るボタン -->
      <a href="./user_list.php">申し込み一覧はこちら</a>
    </section>
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

</body>