<?php
require('./dbconnect.php');



$sql = 'SELECT * FROM company_posting_information';
$stmt = $db->query($sql);
$stmt->execute();
$companies = $stmt->fetchAll();


?>
<pre>
  <?php print_r($companies); ?>
</pre>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <main>
    <section id="company">
      <div class="company_wrapper">
        <h2>企業一覧</h2>
        <div class="company_list">
          <!-- 一つの会社ボックス -->
          <?php foreach ($companies as $company) : ?>
            <div class="company_box outline">
              <a href="./detail.php?company_id='<?= $company['company_id'] ?>'">
                <div class="company_box_logo">
                  <img src="" alt="">
                </div>
                <div class="company_box_img">
                  <img src="" alt="">
                </div>
                <div class="company_box_info">
                  <div class="company_info_first">
                    <img src="" alt="">
                    <!-- <p>IT</p> -->
                    <p><?= $company['industries']; ?></p>
                  </div>
                  <div class="company_info_second">
                    <img src="" alt="">
                    <p><?= $company['achievement']; ?>%</p>
                  </div>
                  <div class="company_info_third">
                    <img src="" alt="">
                    <!-- ここら辺もしphpなら二つのp要素くっつけてもいいかもです -->
                    <!-- <p>文系</p> -->
                    <p><?= $company['type']; ?></p>
                    <!-- ここまで -->
                  </div>
                </div>
                <div class="company_box_exp">
                  <p>マイナビ新卒紹介は…</p>
                </div>
                <div class="company_box_button">
                  <a href="" class="inquiry">お問い合わせはこちら</a>
                  <a href="" class="comparison">複数の会社を比較する</a>
                </div>
                <div class="company_box_check">
                  <label for="check"><input type="checkbox">選択する</label>
                </div>
              </a>
            </div>
          <?php endforeach; ?>
          <!-- ここまで -->
        </div>
      </div>
    </section>
  </main>
</body>

</html>