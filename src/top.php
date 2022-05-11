<?php
require('./dbconnect.php');

$sql = 'SELECT * FROM company_posting_information';
$stmt = $db->query($sql);
$stmt->execute();
$companies = $stmt->fetchAll();

?>


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
              <a href="./detail.php?company_id='<?= $company['company_id']; ?>'">
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
                  <!-- valueにデータを追加していくことで、一時表示ボックスに反映できる -->
                  <label for="check"><input type="checkbox" name="select_company_checkboxes" value="<?= $company['company_id'];?><?= $company['type'];?>" onchange="checked_counter()">選択する</label>
                </div>
              </a>
            </div>
          <?php endforeach; ?>
          <!-- ここまで -->
        </div>
        <div>
          <!-- 比較チェックボタンついた会社を一時表示するボックス -->
          <div id="checked_company_box" class="selected_company_box">
            <p>比較するエージェント会社</p>

          </div>
        </div>
      </div>
    </section>
  </main>

  <script>
    /* 
     比較チェックボタンついた会社を一時表示するボックスの関数
    */

      function checked_counter(){
        let compare_checked_buttons = document.getElementsByName("select_company_checkboxes");
        let len = compare_checked_buttons.length;
        for (let i = 0; i < len; i++){
            if (compare_checked_buttons.item(i).checked){
                console.log(compare_checked_buttons.item(i).value + ' is checked');
                let box_contents = "";
                box_contents = compare_checked_buttons.item(i).value;
                document.getElementById('checked_company_box').insertAdjacentHTML('beforeend', box_contents);
            }else{
                console.log(compare_checked_buttons.item(i).value + ' is not checked');
            }
        }      
      };

    // window.addEventListener('DOMContentLoaded', function(){

    //   // チェックボタンを取得
    // let compare_checked_buttons = document.getElementsByName("select_company_checkboxes");

      // compare_checked_buttons.addEventListener('change', checked_counter);
    //   // イベント「change」を登録
    //   compare_checked_buttons.addEventListener("change",function checked_counter(){
    //     let len = compare_checked_buttons.length;
    //     for (let i = 0; i < len; i++){
    //         if (compare_checked_buttons.item(i).checked){
    //             console.log(compare_checked_buttons.item(i).value + ' is checked');
    //         }else{
    //             console.log(compare_checked_buttons.item(i).value + ' is not checked');
    //         }
    //     }
    //   });
        // });

	</script>
</body>

</html>