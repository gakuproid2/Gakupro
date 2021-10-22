-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- ホスト: localhost:8889
-- 生成日時: 2021 年 10 月 22 日 22:09
-- サーバのバージョン： 5.7.32
-- PHP のバージョン: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `gakupro`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `imageget_t`
--

CREATE TABLE `imageget_t` (
  `Key_Code` varchar(15) NOT NULL,
  `Password` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `imageget_t`
--

INSERT INTO `imageget_t` (`Key_Code`, `Password`) VALUES
('20210902001', 1322),
('20210904001', 6664);

-- --------------------------------------------------------

--
-- テーブルの構造 `MainCategory_M`
--

CREATE TABLE `MainCategory_M` (
  `MainCategory_CD` int(11) NOT NULL,
  `MainCategory_Name` varchar(30) NOT NULL,
  `UsageFlag` int(11) NOT NULL,
  `Changer` int(11) DEFAULT NULL,
  `UpdateDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `MainCategory_M`
--

INSERT INTO `MainCategory_M` (`MainCategory_CD`, `MainCategory_Name`, `UsageFlag`, `Changer`, `UpdateDate`) VALUES
(1, '性別', 1, 1, '2021-08-06 22:28:53'),
(2, '権限', 1, 1, '2021-09-04 01:12:50'),
(3, '学校区分', 1, 1, '2021-09-04 01:15:21');

-- --------------------------------------------------------

--
-- テーブルの構造 `MajorSubject_M`
--

CREATE TABLE `MajorSubject_M` (
  `School_CD` int(11) NOT NULL,
  `MajorSubject_CD` int(11) NOT NULL,
  `MajorSubject_Name` varchar(30) NOT NULL,
  `StudyPeriod` int(11) NOT NULL,
  `Remarks` varchar(100) NOT NULL,
  `UsageFlag` int(11) NOT NULL,
  `Changer` int(11) DEFAULT NULL,
  `UpdateDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `MajorSubject_M`
--

INSERT INTO `MajorSubject_M` (`School_CD`, `MajorSubject_CD`, `MajorSubject_Name`, `StudyPeriod`, `Remarks`, `UsageFlag`, `Changer`, `UpdateDate`) VALUES
(1, 1, '健康科学コース', 3, 'テスト', 1, 1, '2021-08-14 10:51:06'),
(1, 2, '文理コース', 3, 'テスト', 1, NULL, NULL),
(1, 3, '特別進学コース', 3, 'テスト３', 1, 1, '2021-08-14 10:51:12'),
(10, 1, '法学部', 4, 'テスト大学', 1, 1, '2021-08-14 10:25:52');

-- --------------------------------------------------------

--
-- テーブルの構造 `Menber_M`
--

CREATE TABLE `Menber_M` (
  `Menber_ID` int(11) NOT NULL,
  `Name` varchar(30) NOT NULL,
  `Furigana` varchar(30) DEFAULT NULL,
  `Birthday` date DEFAULT NULL,
  `School_Name` varchar(30) DEFAULT NULL,
  `MajorSubject_Name` varchar(30) DEFAULT NULL,
  `TEL` varchar(15) DEFAULT NULL,
  `Changer` int(11) DEFAULT NULL,
  `UpdateDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `School_M`
--

CREATE TABLE `School_M` (
  `School_CD` int(11) NOT NULL,
  `School_Division` int(11) DEFAULT NULL,
  `School_Name` varchar(30) NOT NULL,
  `TEL` varchar(15) NOT NULL,
  `URL` varchar(50) NOT NULL,
  `UsageFlag` int(11) NOT NULL,
  `Changer` int(11) DEFAULT NULL,
  `UpdateDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `School_M`
--

INSERT INTO `School_M` (`School_CD`, `School_Division`, `School_Name`, `TEL`, `URL`, `UsageFlag`, `Changer`, `UpdateDate`) VALUES
(1, 1, '西原高校', '090-1234-5678', 'nishihara', 1, 1, '2021-08-16 21:47:47'),
(5, 1, '浦添高校', '090-1234-5678', 'urasoe', 0, NULL, NULL),
(7, 2, '琉球大学', '090-1234-5678', 'ryukyu', 0, 1, '2021-08-14 10:42:06'),
(8, 3, 'パシフィックテクノカレッジ', '090-1234-5678', 'pasifikkutekunokarejji', 0, 1, '2021-08-14 10:43:21'),
(10, 2, '沖縄国際大学', '090-1234-5678', 'okinawakokusai', 1, 1, '2021-08-14 08:42:26');

-- --------------------------------------------------------

--
-- テーブルの構造 `Screen_M`
--

CREATE TABLE `Screen_M` (
  `Screen_ID` int(11) NOT NULL,
  `Screen_Name` varchar(30) DEFAULT NULL,
  `Screen_Path` varchar(30) DEFAULT NULL,
  `Authority` varchar(1) DEFAULT NULL,
  `UsageFlag` int(11) NOT NULL,
  `Changer` int(11) DEFAULT NULL,
  `UpdateDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `Screen_M`
--

INSERT INTO `Screen_M` (`Screen_ID`, `Screen_Name`, `Screen_Path`, `Authority`, `UsageFlag`, `Changer`, `UpdateDate`) VALUES
(1, 'ログイン', 'frm_Login.php', '3', 1, NULL, NULL),
(2, 'メインメニュー', 'frm_MainMenu.php', '3', 1, NULL, NULL),
(3, 'DB接続確認', 'frm_DBcc.php', '1', 1, NULL, NULL),
(4, '大分類マスタ', 'frm_MainCategory_M.php', '2', 1, NULL, NULL),
(5, '中分類マスタ', 'frm_SubCategory_M.php', '2', 1, NULL, NULL),
(6, '画像アップロード検証用', 'frm_ImageUpload.php', '1', 1, NULL, NULL),
(7, '写真取得検証用', 'frm_ImageGet.php', '1', 1, NULL, NULL),
(8, 'QRチケット作成', 'frm_CreateQR.php', '3', 1, NULL, NULL),
(9, '画面管理', 'frm_Screen_M.php', '2', 1, NULL, NULL),
(10, '学校マスタ', 'frm_School_M.php', '1', 1, 1, '2021-09-04 10:54:31'),
(11, '専攻マスタ', 'frm_MajorSubject_M.php', '2', 1, 2, '2021-09-04 01:23:59'),
(12, 'スタッフマスタ', 'frm_Staff_M.php', '2', 1, 2, '2021-09-04 01:30:27'),
(13, '仮登録画面', 'frm_TemporaryRegistration.php', '3', 1, 1, '2021-09-11 10:27:00');

-- --------------------------------------------------------

--
-- テーブルの構造 `Staff_M`
--

CREATE TABLE `Staff_M` (
  `Staff_ID` int(11) NOT NULL,
  `Staff_Name` varchar(30) NOT NULL,
  `Staff_NameYomi` varchar(30) NOT NULL,
  `NickName` varchar(30) NOT NULL,
  `Login_ID` varchar(30) NOT NULL,
  `Password` varchar(8) NOT NULL,
  `Authority` varchar(1) DEFAULT NULL,
  `UsageFlag` int(11) NOT NULL,
  `Changer` int(11) DEFAULT NULL,
  `UpdateDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `Staff_M`
--

INSERT INTO `Staff_M` (`Staff_ID`, `Staff_Name`, `Staff_NameYomi`, `NickName`, `Login_ID`, `Password`, `Authority`, `UsageFlag`, `Changer`, `UpdateDate`) VALUES
(1, '崎原　悠磨', 'ｻｷﾊﾗ ﾕｳﾏ', 'ゆうま', '0527', '5555', '1', 1, 1, '2021-08-07 09:30:39'),
(2, '崎原　徳真', 'ｻｷﾊﾗ ﾄｸﾏ', 'とーくー', '0604', '6666', '2', 1, 1, '2021-08-07 09:31:39'),
(3, 'ほの', 'ﾎﾉ', 'ほの', '0723', '7777', '2', 1, 1, '2021-08-19 19:50:54'),
(6, '紗羽', 'ｻﾜ', 'さーわ', '0714', '0714', '1', 1, 1, '2021-08-19 19:52:23'),
(7, '崎原　望愛', 'ﾉｱ', 'のあ', '0818', '8888', '2', 1, 1, '2021-08-19 19:56:24'),
(8, '新城　翔也', 'ｼﾝｼﾞｮｳ ｼｮｳﾔ', 'しょうや', '0819', '0819', '2', 1, 1, '2021-08-19 19:58:40'),
(9, 'テスト', 'ﾃｽﾄ', 'テスト', '0000', '0000', '1', 1, 1, NULL);

-- --------------------------------------------------------

--
-- テーブルの構造 `SubCategory_M`
--

CREATE TABLE `SubCategory_M` (
  `MainCategory_CD` int(11) NOT NULL,
  `SubCategory_CD` int(11) NOT NULL,
  `SubCategory_Name` varchar(30) NOT NULL,
  `UsageFlag` int(11) NOT NULL,
  `Changer` int(11) DEFAULT NULL,
  `UpdateDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `SubCategory_M`
--

INSERT INTO `SubCategory_M` (`MainCategory_CD`, `SubCategory_CD`, `SubCategory_Name`, `UsageFlag`, `Changer`, `UpdateDate`) VALUES
(1, 1, '男性', 1, 1, '2021-08-06 22:30:15'),
(1, 2, '女性', 1, 1, '2021-08-06 22:30:22'),
(2, 1, '管理者', 1, 1, '2021-09-04 01:15:38'),
(2, 2, '社員', 1, 1, '2021-09-04 01:15:48'),
(2, 3, 'メンバー', 1, 1, '2021-09-04 01:15:56'),
(3, 1, '高校', 1, 1, '2021-09-04 01:16:11'),
(3, 2, '大学', 1, 1, '2021-09-04 01:16:18'),
(3, 3, '専門', 1, 1, '2021-09-04 01:16:27');

-- --------------------------------------------------------

--
-- テーブルの構造 `TemporaryMember_M`
--

CREATE TABLE `TemporaryMember_M` (
  `ID` int(11) NOT NULL,
  `Password` int(4) NOT NULL,
  `Mailaddress` varchar(30) NOT NULL,
  `Name` varchar(30) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `TemporaryMember_M`
--

INSERT INTO `TemporaryMember_M` (`ID`, `Password`, `Mailaddress`, `Name`) VALUES
(88, 5676, 'yuma.saki0527@gmail.com', ''),
(89, 1549, 'yuma.saki0527@gmail.com', ''),
(90, 6506, 'yuma.saki0527@gmail.com', ''),
(91, 4213, 'yuma.saki0527@gmail.com', ''),
(92, 2840, 'yuma.saki0527@gmail.com', ''),
(93, 8492, 'yuma.saki0527@gmail.com', ''),
(94, 5144, 'a', ''),
(95, 7734, 'yuma.saki0527@gmail.com', ''),
(96, 2521, 'yuma.saki0527@gmail.com', ''),
(97, 2463, 'yuma.saki0527@gmail.com', ''),
(98, 2799, 'yuma.saki0527@gmail.com', ''),
(99, 9541, 'yuma.saki0527@gmail.com', ''),
(100, 2751, 'yuma.saki0527@gmail.com', '');

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `imageget_t`
--
ALTER TABLE `imageget_t`
  ADD PRIMARY KEY (`Key_Code`);

--
-- テーブルのインデックス `MainCategory_M`
--
ALTER TABLE `MainCategory_M`
  ADD PRIMARY KEY (`MainCategory_CD`);

--
-- テーブルのインデックス `MajorSubject_M`
--
ALTER TABLE `MajorSubject_M`
  ADD PRIMARY KEY (`School_CD`,`MajorSubject_CD`);

--
-- テーブルのインデックス `Menber_M`
--
ALTER TABLE `Menber_M`
  ADD PRIMARY KEY (`Menber_ID`);

--
-- テーブルのインデックス `School_M`
--
ALTER TABLE `School_M`
  ADD PRIMARY KEY (`School_CD`);

--
-- テーブルのインデックス `Screen_M`
--
ALTER TABLE `Screen_M`
  ADD PRIMARY KEY (`Screen_ID`);

--
-- テーブルのインデックス `Staff_M`
--
ALTER TABLE `Staff_M`
  ADD PRIMARY KEY (`Staff_ID`);

--
-- テーブルのインデックス `SubCategory_M`
--
ALTER TABLE `SubCategory_M`
  ADD PRIMARY KEY (`MainCategory_CD`,`SubCategory_CD`);

--
-- テーブルのインデックス `TemporaryMember_M`
--
ALTER TABLE `TemporaryMember_M`
  ADD PRIMARY KEY (`ID`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `TemporaryMember_M`
--
ALTER TABLE `TemporaryMember_M`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
