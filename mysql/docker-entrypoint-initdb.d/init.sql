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
  delete_flg INT NOT NULL
);

INSERT INTO users (name, university, department, grad_year, mail, phone_number, address, delete_flg) VALUES 
('鈴木花子', '〇〇大学', '学部', '24年春', 'marumaru@gmail.com', '080-5432-1987','〇県△市', 0),
('佐藤太郎', '〇△大学', '学部', '24年春', 'marusankaku@gmail.com', '080-5432-1988','△県〇市', 0),
('田中一郎', '△〇大学', '学部', '24年秋', 'sankakumaru@gmail.com', '080-5432-1989','△県〇市', 0),
('山田かな', '△△大学', '学部', '25年春', 'sankakusankaku@gmail.com', '080-5432-1990','△県△市', 0),
('加藤ゆう', '〇〇大学', '学部', '25年春', 'marusankakubatu@gmail.com', '080-5432-1991','〇県〇市', 0);


-- エージェント契約情報テーブル
DROP TABLE IF EXISTS company;
CREATE TABLE company
(
  id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
  company_name VARCHAR(255) NOT NULL,
  company_url VARCHAR(255) NOT NULL,
  representative VARCHAR(255) NOT NULL,
  mail_contact VARCHAR(255) NOT NULL,
  mail_manager VARCHAR(255) NOT NULL,
  mail_notification VARCHAR(255) NOT NULL,
  phone_number VARCHAR(255) NOT NULL,
  address VARCHAR(255) NOT NULL,
  delete_flg INT NOT NULL
);

INSERT INTO company (company_name, company_url, representative, mail_contact, mail_manager, mail_notification, phone_number, address, delete_flg) VALUES 
('鈴木会社', 'marumaruurl.com', '赤井', 'aaaaiiiiuuuu@gmail.com', 'ssssmmmmllll@gmail.com', 'marumaru@gmail.com', '0120-3456-1987','〇県△市', 0),
('佐藤会社', 'marumaruurl.com', '工藤', 'aaaauuuuiiii@gmail.com', 'mmmmssssllll@gmail.com', 'marusankaku@gmail.com', '0120-3456-1988','△県〇市', 0),
('田中会社', 'marumaruurl.com', '羽柴', 'iiiiaaaauuuu@gmail.com', 'ssssllllmmmm@gmail.com', 'sankakumaru@gmail.com', '0120-3456-1989','△県〇市', 0),
('山田会社', 'marumaruurl.com', '毛利', 'iiiiuuuuaaaa@gmail.com', 'mmssssmmllll@gmail.com', 'sankakusankaku@gmail.com', '0120-3456-1990','△県△市', 0),
('加藤会社', 'marumaruurl.com', '安室', 'aaaauuuuuuuu@gmail.com', 'llllssssmmmm@gmail.com', 'marusankakubatu@gmail.com', '0120-3456-1991','〇県〇市', 0);


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
  catch_copy VARCHAR(255) NOT NULL,
  information VARCHAR(255) NOT NULL,
  strength VARCHAR(255) NOT NULL,
  job_offer_number VARCHAR(255) NOT NULL,
  user_count VARCHAR(255) NOT NULL,
  informal_job_offer_rate VARCHAR(255) NOT NULL,
  satisfaction_degrees VARCHAR(255) NOT NULL,
  finding_employment_target VARCHAR(255) NOT NULL,
  ES boolean NOT NULL,
  interview boolean NOT NULL,
  limited_course boolean NOT NULL,
  competence_diagnosis boolean NOT NULL,
  special_selection boolean NOT NULL,
  interview_style VARCHAR(255) NOT NULL,
  location VARCHAR(255) NOT NULL,
  delete_flg INT NOT NULL
);

INSERT INTO company_posting_information (company_id, logo, name, img, industries, achievement, type, catch_copy, information, strength, job_offer_number, user_count, informal_job_offer_rate, satisfaction_degrees, finding_employment_target, ES, interview, limited_course, competence_diagnosis, special_selection, interview_style, location, delete_flg) VALUES 
(1, './src/admin/img/logo/', '鈴木会社', './src/admin/img/img/', 'IT', '満足度９８％', '理系', 'dream', '鈴木会社は～で、実績が～で、…', '強み', '1千万人', '2千万人', '90%', '89%', 'IT企業', true, true, true, true, true, 'オンライン', 'オンライン', 0),
(2, './src/admin/img/logo/', '佐藤会社', './src/admin/img/img/', 'サービス', '内定率４０％', '文系', 'dream', '佐藤会社は～で、実績が～で、…', '強み', '1千万人', '2千万人', '90%', '89%', 'IT企業', true, false, true, true, true, 'オンライン', 'オンライン', 0),
(3, './src/admin/img/logo/', '田中会社', './src/admin/img/img/', '商社', '顧客数No.1', '理系', 'dream', '田中会社は～で、実績が～で、…', '強み', '1千万人', '2千万人', '90%', '89%', 'IT企業', true, true, false, false, true, 'オンライン', 'オンライン', 0),
(4, './src/admin/img/logo/', '山田会社', './src/admin/img/img/', '小売り', '顧客満足度９０%', '理系', 'dream', '山田会社は～で、実績が～で、…', '強み', '1千万人', '2千万人', '90%', '89%', 'IT企業', true, true, true, false, true, '対面', '都心', 0),
(5, './src/admin/img/logo/', '加藤会社', './src/admin/img/img/', '金融', '利用学生数１０万人', '文系', 'dream', '加藤会社は～で、実績が～で、…', '強み', '1千万人', '2千万人', '90%', '89%', 'IT企業', true, true, true, true, false, 'オンライン', 'オンライン', 0);


-- 管理者画面ログインテーブル
DROP TABLE IF EXISTS admin;
CREATE TABLE admin
(
  id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  password VARCHAR(255) NOT NULL,
  company_id INT NOT NULL,
  mail_admin VARCHAR(255) NOT NULL UNIQUE,
  delete_flg INT NOT NULL
);

INSERT INTO admin (name, password, company_id, mail_admin, delete_flg) VALUES 
('佐藤', 'aaaaaa', 1, 'ssssmmmmllll@gmail.com', 0),
('山中', 'bbbbbb', 2, 'mmmmssssllll@gmail.com', 0),
('梢', 'cccccc', 3, 'ssssllllmmmm@gmail.com', 0),
('北', 'ccacca', 3, 'kkkkllllmmmm@gmail.com', 0),
('西', 'dddddd', 4, 'mmssssmmllll@gmail.com', 0),
('本村', 'eeeeee', 5, 'llllssssmmmm@gmail.com', 0);


-- 学生・エージェント中間テーブル
DROP TABLE IF EXISTS company_user;

CREATE TABLE company_user
(
  id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
  user_id INT NOT NULL,
  company_id INT NOT NULL,
  contact_datetime DATETIME NOT NULL
);

INSERT INTO company_user (user_id, company_id, contact_datetime) VALUES 
(1, 1, '2022-04-30'),
(1, 2, '2022-05-03'),
(2, 1, '2022-05-06'),
(3, 4, '2022-05-06'),
(4, 3, '2022-05-10'),
(5, 5, '2022-06-01');

-- datetimeを消して確認…それでも反映されず
-- CREATE TABLE company_user
-- (
--   id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
--   user_id INT NOT NULL,
--   company_id INT NOT NULL,
-- );

-- INSERT INTO company_user (user_id, company_id) VALUES 
-- (1, 1),
-- (1, 2),
-- (2, 1),
-- (3, 4),
-- (4, 3),
-- (5, 5);

-- テーブル名を変えただけのものも反映されず
-- DROP TABLE IF EXISTS admin2;
-- CREATE TABLE admin2
-- (
--   id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
--   password VARCHAR(255) NOT NULL,
--   mail_admin VARCHAR(255) NOT NULL
-- );

-- INSERT INTO admin2 (password, mail_admin) VALUES 
-- ('aaaaaa', 'ssssmmmmllll@gmail.com'),
-- ('bbbbbb', 'mmmmssssllll@gmail.com'),
-- ('cccccc', 'ssssllllmmmm@gmail.com'),
-- ('dddddd', 'mmssssmmllll@gmail.com'),
-- ('eeeeee', 'llllssssmmmm@gmail.com');







-- 以下サンプルデータ
-- DROP SCHEMA IF EXISTS craft;

-- CREATE SCHEMA craft;

-- USE craft;

-- DROP TABLE IF EXISTS users;

-- CREATE TABLE users (
--   id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
--   email boolean UNIQUE NOT NULL,
--   password VARCHAR(255) NOT NULL,
--   created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
--   updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
-- );

-- INSERT INTO
--   users
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