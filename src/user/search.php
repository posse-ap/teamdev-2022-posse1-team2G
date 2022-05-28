<?php

//①データ取得ロジックを呼び出す
require('searchfun.php');
$userData = getUserData($_GET);

?>
<!DOCTYPE HTML>
<html lang="ja">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>PHPの検索機能</title>
  <link rel="stylesheet" href="../css/serach.css">
  <!-- Bootstrap読み込み（スタイリングのため） -->
  <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css"> -->
</head>

<body class='form_body'>
  <div class='form_title'>
    <h1>検索する</h1>
  </div>
  <div class=" form_container">
    <!-- 検索フォームのフロントを作る際、<form></form>はコピペして使って！-->
    <form action="./result.php" method='GET'>
      <div class="form-group form_industries">
        <div class='form_each_heading'>
          <p>業種</p>
        </div>
        <div class='form_checkbox_container'>
          <div class='each_industries_checkbox'>
            <input type="checkbox" name="industries[]" id='service_check' value="サービス">
            <label for="service_check">サービス</label>
          </div>
          <div class='each_industries_checkbox'>
            <input type="checkbox" name="industries[]" id='service_IT' value="IT">
            <label for="service_IT">IT</label>
          </div>
          <div class='each_industries_checkbox'>
            <input type="checkbox" name="industries[]" id='service_retail' value="小売り">
            <label for="service_retail">小売り</label>
          </div>
          <div class='each_industries_checkbox'>
            <input type="checkbox" name="industries[]" id='service_trading_company' value="商社">
            <label for="service_trading_company">商社</label>
          </div>
          <div class='each_industries_checkbox'>
            <input type="checkbox" name="industries[]" id='service_finance' value="金融">
            <label for="service_finance">金融</label>
          </div>
          <div class='each_industries_checkbox'>
            <input type="checkbox" name="industries[]" id='service_communication' value="通信">
            <label for="service_communication">通信</label>
          </div>
          <div class='each_industries_checkbox'>
            <input type="checkbox" name="industries[]" id='service_mass_communication' value="マスコミ">
            <label for="service_mass_communication">マスコミ</label>
          </div>
          <!-- <input type="checkbox" name="industries[]" value="IT">IT
          <input type="checkbox" name="industries[]" value="小売り">小売り
          <input type="checkbox" name="industries[]" value="商社">商社
          <input type="checkbox" name="industries[]" value="金融">金融
          <input type="checkbox" name="industries[]" value="通信">通信
          <input type="checkbox" name="industries[]" value="マスコミ">マスコミ -->
        </div>
      </div>
      <div class="form-group form_type">
        <div class='form_each_heading'>
          <p>あなたのタイプ</p>
        </div>
        <div class='form_checkbox_container'>
          <div class='each_type_checkbox'>
            <input type="checkbox" name="types[]" value="文系" id="type_humanities">
            <label for="type_humanities">文系</label>
          </div>
          <div class='each_type_checkbox'>
            <input type="checkbox" name="types[]" value="理系" id="type_sciences">
            <label for="type_sciences">理系</label>
          </div>
          <div class='each_type_checkbox'>
            <input type="checkbox" name="types[]" value="留学" id="type_study_abroad">
            <label for="type_study_abroad">留学</label>
          </div>
          <div class='each_type_checkbox'>
            <input type="checkbox" name="types[]" value="体育会" id="type_physical_education_party">
            <label for="type_physical_education_party">体育会</label>
          </div>
        </div>
      </div>
      <div class='form_submit'>
        <button type="submit" class="btn btn-default">検索</button>
      </div>
    </form>
  </div>
</body>

</html>