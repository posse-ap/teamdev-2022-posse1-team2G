<?php
//エスケープ処理を行う関数
function h($var) {
  if(is_array($var)){
    //$varが配列の場合、h()関数をそれぞれの要素について呼び出す（再帰）
    return array_map('h', $var);
  }else{
    return htmlspecialchars($var, ENT_QUOTES, 'UTF-8');
  }
}
 
//入力値に不正なデータがないかなどをチェックする関数
function checkInput($var){
  if(is_array($var)){
    return array_map('checkInput', $var);
  }else{
    //NULLバイト攻撃対策
    if(preg_match('/\0/', $var)){  
      die('不正な入力です。');
    }
    //文字エンコードのチェック
    if(!mb_check_encoding($var, 'UTF-8')){ 
      die('不正な入力です。');
    }
    //改行、タブ以外の制御文字のチェック
    if(preg_match('/\A[\r\n\t[:^cntrl:]]*\z/u', $var) === 0){  
      die('不正な入力です。制御文字は使用できません。');
    }
    return $var;
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <!-- ↓のメッセージが見えたらこのファイルが見えていることになる -->
  <h1>外部アクセス拒否できていない</h1>
</body>
</html>