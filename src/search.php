<?php

//①データ取得ロジックを呼び出す
include_once('model.php');
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

    <form action="" method='GET'>
      <div class="form-group">
        <label for="">業種</label>
        <input type="radio" name="industries" value='service'>サービス
        <input type="radio" name="industries" value='IT'>IT
        <input type="radio" name="industries" value='retail'>小売り
        <input type="radio" name="industries" value='trading_company'>商社
        <input type="radio" name="industries" value='finance'>金融
        <input type="radio" name="industries" value='communication'>通信
        <input type="radio" name="industries" value='mass_communication'>マスコミ
        <?php if (isset($_GET['industries'])) { ?>
          <?php $industries = $_GET['industries']; ?>
          <?php echo $industries; ?>
        <?php } ?>
      </div>
      <button type="submit" class="btn btn-default" name="search">検索</button>
    </form>



    <!-- 
    <form method="get">
      <div class="form-group">
        <label for="InputName">名前</label>
        <input name="name" class="form-control" id="InputName" value="<?php echo isset($_GET['name']) ? htmlspecialchars($_GET['name']) : '' ?>">
      </div>
      <div class="form-group">
        <label for="InputSex">性別</label>
        <select name="sex" class="form-control" id="InputSex">
          <option value="0" <?php echo empty($_GET['sex']) ? 'selected' : '' ?>>選択しない</option>
          <option value="1" <?php echo isset($_GET['sex']) && $_GET['sex'] == '1' ? 'selected' : '' ?>>男性</option>
          <option value="2" <?php echo isset($_GET['sex']) && $_GET['sex'] == '2' ? 'selected' : '' ?>>女性</option>
        </select>
        <input type="radio" name="sex" value='1' id="">男性
        <input type="radio" name="sex" value='2' id="">女性
        <?php if (isset($_GET['sex'])) { ?>
          <?php $sex = $_GET['sex']; ?>
          <?php echo $sex; ?>
        <?php } ?>
      </div> -->
    <!-- <div class="form-group">
        <label for="InputAge">年齢</label>
        <select name="age" class="form-control" id="InputAge">
          <option value="0" <?php echo empty($_GET['age']) ? 'selected' : '' ?>>選択しない</option>
          <option value="10" <?php echo isset($_GET['age']) && $_GET['age'] == '10' ? 'selected' : '' ?>>10代</option>
          <option value="20" <?php echo isset($_GET['age']) && $_GET['age'] == '20' ? 'selected' : '' ?>>20代</option>
          <option value="30" <?php echo isset($_GET['age']) && $_GET['age'] == '30' ? 'selected' : '' ?>>30代</option>
        </select>
      </div> -->
    <!-- <button type="submit" class="btn btn-default" name="search">検索</button> -->
    </form>

  </div>
  <div class="col-xs-6 col-xs-offset-3">
    <?php //③取得データを表示する 
    ?>
    <?php if (isset($userData) && count($userData)) : ?>
      <p class="alert alert-success"><?php echo count($userData) ?>件見つかりました。</p>
      <table class="table">
        <!-- <thead>
          <tr>
            <th>名前</th>
            <th>性別</th>
            <th>年齢</th>
          </tr>
        </thead> -->
        <tbody>
          <?php foreach ($userData as $row) : ?>
            <?php echo htmlspecialchars($row['industries']) ?>

          <?php endforeach; ?>
        </tbody>
      </table>
    <?php else : ?>
      <p class="alert alert-danger">検索対象は見つかりませんでした。</p>
    <?php endif; ?>

  </div>
</body>

</html>