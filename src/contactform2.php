<?php
session_start();

// require 'validation.php';



$mode = 'input';
// $error = array();
// $error = validation($_POST);
if (isset($_POST['back']) && $_POST['back']) {
  // 何もしない
} else if (isset($_POST['confirm']) && $_POST['confirm']) {
  if (!$_POST["fullname"]) {
    $errormessage[] = "名前を入力して下さい";
  } else if (mb_strlen($_POST["fullname"]) > 100) {
    $errormessage[] = "名前は100文字以内にして下さい";
  }
  $_SESSION["fullname"] = htmlspecialchars($_POST["fullname"], ENT_QUOTES);

  // if ($error) {
  //   $mode = 'input';
  // } else {
  //   $mode = 'confirm';
  //   // $error = array();
  // }
  // $_SESSION['fullname']     = $_POST['fullname'];
  // $_SESSION['university']   = $_POST['university'];
  // $_SESSION['department']   = $_POST['department'];
  // $_SESSION['grad_year']    = $_POST['grad_year'];
  // $_SESSION['mail']         = $_POST['mail'];
  // $_SESSION['phone_number'] = $_POST['phone_number'];
  // $_SESSION['address']      = $_POST['address'];
  // $_SESSION['message']      = $_POST['message'];
  // $mode = 'confirm';
} else if (isset($_POST['send']) && $_POST['send']) {
  // $message = "お問い合わせを受け付けました\r\n"
  //   . "名前" . $_SESSION["fullname"] . "\r\n"
  //   . "mail" . $_SESSION["mail"] . "\r\n"
  //   . "お問い合わせ内容:\r\n"
  //   . preg_replace("/\r\n|\r|\n/", "\r\n", $_SESSION["message"]);
  // mail($_SESSION["mail"], "お問い合わせありがとうございます", $message);

  mb_language("Japanese");
  mb_internal_encoding("UTF-8");

  $to = $_POST['mail'];
  $title = 'メール送信完了メール';
  $message = $_POST['message'];
  $headers = "From: rr.hh0207@keio.jp";
  // $from = 'dondonudon27@icloud.com';
  // $pfrom = "-f $from";

  $mail_send = mb_send_mail($to, $title, $message, $headersk);
  if ($mail_send == true) {
    echo "メール送信成功です";
  } else {
    echo "メール送信失敗です";
  }
  // 各企業
  // mail("longerpingye66@gmail.com", "お問い合わせありがとうございます", $message);
  $_SESSION = array();
  $mode = 'send';
} else {
  $_SESSION['fullname'] = "";
  $_SESSION['university'] = "";
  $_SESSION['department'] = "";
  $_SESSION['grad_year'] = "";
  $_SESSION['mail']    = "";
  $_SESSION['phone_number'] = "";
  $_SESSION['address'] = "";
  $_SESSION['message']  = "";
}
?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <title>お問い合わせフォーム</title>
</head>

<body>
  <h1>お問い合わせフォーム</h1>
  <?php if ($mode == 'input') { ?>
    <ul>
      <!-- <?php foreach ($error as $value) : ?> -->
      <!-- $errorは連想配列なのでforeachで分解していく -->
      <li><?php echo $value; ?></li>

      <!-- 分解したエラー文をlistの中に表示していく -->
    <?php endforeach; ?>
    <?php $error = array(); ?>
    </ul>


    <!-- 入力画面 -->
    <form action="./contactform.php" method="post">
      <div>
        <p>名前</p>
        <input type="text" name="fullname" value="<?php echo $_SESSION['fullname'] ?>">
      </div>
      <div>
        <p>大学</p>
        <input type="text" name="university" value="<?php echo $_SESSION['university'] ?>">
      </div>
      </div>
      <div>
        <p>学部学科</p>
        <input type="text" name="department" value="<?php echo $_SESSION['department'] ?>">
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
        <input type="mail" name="mail" value="<?php echo $_SESSION['mail'] ?>">
      </div>
      <div>
        <p>電話番号</p>
        <input type="tel" name="phone_number" value="<?php echo $_SESSION['phone_number'] ?>">
      </div>
      <div>
        <p>住所</p>
        <input type="text" name="address" value="<?php echo $_SESSION['address'] ?>">
      </div>
      <div>
        <p>その他</p>
        <textarea cols="40" rows="8" name="message"><?php echo $_SESSION['message'] ?></textarea><br>
      </div>

      <input type="submit" name="confirm" value="確認" />
    </form>
  <?php } else if ($mode == 'confirm') { ?>
    <!-- 確認画面 -->
    <?php var_dump($_POST['grad_year']); ?>
    <form action="./contactform.php" method="post">
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
        <p><?php echo $_SESSION['phone_number'] ?></p>
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
      <input type="submit" name="send" value="送信" /> -->
    </form>
  <?php } else { ?>
    <!-- 完了画面 -->
    送信完了です。
  <?php } ?>
</body>

</html>