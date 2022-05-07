<?php
require('./dbconnect.php');

$sql = 'SELECT * FROM company_posting_information where company_id = ' . $_REQUEST["company_id"];
// print_r($sql);
$stmt = $db->query($sql);
$stmt->execute();
$companies = $stmt->fetchAll();
$company = array_reduce($companies, 'array_merge', array());
// $_REQUEST["company_id"]
?>
<!-- <pre>
  <?Php print_r($company); ?>
</pre> -->

<div class="company_box outline">
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
  <div>
    <button><a href="./top.php">戻る</a></button>
  </div>
</div>