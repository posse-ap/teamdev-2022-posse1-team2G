<?php
require('./dbconnect.php');

$sql = 'SELECT * FROM company_posting_information';
$stmt = $db->query($sql);
$stmt->execute();
$companies = $stmt->fetchAll();


//セッションを開始
session_start();

//セッションIDを更新して変更（セッションハイジャック対策）
session_regenerate_id(TRUE);
//エスケープ処理やデータをチェックする関数を記述したファイルの読み込み
require '../libs/functions.php';

//NULL 合体演算子を使ってセッション変数を初期化（PHP7.0以降）
$id = $_SESSION['id'] ?? NULL;

//CSRF対策のトークンを生成
if (!isset($_SESSION['ticket'])) {
  //セッション変数にトークンを代入
  $_SESSION['ticket'] = bin2hex(random_bytes(32));
}
//トークンを変数に代入（隠しフィールドに挿入する値）
$ticket = $_SESSION['ticket'];

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>就活エージェント比較サイト</title>
  <link rel="stylesheet" href="../css/reset.css">
  <!-- fontawesomw追加 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
  <link rel="stylesheet" href="../css/style.css">
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
  <main>
    <div class="top">
      <div class="top_wrapper top_trapezoid_right">
        <div class="top_sentence">
          <h1>自分に合った企業が見つかる</h1>
        </div>
        <!-- PHP側で作って貰った検索機能 -->
        <div class='search_empty'></div>

        <!-- ここまで -->
      </div>
    </div>
    <div class="top_search">
      <?php require('./search.php') ?>
    </div>
    <section id="company" class="back_color">
      <div class="company_wrapper">
        <div class="title_box">
          <h2>企業一覧</h2>
          <p>COMPANY LIST</p>
        </div>
        <div class="company_list">
          <!-- 一つの会社ボックス -->
          <?php foreach ($companies as $company) : ?>
            <a href="./detail.php?company_id='<?= $company['company_id']; ?>'">
              <div class="company_box">
                <div class="company_box_logo">
                  <!-- <img src="../img/'<? $company["logo"]; ?>'" alt=""> -->
                  <img src="../img/boozer_logo.png" alt="">
                  <!-- <img src="../img/rikunabi.png" alt=""> -->
                </div>
                <div class="company_box_name">
                  <p><?= $company['name']; ?></p>
                </div>
                <div class="company_box_img">
                  <img src="../img/company1.png" alt="">
                </div>
                <div class="company_box_info">
                  <div class="company_info_first">
                    <i class="fa-solid fa-briefcase"></i>
                    <p class="capital">業種</p>
                    <p><?= $company['industries']; ?></p>
                  </div>
                  <div class="company_info_second">
                    <i class="fa-solid fa-trophy"></i>
                    <p class="capital">実績</p>
                    <p><?= $company['achievement']; ?>%</p>
                  </div>
                  <div class="company_info_third">
                    <i class="fa-solid fa-hand-point-up"></i>
                    <p class="capital">おすすめ</p>
                    <!-- ここら辺もしphpなら二つのp要素くっつけてもいいかもです -->
                    <p><?= $company['type']; ?></p>
                    <!-- ここまで -->
                  </div>
                </div>
                <div class="company_box_exp">
                  <p>マイナビ新卒紹介はあああああああああああああああああああ</p>
                </div>
                <div class='button_container'>
                  <div class="company_box_check">
                    <label for="check"><input type="checkbox" id='check' name="select_company_checkboxes" value="<?= $company['company_id']; ?>-<?= $company['name']; ?>" onchange="checked_counter()">比較する</label>
                  </div>
                  <div class="company_box_button">
                    <a href="./contact/contactform.php?company_id=<?= h($company['company_id']); ?>" class="inquiry">お問い合わせ</a>
                  </div>
                  <a class="page_change" href="../html/result.html"></a>
                </div>
              </div>
            </a>
          <?php endforeach; ?>
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
      </div>
    </section>
    <section id="problem">
      <div class="title_box">
        <h2>お悩みの方へ</h2>
        <p>WHAT IS PROBLEM</p>
      </div>
    </section>
    <!-- 比較のメリットのコーナー -->
    <section id="merit">
      <div class="title_box">
        <h2>比較のメリット</h2>
        <p>MERIT OF COMPARISON</p>
      </div>
      <div class="merit_list">
        <div class="merit_box">
          <h3></h3>
          <p></p>
        </div>
      </div>
    </section>
    <!-- ここまで -->
    <!-- よくある質問のコーナー -->
    <section id="question" class="back_color">
      <div class="title_box">
        <h2>よくある質問</h2>
        <p>QUESTION AND ANSWER</p>
      </div>
      <div class="question_wrapper">
        <ul class="question_list">
          <li>
            <div class="question_box">
              <div class="question_box_txt">
                <span class="question_capital">Q.</span>
                <h3>本当に無料で利用できますか？</h3>
              </div>
            </div>
            <div class="answer_box">
              <div class="answer_box_txt">
                <span class="answer_capital">A.</span>
                <p>当サイトは掲載を依頼して下さる企業様からいただく、紹介手数料により事業が成り立っています。そのため、当サイトのご利用者様からは一切料金をいただいておりませんので、安心してご利用ください。</p>
              </div>
            </div>
          </li>
          <li>
            <div class="question_box">
              <div class="question_box_txt">
                <span class="question_capital">Q.</span>
                <h3>今すぐ就職は考えていませんが、相談のみでも可能ですか？</h3>
              </div>
            </div>
            <div class="answer_box">
              <div class="answer_box_txt">
                <span class="answer_capital">A.</span>
                <p>多くのエージェント企業様は今後のキャリアプランを一緒に考えてくださり、相談のみの対応も積極的に受け付けられております。ぜひ、お気軽にお問い合わせください。</p>
              </div>
            </div>
          </li>
          <li>
            <div class="question_box">
              <div class="question_box_txt">
                <span class="question_capital">Q.</span>
                <h3>企業紹介の流れを教えてください。</h3>
              </div>
            </div>
            <div class="answer_box">
              <div class="answer_box_txt">
                <span class="answer_capital">A.</span>
                <p>まずお問い合わせを希望される企業を選択していただき、必要な情報を入力されましたら応募完了となります。その後、応募されました企業先から連絡が届きますので、その企業様と直接やりとりをしていただく流れとなっております。</p>
              </div>
            </div>
          </li>
          <li>
            <div class="question_box">
              <div class="question_box_txt">
                <span class="question_capital">Q.</span>
                <h3>応募したのですが連絡が返ってきません。</h3>
              </div>
            </div>
            <div class="answer_box">
              <div class="answer_box_txt">
                <span class="answer_capital">A.</span>
                <p>弊社担当者がご登録内容を確認した後、次のステップのご案内をいたします。通常、5営業日以内にはご連絡をさせていただいておりますが、1週間を過ぎても弊社から連絡がない場合は、何らかの理由で登録が完了していないあるいは登録内容に不備がある可能性がございますので、お手数をおかけいたしますが下記までご連絡ください。</p>
              </div>
            </div>
          </li>
          <li>
            <div class="question_box">
              <div class="question_box_txt">
                <span class="question_capital">Q.</span>
                <h3>一度応募しましたがキャンセルしたいです。</h3>
              </div>
            </div>
            <div class="answer_box">
              <div class="answer_box_txt">
                <span class="answer_capital">A.</span>
                <p>お手数ですが下記のメールアドレスよりお手続きをお願いいたします。</p>
              </div>
            </div>
          </li>
          <li>
            <div class="question_box">
              <div class="question_box_txt">
                <span class="question_capital">Q.</span>
                <h3>個人情報が漏れることはないですか？</h3>
              </div>
            </div>
            <div class="answer_box">
              <div class="answer_box_txt">
                <span class="answer_capital">A.</span>
                <p>当サイトからご応募いただいたご登録者様の個人情報はエージェント企業様へのご紹介のみを目的に使用しております。お預かりしている全ての個人情報はご本人様の許可なく、第三者に提供することは一切ございませんので、安心してご利用ください。</p>
              </div>
            </div>
          </li>
        </ul>
      </div>
    </section>
    <!-- ここまで -->
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
      <!-- <div class="footer_company">
        <p>企業の方へ</p>
        <ul class="footer_list">
          <li><a href="#">CRAFTについて</a></li>
          <li><a href="#">サイト掲載について</a></li>
        </ul>
      </div>
      <div class="footer_logo">
        <p>CRAFT</p>
      </div>
      <span class="footer_copyright">
        ©︎ 2022 CRAFT. All rights reserved.
      </span> -->
    </div>
  </footer>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="../js/script.js"></script>
  <!-- 比較ボタンの挙動（company_idの受け渡し）を記述したファイルの読み込み -->
  <script src="../js/to_compare_table.js"></script>
</body>

</html>