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
('鈴木会社', '0120-3456-1987', 'aaaaiiiiuuuu@gmail.com', 'ssssmmmmllll@gmail.com', 'suzuki@gmail.com', '赤井', '〇県△市','marumaruurl.com'),
('佐藤会社', '0120-3456-1988', 'aaaauuuuiiii@gmail.com', 'mmmmssssllll@gmail.com', 'satouu@gmail.com', '世良', '△県〇市','marumaruurl.com'),
('田中会社', '0120-3456-1989', 'iiiiaaaauuuu@gmail.com', 'ssssllllmmmm@gmail.com', 'tanaka@gmail.com', '毛利', '△県〇市','marumaruurl.com'),
('山田会社', '0120-3456-1990', 'iiiiuuuuaaaa@gmail.com', 'mmssssmmllll@gmail.com', 'yamada@gmail.com', '安室', '△県△市', 'marumruurl.com'),
('加藤会社', '0120-3456-1991', 'aaaauuuuuduu@gmail.com', 'llllssssmmmm@gmail.com', 'katouu@gmail.com', '諸星', '〇県〇市','marumaruurl.com');



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
(1,'boozer_logo.png', '鈴木会社', 'boozer_logo.png', 'IT,商社,小売り,金融', '満足度９８％', '理系'),
(2, 'shukatsu_logo.png', '佐藤会社', 'makiko.jpg', 'サービス', '内定率４０％', '文系'),
(3, './src/admin/img/logo/', '田中会社', './src/admin/img/img/', '商社,サービス', '顧客数No.1', '理系'),
(4, './src/admin/img/logo/', '山田会社', './src/admin/img/img/', '小売り,金融', '顧客満足度９０%', '理系'),
(5, './src/admin/img/logo/', '加藤会社', './src/admin/img/img/', '金融', '利用学生数１０万人', '文系');



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
(1, '100万人', '120社', '10万人', '1819人', '30%', '89%'),
(2, '1000人', '20社', '1万人', '819人', '50%', '89%'),
(3, '34445人', '220社', '50万人', '3181人', '30%', '88%'),
(4, '10030人', '40社', '1万人', '319人', '40%', '60%'),
(5, '1060人', '10社', '30万人', '1819人', '29%', '89%');



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
(1, true, true, true, true, true, true, true, true, true),
(2, true, false, true, true, true, false, true, true, true),
(3, true, true, true, true, false, true, true, true, false),
(4, false, true, true, true, true, true, false, true, true),
(5, true, false, true, false, true, false, true, true, false);

-- 企業説明
DROP TABLE IF EXISTS company_feature;
CREATE TABLE company_feature
(
  feature_id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
  company_id INT NOT NULL,
  feature VARCHAR(255) NOT NULL,
  message VARCHAR(255) NOT NULL
);

INSERT INTO company_feature (company_id, feature, message) VALUES 
(1, '➀すごい➁やばい➂ｖｂｋｆｖばえうヴぁえいうヴぇらいうあえいうｒヴあｆｄヴあｄｊ', 'ｆヴあヴあヴぁｓｄヴぁｓｊｋｄｖｊｋｓｄヴぁｓｊｄヴぁｊｓｋ'),
(2, '➀すごい➁やばい➂ｖｂｋｆｖばえうヴぁえいうヴぇらいうあえいうｒヴあｆｄヴあｄｊ', 'ｆヴあヴあヴぁｓｄヴぁｓｊｋｄｖｊｋｓｄヴぁｓｊｄヴぁｊｓｋ'),
(3, '➀すごい➁やばい➂ｖｂｋｆｖばえうヴぁえいうヴぇらいうあえいうｒヴあｆｄヴあｄｊ', 'ｆヴあヴあヴぁｓｄヴぁｓｊｋｄｖｊｋｓｄヴぁｓｊｄヴぁｊｓｋ'),
(4, '➀すごい➁やばい➂ｖｂｋｆｖばえうヴぁえいうヴぇらいうあえいうｒヴあｆｄヴあｄｊ', 'ｆヴあヴあヴぁｓｄヴぁｓｊｋｄｖｊｋｓｄヴぁｓｊｄヴぁｊｓｋ'),
(5, '➀すごい➁やばい➂ｖｂｋｆｖばえうヴぁえいうヴぇらいうあえいうｒヴあｆｄヴあｄｊ', 'ｆヴあヴあヴぁｓｄヴぁｓｊｋｄｖｊｋｓｄヴぁｓｊｄヴぁｊｓｋ');




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




-- -- エージェント掲載情報テーブル
-- DROP TABLE IF EXISTS company_posting_information;
-- CREATE TABLE company_posting_information
-- (
--   id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
--   company_id INT NOT NULL,
--   logo VARCHAR(255) NOT NULL,
--   name VARCHAR(255) NOT NULL,
--   img VARCHAR(255) NOT NULL,
--   industries VARCHAR(255) NOT NULL,
--   achievement VARCHAR(255) NOT NULL,
--   type VARCHAR(255) NOT NULL,
--   catch_copy VARCHAR(255) NOT NULL,
--   information VARCHAR(255) NOT NULL,
--   strength VARCHAR(255) NOT NULL,
--   job_offer_number VARCHAR(255) NOT NULL,
--   user_count VARCHAR(255) NOT NULL,
--   informal_job_offer_rate VARCHAR(255) NOT NULL,
--   satisfaction_degrees VARCHAR(255) NOT NULL,
--   finding_employment_target VARCHAR(255) NOT NULL,
--   ES boolean NOT NULL,
--   interview boolean NOT NULL,
--   limited_course boolean NOT NULL,
--   competence_diagnosis boolean NOT NULL,
--   special_selection boolean NOT NULL,
--   interview_style VARCHAR(255) NOT NULL,
--   location VARCHAR(255) NOT NULL,
--   delete_flg INT NOT NULL
-- );

-- INSERT INTO company_posting_information (company_id, logo, name, img, industries, achievement, type, catch_copy, information, strength, job_offer_number, user_count, informal_job_offer_rate, satisfaction_degrees, finding_employment_target, ES, interview, limited_course, competence_diagnosis, special_selection, interview_style, location, delete_flg) VALUES 
-- (1, './src/admin/img/logo/', '鈴木会社', './src/admin/img/img/', 'IT', '満足度９８％', '理系', 'dream', '鈴木会社は～で、実績が～で、…', '強み', '1千万人', '2千万人', '90%', '89%', 'IT企業', true, true, true, true, true, 'オンライン', 'オンライン', 0),
-- (2, './src/admin/img/logo/', '佐藤会社', './src/admin/img/img/', 'サービス', '内定率４０％', '文系', 'dream', '佐藤会社は～で、実績が～で、…', '強み', '1千万人', '2千万人', '90%', '89%', 'IT企業', true, false, true, true, true, 'オンライン', 'オンライン', 0),
-- (3, './src/admin/img/logo/', '田中会社', './src/admin/img/img/', '商社', '顧客数No.1', '理系', 'dream', '田中会社は～で、実績が～で、…', '強み', '1千万人', '2千万人', '90%', '89%', 'IT企業', true, true, false, false, true, 'オンライン', 'オンライン', 0),
-- (4, './src/admin/img/logo/', '山田会社', './src/admin/img/img/', '小売り', '顧客満足度９０%', '理系', 'dream', '山田会社は～で、実績が～で、…', '強み', '1千万人', '2千万人', '90%', '89%', 'IT企業', true, true, true, false, true, '対面', '都心', 0),
-- (5, './src/admin/img/logo/', '加藤会社', './src/admin/img/img/', '金融', '利用学生数１０万人', '文系', 'dream', '加藤会社は～で、実績が～で、…', '強み', '1千万人', '2千万人', '90%', '89%', 'IT企業', true, true, true, true, false, 'オンライン', 'オンライン', 0);


-- -- 管理者画面ログインテーブル
-- DROP TABLE IF EXISTS admin;
-- CREATE TABLE admin
-- (
--   id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
--   company_id INT NOT NULL,
--   password VARCHAR(255) NOT NULL,
--   mail_admin VARCHAR(255) NOT NULL,
--   delete_flg INT NOT NULL
-- );

-- INSERT INTO admin (password, company_id, mail_admin, delete_flg) VALUES 
-- ('aaaaaa', 1, 'ssssmmmmllll@gmail.com', 0),
-- ('bbbbbb', 2, 'mmmmssssllll@gmail.com', 0),
-- ('cccccc', 3, 'ssssllllmmmm@gmail.com', 0),
-- ('dddddd', 4, 'mmssssmmllll@gmail.com', 0),
-- ('eeeeee', 5, 'llllssssmmmm@gmail.com', 0);


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



-- DROP TABLE IF EXISTS userss;
-- CREATE TABLE userss
-- (
--   `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
--   `name` VARCHAR(45) NOT NULL COMMENT '名前',
--   `sex` INT UNSIGNED NOT NULL COMMENT '性別\n1:男\n2:女',
--   `age` INT UNSIGNED NOT NULL COMMENT '年齢',
--   `valid` INT UNSIGNED NOT NULL,
--   PRIMARY KEY (`id`)
--   );

-- INSERT INTO userss (name, sex, age, valid) VALUES
-- ('田中太郎', '1', '26', '1'),
-- ('山田花子', '2', '16', '1'),
-- ('高橋正樹', '1', '18', '1'),
-- ('金子優子', '2', '31', '1'),
-- ('吉井佳子', '2', '21', '1'),
-- ('橘勇気', '1', '13', '1'),
-- ('小林隆', '1', '39', '1'),
-- ('影山夏生', '1', '11', '0'),
-- ('加藤裕太', '1', '23', '1'),
-- ('後藤由美', '2', '20', '1');






-- 以下サンプルデータ
-- DROP SCHEMA IF EXISTS craft;

-- CREATE SCHEMA craft;

-- USE craft;

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

-- INSERT INTO
--   admin
-- SET
--   email = 'test@posse-ap.com',
--   password = sha1('password');

-- DROP TABLE IF EXISTS events;

-- CREATE TABLE events (
--   id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
--   title VARCHAR(255) NOT NULL,
--   created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
--   updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
-- );

-- INSERT INTO
--   events
-- SET
--   title = 'イベント1';

-- INSERT INTO
--   events
-- SET
--   title = 'イベント2';

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
