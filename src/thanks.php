<?php

?>
<!-- ここまでPHP -->


<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>お問い合わせ完了ページ</title>
</head>
<body>
  <main>
    <section id="contact">
      <!-- ページメイン -->
      <div class="contact_wrapper">
        <p>contact</p>
        <h1>お問い合わせ完S了</h1>
        <div class="contact_box">
          <p>お問い合わせありがとうございます。</p>
          <p>確認のため、自動送信メールをお送りいたします。</p>
        </div>
      </div>
      <!-- シェアボタン -->
        <!-- 参考サイト→ https://webdesign-trends.net/entry/3632 -->
        <!-- 形だけ、URLをあとで入れる -->
      <div class="contact_share_wrapper">
        <p>シェアはこちら</p>
        <a href="http://www.facebook.com/share.php?u={URL}" rel="nofollow" target="_blank">facebook</a>
        <a href="https://twiter.com/share?url=https://webdesign-trends.net/entry/3632">twiter</a>
        <a href="https://social-plugins.line.me/lineit/share?url={{URL}}">LINEで送る</a>
      </div>
      <!-- 戻るボタン -->
      <a href="index.php" class="back_button">TOPページはこちら</a>
    </section>
  </main>
</body>
</html>