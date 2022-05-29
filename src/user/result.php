<?php
session_start();
session_regenerate_id( TRUE );
   //エスケープ処理やデータをチェックする関数を記述したファイルの読み込み
   require '../libs/functions.php'; 
   
   //NULL 合体演算子を使ってセッション変数を初期化（PHP7.0以降）
   $id = $_SESSION[ 'id' ] ?? NULL;
   
   //CSRF対策のトークンを生成
   if ( !isset( $_SESSION[ 'ticket' ] ) ) {
     //セッション変数にトークンを代入
     $_SESSION[ 'ticket' ] = bin2hex(random_bytes(32));
   }
   //トークンを変数に代入（隠しフィールドに挿入する値）
   $ticket = $_SESSION[ 'ticket' ];
// ここまで比較表ページへの挙動に必要なphp

    require('../dbconnect.php');
    require('searchfun.php');
    $userData = getUserData($_GET);

// 企業数のカウント
$cnt = count($userData);
$cnt_row = 0;
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>絞り込み結果ページ</title>
  <link rel="stylesheet" href="../css/reset.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
  <link rel="stylesheet" href="../css/parts.css">
  <link rel="stylesheet" href="../css/result.css">
</head>

<body>
<header>
    <div class="header_wrapper">
      <div class="header_logo">
        <img src="../img/boozer_logo.png" alt="logo">
        <!-- <a href="#">CRAFT</a> -->
      </div>
    </div>
    <nav class="header_nav">
      <ul>
        <li class="nav_item"><a href="#company">企業一覧</a></li>
        <li class="nav_item"><a href="#problem">お悩みの方へ</a></li>
        <li class="nav_item"><a href="#merit">比較のメリット</a></li>
        <li class="nav_item"><a href="#question">よくある質問</a></li>
        <!-- 時間あったらモーダルにしてちょっと就活エージェントのこと書いて、就活の教科書の特集に飛ばせるかも -->
        <li class="nav_item"><a href="#">就活エージェントとは</a></li>
        <!-- ここまで -->
        <li class="nav_item"><a href="#">企業の方へ</a></li>
      </ul>
    </nav>
  </header>
  <main class="main_wrapper">
  <?php if (isset($userData) && count($userData)) : ?>
    <h1>絞り込み結果<span class="alert alert-success"> -<?php echo count($userData) ?>件見つかりました-</span></h1>
    <table class="table">
      <?php foreach ($userData as $row) : ?>
        <div class="result_list">
         <!-- 絞り込みページでの検索結果カード -->
         <div class="result_box">
           <div class="result_left">
             <div class="result_box_logo">
               <img src="../img/rikunabi.png" alt="">
             </div>
           </div>
           <div class="result_right">
             <div class="result_top_flex">
               <div class="result_box_name">
                 <p><?php echo htmlspecialchars($row['name']); ?></p>
               </div>
               <div class="company_box_check">
                    <input type="checkbox" name="select_company_checkboxes" value="<?= $row['company_id']; ?><?= $row['name']; ?>" id="checked_box_<? echo $cnt_row; ?>" onchange="checked_counter()">
                    <label for="checked_box_<? echo $cnt_row; ?>">会社を比較する</label>
                    <? $cnt_row += 1; ?>
                    <!-- <label for="check"><input type="checkbox" name="select_company_checkboxes" value="<?= $row['company_id']; ?>-<?= $row['name']; ?>" onchange="checked_counter()">複数の会社を比較する</label> -->
               </div>
             </div>
             <div class="result_box_line"></div>
             <div class="result_box_info">
               <div class="company_info_first">
                 <div class="company_info_title">
                   <i class="fa-solid fa-briefcase"></i>
                   <p class="capital">業種</p>
                 </div>
                 <div class="company_info_result">
                   <p><?php echo htmlspecialchars($row['industries']); ?></p>
                 </div>
               </div>
               <div class="result_info_second">
                 <div class="company_info_title">
                   <i class="fa-solid fa-trophy"></i>
                   <p class="capital">実績</p>
                 </div>
                 <div class="company_info_result">
                   <p><?php echo htmlspecialchars($row['achievement']); ?></p>
                 </div>
               </div>
               <div class="result_info_third">
                 <div class="company_info_title">
                   <i class="fa-solid fa-hand-point-up"></i>
                   <p class="capital">おすすめ</p>
                 </div>
                 <div class="company_info_result">
                   <p><?php echo htmlspecialchars($row['type']); ?></p>
                 </div>
                 <!-- ここまで -->
               </div>
             </div>
             <div class="result_box_line"></div>
             <div class="result_bottom">
               <div class="result_box_exp">
                 <p class="capital">企業について</p>
                 <p class="box_exp_sentence">マイナビ新卒紹介はあああああああああああああああああああああああああああ</p>
               </div>
               <div class="result_box_button_second">
                 <a href="" class="inquiry">お問い合わせ</a>
               </div>
             </div>
           </div>
        </div>
        <?php endforeach; ?>
         </div>
       </table>
     <?php else : ?>
       <p class="alert alert-danger">検索対象は見つかりませんでした。</p>
     <?php endif; ?>
     <div>
          <!-- 比較チェックボタンついた会社を一時表示するボックス -->
        <div id="at_once_box" class="selected_company_box">
          <p class="box-title">比較するエージェント会社</p>
          <form id="form" class="validationForm" action="./compare_table.php" method="post">
            <!-- 比較チェックボタンついた会社の表示箇所 -->
            <div id="checked_company_box"></div>
            <!-- 完了ページへ渡すトークンの隠しフィールド -->
            <input type="hidden" name="ticket" value="<?php echo h($ticket); ?>">
            <!-- 比較するボタンを押すと、一時表示された会社の情報を比較表ページにpostする -->
            <button name="submitted" type="submit" class="contact_button">比較する</button>
          </form>
        </div>
     </div>
   </div>
  </main>

  <footer>
    <div class="footer_wrapper">
      <div class="footer_student">
        <p>学生の方へ</p>
        <ul class="footer_list">
          <li><a href="#company">企業一覧</a></li>
          <li><a href="#problem">お悩みの方へ</a></li>
          <li><a href="#merit">比較のメリット</a></li>
          <li><a href="#question">よくある質問</a></li>
          <li><a href="#">就活エージェントとは</a></li>
        </ul>
      </div>
      <div class="footer_company">
        <p>企業の方へ</p>
        <ul class="footer_list">
          <li><a href="#">CRAFTについて</a></li>
          <li><a href="#">サイト掲載について</a></li>
        </ul>
      </div>
      <div class="footer_logo">
        <!-- <img src="" alt="logo"> -->
        <p>CRAFT</p>
      </div>
      <span class="footer_copyright">
        ©︎ 2022 CRAFT. All rights reserved.
      </span>
    </div>
  </footer>


   <!-- 比較ボタンの挙動（company_idの受け渡し）を記述したファイルの読み込み -->
  <script src="../js/compare_table.js"></script>
</body>

</html>
