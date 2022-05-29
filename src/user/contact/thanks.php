<?php
//セッションを開始
session_start(); 

require('../dbconnect.php');
//エスケープ処理やデータをチェックする関数を記述したファイルの読み込み
require '../../libs/functions.php'; 
 
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
$name = h( $_SESSION[ 'name' ] );
$university = h( $_SESSION[ 'university' ] );
$department = h( $_SESSION[ 'department' ] );
$grad_year = h( $_SESSION[ 'grad_year' ] );
$email = h( $_SESSION[ 'email' ] ) ;
$phone_number =  h( $_SESSION[ 'phone_number' ] ) ;
$address = h( $_SESSION[ 'address' ] );
$message = h( $_SESSION[ 'message' ] );

/* メールの作成 （to 学生）*/
//メール本文の組み立て
$honbun = '';
$honbun .= "メールフォームよりお問い合わせがありました。\n\n";
$honbun .= "【お名前】\n";
$honbun .= $name . "\n\n";
$honbun .= "【メールアドレス】\n";
$honbun .= $email . "\n\n";
$honbun .= "【お問い合わせ内容】\n";
$honbun .= "申し込みいただきありがとうございます。" . "\n";
$honbun .= "担当の者から連絡致しますので少々お待ちください。" . "\n\n";

  
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
$mail_to  = $email;
$returnMail  = $email;
$mail_subject  = "craftのご利用";
$mail_body  = $honbun . "\n\n";
$mail_header = "from: ayaka1712pome@gmail.com\r\n"
             . "Return-Path: ayaka1712pome@gmail.com\r\n"
             . "MIME-Version: 1.0\r\n"
             . "Content-Transfer-Encoding: BASE64\r\n"
             . "Content-Type: text/plain; charset=UTF-8\r\n";

//メール送信処理
$mailsousin  = mb_send_mail($mail_to, $mail_subject, $mail_body, $mail_header);

$result_user = $mailsousin;
 
// //メールの送信（結果を変数 $result に代入）
// if ( ini_get( 'safe_mode' ) ) {
//   //セーフモードがOnの場合は第5引数が使えない
//   $result_user = $mailsousin;
//   echo 1;
// } else {
//   $result_user = mb_send_mail($mail_to, $mail_subject, $mail_body, $mail_header, '-f' . $returnMail );
//   echo 2;
// }


/* メールの作成 （to エージェント）*/
// SELECT文を変数に格納
  $company_id_session = $_SESSION[ 'company_id' ];
  // echo "<pre>";
  // print_r($company_id_session);
  // echo"</pre>";

  // キーワードの数だけループして、LIKE句の配列を作る
  $company_id_Condition = [];
  foreach ($company_id_session as $company_id) {
    $id = $company_id;
    $sql = "SELECT
                company_posting_information.company_id AS company_id,
                company_posting_information.name AS company_name,
                company.mail_notification AS mail_notification
                FROM company_posting_information
                INNER JOIN company
                ON  company_posting_information.company_id = company.id
                WHERE company_posting_information.id = :id ";
    $stmt = $db->prepare($sql); 
    $stmt->bindValue(':id', $id, PDO::PARAM_STR);
    $stmt->execute();
    $contact_mail_info = $stmt->fetch();
      
    // echo "<pre>";
    // print_r($contact_mail_info);
    // echo"</pre>";
  
  //メール本文の用意
  $honbun_agent = '';
  $honbun_agent .= "いつもboozer社craftをご利用いただきありがとうございます。\n\n";
  $honbun_agent .= "当サイトより学生ユーザーから貴社へのお問い合わせがあったので通知メールを送信いたしました。" . "\n";
  $honbun_agent .= "管理ページの申し込み一覧ページよりご確認ください。" . "\n\n";
  
    
  //-------- sendmail（mb_send_mail）を使ったメールの送信処理------------
  /* 
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
  $mail_to_agent  = $contact_mail_info['mail_notification'];
  $returnMail  = $contact_mail_info['mail_notification'];
  $mail_subject_agent  = "craft: 貴社への学生情報追加の通知について";
  $mail_body_agent  = $honbun_agent . "\n\n";
  $mail_header_agent = "from: ayaka1712pome@gmail.com\r\n"
    . "Return-Path: ayaka1712pome@gmail.com\r\n"
    . "MIME-Version: 1.0\r\n"
    . "Content-Transfer-Encoding: BASE64\r\n"
    . "Content-Type: text/plain; charset=UTF-8\r\n";
  
  //メール送信処理
  $mailsousin_agent  = mb_send_mail($mail_to_agent, $mail_subject_agent, $mail_body_agent, $mail_header_agent);
   
  // //メールの送信（結果を変数 $result_agent に代入）
  // if ( ini_get( 'safe_mode' ) ) {
  //   //セーフモードがOnの場合は第5引数が使えない
  //   $result_agent = $mailsousin_agent;
  //   echo 3;
  // } else {
  //   $result_agent = mb_send_mail($mail_to_agent, $mail_subject_agent, $mail_body_agent, $mail_header_agent, '-f' . $returnMail );
  //   echo 4;
  // }
  $result_agent = $mailsousin_agent;
  
  //データ追加
  try {
    //usersテーブルへ
    //データ登録
    $sql_users = "INSERT INTO 
      users 
      (name,university,department,grad_year,mail,phone_number,address,delete_flg) 
      VALUES
      ('$name','$university','$department','$grad_year','$email','$phone_number','$address', 0)";
    $stmt_users = $db->prepare($sql_users);
    $stmt_users->execute();
    $database_result_users = $stmt_users->fetchAll();
  
    //company_userテーブルへ
    //データ登録の準備
      //user_idの取得・定義   （usersテーブルの最後の行のidを持ってくる）
      $stmt = $db->query('SELECT id FROM users ORDER BY id DESC LIMIT 1');  
      $last_user_id = $stmt->fetch();
      $user_id = $last_user_id['id'];
      //company_idの取得・定義  (複数の場合はforeachやconcat?で一つ一つに分ける必要がある)
      // if (isset($_GET['company_id'])) {
      //   $company_id_array = $_GET['company_id'];
      // }
      // $company_id = h($company_id_array);
      //contact_datetimeの取得・定義
      $contact_datetime = date("Y-m-d");
    //データ登録
    $sql = "INSERT INTO 
      company_user
      (user_id,company_id,contact_datetime) 
      VALUES 
      ($user_id,$company_id,'$contact_datetime')";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $database_result = $stmt->fetchAll();

  }catch(PDOException $e){
    echo $e -> getMessage();
    exit();
  }
}


//メール送信の結果判定
if ( $result_user && $result_agent) {
  //成功した場合はセッションを破棄
  $_SESSION = array(); //空の配列を代入し、すべてのセッション変数を消去 
  session_destroy(); //セッションを破棄
} else {
  //送信失敗時（もしあれば）
}
?>
<!-- ここまでPHP -->


<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>お問い合わせ完了ページ</title>
</head>
<body>
  <main>
    <section id="contact">
      <!-- ページメイン -->
      <div class="contact_wrapper">
        <p>contact</p>
        <h2>お問い合わせフォーム</h2>
        <?php if ( $result_user && $result_agent ): ?>
        <h1>お問い合わせ完了</h1>
        <p>お問い合わせいただきありがとうございます。</p>
        <p>確認のため、自動送信メールをお送りいたします。</p>
        <p>お問い合わせフォームに入力されたメールの受信ボックスをご確認ください。</p>
        <?php else: ?>
        <p>申し訳ございませんが、送信に失敗しました。</p>
        <p>しばらくしてもう一度お試しになるか、メールにてご連絡ください。</p>
        <p>ご迷惑をおかけして誠に申し訳ございません。</p>
        <?php endif; ?>
      </div>
      <!-- シェアボタン -->
        <!-- 参考サイト→ https://webdesign-trends.net/entry/3632 -->
        <!-- 形だけ、URLをあとで入れる -->
      <div class="contact_share_wrapper">
        <p>シェアはこちら</p>
        <a href="http://www.facebook.com/share.php?u={URL}" rel="nofollow" target="_blank">facebook</a>
        <a href="https://twiter.com/share?url=https://webdesign-trends.net/entry/3632">twiter</a>
        <a href="https://social-plugins.line.me/lineit/share?url={{URL}}">LINEで送る</a>
      </div>
      <!-- 戻るボタン -->
      <a href="../top.php">TOPページはこちら</a>
    </section>
  </main>
</body>
</html>