-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  ven. 03 juil. 2020 à 12:38
-- Version du serveur :  10.3.16-MariaDB
-- Version de PHP :  7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `zenit1226833`
--

-- --------------------------------------------------------

--
-- Structure de la table `Category`
--

CREATE TABLE `Category` (
  `Id` tinyint(3) NOT NULL,
  `Name` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `Category`
--

INSERT INTO `Category` (`Id`, `Name`) VALUES
(1, 'Black Desert Online'),
(2, 'Enhancing'),
(3, 'Event'),
(4, 'Tournament'),
(5, 'MMORPG'),
(6, 'Zenith Kings'),
(7, 'Video Games');

-- --------------------------------------------------------

--
-- Structure de la table `Comment`
--

CREATE TABLE `Comment` (
  `Id` tinyint(3) NOT NULL,
  `Member_Id` tinyint(3) NOT NULL,
  `Contents` text NOT NULL,
  `CreationTimestamp` datetime NOT NULL DEFAULT current_timestamp(),
  `Post_Id` tinyint(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `Comment`
--

INSERT INTO `Comment` (`Id`, `Member_Id`, `Contents`, `CreationTimestamp`, `Post_Id`) VALUES
(1, '1', '<p>First comment!</p>', '2019-10-11 11:15:36', 3),
(2, '1', '<p>try</p>', '2020-06-11 14:00:04', 6),
(3, '1', '<p>SECOND TRY</p>', '2020-06-11 14:01:52', 8),
(4, '1', '<p>Yo les mecs ça marche???</p>', '2020-06-11 14:06:41', 7),
(5, '1', '<p>thirddddddddddddddddddddddddddddddddddddddddddddddddd</p>', '2020-06-11 14:12:13', 8),
(6, '1', '<p>Problème d\'id quand même</p>', '2020-06-11 14:23:47', 8),
(7, '1', '<p>LongJohn</p>', '2020-06-11 14:26:41', 8),
(8, '1', '<p>oupssss</p>', '2020-06-11 14:27:45', 8),
(9, '1', '<p>whatssss</p>', '2020-06-11 14:28:33', 8),
(10, '1', '<p>555</p>', '2020-06-11 14:51:59', 6),
(11, '1', '<p>nice 4</p>', '2020-06-11 14:57:52', 6),
(12, '1', '<p>yo!!!</p>', '2020-06-11 14:58:40', 6),
(13, '1', '<p>dernier try</p>', '2020-06-11 14:59:19', 8),
(14, '1', '<p>Bonjour les gars!!</p>', '2020-07-08 15:01:47', 17);

-- --------------------------------------------------------

--
-- Structure de la table `Likes`
--

CREATE TABLE `Likes` (
  `Id` tinyint(3) NOT NULL,
  `Member_Id` tinyint(3) NOT NULL,
  `Post_Id` tinyint(3) NOT NULL,
  `Comment_Id` tinyint(3) DEFAULT NULL,
  `Value` tinyint(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `Likes`
--

INSERT INTO `Likes` (`Id`, `Member_Id`, `Post_Id`, `Comment_Id`, `Value`) VALUES
(1, 1, 2, NULL, 1),
(2, 2, 2, NULL, 1),
(3, 1, 17, 14, 1);

-- --------------------------------------------------------

--
-- Structure de la table `Member`
--

CREATE TABLE `Member` (
  `Id` tinyint(3) NOT NULL,
  `FirstName` varchar(40) DEFAULT NULL,
  `LastName` varchar(40) DEFAULT NULL,
  `Avatar` varchar(10) DEFAULT NULL,
  `FamilyName` varchar(40) DEFAULT NULL,
  `CharacterName` varchar(40) DEFAULT NULL,
  `CharacterClass` varchar(20) DEFAULT NULL,
  `CharacterPic` varchar(40) DEFAULT NULL,
  `CharacterLevel` smallint(2) DEFAULT NULL,
  `StatusInGuild` varchar(40) DEFAULT NULL,
  `Email` varchar(40) NOT NULL,
  `Password` varchar(64) NOT NULL,
  `BirthDate` date NOT NULL,
  `Address` varchar(150) DEFAULT NULL,
  `City` varchar(40) DEFAULT NULL,
  `ZipCode` char(5) DEFAULT NULL,
  `Country` varchar(40) DEFAULT NULL,
  `Phone` char(10) DEFAULT NULL,
  `CreationTimestamp` datetime NOT NULL DEFAULT current_timestamp(),
  `LastLoginTimestamp` datetime DEFAULT NULL,
  `Admin` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `Member`
--

INSERT INTO `Member` (`Id`, `FirstName`, `LastName`, `Avatar`, `FamilyName`, `CharacterName`, `CharacterClass`, `CharacterPic`, `CharacterLevel`, `StatusInGuild`, `Email`, `Password`, `BirthDate`, `Address`, `City`, `ZipCode`, `Country`, `Phone`, `CreationTimestamp`, `LastLoginTimestamp`, `Admin`) VALUES
(1, 'Mike', 'Altman', '30.gif', 'SX77', 'SaXeGaArD9', 'Wizard', 'SaXeGaArD9(SX77).jpg', 64, 'A - Grand Master', 'altman_mike@yahoo.fr', '$2y$11$3145f90c44fb6146e2d6buokkqFKLbld3d70.QfiB2FgS0U0NtxWq', '1984-01-29', 'Pas besoin de savoir mais bon ..oiudfdf', 'Lyon', '69007', 'France', '0781570127', '2019-03-24 00:00:00', '2020-08-22 13:18:17', 1),
(2, 'Roger', 'Dartoot', NULL, 'Delaini', 'Hiukki', 'Tamer', 'Hiukki(Delaini).jpg', 61, 'B - Officier', 'zk@aol.fr', '$2y$11$acb0901cd6d616714cc11ulcLwmNKbbSniZTNXBa6.yH72ISz5mOK', '1986-09-08', '', '', '', 'UK', '', '2019-04-02 00:00:00', '0000-00-00 00:00:00', 0),
(3, 'DESP', 'HANG', NULL, 'Despe', 'Hangaqu', 'Lhan', 'Hangaqu(Despe).jpg', 62, 'B - Officier', 'despeee03@aol.fr', '$2y$11$97213bd4e0943e9c08138udK/.WG599ZIIC2C5sZrqEL4kr0qPY8y', '1977-01-01', '2019-10-26 13:31:32', '', '', 'Belgique', '', '2019-04-06 00:00:00', '0000-00-00 00:00:00', 0),
(4, 'Makiller', 'Killeraja', NULL, 'Killeraja', 'Makiller', 'Dark Knight', 'Makiller(Killeraja).jpg', 61, 'D - Master Quarter', 'killeraja06@hotmail.fr', '$2y$11$51dab14313290f51978cfupDvGC..Wzj/zOJz83Owd2VxKHA49HtC', '1971-06-20', '2020-01-20 19:57:13', '', '', 'Belgique', '', '2019-04-07 00:00:00', '0000-00-00 00:00:00', 0),
(5, 'Bob', 'Thunda', NULL, 'Thundagar', 'Nippo', 'Striker', 'Nippo(Thundagar).jpg', 62, 'B - Officier', 'nippthund@gmail.uk', '$2y$11$0a95fc11c40505364cb80uhGPKkqSl.hr/e1CSz9VANVr66noFUwC', '1970-07-06', '', 'Manchester', '', 'UK', '', '2020-06-10 13:09:29', NULL, 0),
(6, 'Gilberto', 'Ladosco', NULL, 'Beewoki', 'Beewoki', 'Dark Knight', 'noatm.jpg', 57, 'B - Officier', 'trèsconcat@aol.fr', '$2y$11$760081e2b50e9f18501b5uAySzs.8syN.Osu3EVZ15O9esn.OLs/a', '0000-00-00', '', '', '', 'Espagne', '', '2020-01-20 21:01:29', NULL, 0),
(7, 'Geralt', 'DuMorvant', NULL, 'Fufurious', 'Furiousmystic', 'Mystic', 'Furiousmystic(Fufurious).jpg', 60, 'C - General', 'tetete@aol.fr', '$2y$11$a0a280b1d91a78c7ee623Oepv/D9JVsI0.ua9CVA574UBVt5JTLIe', '1979-02-20', '', '', '', 'France', '', '2020-01-20 21:29:32', NULL, 0),
(8, 'Azy.', 'Wad.', NULL, 'Waden', 'Azyriel', 'Witch', 'Azyriel(Waden).jpg', 60, 'C - General', 'watsho@gmx.fr', '$2y$11$271c10466bd5ce8a75642u16kUp3UT2ph/0BIFixqDm8UuLo3nlvS', '1980-12-06', '', '', '', 'FRANCE', '', '2019-04-10 00:00:00', '2020-01-20 20:27:41', 0),
(9, 'KRASNO', 'SERGEY', NULL, 'FRANCE', 'GALLA', 'Witch', 'noatm.jpg', 59, 'General', 'KESNOSS@YAHOO.COM', '$2y$11$2666e5c45f719f8fac077udQq33PmVtoV48DIDQdRYKBf7jbsyn4W', '1977-01-01', '', 'BOURG LES VALENCE', '26500', 'FRANCE', '0622422981', '2019-10-26 00:00:00', '2019-12-29 15:31:16', 0),
(10, 'Watishc', 'Partich', NULL, 'Kyoge1', 'Hiirolol', 'Ninja', 'Hiirolol(Kyoge1).jpg', 60, 'E - Recruit', 'lolo@aol.fr', '$2y$11$f0ad4219f7dd61762b9a2O1YrF/9IUibl7QjbIm9BGsD141RNZ3A2', '1997-07-23', '', '', '', '', '', '2020-01-20 20:39:54', NULL, 0),
(11, 'Bernard', 'Berni', NULL, 'Kilada', 'Musakila', 'Musa', 'Musakila(Kilada).jpg', 62, 'C - General', 'pittus@aol.uk', '$2y$11$8a781d6629c439c02fcc9u69BKuLyJ0zwovD4q/QIofoYZGvyEyHe', '1980-01-01', '', 'Paris', '75000', 'France', '066445588', '2020-01-20 20:44:53', NULL, 0),
(12, 'Procyd', 'Dural', NULL, 'Abysseaters', 'Leviatah', 'Sorceress', 'Leviatah(Abysseaters).jpg', 62, 'D - Master Quarter', 'fake@yahoo.com', '$2y$11$c94d5a4cfdc7dec3806f0OWV3vDU8bqERZrbD0xe77g6lKVu6qpEi', '0000-00-00', '', '', '', 'CZ', '', '2020-01-20 20:53:52', NULL, 0),
(13, 'Junez', 'Garcia', NULL, 'Vilagarcia', 'Canelonni', 'Dark Knight', 'Canelonni(Vilagarcia).jpg', 60, 'B - Officier', 'Junez@gmail.fr', '$2y$11$6851f32b9a6b67a1d57ffus2Ymtmq1LLrJnX6sDCVasVhtOydmXHy', '2000-06-04', '', 'Pontevedra', '', 'Espagne', '', '2020-06-04 15:13:43', '2020-06-04 15:14:41', 0),
(14, 'Mzazz', 'Mzazzz', NULL, 'MysticxX', 'Mzazz3', 'Kunoichi', 'Mzazz3(MysticxX).jpg', 60, 'D - Master Quarter', 'mzazz@gmail.fr', '$2y$11$ae2f6d09dddb6fb7525adulRfbxhlXJLbZ38DuEbydQg5dTTyVz0W', '2000-06-04', '', '', '', 'CZ', '0125469877', '2020-06-04 16:04:42', NULL, 0),
(15, 'Jack', 'T.', NULL, 'FirstSnowFall', 'Nixprox', 'Dark Knight', 'Nixprox(FirstSnowFall).jpg', 58, 'E - Recruit', 'nixprox@gmail.com', '$2y$11$456bdd1140930c5049cd3unrl.Lc1xE5iuRFLNfXM0aAUwXt7I7x2', '2000-06-04', 'Place de la nouvelle classe', '', '', 'UK', '', '2020-06-04 16:11:02', NULL, 0),
(16, 'Rodrigo', 'Sansi', NULL, 'Putalee', 'Sansigolo', 'Ranger', 'Sansigolo(Putalee).jpg', 56, 'E - Recruit', 'putalee@gmail.it', '$2y$11$c6b182e413a18d96e5582uamzPhq6Bf7R.BV6rljsA7ETmqKe95gW', '2000-06-04', 'roma', '', '66666', 'Italie', '', '2020-06-04 16:33:32', NULL, 0),
(17, 'Jony', 'Jonyy', NULL, 'Jony82', 'Jony82', 'Archer', 'Jony82(Jony82).jpg', 58, 'E - Recruit', 'else@gmail.fr', '$2y$11$a7e9e0fb17d15de46f670uxXgvB..43k.Csn/0pICvtFspYR9kY0G', '2000-06-04', '', '', '', 'Espagne', '', '2020-06-04 16:36:37', NULL, 0),
(18, 'Jimmy', 'MaCrae', NULL, 'SILEXMACRAE', 'JIMMYNOOBCHAMPS', 'Musa', 'JIMMYNOOBCHAMPS(SILEXMACRAE).jpg', 60, 'B - Officier', 'jimmy45@gmail.uk', '$2y$11$767b1b659cd83b0993d24eYnk7ZLDk2PABmFFEEJbI.21Mi7jk5Ny', '2000-06-04', '', 'London', '', 'United-Kingdom', '', '2020-06-04 16:55:56', NULL, 0),
(19, 'Pierre', 'A.', NULL, 'ROZPIERDALATORZY', 'NINJUCH', 'Ninja', 'NINJUCH(ROZPIERDALATORZY).jpg', 60, 'C - General', 'pt114478@gmail.com', '$2y$11$d47dee3abba7a824d0f14e.g6eNjy4YiWWE9Q58zVrkusJjhhbrba', '2000-05-08', '', '', '', 'Netherlands', '0784516236', '2020-06-08 12:25:33', NULL, 0),
(20, 'Miguel', 'N.', NULL, 'BIGPCHOTO', 'AZUNADV', 'Lhan', 'AZUNADV(BIGPCHOTO).jpg', 57, 'D - Master Quarter', 'bigp@aol.com', '$2y$11$5be5bf210bbdda54e2ebceHyKo4g.oj81qa5mfbk7dlv1mNgp0VOm', '1999-06-09', '', '', NULL, 'Portugal', NULL, '2020-06-09 11:39:28', NULL, 0),
(21, 'Aya', 'Spark', NULL, 'AYLING', 'ISPARKX1', 'Tamer', 'ISPARKX1(AYLING).jpg', 61, 'D - Master Quarter', 'ayling04@outlook.com', '$2y$11$fcdd59dd25f36e4a57325OEkIH2Oi3upHJtO0CVWcwoyt0me36nVm', '1999-06-09', '', '', NULL, 'United Kingdom', NULL, '2020-06-09 11:44:48', NULL, 0),
(22, 'Hyp.', 'Bens.', NULL, 'HARANDARIEL', 'HYPERICA', 'Shai', 'HYPERICA(HARANDARIEL).jpg', 60, 'E - Recruit', 'plass5@yahoo.com', '$2y$11$20bb06a205e5c9d79caa2OjScfxweZYfu4PGjpCHlihzsROT7THQy', '2000-06-09', '', '', NULL, 'Autriche', '', '2020-06-09 13:48:36', NULL, 0),
(23, 'Sergey', 'Gada', NULL, 'GADARENE', 'LITTLE_PAIN', 'Shai', 'LITTLE_PAIN(GADARENE).jpg', 61, 'B - Officier', 'ptk06@gmail.ru', '$2y$11$bd90c265f77edda1ca50ber6JYbATzwTHFMpiVQCAZvco9TUTvj4m', '1985-12-09', '', '', '', 'Russie', '', '2020-06-09 13:56:50', NULL, 0),
(24, 'S.', 'Sanaz', NULL, 'SANAZAKI', 'SHANELOBERLIN', 'Mystic', 'noatm.jpg', 61, 'B - Officier', 'zuz05@aol.uk', '$2y$11$a9337429b9d41429c616bu2C6ryY7VB.2fK7A2HM2VW9xvA2d/eyq', '1980-10-03', '', '', '', 'Russie', '', '2020-06-09 16:17:57', NULL, 0),
(25, 'Julien', 'Narque..', NULL, 'NARQUELION', 'NUMINEXS', 'Striker', 'NUMINEXS(NARQUELION).jpg', 61, 'C - General', 'numin@aol.com', '$2y$11$62719fa9400ea213b7ca6ua/ZacRGpenC/O95VUDSfJH./ppTUFf2', '2000-06-06', '', '', '', 'FRANCE', '', '2020-06-09 16:54:02', '2020-06-09 17:09:32', 0),
(26, 'Sky', 'Skytech', NULL, 'Tigiyans', 'YAMINNO', 'Dark Knight', 'YAMINNO(Tigiyans).jpg', 60, 'D - Master Quarter', 'zozo58@gmail.fr', '$2y$11$a0b7625c1bcff748f9e33uJgzkxweQ7xbVBTP5fQv2GEGdJNNSfZK', '1976-02-01', '', '', '', 'FRANCE', '', '2020-06-10 12:55:17', '2020-06-10 12:55:35', 0),
(27, 'Nicolas', 'Baud.', NULL, 'MAGIC_WELL', 'NESS_FIT', 'Sorceress', 'NESS_FIT(MAGIC_WELL).jpg', 60, 'D - Master Quarter', 'mwell07@aol.fr', '$2y$11$e3c5573b8b8e9739a0aa9u9ml5E2eroi5lcKc./8woLUuBwetI5kq', '2000-06-10', '', '', '', 'France', '', '2020-06-10 13:01:37', NULL, 0),
(28, 'Nath', 'Veroch', NULL, 'BLUESIDE', 'BLUESIDEX', 'Sorceress', 'BLUESIDEX(BLUESIDE).jpg', 59, 'C - General', 'blusideX@aol.ger', '$2y$11$070156286bfaebcfbd1e6uq1oLQph.YvipKe0pUPhrz7PXcFYVA/G', '1981-05-04', '', '', '', 'Allemagne', '', '2020-06-10 13:06:10', NULL, 0),
(29, 'Pierre', 'Ard.', NULL, 'PETERPAINN', 'ARDARS', 'Valkyrie', 'noatm.jpg', 62, 'B - Officier', 'testS@aol.fr', '$2y$11$fdd99497c64ba3399cbdcuEl.p.MEJH9IfuePzoAZHgxRQocOVvXa', '1982-08-20', '', '', '', 'France', '', '2020-06-10 13:18:03', NULL, 0),
(30, 'V.', 'C.', NULL, 'ICEEBANG', 'ICEBANG', 'Dark Knight', 'ICEBANG(ICEEBANG).jpg', 62, 'B - Officier', 'testO@aol.fr', '$2y$11$617911975f781db09aca6uFehvR4Y1THbQmBIZ5OWKtAhCbDRFj.q', '1990-01-28', '', '', '', 'France', '', '2020-06-10 13:24:04', NULL, 0),
(31, 'D.', 'Salesmann', NULL, 'SALESMANN', 'XANHU', 'Musa', 'XANHU(SALESMANN).jpg', 62, 'B - Officier', 'salessxanhu@outlook.be', '$2y$11$f569c39bdf430d62d2a29uNgsLyAVY8u3R/HYDoCj3OmwJSS6HYiu', '1960-06-20', '', '', '', 'Belgique', '', '2020-06-20 19:11:03', NULL, 0),
(32, 'R.', 'Alph.', NULL, 'ALPHEIM', 'BLOODBANE', 'Berzerker', 'BLOODBANE(ALPHEIM).jpg', 61, 'B - Officier', 'bvener@try.uk', '$2y$11$7bf3659c78eb4f0b2347euA7RxNIwYp3hmAJL0u5ucFZ3FFXkPGOy', '1978-05-01', '', 'Liverpool', '', 'United-Kingdom', '', '2020-06-27 18:16:28', NULL, 0);

-- --------------------------------------------------------

--
-- Structure de la table `War`
--

CREATE TABLE `War` (
  `Id` tinyint(3) NOT NULL,
  `Us` varchar(40) DEFAULT NULL,
  `UsLogo` varchar(40) DEFAULT NULL,
  `Opponent` varchar(40) DEFAULT NULL,
  `OpponentLogo` varchar(40) DEFAULT NULL,
  `Day` varchar(20) DEFAULT NULL,
  `Node` varchar(20) DEFAULT NULL,
  `Tier` varchar(20) DEFAULT NULL,
  `Score` varchar(20) DEFAULT NULL,
  `CreationTimestamp` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `War`
--

INSERT INTO `War` (`Id`, `Us`, `UsLogo`, `Opponent`, `OpponentLogo`, `Day`, `Node`, `Tier`, `Score`, `CreationTimestamp`) VALUES
(1, 'Les_Temporaires', 'Les_Temporaires', 'rune', 'rune', 'Mercredi', 'Valencia', 'Tier 1 easy', '0 - 1', '2020-07-10 00:00:00'),
(2, 'Les_Temporaires', 'Les_Temporaires', 'Provoke', 'Provoke', 'Vendredi', 'Mediah', 'Tier 1 middle', '0 - 1', '2020-07-11 18:39:07'),
(3, 'LesPourfendeurs', 'LesPourfendeurs', 'Dreamkeepers', 'Dreamkeepers', 'Mercredi', 'Balenos', 'Tier 1 hard', '0 - 1', '2020-07-14 12:22:36');

-- --------------------------------------------------------

--
-- Structure de la table `Order`
--

CREATE TABLE `Order` (
  `Id` tinyint(3) NOT NULL,
  `Member_Id` tinyint(3) NOT NULL,
  `SumPrices` double NOT NULL,
  `Taxes` float NOT NULL,
  `CostOfPortage` double NOT NULL,
  `Total` double NOT NULL,
  `CreationTimestamp` datetime NOT NULL DEFAULT current_timestamp(),
  `CompleteTimestamp` datetime NOT NULL DEFAULT '0000-00-00 00:00:00';
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `Order`
--

INSERT INTO `Order` (`Id`, `Member_Id`, `SumPrices`, `Taxes`, `CostOfPortage`, `Total`, `CreationTimestamp`, `CompleteTimestamp`) VALUES
(1, 1, 0, 20, 0, 0, '2020-05-21 21:50:53', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `Orderline`
--

CREATE TABLE `Orderline` (
  `Id` tinyint(3) NOT NULL,
  `QuantityOrdered` smallint(4) NOT NULL,
  `Product_Id` tinyint(3) NOT NULL,
  `Order_Id` tinyint(3) NOT NULL,
  `PriceEach` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Post`
--

CREATE TABLE `Post` (
  `Id` tinyint(3) NOT NULL,
  `Title` varchar(100) NOT NULL,
  `Picture` varchar(50) DEFAULT NULL,
  `Contents` text NOT NULL,
  `CreationTimestamp` datetime NOT NULL DEFAULT current_timestamp(),
  `Member_Id` tinyint(3) NOT NULL,
  `Category_Id` tinyint(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `Post`
--

INSERT INTO `Post` (`Id`, `Title`, `Picture`, `Contents`, `CreationTimestamp`, `Member_Id`, `Category_Id`) VALUES
(1, 'ZK internal tourney duel', 'Arsha arena 500.jpg', '<p>Et hanc quidem praeter oppida multa duae civitates exornant Seleucia opus Seleuci regis, et Claudiopolis quam deduxit coloniam Claudius Caesar. Isaura enim antehac nimium potens, olim subversa ut rebellatrix interneciva aegre vestigia claritudinis pristinae monstrat admodum pauca.</p>', '2019-09-09 19:58:22', 1, 1),
(2, 'Altar Of Blood +50% loot event', 'Altar of Blood 500.jpg', '<p>Abusus enim multitudine hominum, quam tranquillis in rebus diutius rexit, ex agrestibus habitaculis urbes construxit multis opibus firmas et viribus, quarum ad praesens pleraeque licet Graecis nominibus appellentur, quae isdem ad arbitrium inposita sunt conditoris, primigenia tamen nomina non amittunt, quae eis Assyria lingua institutores veteres indiderunt.</p>\r\n<p>Accedat huc suavitas quaedam oportet sermonum atque morum, haudquaquam mediocre condimentum amicitiae. Tristitia autem et in omni re severitas habet illa quidem gravitatem, sed amicitia remissior esse debet et liberior et dulcior et ad omnem comitatem facilitatemque proclivior.</p>\r\n<p>Sed fruatur sane hoc solacio atque hanc insignem ignominiam, quoniam uni praeter se inusta sit, putet esse leviorem, dum modo, cuius exemplo se consolatur, eius exitum expectet, praesertim cum in Albucio nec Pisonis libidines nec audacia Gabini fuerit ac tamen hac una plaga conciderit, ignominia senatus.</p>\r\n<p>Iamque lituis cladium concrepantibus internarum non celate ut antea turbidum saeviebat ingenium a veri consideratione detortum et nullo inpositorum vel conpositorum fidem sollemniter inquirente nec discernente a societate noxiorum insontes velut exturbatum e iudiciis fas omne discessit, et causarum legitima silente defensione carnifex rapinarum sequester et obductio capitum et bonorum ubique multatio versabatur per orientales provincias, quas recensere puto nunc oportunum absque Mesopotamia digesta, cum bella Parthica dicerentur, et Aegypto, quam necessario aliud reieci ad tempus.</p>\r\n<p>Iis igitur est difficilius satis facere, qui se Latina scripta dicunt contemnere. in quibus hoc primum est in quo admirer, cur in gravissimis rebus non delectet eos sermo patrius, cum idem fabellas Latinas ad verbum e Graecis expressas non inviti legant. quis enim tam inimicus paene nomini Romano est, qui Ennii Medeam aut Antiopam Pacuvii spernat aut reiciat, quod se isdem Euripidis fabulis delectari dicat, Latinas litteras oderit?</p>', '2019-09-09 20:00:22', 1, 1),
(3, 'BlackStar Weapon (Red gear)', 'black star weapon 500.jpg', '<p>Guddat (Corney) got in total 2 IV BlackStars (TET BlackStar) already!! Myswordinuranus got one and sold it 14 billions silvers! And myself +199 fs and +117 fs on 2 characters, tet blackstar i want!</p>', '2019-09-17 13:35:48', 1, 2),
(4, 'Isabella spawn times in EU', 'isabella event.jpg', '<p>Sunday to Friday: CEST 10:00, 17:00, 23:15 UTC 08:00, 15:00, 21:15 Saturdays: CEST 10:00, 17:00, 01:00 UTC 08:00, 15:00, 23:00</p>', '2019-10-23 12:49:55', 1, 3),
(5, 'Rare fish ', 'rare fish.jpg', '<p>Rare fish 500 000 silvers are coming in all cities of bdo! Time is to increase our fishing lifeskills!</p>', '2019-11-13 12:55:41', 1, 3),
(6, 'Holidays events & promotions', 'Pilaku 500.jpg', '<p>Available until December 31: maximum 70% on bdo stuffs! Don\'t forget your matchlocks to defeat the Piku Piku Yeti in Heidel. You also have few days to collect seeds Cron (about 24 Cron stones by seed). Merry Christmas!</p>', '2019-12-28 13:50:26', 1, 1),
(7, 'Guardian pre-registration now', 'Guardiana pre-creation.jpg', '<p>The new class GUARDIAN creation will start the 15th January and will be online the next 22th. You should register yourself for rewards: <a href=\"https://www.blackdesertonline.com/guardian?lang=EN\" target=\"_blank\" rel=\"noopener\">here</a></p>', '2019-12-28 13:59:37', 1, 1),
(8, 'New Year choices until further notice!!!', 'New year.jpg', '<p>A 7 days rewards and more have been added to celebrate the New Year. More exp boosts: weekdays fight +100% / skills +20% and weekends fight +200% / skills +20%, cmon!</p>', '2019-12-28 14:08:46', 1, 1),
(10, 'Salutations', 'event season fughar.jpg', '<p>Comment allez-vous les gens, toujours co????</p>', '2020-06-11 16:38:12', 1, 1),
(14, 'New class again', 'New class beside.jpg', '<p>Valencia warior with desert heat resistances</p>', '2020-06-16 14:21:00', 1, 1),
(15, 'Spring Season Servers', 'tuvala tounament.jpg', '<p>Come try season servers! create a class in and join to leveling fast your hero, a lots of rewards and more!</p>', '2020-06-16 18:37:30', 1, 3),
(16, 'Guildes Alliances', 'alliance logo.jpg', '<p>We will go in this direction for now! see ya!</p>', '2020-06-16 18:39:33', 1, 1),
(17, 'Test tiny mce', 'frodon.jpg', '<p><em><strong>Salut les potos!</strong></em></p>\r\n<p>L\'heure approche et vous le voyez au loin, il est incandescent!</p>\r\n<p>\"Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?\"</p>\r\n<p><strong>Bye les amigos</strong></p>', '2020-06-28 21:14:45', 1, 1),
(18, 'Nouvelle classe', 'New class front.jpg', '<p>Et un aper&ccedil;u de la nouvelle classe! Le guerrier du d&eacute;sert!</p>\r\n<p>Nous avons quelque echoes des futurs armes et comp&eacute;tences de ce personnage provenant de la ville de Valencia:</p>\r\n<p>&nbsp;- r&eacute;sistance &agrave; la chaleur du d&eacute;sert augment&eacute;e</p>\r\n<p>&nbsp;- dague &agrave; double lame pour arme secondaire</p>\r\n<p>Voil&agrave; pour l\'instant.</p>', '2020-07-17 14:51:29', 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `Product`
--

CREATE TABLE `Product` (
  `Id` tinyint(3) NOT NULL,
  `Name` varchar(30) NOT NULL,
  `Photo` varchar(30) NOT NULL,
  `Description` varchar(250) NOT NULL,
  `QuantityInStock` tinyint(4) NOT NULL,
  `BuyPrice` double NOT NULL,
  `SalePrice` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `Product`
--

INSERT INTO `Product` (`Id`, `Name`, `Photo`, `Description`, `QuantityInStock`, `BuyPrice`, `SalePrice`) VALUES
(1, 'Cap Black', 'Cap Black.png', 'Cap one color black', 1, 15, 17),
(2, 'Cap B&O', 'Cap B&O.png', 'Cap two colors black & orange', 2, 18, 24),
(3, 'TShirt Green', 'TShirt Green.png', 'TShirt tricolore green, black and grey.. team style..', 5, 49, 52),
(4, 'TShirt Blue', 'TShirt Blue.png', 'TShirt tricolore blue, white and grey.. team style!', 6, 49, 53),
(5, 'TShirt White', 'TShirt White.png', 'TShirt tricolore white, blue and grey.. team style', 2, 47, 50),
(6, 'Sweat Magenta', 'Sweat Magenta.png', 'Sweat two colors yellow & magenta', 2, 64, 70.5),
(7, 'Sweat White', 'Sweat White.png', 'Sweat two colors white & blue', 3, 63, 69),
(8, 'Sweat Blue', 'Sweat Blue.png', 'Sweat two colors yellow & blue', 3, 64, 70),
(9, 'Mug Black&White', 'Mug Black&White.png', 'Ceramic mug..', 8, 2.5, 4),
(10, 'Mug Orange&White', 'Mug Orange&White.png', 'Ceramic mug..', 3, 2, 3.7);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `Category`
--
ALTER TABLE `Category`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Name` (`Name`);

--
-- Index pour la table `Comment`
--
ALTER TABLE `Comment`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `Member_Id` (`Member_Id`),
  ADD KEY `Post_Id` (`Post_Id`);

--
-- Index pour la table `Likes`
--
ALTER TABLE `Likes`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `Member_Id` (`Member_Id`) USING BTREE,
  ADD KEY `Post_Id` (`Post_Id`) USING BTREE,
  ADD KEY `Comment_Id` (`Comment_Id`) USING BTREE;

--
-- Index pour la table `Member`
--
ALTER TABLE `Member`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `Email` (`Email`);
  
--
-- Index pour la table `War`
--
ALTER TABLE `War`
  ADD PRIMARY KEY (`Id`);
  
--
-- Index pour la table `Order`
--
ALTER TABLE `Order`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `Member_Id` (`Member_Id`);

--
-- Index pour la table `Orderline`
--
ALTER TABLE `Orderline`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `UniciteProductOrder` (`Product_Id`,`Order_Id`) USING BTREE,
  ADD KEY `Product_Id` (`Product_Id`),
  ADD KEY `Order_Id` (`Order_Id`);

--
-- Index pour la table `Post`
--
ALTER TABLE `Post`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Title` (`Title`),
  ADD KEY `Member_Id` (`Member_Id`),
  ADD KEY `Category_Id` (`Category_Id`);

--
-- Index pour la table `Product`
--
ALTER TABLE `Product`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `Category`
--
ALTER TABLE `Category`
  MODIFY `Id` tinyint(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `Comment`
--
ALTER TABLE `Comment`
  MODIFY `Id` tinyint(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `Likes`
--
ALTER TABLE `Likes`
  MODIFY `Id` tinyint(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `Member`
--
ALTER TABLE `Member`
  MODIFY `Id` tinyint(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
  
--
-- AUTO_INCREMENT pour la table `War`
--
ALTER TABLE `War`
  MODIFY `Id` tinyint(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
  
--
-- AUTO_INCREMENT pour la table `Order`
--
ALTER TABLE `Order`
  MODIFY `Id` tinyint(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `Orderline`
--
ALTER TABLE `Orderline`
  MODIFY `Id` tinyint(3) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Post`
--
ALTER TABLE `Post`
  MODIFY `Id` tinyint(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT pour la table `Product`
--
ALTER TABLE `Product`
  MODIFY `Id` tinyint(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `Comment`
--
ALTER TABLE `Comment`
  ADD CONSTRAINT `Comment_ibfk_1` FOREIGN KEY (`Member_Id`) REFERENCES `Member` (`Id`) ON DELETE CASCADE,
  ADD CONSTRAINT `Comment_ibfk_2` FOREIGN KEY (`Post_Id`) REFERENCES `Post` (`Id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `Likes`
--
ALTER TABLE `Likes`
  ADD CONSTRAINT `Likes_ibfk_1` FOREIGN KEY (`Member_Id`) REFERENCES `Member` (`Id`) ON DELETE CASCADE,
  ADD CONSTRAINT `Likes_ibfk_2` FOREIGN KEY (`Post_Id`) REFERENCES `Post` (`Id`) ON DELETE CASCADE,
  ADD CONSTRAINT `Likes_ibfk_3` FOREIGN KEY (`Comment_Id`) REFERENCES `Comment` (`Id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `Order`
--
ALTER TABLE `Order`
  ADD CONSTRAINT `Order_ibfk_1` FOREIGN KEY (`Member_Id`) REFERENCES `Member` (`Id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `Orderline`
--
ALTER TABLE `Orderline`
  ADD CONSTRAINT `Orderline_ibfk_1` FOREIGN KEY (`Order_Id`) REFERENCES `Order` (`Id`) ON DELETE CASCADE,
  ADD CONSTRAINT `Orderline_ibfk_2` FOREIGN KEY (`Product_Id`) REFERENCES `Product` (`Id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `Post`
--
ALTER TABLE `Post`
  ADD CONSTRAINT `Post_ibfk_1` FOREIGN KEY (`Member_Id`) REFERENCES `Member` (`Id`) ON DELETE CASCADE,
  ADD CONSTRAINT `Post_ibfk_2` FOREIGN KEY (`Category_Id`) REFERENCES `Category` (`Id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
