-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 31, 2023 at 01:20 AM
-- Server version: 10.5.20-MariaDB
-- PHP Version: 8.1.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `Earn`
--

-- --------------------------------------------------------

--
-- Table structure for table `airtime`
--

CREATE TABLE `airtime` (
  `aId` int(100) NOT NULL,
  `aNetwork` varchar(10) NOT NULL,
  `aBuyDiscount` float NOT NULL DEFAULT 96,
  `aUserDiscount` float NOT NULL,
  `aAgentDiscount` float NOT NULL,
  `aVendorDiscount` float NOT NULL,
  `aType` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `airtime`
--

INSERT INTO `airtime` (`aId`, `aNetwork`, `aBuyDiscount`, `aUserDiscount`, `aAgentDiscount`, `aVendorDiscount`, `aType`) VALUES
(1, '1', 98, 99.5, 99.2, 99, 'VTU'),
(2, '2', 95.5, 99, 98, 97.5, 'VTU'),
(3, '3', 96.5, 98.5, 98, 97.8, 'VTU'),
(4, '4', 98, 99.5, 99.2, 99, 'VTU'),
(5, '1', 98, 99.6, 99.2, 99, 'Share And Sell'),
(6, '2', 93.5, 98, 97.2, 96.5, 'Share And Sell'),
(7, '3', 87, 94, 93, 92, 'Share And Sell'),
(8, '4', 88, 85, 94, 92, 'Share And Sell');

-- --------------------------------------------------------

--
-- Table structure for table `airtimepinprice`
--

CREATE TABLE `airtimepinprice` (
  `aId` int(100) NOT NULL,
  `aNetwork` varchar(10) NOT NULL,
  `aUserDiscount` float NOT NULL,
  `aAgentDiscount` float NOT NULL,
  `aVendorDiscount` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `airtimepinprice`
--

INSERT INTO `airtimepinprice` (`aId`, `aNetwork`, `aUserDiscount`, `aAgentDiscount`, `aVendorDiscount`) VALUES
(1, '1', 99, 98, 97),
(2, '2', 99, 98, 97),
(3, '3', 99, 98, 97),
(4, '4', 99, 98, 97);

-- --------------------------------------------------------

--
-- Table structure for table `alphatopupprice`
--

CREATE TABLE `alphatopupprice` (
  `alphaId` int(200) NOT NULL,
  `buyingPrice` int(100) NOT NULL,
  `sellingPrice` int(100) NOT NULL,
  `agent` int(100) NOT NULL,
  `vendor` int(100) NOT NULL,
  `dPosted` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `apiconfigs`
--

CREATE TABLE `apiconfigs` (
  `aId` int(200) NOT NULL,
  `name` varchar(30) NOT NULL,
  `value` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `apiconfigs`
--

INSERT INTO `apiconfigs` (`aId`, `name`, `value`) VALUES
(1, 'monifyCharges', '1.08'),
(2, 'monifyApi', 'MK_PROD_6L'),
(3, 'monifySecrete', 'VDFZR0'),
(4, 'monifyContract', '6920'),
(5, 'monifyWeStatus', 'On'),
(6, 'monifyMoStatus', 'On'),
(7, 'monifyFeStatus', 'On'),
(8, 'monifySaStatus', 'On'),
(9, 'monifyStatus', 'On'),
(10, 'paystackCharges', '100'),
(11, 'paystackApi', 'a'),
(12, 'paystackStatus', 'Off'),
(13, 'mtnVtuKey', '49697ettdrd55555ggdd76ss77477ddssg6'),
(14, 'mtnVtuProvider', 'https://vtunaija.com.ng/api/airtime/'),
(15, 'mtnSharesellKey', '49697ettdrd55555ggdd76ss77477ddssg6'),
(16, 'mtnSharesellProvider', 'https://vtunaija.com.ng/api/airtime/'),
(17, 'airtelVtuKey', '49697ettdrd55555ggdd76ss77477ddssg6'),
(18, 'airtelVtuProvider', 'https://vtunaija.com.ng/api/airtime/'),
(19, 'airtelSharesellKey', '49697ettdrd55555ggdd76ss77477ddssg6'),
(20, 'airtelSharesellProvider', 'https://vtunaija.com.ng/api/airtime/'),
(21, 'gloVtuKey', '49697ettdrd55555ggdd76ss77477ddssg6'),
(22, 'gloVtuProvider', 'https://vtunaija.com.ng/api/airtime/'),
(23, 'gloSharesellKey', '49697ettdrd55555ggdd76ss77477ddssg6'),
(24, 'gloSharesellProvider', 'https://vtunaija.com.ng/api/airtime/'),
(25, '9mobileVtuKey', '49697ettdrd55555ggdd76ss77477ddssg6'),
(26, '9mobileVtuProvider', 'https://vtunaija.com.ng/api/airtime/'),
(27, '9mobileSharesellKey', '49697ettdrd55555ggdd76ss77477ddssg6'),
(28, '9mobileSharesellProvider', 'https://vtunaija.com.ng/api/airtime/'),
(29, 'mtnSmeApi', '49697ettdrd55555ggdd76ss77477ddssg6'),
(30, 'mtnSmeProvider', 'https://vtunaija.com.ng/api/data/'),
(31, 'mtnGiftingApi', '49697ettdrd55555ggdd76ss77477ddssg6'),
(32, 'mtnGiftingProvider', 'https://vtunaija.com.ng/api/data/'),
(33, 'mtnCorporateApi', '49697ettdrd55555ggdd76ss77477ddssg6'),
(34, 'mtnCorporateProvider', 'https://vtunaija.com.ng/api/data/'),
(35, 'airtelSmeApi', '49697ettdrd55555ggdd76ss77477ddssg6'),
(36, 'airtelSmeProvider', 'https://vtunaija.com.ng/api/data/'),
(37, 'airtelGiftingApi', '49697ettdrd55555ggdd76ss77477ddssg6'),
(38, 'airtelGiftingProvider', 'https://vtunaija.com.ng/api/data/'),
(39, 'airtelCorporateApi', '49697ettdrd55555ggdd76ss77477ddssg6'),
(40, 'airtelCorporateProvider', 'https://vtunaija.com.ng/api/data/'),
(41, 'gloSmeApi', '49697ettdrd55555ggdd76ss77477ddssg6'),
(42, 'gloSmeProvider', 'https://vtunaija.com.ng/api/data/'),
(43, 'gloGiftingApi', '49697ettdrd55555ggdd76ss77477ddssg6'),
(44, 'gloGiftingProvider', 'https://vtunaija.com.ng/api/data/'),
(45, 'gloCorporateApi', '49697ettdrd55555ggdd76ss77477ddssg6'),
(46, 'gloCorporateProvider', 'https://vtunaija.com.ng/api/data/'),
(47, '9mobileSmeApi', '49697ettdrd55555ggdd76ss77477ddssg6'),
(48, '9mobileSmeProvider', 'https://vtunaija.com.ng/api/data/'),
(49, '9mobileGiftingApi', '49697ettdrd55555ggdd76ss77477ddssg6'),
(50, '9mobileGiftingProvider', 'https://vtunaija.com.ng/api/data/'),
(51, '9mobileCorporateApi', '49697ettdrd55555ggdd76ss77477ddssg6'),
(52, '9mobileCorporateProvider', 'https://vtunaija.com.ng/api/data/'),
(53, 'cableVerificationApi', 'adad67512afd'),
(54, 'cableVerificationProvider', 'https://n3tdata.com/api/cable/cable-validation'),
(55, 'cableApi', 'ae3a512afd'),
(56, 'cableProvider', 'https://n3tdata.com/api/cable/'),
(57, 'meterVerificationApi', 'ad67512afd'),
(58, 'meterVerificationProvider', 'https://gladtidingsdata.com/api/validatemeter'),
(59, 'meterApi', 'add675fd'),
(60, 'meterProvider', 'https://gladtidingsdata.com/api/billpayment/'),
(61, 'examApi', 'd6751afd'),
(62, 'examProvider', 'https://gladtidingsdata.com/api/epin/'),
(63, 'rechargePinApi', ''),
(64, 'rechargePinProvider', ''),
(65, 'walletOneApi', '49697e666ggf66hh866hhg77hhde8'),
(66, 'walletOneProvider', 'https://gladtidingsdata.com/api/user/'),
(67, 'walletOneProviderName', 'Gladtidingsdata'),
(68, 'walletTwoApi', 'ggf555sdd5uuu888hhg690384187e8'),
(69, 'walletTwoProvider', 'https://maskawasub.com/api/user/'),
(70, 'walletTwoProviderName', 'Maskawasub'),
(71, 'walletThreeApi', '49697ettdrd55555ggdd76ss77477ddssg6'),
(72, 'walletThreeProvider', 'https://vtunaija.com.ng/api/user/'),
(73, 'walletThreeProviderName', 'VtuNaija'),
(74, 'dataPinApi', 'ada7'),
(75, 'dataPinProvider', 'https://gladtidingsdata.com/api/datarechargepin/'),
(76, 'alphaApi', ''),
(77, 'alphaProvider', '');

-- --------------------------------------------------------

--
-- Table structure for table `apilinks`
--

CREATE TABLE `apilinks` (
  `aId` int(200) NOT NULL,
  `name` varchar(30) NOT NULL,
  `value` varchar(100) DEFAULT NULL,
  `type` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `apilinks`
--

INSERT INTO `apilinks` (`aId`, `name`, `value`, `type`) VALUES
(1, 'VtuNaija', 'https://vtunaija.com.ng/api/user/', 'Wallet'),
(2, 'VtuNaija', 'https://vtunaija.com.ng/api/airtime/', 'Airtime'),
(3, 'VtuNaija', 'https://vtunaija.com.ng/api/data/', 'Data'),
(4, 'VtuNaija', 'https://vtunaija.com.ng/api/cabletv/verify/', 'CableVer'),
(5, 'VtuNaija', 'https://vtunaija.com.ng/api/cabletv/', 'Cable'),
(6, 'VtuNaija', 'https://vtunaija.com.ng/api/electricity/verify/', 'ElectricityVer'),
(7, 'VtuNaija', 'https://vtunaija.com.ng/api/electricity/', 'Electricity'),
(8, 'VtuNaija', 'https://vtunaija.com.ng/api/exam/', 'Exam'),
(9, 'N3T Data', 'https://n3tdata.com/api/user/', 'Wallet'),
(10, 'N3T Data', 'https://n3tdata.com/api/topup/', 'Airtime'),
(11, 'N3T Data', 'https://n3tdata.com/api/data/', 'Data'),
(12, 'N3T Data', 'https://n3tdata.com/api/cable/cable-validation', 'CableVer'),
(13, 'N3T Data', 'https://n3tdata.com/api/cable/', 'Cable'),
(14, 'N3T Data', 'https://n3tdata.com/api/bill/bill-validation', 'ElectricityVer'),
(15, 'N3T Data', 'https://n3tdata.com/api/bill/', 'Electricity'),
(16, 'N3T Data', 'https://n3tdata.com/api/exam/', 'Exam'),
(17, 'Bilalsadasub', 'https://bilalsadasub.com/api/user/', 'Wallet'),
(18, 'Bilalsadasub', 'https://bilalsadasub.com/api/topup/', 'Airtime'),
(19, 'Bilalsadasub', 'https://bilalsadasub.com/api/data/', 'Data'),
(20, 'Bilalsadasub', 'https://bilalsadasub.com/api/cable/cable-validation', 'CableVer'),
(21, 'Bilalsadasub', 'https://bilalsadasub.com/api/cable/', 'Cable'),
(22, 'Bilalsadasub', 'https://bilalsadasub.com/api/bill/bill-validation', 'ElectricityVer'),
(23, 'Bilalsadasub', 'https://bilalsadasub.com/api/bill/', 'Electricity'),
(24, 'Bilalsadasub', 'https://bilalsadasub.com/api/exam/', 'Exam'),
(33, 'Maskawasub', 'https://maskawasub.com/api/user/', 'Wallet'),
(34, 'Maskawasub', 'https://maskawasub.com/api/topup/', 'Airtime'),
(35, 'Maskawasub', 'https://maskawasub.com/api/data/', 'Data'),
(36, 'Maskawasub', 'https://maskawasub.com/api/validateiuc', 'CableVer'),
(37, 'Maskawasub', 'https://maskawasub.com/api/cablesub/', 'Cable'),
(38, 'Maskawasub', 'https://maskawasub.com/api/validatemeter', 'ElectricityVer'),
(39, 'Maskawasub', 'https://maskawasub.com/api/billpayment/', 'Electricity'),
(40, 'Maskawasub', 'https://maskawasub.com/api/epin/', 'Exam'),
(41, 'Gladtidingsdata', 'https://gladtidingsdata.com/api/user/', 'Wallet'),
(42, 'Gladtidingsdata', 'https://gladtidingsdata.com/api/topup/', 'Airtime'),
(43, 'Gladtidingsdata', 'https://gladtidingsdata.com/api/data/', 'Data'),
(44, 'Gladtidingsdata', 'https://gladtidingsdata.com/api/validateiuc', 'CableVer'),
(45, 'Gladtidingsdata', 'https://gladtidingsdata.com/api/cablesub/', 'Cable'),
(46, 'Gladtidingsdata', 'https://gladtidingsdata.com/api/validatemeter', 'ElectricityVer'),
(47, 'Gladtidingsdata', 'https://gladtidingsdata.com/api/billpayment/', 'Electricity'),
(48, 'Gladtidingsdata', 'https://gladtidingsdata.com/api/epin/', 'Exam'),
(49, 'Gongozconcept', 'https://gongozconcept.com/api/user/', 'Wallet'),
(50, 'Gongozconcept', 'https://gongozconcept.com/api/topup/', 'Airtime'),
(51, 'Gongozconcept', 'https://gongozconcept.com/api/data/', 'Data'),
(52, 'Gongozconcept', 'https://gongozconcept.com/api/validateiuc', 'CableVer'),
(53, 'Gongozconcept', 'https://gongozconcept.com/api/cablesub/', 'Cable'),
(54, 'Gongozconcept', 'https://gongozconcept.com/api/validatemeter', 'ElectricityVer'),
(55, 'Gongozconcept', 'https://gongozconcept.com/api/billpayment/', 'Electricity'),
(56, 'Gongozconcept', 'https://gongozconcept.com/api/epin/', 'Exam'),
(57, 'Sabrdataapi', 'https://sabrdataapi.com/api/user/', 'Wallet'),
(58, 'Sabrdataapi', 'https://sabrdataapi.com/api/topup/', 'Airtime'),
(59, 'Sabrdataapi', 'https://sabrdataapi.com/api/data/', 'Data'),
(60, 'Sabrdataapi', 'https://sabrdataapi.com/ajax/validate_iuc', 'CableVer'),
(61, 'Sabrdataapi', 'https://sabrdataapi.com/api/cablesub/', 'Cable'),
(62, 'Sabrdataapi', 'https://sabrdataapi.com/api/validatemeter', 'ElectricityVer'),
(63, 'Sabrdataapi', 'https://sabrdataapi.com/api/billpayment/', 'Electricity'),
(64, 'Sabrdataapi', 'https://sabrdataapi.com/api/epin/', 'Exam'),
(65, 'N3tdata247', 'https://n3tdata247.com/api/user/', 'Wallet'),
(66, 'N3tdata247', 'https://n3tdata247.com/api/data_card/', 'Data Pin'),
(67, 'Beensade', 'https://beensadeprint.com/api/user/', 'Wallet'),
(68, 'Beensade', 'https://beensadeprint.com/api/data_card/', 'Data Pin'),
(69, 'Gladtidingsdata', 'https://gladtidingsdata.com/api/datarechargepin/', 'Data Pin'),
(70, 'Gladtidingsdata', 'https://gladtidingsdata.com/api/rechargepin', 'Recharge Pin'),
(71, 'Apisebtech1vtu', 'https://api.sebtech1vtu.com.ng/api/data/', 'Data'),
(72, 'Apivtuorg', 'https://api.vtu.org.ng/api/airtime/', 'Airtime'),
(74, 'VtuNaija', 'https://vtunaija.com.ng/api/datapin/', 'Data Pin'),
(75, 'VtuNaija', 'https://vtunaija.com.ng/alphatopup', 'Alpha Topup');

-- --------------------------------------------------------

--
-- Table structure for table `cableid`
--

CREATE TABLE `cableid` (
  `cId` int(11) NOT NULL,
  `cableid` varchar(10) DEFAULT NULL,
  `provider` varchar(10) NOT NULL,
  `providerStatus` varchar(10) NOT NULL DEFAULT 'On'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `cableid`
--

INSERT INTO `cableid` (`cId`, `cableid`, `provider`, `providerStatus`) VALUES
(1, '1', 'GOTV', 'On'),
(2, '2', 'DSTV', 'On'),
(3, '3', 'STARTIMES', 'On');

-- --------------------------------------------------------

--
-- Table structure for table `cableplans`
--

CREATE TABLE `cableplans` (
  `cpId` int(100) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `userprice` varchar(255) NOT NULL,
  `agentprice` varchar(255) NOT NULL,
  `vendorprice` varchar(255) NOT NULL,
  `planid` varchar(255) NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `cableprovider` tinyint(10) NOT NULL,
  `day` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `cableplans`
--

INSERT INTO `cableplans` (`cpId`, `name`, `price`, `userprice`, `agentprice`, `vendorprice`, `planid`, `type`, `cableprovider`, `day`) VALUES
(1, 'Gotv Smallie', '1089', '1100', '1097', '1095', '1', NULL, 1, '30'),
(2, 'Gotv Jinja', '2228', '2250', '2245', '2240', '2', NULL, 1, '30'),
(3, 'Gotv Jolli', '3267', '3300', '3295', '3288', '3', NULL, 1, '30'),
(4, 'Gotv Max', '4802', '4850', '4840', '4830', '4', NULL, 1, '30'),
(5, 'Gotv Supa', '6336', '6390', '6380', '6365', '5', NULL, 1, '30'),
(6, 'Dstv Padi', '2475', '2495', '2490', '2485', '6', NULL, 2, '30'),
(7, 'Dstv Yanga', '3465', '3490', '3485', '3480', '7', NULL, 2, '30'),
(8, 'Dstv Confam', '6169', '6190', '6185', '6180', '8', NULL, 2, '30'),
(9, 'Dstv Compact', '10448', '10488', '10480', '10475', '9', NULL, 2, '30'),
(10, 'Dstv Compact Plus', '16517', '16575', '16570', '16565', '10', NULL, 2, '30'),
(11, 'Dstv Premiun', '24375', '24450', '24435', '24420', '11', NULL, 2, '30'),
(12, 'Dstv Premiun Asia', '32636', '32750', '32725', '32700', '12', NULL, 2, '30'),
(13, 'Nova', '1194', '1198', '1197', '1196', '13', NULL, 3, '30'),
(14, 'Basic (Antenna)', '2090', '2098', '2097', '2096', '14', NULL, 3, '30'),
(15, 'Smart (Dish)', '2786', '2796', '2795', '2793', '15', NULL, 3, '30'),
(16, 'Classic (Antenna)', '3085', '3096', '3094', '3092', '16', NULL, 3, '30'),
(17, 'Super (Dish)', '5274', '5296', '5292', '5288', '17', NULL, 3, '30'),
(18, 'Special', '3883', '3896', '3893', '3890', '18', NULL, 3, '30');

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `msgId` int(200) NOT NULL,
  `sId` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `contact` varchar(200) NOT NULL,
  `subject` varchar(200) NOT NULL,
  `message` text NOT NULL,
  `dPosted` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`msgId`, `sId`, `name`, `contact`, `subject`, `message`, `dPosted`) VALUES
(1, 0, 'Topupmate', 'ibyusuf31@gmail.com', 'Testing', 'Test', '2022-06-21 17:06:56'),
(2, 0, 'Ibrahim Ahmed', 'ibyusuf31@gmail.com', 'Test From Landing Page', 'Test From Landing Page', '2022-06-23 13:08:11');

-- --------------------------------------------------------

--
-- Table structure for table `crypto`
--

CREATE TABLE `crypto` (
  `type` varchar(255) NOT NULL,
  `network` tinyint(255) NOT NULL,
  `agentrate` varchar(255) NOT NULL,
  `userrate` varchar(255) NOT NULL,
  `vendorrate` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `datapins`
--

CREATE TABLE `datapins` (
  `dpId` int(100) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `userprice` varchar(255) NOT NULL,
  `agentprice` varchar(255) NOT NULL,
  `vendorprice` varchar(255) NOT NULL,
  `planid` varchar(255) NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `datanetwork` tinyint(10) NOT NULL,
  `day` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `datapins`
--

INSERT INTO `datapins` (`dpId`, `name`, `price`, `userprice`, `agentprice`, `vendorprice`, `planid`, `type`, `datanetwork`, `day`) VALUES
(1, '1.5GB', '200', '300', '300', '300', '1', 'Gifting', 1, '30'),
(2, '500 MB', '108', '120', '120', '120', '2', 'SME', 1, '30'),
(3, '1GB', '215', '220', '220', '220', '3', 'SME', 1, '30'),
(4, '2GB', '430', '450', '450', '450', '4', 'SME', 1, '30'),
(5, '3GB', '645', '650', '650', '650', '5', 'SME', 1, '30'),
(6, '5GB', '1075', '1090', '1090', '1090', '6', 'SME', 1, '30'),
(7, '10GB', '2150', '2200', '2200', '2200', '7', 'SME', 1, '30'),
(8, '500 MB', '100', '120', '120', '120', '8', 'Corporate', 2, '30'),
(9, '1GB', '200', '220', '220', '220', '9', 'Corporate', 2, '30'),
(10, '2GB', '400', '420', '420', '420', '10', 'Corporate', 2, '30'),
(11, '5GB', '1000', '1200', '1200', '1200', '11', 'Corporate', 2, '30'),
(12, '10GB', '2000', '2200', '2200', '2200', '12', 'Corporate', 2, '30');

-- --------------------------------------------------------

--
-- Table structure for table `dataplans`
--

CREATE TABLE `dataplans` (
  `pId` int(100) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `userprice` varchar(255) NOT NULL,
  `agentprice` varchar(255) NOT NULL,
  `vendorprice` varchar(255) NOT NULL,
  `planid` varchar(255) NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `datanetwork` tinyint(10) NOT NULL,
  `day` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `dataplans`
--

INSERT INTO `dataplans` (`pId`, `name`, `price`, `userprice`, `agentprice`, `vendorprice`, `planid`, `type`, `datanetwork`, `day`) VALUES
(1, '500 MB', '109', '125', '122', '118', '1', 'SME', 1, '30'),
(2, '1GB', '216', '235', '230', '225', '2', 'SME', 1, '30'),
(3, '2GB', '432', '470', '460', '450', '3', 'SME', 1, '30'),
(4, '3GB', '657', '705', '690', '675', '4', 'SME', 1, '30'),
(5, '5GB', '1095', '1165', '1150', '1135', '5', 'SME', 1, '30'),
(6, '10GB', '2190', '2350', '2300', '2250', '6', 'SME', 1, '30'),
(7, '50MB', '26', '35', '33', '30', '7', 'Corporate', 1, '7'),
(8, '150 MB', '52', '70', '65', '60', '8', 'Corporate', 1, '7'),
(9, '250 MB', '62', '80', '75', '70', '9', 'Corporate', 1, '7'),
(10, '500 MB', '117', '130', '126', '122', '10', 'Corporate', 1, '30'),
(11, '1 GB', '226', '250', '245', '235', '11', 'Corporate', 1, '30'),
(12, '2 GB', '452', '500', '490', '470', '12', 'Corporate', 1, '30'),
(13, '3 GB', '678', '750', '735', '705', '13', 'Corporate', 1, '30'),
(14, '5 GB', '1130', '1250', '1223', '1175', '14', 'Corporate', 1, '30'),
(15, '10 GB', '2260', '2500', '2450', '2350', '15', 'Corporate', 1, '30'),
(16, '500 MB SME 2', '117', '130', '126', '122', '16', 'Gifting', 1, '30'),
(17, '1 GB SME 2', '226', '250', '245', '235', '17', 'Gifting', 1, '30'),
(18, '2 GB sME2', '452', '500', '490', '470', '18', 'Gifting', 1, '30'),
(19, '3 GB SME 2', '678', '750', '735', '705', '19', 'Gifting', 1, '30'),
(20, '5 GB SME 2', '1130', '1225', '1222', '1175', '20', 'Gifting', 1, '30'),
(21, '10GB SME 2', '2260', '2500', '2500', '2500', '21', 'Gifting', 1, '30'),
(22, '500 MB', '105', '130', '125', '120', '22', 'Corporate', 2, '30'),
(23, '1 GB', '226', '270', '260', '250', '23', 'Corporate', 2, '30'),
(24, '2 GB', '452', '540', '520', '500', '24', 'Corporate', 2, '30'),
(25, '3 GB', '678', '810', '780', '750', '25', 'Corporate', 2, '30'),
(26, '5 GB', '1130', '1350', '1300', '1250', '26', 'Corporate', 2, '30'),
(27, '10 GB', '2260', '2700', '2600', '2500', '27', 'Corporate', 2, '30'),
(28, '500 MB', '105', '128', '125', '120', '28', 'Corporate', 4, '30'),
(29, '1 GB', '210', '240', '235', '230', '29', 'Corporate', 4, '30'),
(30, '2 GB', '420', '480', '470', '460', '30', 'Corporate', 4, '30'),
(31, '100MB', '41', '55', '52', '48', '31', 'Corporate', 4, '30'),
(32, '5 GB', '1050', '1200', '1175', '1150', '32', 'Corporate', 4, '30'),
(33, '10 GB', '2100', '2400', '2350', '2300', '33', 'Corporate', 4, '30'),
(34, '500 MB', '85', '95', '90', '87', '34', 'Corporate', 3, '30'),
(35, '1 GB', '170', '190', '185', '180', '35', 'Corporate', 3, '30'),
(36, '2 GB', '340', '380', '370', '360', '36', 'Corporate', 3, '30'),
(37, '3 GB', '510', '570', '555', '540', '37', 'Corporate', 3, '30'),
(38, '300MB', '61', '73', '72', '70', '38', 'Corporate', 4, '14'),
(40, '10GB', '1550', '1900', '1850', '1800', '39', 'Corporate', 3, '30'),
(41, '1.8GB', '468', '490', '485', '480', '40', 'Gifting', 2, '14'),
(42, '3.9GB', '935', '960', '955', '950', '41', 'Gifting', 2, '30'),
(43, '9.2GB', '1870', '1950', '1925', '1900', '42', 'Gifting', 2, '30'),
(44, '14GB', '2795', '2930', '2900', '2870', '43', 'Gifting', 2, '30'),
(45, '10.8GB', '2350', '2420', '2410', '2400', '44', 'Gifting', 2, '30'),
(46, '650MB', '172', '185', '182', '180', '45', 'Gifting', 3, '30'),
(47, '1500', '826', '840', '838', '835', '46', 'Gifting', 3, '30'),
(48, '4500MB', '1648', '1680', '1675', '1670', '47', 'Gifting', 3, '30'),
(49, '11GB', '3290', '3350', '3345', '3340', '48', 'Gifting', 3, '30'),
(50, '200MB', '53', '60', '59', '58', '49', 'Corporate', 2, '30');

-- --------------------------------------------------------

--
-- Table structure for table `datatokens`
--

CREATE TABLE `datatokens` (
  `tId` int(100) NOT NULL,
  `sId` int(100) NOT NULL,
  `tRef` varchar(255) NOT NULL,
  `business` varchar(30) NOT NULL,
  `network` varchar(30) NOT NULL,
  `datasize` varchar(30) NOT NULL,
  `quantity` int(100) NOT NULL,
  `serial` text NOT NULL,
  `tokens` text NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `electricityid`
--

CREATE TABLE `electricityid` (
  `eId` int(11) NOT NULL,
  `electricityid` varchar(50) DEFAULT NULL,
  `provider` varchar(50) NOT NULL,
  `abbreviation` varchar(5) NOT NULL,
  `providerStatus` varchar(10) NOT NULL DEFAULT 'On'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `electricityid`
--

INSERT INTO `electricityid` (`eId`, `electricityid`, `provider`, `abbreviation`, `providerStatus`) VALUES
(1, '1', 'Ikeja Electric', 'IE', 'On'),
(2, '2', 'Eko Electric', 'EKEDC', 'On'),
(3, '3', 'Kano Electric', 'KEDCO', 'On'),
(4, '4', 'Port Harcourt Electric', 'PHEDC', 'On'),
(5, '5', 'Jos Electric', 'JED', 'On'),
(6, '6', 'Ibadan Electric', 'IBEDC', 'On'),
(7, '7', 'Kaduna Electric', 'KEDC', 'On'),
(8, '8', 'Abuja Electric', 'AEDC', 'On'),
(9, '9', 'Enugu Electric', 'ENUGU', 'On'),
(10, '10', 'Benin Electric', 'BENIN', 'On'),
(11, '11', 'Yola Electric', 'YOLA', 'On');

-- --------------------------------------------------------

--
-- Table structure for table `examid`
--

CREATE TABLE `examid` (
  `eId` int(11) NOT NULL,
  `examid` varchar(10) DEFAULT NULL,
  `provider` varchar(50) NOT NULL,
  `price` int(20) NOT NULL DEFAULT 0,
  `buying_price` int(20) NOT NULL DEFAULT 0,
  `providerStatus` varchar(10) NOT NULL DEFAULT 'On'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `examid`
--

INSERT INTO `examid` (`eId`, `examid`, `provider`, `price`, `buying_price`, `providerStatus`) VALUES
(1, '1', 'WAEC', 2850, 2750, 'On'),
(2, '2', 'NECO', 900, 816, 'On'),
(3, '3', 'NABTEB', 880, 800, 'On');

-- --------------------------------------------------------

--
-- Table structure for table `networkid`
--

CREATE TABLE `networkid` (
  `nId` int(11) NOT NULL,
  `networkid` varchar(10) NOT NULL,
  `smeId` varchar(10) NOT NULL,
  `giftingId` varchar(10) NOT NULL,
  `corporateId` varchar(10) NOT NULL,
  `vtuId` varchar(10) NOT NULL,
  `sharesellId` varchar(10) NOT NULL,
  `network` varchar(20) NOT NULL,
  `networkStatus` varchar(10) NOT NULL DEFAULT 'Off',
  `vtuStatus` varchar(10) NOT NULL DEFAULT 'Off',
  `sharesellStatus` varchar(10) NOT NULL DEFAULT 'Off',
  `airtimepinStatus` varchar(10) NOT NULL DEFAULT 'Off',
  `smeStatus` varchar(10) NOT NULL DEFAULT 'Off',
  `giftingStatus` varchar(10) NOT NULL DEFAULT 'Off',
  `corporateStatus` varchar(10) NOT NULL DEFAULT 'Off',
  `datapinStatus` varchar(10) NOT NULL DEFAULT 'Off'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `networkid`
--

INSERT INTO `networkid` (`nId`, `networkid`, `smeId`, `giftingId`, `corporateId`, `vtuId`, `sharesellId`, `network`, `networkStatus`, `vtuStatus`, `sharesellStatus`, `airtimepinStatus`, `smeStatus`, `giftingStatus`, `corporateStatus`, `datapinStatus`) VALUES
(1, '1', '1', '1', '1', '1', '1', 'MTN', 'On', 'On', 'On', 'On', 'On', 'On', 'On', 'On'),
(2, '2', '2', '2', '2', '2', '2', 'GLO', 'On', 'On', 'On', 'On', 'Off', 'On', 'On', 'On'),
(3, '3', '3', '3', '3', '3', '3', '9MOBILE', 'On', 'On', 'On', 'On', 'Off', 'On', 'On', 'On'),
(4, '4', '4', '4', '4', '4', '4', 'AIRTEL', 'On', 'On', 'On', 'On', 'Off', 'Off', 'On', 'On');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `msgId` int(200) NOT NULL,
  `msgfor` tinyint(4) NOT NULL,
  `subject` varchar(200) NOT NULL,
  `message` text NOT NULL,
  `status` tinyint(3) NOT NULL DEFAULT 0,
  `dPosted` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`msgId`, `msgfor`, `subject`, `message`, `status`, `dPosted`) VALUES
(1, 3, 'Welcome Message', 'Hi There! You are welcome, we are your one-stop platform for all for bills payment, airtime, data plans, and cable tv subscription. All our services are available to you at a discount rate. Our customer support team is available to you 24/7.', 0, '2022-06-21 17:05:02');

-- --------------------------------------------------------

--
-- Table structure for table `sitesettings`
--

CREATE TABLE `sitesettings` (
  `sId` int(200) NOT NULL,
  `sitename` varchar(20) DEFAULT NULL,
  `siteurl` varchar(100) DEFAULT NULL,
  `agentupgrade` varchar(20) DEFAULT NULL,
  `vendorupgrade` varchar(20) DEFAULT NULL,
  `apidocumentation` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `whatsapp` varchar(20) DEFAULT NULL,
  `whatsappgroup` varchar(100) DEFAULT NULL,
  `facebook` varchar(10) DEFAULT NULL,
  `twitter` varchar(200) DEFAULT NULL,
  `instagram` varchar(200) DEFAULT NULL,
  `telegram` varchar(100) DEFAULT NULL,
  `referalupgradebonus` float NOT NULL DEFAULT 100,
  `referalairtimebonus` float NOT NULL DEFAULT 1,
  `referaldatabonus` float NOT NULL DEFAULT 1,
  `referalwalletbonus` float NOT NULL DEFAULT 1,
  `referalcablebonus` float NOT NULL DEFAULT 1,
  `referalexambonus` float NOT NULL DEFAULT 1,
  `referalmeterbonus` float NOT NULL DEFAULT 1,
  `wallettowalletcharges` float NOT NULL DEFAULT 50,
  `sitecolor` varchar(10) NOT NULL DEFAULT '#0000e6',
  `logindesign` varchar(10) NOT NULL DEFAULT '5',
  `homedesign` varchar(10) NOT NULL DEFAULT '5',
  `notificationStatus` varchar(5) NOT NULL DEFAULT 'Off',
  `accountname` varchar(50) DEFAULT NULL,
  `accountno` varchar(15) DEFAULT NULL,
  `bankname` varchar(20) DEFAULT NULL,
  `electricitycharges` varchar(5) DEFAULT NULL,
  `airtimemin` varchar(10) NOT NULL DEFAULT '50',
  `airtimemax` varchar(10) NOT NULL DEFAULT '500'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `sitesettings`
--

INSERT INTO `sitesettings` (`sId`, `sitename`, `siteurl`, `agentupgrade`, `vendorupgrade`, `apidocumentation`, `phone`, `email`, `whatsapp`, `whatsappgroup`, `facebook`, `twitter`, `instagram`, `telegram`, `referalupgradebonus`, `referalairtimebonus`, `referaldatabonus`, `referalwalletbonus`, `referalcablebonus`, `referalexambonus`, `referalmeterbonus`, `wallettowalletcharges`, `sitecolor`, `logindesign`, `homedesign`, `notificationStatus`, `accountname`, `accountno`, `bankname`, `electricitycharges`, `airtimemin`, `airtimemax`) VALUES
(1, 'Coolest Hub', 'https://www.coolesthub.com.ng', '0', '0', 'https://www.coolesthub.com.ng/mobile/home/pricing', '07046306346', 'telecomplug@gmail.com', '7046306346', '', '', '', '', '', 0, 0.2, 1, 0, 15, 20, 10, 10, '#0000ff', '3', '5', 'On', 'Sebastine O. ', '9159599001', 'Opay(Paycom)', '0', '50', '5000');

-- --------------------------------------------------------

--
-- Table structure for table `subscribers`
--

CREATE TABLE `subscribers` (
  `sId` int(200) NOT NULL,
  `sApiKey` varchar(200) NOT NULL,
  `sFname` varchar(50) NOT NULL,
  `sLname` varchar(50) NOT NULL,
  `sEmail` varchar(50) DEFAULT NULL,
  `sPhone` varchar(20) NOT NULL,
  `sPass` varchar(150) NOT NULL,
  `sState` varchar(50) NOT NULL,
  `sPin` int(10) NOT NULL DEFAULT 1234,
  `sPinStatus` tinyint(3) DEFAULT 0,
  `sType` tinyint(10) NOT NULL DEFAULT 1,
  `sWallet` float NOT NULL DEFAULT 0,
  `sRefWallet` float NOT NULL DEFAULT 0,
  `sBankNo` varchar(20) DEFAULT NULL,
  `sRolexBank` varchar(20) DEFAULT NULL,
  `sSterlingBank` varchar(20) DEFAULT NULL,
  `sFidelityBank` varchar(20) DEFAULT NULL,
  `sBankName` varchar(30) DEFAULT NULL,
  `sRegStatus` tinyint(5) NOT NULL DEFAULT 3,
  `sVerCode` smallint(20) NOT NULL DEFAULT 0,
  `sRegDate` datetime NOT NULL DEFAULT current_timestamp(),
  `sLastActivity` datetime DEFAULT NULL,
  `sReferal` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `subscribers`
--

INSERT INTO `subscribers` (`sId`, `sApiKey`, `sFname`, `sLname`, `sEmail`, `sPhone`, `sPass`, `sState`, `sPin`, `sPinStatus`, `sType`, `sWallet`, `sRefWallet`, `sBankNo`, `sRolexBank`, `sSterlingBank`, `sFidelityBank`, `sBankName`, `sRegStatus`, `sVerCode`, `sRegDate`, `sLastActivity`, `sReferal`) VALUES
(2, 'sBCCiGv3CoICpq1ArAC92lf8dx2AAbdB34yBnJCAwAeBH2cCA3BzcF3Dg6CE1682020195', 'Sebastine', 'Kattahh', 'ojiemudiaekatah521@gmail.com', '07046306346', '3198def47c', 'Abia', 1, 0, 1, 901, 0, '7200229040', '6259997752', '8942728199', '4553049272', 'Wema bank', 0, 1930, '2023-04-20 20:49:55', '2023-05-29 22:33:41', '');

-- --------------------------------------------------------

--
-- Table structure for table `sysusers`
--

CREATE TABLE `sysusers` (
  `sysId` int(100) NOT NULL,
  `sysName` varchar(50) NOT NULL,
  `sysRole` tinyint(2) NOT NULL,
  `sysUsername` varchar(20) NOT NULL,
  `sysToken` varchar(30) NOT NULL,
  `sysStatus` tinyint(2) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `sysusers`
--

INSERT INTO `sysusers` (`sysId`, `sysName`, `sysRole`, `sysUsername`, `sysToken`, `sysStatus`) VALUES
(1, 'Coolest Hub', 1, 'Coolesthubmanager', 'Coolesthub111', 0);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `tId` int(200) NOT NULL,
  `sId` int(100) NOT NULL,
  `transref` varchar(255) NOT NULL,
  `servicename` varchar(100) NOT NULL,
  `servicedesc` varchar(255) NOT NULL,
  `amount` varchar(100) NOT NULL,
  `status` tinyint(5) NOT NULL,
  `oldbal` varchar(100) NOT NULL,
  `newbal` varchar(100) NOT NULL,
  `profit` float NOT NULL DEFAULT 0,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`tId`, `sId`, `transref`, `servicename`, `servicedesc`, `amount`, `status`, `oldbal`, `newbal`, `profit`, `date`) VALUES
(1, 2, '96601682064954', 'Wallet Credit', 'Wallet Credit of N1000 for user ojiemudiaekatah521@gmail.com. Reason: Trh', '1000', 0, '0', '1000', 0, '2023-04-21 09:15:54'),
(2, 2, '43721682064983', 'Airtime', 'MTN Airtime purchase of N100 for phone number 08105992014', '99', 0, '1000', '901', 3, '2023-04-21 09:17:14'),
(3, 2, '49971682145645', 'Data', 'Purchase of MTN 500 MB SME 30 Days Plan for phone number 08105992014', '150', 1, '901', '901', 0, '2023-04-22 07:41:24'),
(4, 2, '45241682146106', 'Data', 'Purchase of MTN 500 MB SME 30 Days Plan for phone number 08105992014', '150', 1, '901', '901', 0, '2023-04-22 07:49:29'),
(5, 2, '87571682146497', 'Data', 'Purchase of MTN 500 MB SME 30 Days Plan for phone number 08105992014', '150', 1, '901', '901', 0, '2023-04-22 07:55:49'),
(6, 2, '88661682469674', 'Data', 'Purchase of MTN 500 MB SME 30 Days Plan for phone number 07046306346', '150', 1, '901', '901', 0, '2023-04-26 01:41:48'),
(7, 2, '95901684103013', 'Data', 'Purchase of MTN 500 MB SME 30 Days Plan for phone number 07046306346', '125', 1, '901', '901', 0, '2023-05-14 23:25:07');

-- --------------------------------------------------------

--
-- Table structure for table `userlogin`
--

CREATE TABLE `userlogin` (
  `id` int(200) NOT NULL,
  `user` int(100) NOT NULL,
  `token` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `userlogin`
--

INSERT INTO `userlogin` (`id`, `user`, `token`) VALUES
(1, 2, '1682020195kDHxrltqwC931'),
(2, 2, '1682022590tvynzkmDHl696'),
(3, 2, '1682064629IzAHCwksJo121'),
(4, 2, '1682145627qHwlyrAFox979'),
(5, 2, '1682295203mFEqlCkBIz212'),
(6, 2, '1682469642JIBtlkpHxo546'),
(7, 2, '1682491677ACzxHpwBrG805'),
(8, 2, '1684102945EIAtHpxJqz440'),
(9, 2, '1684183224slBqEntprw206'),
(10, 2, '1684185918CJAlrtvozq982'),
(11, 2, '1684417906ArCqsmEIzt825'),
(12, 2, '1684614752FmnlBtHADr425'),
(13, 2, '1684622753JzICGtFyro732'),
(14, 2, '1685394296kABmtorvyG415');

-- --------------------------------------------------------

--
-- Table structure for table `uservisits`
--

CREATE TABLE `uservisits` (
  `id` int(200) NOT NULL,
  `user` int(100) NOT NULL,
  `state` varchar(10) NOT NULL,
  `visitTime` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `uservisits`
--

INSERT INTO `uservisits` (`id`, `user`, `state`, `visitTime`) VALUES
(1, 2, 'Abia', '1682020205'),
(2, 2, 'Abia', '1682022594'),
(3, 2, 'Abia', '1682469646'),
(4, 2, 'Abia', '1684614755');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `airtime`
--
ALTER TABLE `airtime`
  ADD PRIMARY KEY (`aId`);

--
-- Indexes for table `airtimepinprice`
--
ALTER TABLE `airtimepinprice`
  ADD PRIMARY KEY (`aId`);

--
-- Indexes for table `alphatopupprice`
--
ALTER TABLE `alphatopupprice`
  ADD PRIMARY KEY (`alphaId`);

--
-- Indexes for table `apiconfigs`
--
ALTER TABLE `apiconfigs`
  ADD PRIMARY KEY (`aId`);

--
-- Indexes for table `apilinks`
--
ALTER TABLE `apilinks`
  ADD PRIMARY KEY (`aId`);

--
-- Indexes for table `cableid`
--
ALTER TABLE `cableid`
  ADD PRIMARY KEY (`cId`);

--
-- Indexes for table `cableplans`
--
ALTER TABLE `cableplans`
  ADD PRIMARY KEY (`cpId`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`msgId`);

--
-- Indexes for table `datapins`
--
ALTER TABLE `datapins`
  ADD PRIMARY KEY (`dpId`);

--
-- Indexes for table `dataplans`
--
ALTER TABLE `dataplans`
  ADD PRIMARY KEY (`pId`);

--
-- Indexes for table `datatokens`
--
ALTER TABLE `datatokens`
  ADD PRIMARY KEY (`tId`);

--
-- Indexes for table `electricityid`
--
ALTER TABLE `electricityid`
  ADD PRIMARY KEY (`eId`);

--
-- Indexes for table `examid`
--
ALTER TABLE `examid`
  ADD PRIMARY KEY (`eId`);

--
-- Indexes for table `networkid`
--
ALTER TABLE `networkid`
  ADD PRIMARY KEY (`nId`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`msgId`);

--
-- Indexes for table `sitesettings`
--
ALTER TABLE `sitesettings`
  ADD PRIMARY KEY (`sId`);

--
-- Indexes for table `subscribers`
--
ALTER TABLE `subscribers`
  ADD PRIMARY KEY (`sId`),
  ADD UNIQUE KEY `sApiKey` (`sApiKey`),
  ADD UNIQUE KEY `sPhone` (`sPhone`),
  ADD UNIQUE KEY `sEmail` (`sEmail`);

--
-- Indexes for table `sysusers`
--
ALTER TABLE `sysusers`
  ADD PRIMARY KEY (`sysId`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`tId`),
  ADD UNIQUE KEY `transref` (`transref`);

--
-- Indexes for table `userlogin`
--
ALTER TABLE `userlogin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `uservisits`
--
ALTER TABLE `uservisits`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `airtime`
--
ALTER TABLE `airtime`
  MODIFY `aId` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `airtimepinprice`
--
ALTER TABLE `airtimepinprice`
  MODIFY `aId` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `alphatopupprice`
--
ALTER TABLE `alphatopupprice`
  MODIFY `alphaId` int(200) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `apiconfigs`
--
ALTER TABLE `apiconfigs`
  MODIFY `aId` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `apilinks`
--
ALTER TABLE `apilinks`
  MODIFY `aId` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `cableid`
--
ALTER TABLE `cableid`
  MODIFY `cId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cableplans`
--
ALTER TABLE `cableplans`
  MODIFY `cpId` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `msgId` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `datapins`
--
ALTER TABLE `datapins`
  MODIFY `dpId` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `dataplans`
--
ALTER TABLE `dataplans`
  MODIFY `pId` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `datatokens`
--
ALTER TABLE `datatokens`
  MODIFY `tId` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `electricityid`
--
ALTER TABLE `electricityid`
  MODIFY `eId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `examid`
--
ALTER TABLE `examid`
  MODIFY `eId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `networkid`
--
ALTER TABLE `networkid`
  MODIFY `nId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `msgId` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sitesettings`
--
ALTER TABLE `sitesettings`
  MODIFY `sId` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `subscribers`
--
ALTER TABLE `subscribers`
  MODIFY `sId` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sysusers`
--
ALTER TABLE `sysusers`
  MODIFY `sysId` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `tId` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `userlogin`
--
ALTER TABLE `userlogin`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `uservisits`
--
ALTER TABLE `uservisits`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
