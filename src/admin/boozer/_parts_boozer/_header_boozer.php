<?php

?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>boozer 管理者画面</title>
  <!-- ↓この_header.phpから見たparts.cssの位置ではなく、このphpファイルが読み込まれるファイルから見た位置を指定してあげる必要がある -->
  <link rel="stylesheet" href="../_parts_boozer/parts.css">
  <link rel="stylesheet" href="../admin_index.css">
  <link rel="stylesheet" href="../admin_style.css">
</head>
<body>
  <header>
    <div class="header_wrapper">
      <div class="header_logo">
        <img src="../../img/boozer_logo.png" alt="logo">
        <!-- <a href="#">CRAFT</a> -->
      </div>
    </div>
    <nav class="header_nav">
      <ul>
        <li class="nav_item"><a href="#company">申し込み一覧</a></li>
        <li class="nav_item"><a href="#problem">登録情報</a></li>
        <li class="nav_item"><a href="#merit">申請</a></li>
      </ul>
    </nav>
  </header>
  <main>