DROP DATABASE IF EXISTS craft;
CREATE DATABASE craft;

USE craft;

-- ユーザーテーブル
DROP TABLE IF EXISTS users;
CREATE TABLE users
(
  id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  university VARCHAR(255) NOT NULL,
  department VARCHAR(255) NOT NULL,
  grad_year VARCHAR(255) NOT NULL,
  mail VARCHAR(255) NOT NULL,
  phone_number VARCHAR(255) NOT NULL,
  address VARCHAR(255) NOT NULL,
  -- rep VARCHAR(255) DEFAULT '未設定',
  delete_flg INT NOT NULL DEFAULT 0
);

INSERT INTO users (name, university, department, grad_year, mail, phone_number, address) VALUES 
('鈴木花子', '〇〇大学', '学部', '24年春', 'marumaru@gmail.com', '080-5432-1987','〇県△市'),
('佐藤太郎', '〇△大学', '学部', '24年春', 'marusankaku@gmail.com', '080-5432-1988','△県〇市'),
('田中一郎', '△〇大学', '学部', '24年秋', 'sankakumaru@gmail.com', '080-5432-1989','△県〇市'),
('山田かな', '△△大学', '学部', '25年春', 'sankakusankaku@gmail.com', '080-5432-1990','△県△市'),
('加藤ゆう', '〇〇大学', '学部', '25年春', 'marusankakubatu@gmail.com', '080-5432-1991','〇県〇市');


-- エージェント契約情報テーブル
DROP TABLE IF EXISTS company;
CREATE TABLE company
(
  id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
  company_name VARCHAR(255) NOT NULL,
  phone_number VARCHAR(255) NOT NULL,
  mail_contact VARCHAR(255) NOT NULL,
  mail_manager VARCHAR(255) NOT NULL,
  mail_notification VARCHAR(255) NOT NULL,
  representative VARCHAR(255) NOT NULL,
  address VARCHAR(255) NOT NULL,
  company_url VARCHAR(255) NOT NULL,
  delete_flg INT NOT NULL DEFAULT 0
);

INSERT INTO company (company_name, phone_number, mail_contact, mail_manager, mail_notification, representative, address, company_url) VALUES 
('キャリタス', '0120-845-188', 'aaaaiiiiuuuu@gmail.com', 'ssssmmmmllll@gmail.com', 'suzuki@gmail.com', '赤い', '東京都文京区後楽2-5-1 飯田橋ファーストビル9階','https://www.disc.co.jp/'),
('株式会社サポーターズ', '03-4577-1466', 'aaaauuuuiiii@gmail.com', 'mmmmssssllll@gmail.com', 'satouu@gmail.com', '世良', '△県〇市','東京都渋谷区道玄坂１丁目２１−１ 渋谷ソラスタ15F'),
('就活エージェント　neo', '03-5908-8058', 'iiiiaaaauuuu@gmail.com', 'ssssllllmmmm@gmail.com', 'tanaka@gmail.com', '毛利', '東京都新宿区西新宿1-22-2 新宿サンエービル 2階','https://careerstart.co.jp/company'),
('キャリアスタート', '03-6271-8585', 'iiiiuuuuaaaa@gmail.com', 'mmssssmmllll@gmail.com', 'yamada@gmail.com', '安室', '東京都港区新橋2丁目6-2 アイマークビル8階', 'marumruurl.com'),
(' DiG UP CAREER', '080-4618-2189', 'aaaauuuuuduu@gmail.com', 'llllssssmmmm@gmail.com', 'katouu@gmail.com', '諸星', '東京都渋谷区東3-14-15','https://nas-inc.co.jp/');



-- エージェント掲載情報テーブル
DROP TABLE IF EXISTS company_posting_information;
CREATE TABLE company_posting_information
(
  id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
  company_id INT NOT NULL,
  logo VARCHAR(255) NOT NULL,
  name VARCHAR(255) NOT NULL,
  img VARCHAR(255) NOT NULL,
  industries VARCHAR(255) NOT NULL,
  achievement VARCHAR(255) NOT NULL,
  type VARCHAR(255) NOT NULL,
  delete_flg INT NOT NULL DEFAULT 0
);

INSERT INTO company_posting_information (company_id, logo, name, img, industries, achievement, type) VALUES 
(1,'boozer_logo.png', '株式会社　ディスコ', 'boozer_logo.png', 'IT,商社,小売り,金融', '年間500以上のツール制作', '文系'),
(2, 'shukatsu_logo.png', '株式会社サポーターズ', 'makiko.jpg', 'サービス,IT,商社', '全職種対象マッチングメディアサービス', '文系'),
(3, './src/admin/img/logo/', '株式会社ネオキャリア', './src/admin/img/img/', '商社,サービス', '顧客数No.1', '理系'),
(4, './src/admin/img/logo/', '山田会社', './src/admin/img/img/', '小売り,金融,通信', '顧客満足度９０%', '体育会'),
(5, './src/admin/img/logo/', '加藤会社', './src/admin/img/img/', '金融,通信,マスコミ', '利用学生数１０万人', '文系');



-- 実績のテーブル(数値ベース)
DROP TABLE IF EXISTS company_achievement;
CREATE TABLE company_achievement
(
  achievement_id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
  company_id INT NOT NULL,
  -- 求人数
  job_offer_number VARCHAR(255) NOT NULL,
  -- 紹介企業数
  company_number VARCHAR(255) NOT NULL,
  -- 利用学生数
  user_count VARCHAR(255) NOT NULL,
  -- 昨年の利用学生数
  user_count_last_year VARCHAR(255) NOT NULL,
  -- 内定率
  informal_job_offer_rate VARCHAR(255) NOT NULL,
  -- 満足度
  satisfaction_degrees VARCHAR(255) NOT NULL
);

INSERT INTO company_achievement (company_id, job_offer_number, company_number, user_count, user_count_last_year,  informal_job_offer_rate, satisfaction_degrees) VALUES 
(1, '12000件', '7000社', '1万人', '1819人', '30%', '89%'),
(2, '1000件', '500社', '年間7000人以上', '819人', '5.4倍', '89%'),
(3, '34000件程度', '10000社以上', '年間18万人', '3181人', '30%', '88%'),
(4, '1000件以上', '40社', '1万人', '400人', '40%', '80%'),
(5, '1060人', '300社', '6500人', '1819人', '29%', '89%');



-- サービス（〇×についてのテーブル）
DROP TABLE IF EXISTS company_service;
CREATE TABLE company_service
(
  service_id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
  company_id INT NOT NULL,
  --  ES添削
  ES_correction boolean NOT NULL,
  -- 面接対策
  interview boolean NOT NULL,
  -- インターン
  internship boolean NOT NULL,
  -- セミナー
  seminar boolean NOT NULL,
  -- 研修
  training boolean NOT NULL,
  -- 地方学生支援
  regional_student_support boolean NOT NULL,
  -- 限定講座
  limited_course boolean NOT NULL,
  -- 適性診断
  competence_diagnosis boolean NOT NULL,
  -- 特別選考
  special_selection boolean NOT NULL
);

INSERT INTO company_service (company_id, ES_correction, interview, internship, seminar, training, regional_student_support, limited_course, competence_diagnosis, special_selection) VALUES 
(1, true, true, true, true, true, false, true, true, false),
(2, true, false, true, true, false, true, true, false, false),
(3, true, true, false, true, true, false, false, true, false),
(4, true, true, false, true, false, true, true, false, false),
(5, true, true, false, false, false, false, true, false, false);

-- 企業説明
DROP TABLE IF EXISTS company_feature;
CREATE TABLE company_feature
(
  feature_id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
  company_id INT NOT NULL,
  feature_first VARCHAR(255) NOT NULL,
  feature_second VARCHAR(255) NOT NULL,
  feature_third VARCHAR(255) NOT NULL,
  feature_sub_first VARCHAR(255) NOT NULL,
  feature_sub_second VARCHAR(255) NOT NULL,
  feature_sub_third VARCHAR(255) NOT NULL,
  message VARCHAR(255) NOT NULL
);

INSERT INTO company_feature (company_id, feature_first, feature_second, feature_third, feature_sub_first,feature_sub_second,feature_sub_third,message) VALUES 
(1, 'マッチング度が高い', 'いいいいいいいいい', 'VISITS OBとの併用', '学生・企業が相互に「きになる」を送れる', 'iiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiii', '業界の最先端で私語をする人とマッチングができる','messageeeeeeeee'),
(2, '幅広い業界を紹介', '支援金支給が業界トップクラス', 'オリジナルイベント開催', '学生・企業が相互に「きになる」を送れる', '最大３万円の交通費支給！', 'イベントを通して様々な情報を知ることができる！','messageeeeeeeee'),
(3, '掲載数が多い', '紹介企業の採用ニーズが知れる', 'サービス全面無料', 'ナビサイトにない非公開求人の取り扱い多数', '初めての方でも、コンサルタントと一緒にES対策を有利に進められる。', '種類豊富な支給金制度でお金の心配がなくなる！','messageeeeeeeee'),
(4, '徹底したマンツーマンフルサポート', '敏腕キャリアコンサルタント', '未経験OK求人多数', 'ESの対策からフルサポート。未経験者でも安心です。', '内定率80%越えを実現する経験豊富なコンサル短tpが成功に導きます。', '未経験OK求人1000件以上、仕事内容・条件などあなたに合った求人に出合えます。','messageeeeeeeee'),
(5, '手厚いサポート', '理解が深まる', '寄り添ったサービス', '就活のプロ（元人事・人材会社出身）がLINEも使って親身', '企業選び・自己理解のプロによる就活セミナーが受けられる', '就活生に無理強いしない寄り添ったサービスで、友人紹介も60%超！','messageeeeeeeee');




-- 会社概要、取り扱い
DROP TABLE IF EXISTS company_overview;
CREATE TABLE company_overview
(
  overview_id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
  company_id INT NOT NULL,
  -- 歴史（創業年）
  history VARCHAR(255) NOT NULL,
  -- 従業員数
  employee_number VARCHAR(255) NOT NULL,
  -- 資本金
  capital VARCHAR(255) NOT NULL,
  -- 取り扱い地域
  handling_area VARCHAR(255) NOT NULL,
  -- 取り扱い業種
  handling_industries VARCHAR(255) NOT NULL,
  -- 取り扱い職種
  handling_job_category VARCHAR(255) NOT NULL,
  -- 主な就職先
  main_finding_employment_target VARCHAR(255) NOT NULL,
  -- 面談形式
  interview_format VARCHAR(255) NOT NULL,
  -- 面談場所
  interview_location VARCHAR(255) NOT NULL
);

INSERT INTO company_overview (company_id, history, employee_number, capital, handling_area, handling_industries, handling_job_category, main_finding_employment_target, interview_format, interview_location) VALUES 
(1, '1970年創業', '100人', '1000万円', '日本（主に関東）、海外', 'IT、インターネット、メーカー、商社、コンサルティング、マスコミ、エンターテインメント、メディカル', '経営、管理、マーケティング、営業、コンサルタント、専門職、ゲーム、電気・電子、人事、工事、土木、広告', "'dnvsd.png','vsuus.png','vfdnv.png'", 'オンライン', 'オンライン'),
(2, '1970年創業', '100人', '1000万円', '日本（主に関東）、海外', 'IT、インターネット、メーカー、商社、コンサルティング、マスコミ、エンターテインメント、メディカル', '経営、管理、マーケティング、営業、コンサルタント、専門職、ゲーム、電気・電子、人事、工事、土木、広告', "'dnvsd.png','vsuus.png','vfdnv.png'", 'オンライン', 'オンライン'),
(3, '1970年創業', '100人', '1000万円', '日本（主に関東）、海外', 'IT、インターネット、メーカー、商社、コンサルティング、マスコミ、エンターテインメント、メディカル', '経営、管理、マーケティング、営業、コンサルタント、専門職、ゲーム、電気・電子、人事、工事、土木、広告', "'dnvsd.png','vsuus.png','vfdnv.png'", 'オンライン', 'オンライン'),
(4, '1970年創業', '100人', '1000万円', '日本（主に関東）、海外', 'IT、インターネット、メーカー、商社、コンサルティング、マスコミ、エンターテインメント、メディカル', '経営、管理、マーケティング、営業、コンサルタント、専門職、ゲーム、電気・電子、人事、工事、土木、広告', "'dnvsd.png','vsuus.png','vfdnv.png'", 'オンライン', 'オンライン'),
(5, '1970年創業', '100人', '1000万円', '日本（主に関東）、海外', 'IT、インターネット、メーカー、商社、コンサルティング、マスコミ、エンターテインメント、メディカル', '経営、管理、マーケティング、営業、コンサルタント、専門職、ゲーム、電気・電子、人事、工事、土木、広告', "'dnvsd.png','vsuus.png','vfdnv.png'", 'オンライン', 'オンライン');

-- 学生・エージェント中間テーブル
DROP TABLE IF EXISTS company_user;

CREATE TABLE company_user
(
  id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
  user_id INT NOT NULL,
  company_id INT NOT NULL,
  rep VARCHAR(255) DEFAULT '未割り当て',
  contact_datetime DATETIME NOT NULL
);

INSERT INTO company_user (user_id, company_id, contact_datetime) VALUES 
(1, 1, '2022-04-30'),
(1, 2, '2022-05-22'),
(2, 1, '2022-05-23'),
(3, 4, '2022-05-24'),
(4, 3, '2022-05-23'),
(5, 5, '2022-06-01');



DROP TABLE IF EXISTS admin;


CREATE TABLE admin (
  id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
  email VARCHAR(255) UNIQUE NOT NULL,
  name VARCHAR(255) UNIQUE NOT NULL,
  password VARCHAR(255) NOT NULL,
  -- flagが１ならboozer,２ならエージェント
  flag INT NOT NULL,
  company_id INT,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO admin (email, name, password, flag, company_id) VALUES
('test@posse-ap.com', '小笹', sha1('password') , 1, NULL),
('a@a.com', '高木', sha1('a'), 2, 1),
('aa@a.com', '千葉', sha1('aa'), 2, 1),
('aaa@a.com', '目暮', sha1('aaa'), 2, 1),
('b@b.com', '佐藤', sha1('b'), 2, 2),
('c@c.com', '山本', sha1('c'), 2, 3),
('d@d.com', '佐', sha1('d'), 2, 4),
('e@d.com', '島', sha1('e'), 2, 5);


DROP TABLE IF EXISTS students;
CREATE TABLE students (
    id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    fname varchar(100),
    lname varchar(100),
    class varchar(100),
    section varchar(100)
);


INSERT INTO students (fname, lname, class, section) VALUES
('Ro', 'RYU', 'A', 'ONE'),
('Ko', 'KYU', 'B', 'TWO'),
('To', 'TYU', 'C', 'THREE');
