<?php
session_start();
session_regenerate_id( TRUE );
   //エスケープ処理やデータをチェックする関数を記述したファイルの読み込み
   require './libs/functions.php'; 
   
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

    require('./dbconnect.php');
    require('searchfun.php');
    $userData = getUserData($_GET);

    // $sql = 'SELECT * FROM company_posting_information';
    // $stmt = $db->query($sql);
    // $stmt->execute();
    // $companies = $stmt->fetchAll();
    ?>

   <head>
     <meta charset="UTF-8">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>絞り込み結果ページ</title>
     <link rel="stylesheet" href="style.css">
   </head>

   <body>
   <div class="col-xs-6 col-xs-offset-3">
     <?php
      ?>
     <?php if (isset($userData) && count($userData)) : ?>

       <p class="alert alert-success"><?php echo count($userData) ?>件見つかりました。</p>

       <table class="table">
         <div>名前</div>
         <div>
           <?php foreach ($userData as $row) : ?>
             <div class='outline'>
               <a href="./detail.php?company_id='<?= $row['company_id']; ?>'">
                 <div>
                   <?php echo htmlspecialchars($row['industries']); ?>
                 </div>
                 <div>
                   <?php echo htmlspecialchars($row['name']); ?>
                 </div>
                 <div>
                   <a href="./contact/contactform.php?company_id=<?= htmlspecialchars($row['company_id']); ?>">お問い合わせ</a>
                 </div>
                 <div>
                   <p>比較はこちら</p>
                 </div>
                 <div class="company_box_check">
                  <!-- valueにデータを追加していくことで、一時表示ボックスに反映できる -->
                  <label for="check"><input type="checkbox" name="select_company_checkboxes" value="<?= $row['company_id'];?>-<?= $row['name'];?>" onchange="checked_counter()">選択する</label>
                </div>
               </a>
             </div>
           <?php endforeach; ?>
         </div>
       </table>
     <?php else : ?>
       <p class="alert alert-danger">検索対象は見つかりませんでした。</p>
     <?php endif; ?>
     <div>
          <!-- 比較チェックボタンついた会社を一時表示するボックス -->
          <div class="selected_company_box">
            <p>比較するエージェント会社</p>
            <form id="form" class="validationForm" action="./compare_table.php" method="post">
              <!-- 比較チェックボタンついた会社の表示箇所 -->
                 <div id="checked_company_box"></div>
              <!-- 完了ページへ渡すトークンの隠しフィールド -->
                 <input type="hidden" name="ticket" value="<?php echo h($ticket); ?>">
              <!-- 比較するボタンを押すと、一時表示された会社の情報を比較表ページにpostする -->
                 <button name="submitted" type="submit" class="">比較する</button>
            </form>
          </div>
     </div>
   </div>

   <!-- 比較ボタンの挙動（company_idの受け渡し）を記述したファイルの読み込み -->
  <script src="./to_compare_table.js"></script>
  </body>