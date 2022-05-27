<?php

?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>エージェント会社 管理者画面</title>
  <!-- ↓この_header.phpから見たparts.cssの位置ではなく、このphpファイルが読み込まれるファイルから見た位置を指定してあげる必要がある -->
  <link rel="stylesheet" href="../parts.css">
  <link rel="stylesheet" href="../admin_index.css">
  <link rel="stylesheet" href="../admin_style.css">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
  <!-- icon用 -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css">

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
        <li class="nav_item"><a href="../user_list.php">申し込み一覧</a></li>
        <li class="nav_item"><a href="../information_posting.php">登録情報</a></li>
        <li class="nav_item"><a href="../contact_form.php">申請</a></li>
      </ul>
    </nav>
  </header>
  <main>