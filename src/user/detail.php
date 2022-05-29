<?php
require('./dbconnect.php');
$sql = 'SELECT
          company_posting_information.company_id AS company_id,
          company_posting_information.name AS name,
          company_posting_information.industries AS industries,
          company_posting_information.type AS type,
          company.address AS address,
          company_achievement.job_offer_number AS job_offer_number,
          company_achievement.company_number AS company_number,
          company_achievement.user_count AS user_count,
          company_achievement.user_count_last_year AS user_count_last_year,
          company_achievement.informal_job_offer_rate AS informal_job_offer_rate,
          company_achievement.satisfaction_degrees AS satisfaction_degrees,
          company_service.ES_correction AS ES_correction,
          company_service.interview AS interview,
          company_service.internship AS internship,
          company_service.seminar AS seminar,
          company_service.training AS training,
          company_service.regional_student_support AS regional_student_support,
          company_service.limited_course AS limited_course,
          company_service.competence_diagnosis AS competence_diagnosis,
          company_service.special_selection AS special_selection,
          company_feature.feature_first AS feature_first,
          company_feature.feature_second AS feature_second,
          company_feature.feature_third AS feature_third,
          company_feature.feature_sub_first AS feature_sub_first,
          company_feature.feature_sub_second AS feature_sub_second,
          company_feature.feature_sub_third AS feature_sub_third,
          company_feature.message AS message,
          company_overview.history AS history,
          company_overview.employee_number AS employee_number,
          company_overview.capital AS capital,
          company_overview.handling_area AS handling_area,
          company_overview.handling_industries AS handling_industries,
          company_overview.handling_job_category AS handling_job_category,
          company_overview.main_finding_employment_target AS main_finding_employment_target,
          company_overview.interview_format AS interview_format,
          company_overview.interview_location AS interview_location
          FROM company_posting_information
          INNER JOIN company
          ON  company_posting_information.company_id = company.id
          INNER JOIN company_achievement
          ON  company_posting_information.company_id = company_achievement.company_id
          INNER JOIN company_service
          ON  company_posting_information.company_id = company_service.company_id 
          INNER JOIN company_feature
          ON  company_posting_information.company_id = company_feature.company_id 
          INNER JOIN company_overview
          ON  company_posting_information.company_id = company_overview.company_id
          WHERE company_posting_information.company_id = ' . $_REQUEST["company_id"];
$stmt = $db->query($sql);
$stmt->execute();
$companies = $stmt->fetchAll();
$company = array_reduce($companies, 'array_merge', array());

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/parts.css">
  <link rel="stylesheet" href="../css/detail.css">
  <link rel="stylesheet" href="../css/detail_responsive.css">
  <title>企業詳細情報ページ</title>
</head>

<body>
  <header>
    <div class="header_wrapper">
      <div class="header_logo">
        <img src="../img/boozer_logo.png" alt="logo">
      </div>
    </div>
    <nav class="header_nav">
      <ul>
        <li class="nav_item"><a href="./top.php#company">企業一覧</a></li>
        <li class="nav_item"><a href="./top.php#point">お悩みの方へ</a></li>
        <li class="nav_item"><a href="./top.php#merit">比較のメリット</a></li>
        <li class="nav_item"><a href="./top.php#question">よくある質問</a></li>
        <!-- 時間あったらモーダルにしてちょっと就活エージェントのこと書いて、就活の教科書の特集に飛ばせるかも -->
        <li class="nav_item"><a href="#">就活エージェントとは</a></li>
        <!-- ここまで -->
        <li class="nav_item"><a href="#">企業の方へ</a></li>
      </ul>
    </nav>
  </header>
  <!-- header下の全体 -->
  <main class="main main_wrapper">
    <!-- トップページ写真 -->
    <div class="detail_top_page_img">
      <img src="../img/company3.png">
    </div>
    <!-- タイトル -->
    <div class="detail_title">
      <h1>会社詳細情報</h1>
    </div>
    <!-- メインコンテンツとサイドバー覆うdiv -->
    <div class="company_detail_container">
      <!-- ここからメインコンテンツ -->
      <div class="company_detail_main">
        <!-- 強み・特徴 -->
        <section class="detail_section_strength section" id="detail.strength">
          <div>
            <h2 class="section_title">強み・特徴</h2>
          </div>
          <div class="strength_contents">
            <div class="strength_each_content">
              <p class="strength_list"><?= $company['feature_first'] ?></p>
              <p class="strength_small"><?= $company['feature_sub_first'] ?></p>
            </div>
            <div class="strength_each_content">
              <p class="strength_list"><?= $company['feature_second'] ?></p>
              <p class="strength_small"><?= $company['feature_sub_second'] ?></p>
            </div>
            <div class="strength_each_content">
              <p class="strength_list"><?= $company['feature_third'] ?></p>
              <p class="strength_small"><?= $company['feature_sub_third'] ?></p>
            </div>
          </div>
        </section>
        <!-- 実績テーブル -->
        <section class="detail_section_achievement section" id="detail.achievement">
          <div>
            <h2 class="section_title">実績</h2>
          </div>
          <dl class='detail_section_support_list'>
            <dt class="detail_section_support_list_titile_dt">実績内容</dt>
            <dd class="detail_section_support_list_titile_dd">数字</dd>
            <dt>求人数</dt>
            <dd>
              <?= $company['job_offer_number'] ?>
            </dd>
            <dt>紹介企業数</dt>
            <dd>
              <?= $company['company_number'] ?>
            </dd>
            <dt>利用学生数</dt>
            <dd>
              <?= $company['user_count'] ?>
            </dd>
            <dt>昨年の利用学生数</dt>
            <dd>
              <?= $company['user_count_last_year'] ?>
            </dd>
            <dt>内定率</dt>
            <dd>
              <?= $company['informal_job_offer_rate'] ?>
            </dd>
            <dt>満足度</dt>
            <dd>
              <?= $company['satisfaction_degrees'] ?>
            </dd>
          </dl>
        </section>


        <!-- サポートテーブル -->
        <section class='detail_section_support section' id="detail_support">
          <div class="company_contract_information">
            <div>
              <h2 class="section_title">サポート</h2>
            </div>
            <dl class='detail_section_support_list'>
              <dt class="detail_section_support_list_titile_dt">サポート内容</dt>
              <dd class="detail_section_support_list_titile_dd">有無</dd>
              <dt>ES添削</dt>
                <? if ($company['ES_correction'] = 1) : ?>
                  <dd>〇</dd>
                <? else : ?>
                  <dd>✕</dd>
                <? endif; ?>
              <dt>面接対策</dt>
                 <? if ($company['interview'] = 1) : ?>
                   <dd>〇</dd>
                 <? else : ?>
                   <dd>✕</dd>
                 <? endif; ?>
              <dt>インターン</dt>
                 <? if ($company['internship'] = 1) : ?>
                   <dd>〇</dd>
                 <? else : ?>
                   <dd>✕</dd>
                 <? endif; ?>
              <dt>セミナー</dt>
                 <? if ($company['seminar'] = 1) : ?>
                   <dd>〇</dd>
                 <? else : ?>
                   <dd>✕</dd>
                 <? endif; ?>
              <dt>研修</dt>
                 <? if ($company['training'] = 1) : ?>
                   <dd>〇</dd>
                 <? else : ?>
                   <dd>✕</dd>
                 <? endif; ?>
              <dt>地方学生支援</dt>
                 <? if ($company['regional_student_support'] = 1) : ?>
                   <dd>〇</dd>
                 <? else : ?>
                   <dd>✕</dd>
                 <? endif; ?>
              <dt>限定講座</dt>
                 <? if ($company['limited_course'] = 1) : ?>
                   <dd>〇</dd>
                 <? else : ?>
                   <dd>✕</dd>
                 <? endif; ?>
              <dt>特別選考</dt>
                 <? if ($company['special_selection'] = 1) : ?>
                   <dd>〇</dd>
                 <? else : ?>
                   <dd>✕</dd>
                 <? endif; ?>
            </dl>
          </div>
        </section>

        <!-- 先輩の就職先ロゴ -->
        <section class='detail_section_finding_employment_target section' id="detail.finding_employment_target">
          <div>
            <h2 class="section_title">就職先</h2>
          </div>
          <div class="finding_employment_target_logo_container">
            <div>
              <img src="../img/og_image_logo.png">
            </div>
            <div>
              <img src="../img/og_image_logo.png">
            </div>
            <div>
              <img src="../img/makiko.jpg">
            </div>
            <div>
              <img src="../img/og_image_logo.png">
            </div>
            <div>
              <img src="../img/og_image_logo.png">
            </div>
            <div>
              <img src="../img/makiko.jpg">
            </div>
            <div>
              <img src="../img/makiko.jpg">
            </div>
            <div>
              <img src="../img/makiko.jpg">
            </div>
            <div>
              <img src="../img/makiko.jpg">
            </div>
          </div>
        </section>
        <!-- 企業からのメッセージ -->
        <section class="detail_section_message section" id="detail.message">
          <div>
            <h2 class="section_title">企業からのメッセージ</h2>
          </div>
          <div class="detail_section_message_content">
            <p><?= $company['message'] ?></p>
          </div>
        </section>
        <!-- 会社情報テーブル -->
        <section class='detail_section_company_information section' id="detail.information">
          <div class="company_contract_information">
            <div>
              <h2 class="section_title">会社情報</h2>
            </div>
            <dl class='detail_section_company_information_list'>
              <dt>歴史</dt>
              <dd>
                <?= $company['history'] ?>
              </dd>
              <dt>従業員数</dt>
              <dd>
                <?= $company['employee_number'] ?>
              </dd>
              <dt>資本金</dt>
              <dd>
                <?= $company['capital'] ?>
              </dd>
              <dt>住所</dt>
              <dd>
                <?= $company['capital'] ?>
              </dd>
              <dt>面接形式</dt>
              <dd>
                <?= $company['interview_format'] ?>
              </dd>
              <dt>面接場所</dt>
              <dd>
                <?= $company['interview_location'] ?>
              </dd>
              <dt>取り扱い地域</dt>
              <dd>
                <?= $company['handling_area'] ?>
              </dd>
              <dt>取り扱い業種</dt>
              <dd>
                <?= $company['handling_industries'] ?>
              </dd>
              <dt>取り扱い職種</dt>
              <dd>
                <?= $company['handling_job_category'] ?>
              </dd>
          </div>
        </section>
      </div>
      <!-- ここからサイドバー -->
      <div class="company_detail_side">
        <div class="sticky">
          <div class="side_title">
            <h3>目次</h3>
          </div>
          <ul class="company_detail_side_ul">
            <a href="#detail.strength">
              <li>強み・特徴</li>
            </a>
            <a href="#detail.finding_employment_target">
              <li>就職先</li>
            </a>
            <a href="#detail.support">
              <li>サポート</li>
            </a>
            <a href="#detail.achievement">
              <li>実績</li>
            </a>
            <a href="#detail.information">
              <li>会社情報</li>
            </a>
            <a href="#detail.message">
              <li>企業からのメッセージ</li>
            </a>
          </ul>
        </div>
      </div>
    </div>



    <!-- ボタン追加 -->
    <div class="float_button">
      <div class="company_box_button">
        <a href="./contact/contactform.php?company_id=<?= h($company['company_id']); ?>" class="inquiry">お問い合わせ</a>
      </div>
      <div>
        <button><a href="./top.php">戻る</a></button>
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
</body>

</html>
