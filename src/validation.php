<?


function validation($_POST)
{

  $errormessage = [];

  //名前
  if (!$_POST["fullname"]) {
    $errormessage[] = "名前を入力して下さい";
  } else if (mb_strlen($_POST["fullname"]) > 20) {
    $errormessage[] = "名前は20文字以内にして下さい";
  }
  $_SESSION["fullname"] = htmlspecialchars($_POST["fullname"], ENT_QUOTES);

  if (!$_POST["university"]) {
    $errormessage[] = "大学名を入力して下さい";
  } else if (mb_strlen($_POST["university"]) > 20) {
    $errormessage[] = "大学名は20文字以内にして下さい";
  }
  $_SESSION["university"] = htmlspecialchars($_POST["university"], ENT_QUOTES);

  if (!$_POST["department"]) {
    $errormessage[] = "学部を入力して下さい";
  } else if (mb_strlen($_POST["department"]) > 20) {
    $errormessage[] = "学部は20文字以内にして下さい";
  }
  $_SESSION["department"] = htmlspecialchars($_POST["department"], ENT_QUOTES);

  if (!$_POST["mail"]) {
    $errormessage[] = "メールを入力して下さい";
  } else if (mb_strlen($_POST["mail"]) > 200) {
    $errormessage[] = "メールは200文字以内にして下さい";
  } else if (!filter_var($_POST["mail"], FILTER_VALIDATE_EMAIL)) {
    $errormessage[] = "メールアドレスが不正です";
  }
  $_SESSION["mail"] = htmlspecialchars($_POST["mail"], ENT_QUOTES);

  if (!$_POST["phone_number"]) {
    $errormessage[] = "電話番号を入力して下さい";
  } else if (mb_strlen($_POST["phone_number"]) > 20) {
    $errormessage[] = "電話番号は20文字以内にして下さい";
  }
  $_SESSION["phone_number"] = htmlspecialchars($_POST["phone_number"], ENT_QUOTES);

  if (!$_POST["address"]) {
    $errormessage[] = "住所を入力して下さい";
  } else if (mb_strlen($_POST["address"]) > 20) {
    $errormessage[] = "住所は20文字以内にして下さい";
  }
  $_SESSION["address"] = htmlspecialchars($_POST["address"], ENT_QUOTES);

  if (!$_POST["phone_number"]) {
    $errormessage[] = "名前を入力して下さい";
  } else if (mb_strlen($_POST["phone_number"]) > 20) {
    $errormessage[] = "名前は20文字以内にして下さい";
  }
  $_SESSION["phone_number"] = htmlspecialchars($_POST["phone_number"], ENT_QUOTES);

  if (!$_POST["message"]) {
    $errormessage[] = "お問い合わせ内容を入力して下さい";
  } else if (mb_strlen($_POST["message"]) > 500) {
    $errormessage = "お問い合わせ内容は500文字以内にして下さい";
  }
  $_SESSION["message"] = htmlspecialchars($_POST["message"], ENT_QUOTES);


  //もし入力があれば
  //filter_varのurl形式に引っかかったらエラー表示

  //性別
  if (!isset($_POST['gender'])) {
    $error[] = '性別は必ず入力してください。';
  }
  //issetでラジオボタンの入力チェック

  //年齢
  if (empty($_POST['age']) || 6 < $_POST['age']) {
    $error[] = '年齢を入力してください。';
  }
  //未選択、且つ、6より大きい数字の場合はエラー表示

  //お問い合わせ内容の文字数チェック
  if (empty($_POST['message']) || 200 < mb_strlen($_POST['message'])) {
    $error[] = 'お問い合わせ内容は200字以内で入力してください。';
  }
  //未入力、且つ、200文字以上の場合はエラー表示

  //注意事項
  if ($_POST['caution'] !== '1') {
    $error[] = '注意事項をご確認ください。';
  }
  //チェックがついてなかったらエラー表示


  return $errormessage;
}
