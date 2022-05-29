<?php
session_start();
require('../../dbconnect.php');
//エスケープ処理やデータチェックを行う関数のファイルの読み込み
require '../../libs/functions.php';

if (isset($_SESSION['id']) && $_SESSION['time'] + 60 * 60 > time()) {
  $_SESSION['time'] = time();
  // user_idがない、もしくは一定時間を過ぎていた場合
  $id = $_SESSION['id'];
  $sql = "SELECT company_name from company where id='$id';";
  $stmt = $db->prepare($sql);
  $stmt->execute();
  $company_name = $stmt->fetchAll();
} else {
  header('Location: http://' . $_SERVER['HTTP_HOST'] . '/admin/login.php');
  exit();
}

//NULL 合体演算子を使ってセッション変数を初期化
$purpose = $_SESSION[ 'purpose' ] ?? NULL;
$message = $_SESSION[ 'message' ] ?? NULL;
$error = $_SESSION[ 'error' ] ?? NULL;
 
//個々のエラーを NULL で初期化
$error_address = $error[ 'purpose' ] ?? NULL;
$error_message = $error[ 'message' ] ?? NULL;
$company_name_session = $_SESSION[ 'company_name' ] ?? NULL;

//CSRF対策のトークンを生成
if ( !isset( $_SESSION[ 'ticket' ] ) ) {
  //セッション変数にトークンを代入
  $_SESSION[ 'ticket' ] = bin2hex(random_bytes(32));
}
//トークンを変数に代入（隠しフィールドに挿入する値）
$ticket = $_SESSION[ 'ticket' ];

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>申請フォーム画面</title>
  <link rel="stylesheet" href="../parts.css">
  <link rel="stylesheet" href="../admin_index.css">
</head>
<!-- header関数読み込み -->
<?php
include('./_parts_agent/_header_agent.php');  
?>


<div class="container_contents">

  <!-- フォーム -->
  <h1>ー申請フォームー</h1>
  <p>以下のフォームからお問い合わせください。</p>

  <form id="form" class="validationForm form_card" action="./thanks.php" method="post" novalidate>
     <!-- <div class="form_card"> -->
         <div>
           <p class="subtitle">目的</p>
           <label>無効申請</label>
           <input type="radio"  name="purpose" data-error-required-radio="目的は必須です。" value="無効申請">
           <label>登録情報の変更</label>
           <input type="radio"  name="purpose" data-error-required-radio="目的は必須です。" value="登録情報の変更">
           <label>その他</label>
           <input type="radio"  name="purpose" data-error-required-radio="目的は必須です。" value="その他">
         </div>
         
         <div>
           <p class="subtitle">内容</p>
           <textarea cols="40" rows="8" class="maxlength" 
           placeholder="自由記述欄" data-maxlength="1000" id="message" name="message" rows="3"><?php echo $message; ?></textarea>
         </div>
   
         <!--確認ページへトークンをPOSTする、隠しフィールド「ticket」-->
         <input type="hidden" name="ticket" value="<?php echo $ticket; ?>">
   
         <button name="submitted" type="submit" class="btn btn-primary">送信</button>
     <!-- </div> -->
  </form>
</div>


<!-- ↓footer関数の読み込み -->
<?php
include('../_footer.php');  
?>

<!--  JavaScript の読み込み -->
<script src="../../contact/formValidation.js"></script> 
</body>