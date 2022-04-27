<?php
session_start();
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
  if (!$_POST["phone_number"]) {
    $errormessage[] = "電話番号を入力して下さい";
  } else if (mb_strlen($_POST["phone_number"]) > 20) {
    $errormessage[] = "電話番号は20文字以内にして下さい";
  }
  $_SESSION["phone_number"] = htmlspecialchars($_POST["phone_number"], ENT_QUOTES);

  // 住所
  if (!$_POST["address"]) {
    $errormessage[] = "住所を入力して下さい";
  } else if (mb_strlen($_POST["address"]) > 100) {
    $errormessage[] = "住所は100文字以内にして下さい";
  }
  $_SESSION["address"] = htmlspecialchars($_POST["address"], ENT_QUOTES);

  // その他は任意なのでエラーメッセージは表示しない
  $_SESSION["message"] = htmlspecialchars($_POST["message"], ENT_QUOTES);

  //　エラーが生じた場合→input(遷移しない)
  // エラーが生じなかった場合→confirm(確認画面に遷移)
  if ($errormessage) {
    $mode = 'input';
  } else {
    $mode = 'confirm';
  }
}
// 送信ボタンを押したとき 
else if (isset($_POST['send']) && $_POST['send']) {
  $message  = "お問い合わせを受け付けました \r\n"
    . "名前: " . $_SESSION['fullname'] . "\r\n"
    . "mail: " . $_SESSION['mail'] . "\r\n"
    . "お問い合わせ内容:\r\n"
    . preg_replace("/\r\n|\r|\n/", "\r\n", $_SESSION['message']);
  mail($_SESSION['mail'], 'お問い合わせありがとうございます', $message);
  mail('fuga@hogehoge.com', 'お問い合わせありがとうございます', $message);
  $_SESSION = array();
  $mode = 'send';
} else {
  // 送信後は値をクリアにする（保持しない）
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






<!-- ここからフロント側 -->
<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <title>お問い合わせフォーム</title>
</head>

<body>
  <!-- 入力画面 -->
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

    
    <!-- 確認画面のフロント -->
  <?php } else if ($mode == 'confirm') { ?>
    <!-- <?php var_dump($_POST['grad_year']); ?> -->
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
      <input type="submit" name="send" value="送信" />
    </form>

    <!-- 完了画面 -->
  <?php } else { ?>
    送信しました。お問い合わせありがとうございました。<br>
  <?php } ?>
</body>

</html>