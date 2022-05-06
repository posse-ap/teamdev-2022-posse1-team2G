<?php

//①データ取得ロジックを呼び出す
require('searchfun.php');
// え
$userData = getUserData($_GET);

?>
<!DOCTYPE HTML>
<html lang="ja">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>PHPの検索機能</title>
  <link rel="stylesheet" href="style.css">
  <!-- Bootstrap読み込み（スタイリングのため） -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
</head>

<body>
  <h1 class="col-xs-6 col-xs-offset-3">検索フォーム</h1>
  <div class="col-xs-6 col-xs-offset-3 well">

    <?php //②検索フォーム 
    ?>
<!-- 検索フォームのフロントを作る際、<form></form>はコピペして使って！-->
    <form action="" method='GET'>
      <div class="form-group">
        <label for="">業種</label>
        <input type="checkbox" name="industries[]" value="サービス">サービス
        <input type="checkbox" name="industries[]" value="IT">IT
        <input type="checkbox" name="industries[]" value="小売り">小売り
        <input type="checkbox" name="industries[]" value="商社">商社
        <input type="checkbox" name="industries[]" value="金融">金融
        <input type="checkbox" name="industries[]" value="通信">通信
        <input type="checkbox" name="industries[]" value="マスコミ">マスコミ
      </div>

      <div class="form-group">
        <label for="">あなたのタイプ</label>
        <input type="checkbox" name="types[]" value="文系">文系
        <input type="checkbox" name="types[]" value="理系">理系
        <input type="checkbox" name="types[]" value="留学">留学
        <input type="checkbox" name="types[]" value="体育会">体育会
      </div>
      <button type="submit" class="btn btn-default">検索</button>
    </form>

    <div class="col-xs-6 col-xs-offset-3">
      <?php 
      ?>
      <?php if (isset($userData) && count($userData)) : ?>

        <p class="alert alert-success"><?php echo count($userData) ?>件見つかりました。</p>
        <table class="table">
          <thead>
            <tr>
              <th>名前</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($userData as $row) : ?>
              <tr>
                <td><?php echo htmlspecialchars($row['industries']) ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      <?php else : ?>
        <p class="alert alert-danger">検索対象は見つかりませんでした。</p>
      <?php endif; ?>
    </div>


 


    <!-- <?php if (isset($userData) && count($userData)) : ?>
      <p class="alert alert-success"><?php echo count($userData) ?>件見つかりました。</p> -->
    <!-- <table class="table"> -->
    <!-- <tbody>
          <?php foreach ($userData as $row) : ?>
            <?php echo htmlspecialchars($row['industries']) ?>

          <?php endforeach; ?>
        </tbody> -->
    <!-- </table> -->
    <!-- <?php else : ?>

    <?php endif; ?> -->

  </div>
</body>

</html>