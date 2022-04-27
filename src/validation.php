<?
function validation($data)
{

  $errormessage = [];

  //名前
  if (!$data["fullname"]) {
    $errormessage[] = "名前を入力して下さい";
  } else if (mb_strlen($data["fullname"]) > 20) {
    $errormessage[] = "名前は20文字以内にして下さい";
  }
  $_SESSION["fullname"] = htmlspecialchars($data["fullname"], ENT_QUOTES);

  if (!$data["university"]) {
    $errormessage[] = "大学名を入力して下さい";
  } else if (mb_strlen($data["university"]) > 20) {
    $errormessage[] = "大学名は20文字以内にして下さい";
  }
  $_SESSION["university"] = htmlspecialchars($data["university"], ENT_QUOTES);

  // if (!$data["department"]) {
  //   $errormessage[] = "学部を入力して下さい";
  // } else if (mb_strlen($data["department"]) > 20) {
  //   $errormessage[] = "学部は20文字以内にして下さい";
  // }
  // $_SESSION["department"] = htmlspecialchars($data["department"], ENT_QUOTES);

  // if (!$data["mail"]) {
  //   $errormessage[] = "メールを入力して下さい";
  // } else if (mb_strlen($data["mail"]) > 200) {
  //   $errormessage[] = "メールは200文字以内にして下さい";
  // } else if (!filter_var($data["mail"], FILTER_VALIDATE_EMAIL)) {
  //   $errormessage[] = "メールアドレスが不正です";
  // }
  // $_SESSION["mail"] = htmlspecialchars($data["mail"], ENT_QUOTES);

  // if (!$data["phone_number"]) {
  //   $errormessage[] = "電話番号を入力して下さい";
  // } else if (mb_strlen($data["phone_number"]) > 20) {
  //   $errormessage[] = "電話番号は20文字以内にして下さい";
  // }
  // $_SESSION["phone_number"] = htmlspecialchars($data["phone_number"], ENT_QUOTES);

  // if (!$data["address"]) {
  //   $errormessage[] = "住所を入力して下さい";
  // } else if (mb_strlen($data["address"]) > 20) {
  //   $errormessage[] = "住所は20文字以内にして下さい";
  // }
  // $_SESSION["address"] = htmlspecialchars($data["address"], ENT_QUOTES);

  // if (!$data["phone_number"]) {
  //   $errormessage[] = "名前を入力して下さい";
  // } else if (mb_strlen($data["phone_number"]) > 20) {
  //   $errormessage[] = "名前は20文字以内にして下さい";
  // }
  // $_SESSION["phone_number"] = htmlspecialchars($data["phone_number"], ENT_QUOTES);

  // if (!$data["message"]) {
  //   $errormessage[] = "お問い合わせ内容を入力して下さい";
  // } else if (mb_strlen($data["message"]) > 500) {
  //   $errormessage = "お問い合わせ内容は500文字以内にして下さい";
  // }
  // $_SESSION["message"] = htmlspecialchars($data["message"], ENT_QUOTES);


  // //もし入力があれば
  // //filter_varのurl形式に引っかかったらエラー表示

  // //性別
  // if(!isset($data['gender'])){
  //   $error[] = '性別は必ず入力してください。';
  // }
  // //issetでラジオボタンの入力チェック

  // //年齢
  // if(empty($data['age']) || 6 < $data['age']){
  //   $error[] ='年齢を入力してください。';
  // }
  // //未選択、且つ、6より大きい数字の場合はエラー表示

  // //お問い合わせ内容の文字数チェック
  // if(empty($data['message']) || 200 < mb_strlen($data['message'])){
  //   $error[] ='お問い合わせ内容は200字以内で入力してください。';
  // }
  // //未入力、且つ、200文字以上の場合はエラー表示

  // //注意事項
  // if($data['caution'] !== '1'){
  //   $error[] ='注意事項をご確認ください。';
  // }
  // //チェックがついてなかったらエラー表示


  return $errormessage;
}
