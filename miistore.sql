-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 15, 2018 at 07:12 AM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `miistore`
--

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `brd_id` int(11) NOT NULL,
  `brand` varchar(50) NOT NULL,
  `logo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`brd_id`, `brand`, `logo`) VALUES
(1, 'John Player', 'john-players.png'),
(2, 'Pepe Jeans', 'pepe-jeans.png'),
(3, 'Jack and Jones', 'jack-jones.png'),
(4, 'Adidas', 'adidas.png'),
(5, 'Chanel', 'Chanel.png'),
(6, 'Calvin Klein', 'CK-Calvin-Klein.png'),
(7, 'Lacoste', 'lacoste.png'),
(8, 'Levis', 'Levis.png'),
(9, 'Nike', 'nike.png'),
(10, 'Puma', 'puma.png'),
(11, 'Fila', 'fila.png'),
(12, 'Reebok', 'reebok.png'),
(13, 'Purys', 'purys.png'),
(14, 'Old Navy', 'Old_Navy.png'),
(15, 'Forever 21', 'forever21.png');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `cat_id` int(11) NOT NULL,
  `category` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`cat_id`, `category`) VALUES
(1, 'Topwear'),
(2, 'Bottomwear'),
(3, 'Footwear'),
(4, 'Western Wear'),
(5, 'Men Fashion Accessories'),
(6, 'Sports and Active Wear'),
(7, 'Boys Clothing'),
(8, 'Girls Clothing'),
(9, 'Boys Footwear'),
(10, 'Girls Footwear'),
(11, 'Kids Accessories'),
(12, 'Women Clothing');

-- --------------------------------------------------------

--
-- Table structure for table `colors`
--

CREATE TABLE `colors` (
  `clr_id` int(11) NOT NULL,
  `color` varchar(30) NOT NULL,
  `color_cd` varchar(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `colors`
--

INSERT INTO `colors` (`clr_id`, `color`, `color_cd`) VALUES
(0, 'No Color', ''),
(1, 'White', '#FFFFFF'),
(2, 'Black', '#000000'),
(3, 'Red', '#FF0000'),
(4, 'Yellow', '#FFFF00'),
(5, 'Navy Blue', '#000080'),
(6, 'Charcoal Gray', '#4D4E4F'),
(7, 'Brown', '#A52A2A');

-- --------------------------------------------------------

--
-- Table structure for table `counter`
--

CREATE TABLE `counter` (
  `counter_id` int(11) NOT NULL,
  `counter_ip` varchar(50) NOT NULL,
  `counter_date` date NOT NULL,
  `counter_time` time NOT NULL,
  `counter_visit` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `item_id` varchar(11) NOT NULL,
  `item_name` varchar(100) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `scat_id` int(11) NOT NULL,
  `brd_id` int(11) NOT NULL,
  `size` varchar(30) NOT NULL,
  `clr_id` varchar(11) NOT NULL,
  `bgimg` varchar(50) NOT NULL,
  `image` varchar(100) NOT NULL,
  `detail` text NOT NULL,
  `material_care` mediumtext NOT NULL,
  `price` varchar(11) NOT NULL,
  `discount` varchar(11) NOT NULL,
  `stock` int(11) NOT NULL,
  `available` varchar(10) NOT NULL,
  `creation_date` date NOT NULL DEFAULT '0000-00-00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`item_id`, `item_name`, `cat_id`, `scat_id`, `brd_id`, `size`, `clr_id`, `bgimg`, `image`, `detail`, `material_care`, `price`, `discount`, `stock`, `available`, `creation_date`) VALUES
('0001', 'PURYS Women Beige Floral Printed', 4, 13, 13, 'S,M,L,XL', '0', '0818shirt4.jpg', 'shirt1.jpg,shirt2.jpg,shirt3.jpg,shirt4.jpg', 'Beige women shirt, has contrast floral print throughout, a spread collar, long sleeves with button cuffs, a full button placket on the front, gathers below the back yoke', 'Polyester\r\nMachine Wash', '158000', '0', 90, 'Ada', '2017-07-03'),
('0002', 'Relaxed Lace-Trim Sleeveless Top for Women', 4, 13, 14, 'S,M,L,XL', '1,2', '0818shirt5.jpg', 'shirt5.jpg,shirt6.jpg,shirt7.jpg,shirt8.jpg', 'Rounded neck, with button-loop keyhole opening at nape, sleeveless arm opening, crochet-lace cut work and embroidered eyelets, soft, garment-washed lawn cotton, swing silhouette', '100% cotton\r\nMachine Wash\r\nImported', '129000', '20', 1, 'Ada', '2017-07-03'),
('0003', 'Jack & Jones Men Grey Printed Round Neck', 1, 1, 3, 'S,M,L,XL,XXL', '0', '0818tshirt1.jpg', 'tshirt1.jpg,tshirt2.jpg,tshirt3.jpg,tshirt4.jpg', 'Grey printed T-shirt, has a round neck, short sleeves', '100% cotton\r\nMachine Wash', '149500', '20', 100, 'Ada', '2017-08-15'),
('0004', 'Jack & Jones Men Grey Printed Polo Collar', 1, 1, 3, 'S,M,L,XL,XXL', '0', '0818tshirt5.jpg', 'tshirt5.jpg,tshirt6.jpg,tshirt7.jpg,tshirt8.jpg', 'Grey and green printed waist length T-Shirt, has a polo collar with a short button placket, short sleeves', '100% cotton\r\nMachine Wash', '149500', '20', 99, 'Ada', '2017-08-15'),
('0005', 'Jack & Jones Men Blue Printed Round Neck', 1, 1, 3, 'S,M,L,XL', '0', '0818tshirt9.jpg', 'tshirt9.jpg,tshirt10.jpg,tshirt11.jpg,tshirt12.jpg', 'Blue printed T-Shirt, has a round neck, short sleeves', '100% cotton\r\nMachine Wash', '149500', '20', 99, 'Ada', '2017-08-15'),
('0006', 'PURYS Women Olive Green Tailored Fit Solid', 4, 13, 13, 'S,M,L,XL', '0', '0818shirt9.jpg', 'shirt9.jpg,shirt10.jpg,shirt11.jpg,shirt12.jpg', 'Olive green solid casual shirt, has a spread solid, button placket, long sleeves with roll-up tab features, two patch pockets, curved hem', 'Rayon\r\nMachine Wash', '158000', '0', 48, 'Ada', '2017-08-15'),
('0007', 'PURYS Women Cream-Coloured Printed Top', 4, 13, 13, 'S,M,L', '0', '0818shirt13.jpg', 'shirt13.jpg,shirt14.jpg,shirt17.jpg,shirt18.jpg', 'Cream-coloured printed top with layered detail, has a round neck, cold shoulder long sleeves, a button closure on the back', '100% polyester\r\nMachine Wash', '119000', '20', 48, 'Ada', '2017-08-15'),
('0008', 'John Players Men Blue Trim Fit Self-Design', 1, 2, 1, '38,40,42,44', '0', '0818casual1.jpg', 'casual1.jpg,casual2.jpg,casual3.jpg,casual4.jpg', 'Blue self-design casual shirt, has a spread collar, button placket, long sleeves, a chest pocket, curved hem', '100% cotton\r\nMachine Wash', '214890', '20', 50, 'Ada', '2017-08-15'),
('0009', 'Lacoste Grey Regular Fit Solid', 1, 2, 7, '40,42,44', '0', '0819casual5.jpg', 'casual5.jpg,casual6.jpg,casual7.jpg', 'Grey solid casual shirt, has a button-down collar, button placket, long sleeves, curved hem', 'Cotton\r\nMachine-Wash', '223800', '0', 50, 'Ada', '2017-08-21'),
('0010', 'Lacoste Blue Slim Fit Jacquard Poplin', 1, 2, 7, '40,42,44,46', '0', '0819casual8.jpg', 'casual8.jpg,casual9.jpg,casual10.jpg', 'Blue self-design casual shirt, has a spread collar, button placket, long sleeves, curved hem', 'Cotton\r\nMachine-Wash', '223800', '0', 50, 'Ada', '2017-08-21'),
('0011', 'Lacoste Navy Regular Fit Gingham Checked Poplin', 1, 2, 7, '38,40,42,44', '0', '0819casual11.jpg', 'casual11.jpg,casual12.jpg,casual13.jpg', 'Navy blue checked casual shirt, has a button-down collar, button placket, 1 pocket, long sleeves, curved hem', 'Cotton\r\nMachine-Wash', '223800', '0', 50, 'Ada', '2017-08-21'),
('0012', 'Forever 21 Women Grey Melange Solid Round Neck T-Shirt', 4, 13, 15, 'S,M,L', '0', '1213greymelange2.jpg', 'greymelange1.jpg,greymelange2.jpg,greymelange3.jpg,greymelange4.jpg', 'Grey melange solid T-shirt, has a round neck, short sleeves', '65% polyester, 35% cotton\r\nMachine-wash', '99800', '0', 100, 'Ada', '2017-12-13'),
('0013', 'Forever 21 Women Black Layered One-Shoulder Top', 4, 13, 15, 'S,M,L', '0', '1213blacklayered1.jpg', 'blacklayered1.jpg,blacklayered2.jpg,blacklayered3.jpg,blacklayered4jpg.jpg', 'Black solid woven one-shoulder top, has layered detailing', '100% polyester\r\nHand-wash cold', '175900', '0', 100, 'Ada', '2017-12-13'),
('0014', 'Forever 21 Women Charcoal Grey and Pink Boxy Checked Casual Shirt', 4, 13, 15, 'S,M,L', '0', '1213charcoalgrey2.jpg', 'charcoalgrey1.jpg,charcoalgrey2.jpg,charcoalgrey3.jpg,charcoalgrey4.jpg', 'Charcoal grey and pink checked casual shirt, has a spread collar, button placket, 2 pockets, short extended sleeves, curved hem', '100% cotton\r\nMachine-wash cold', '175000', '10', 100, 'Ada', '2017-12-13'),
('0015', 'Forever 21 Women Red Self Design Bardot Top ', 4, 13, 15, 'S,M,L', '0', '1213redself1.jpg', 'redself1.jpg,redself2.jpg,redself3.jpg,redself4.jpg', 'Red self-design woven bardot top, has an off-shoulder styling, three-quarter sleeves', '100% cotton\r\nMachine-wash', '193200', '25', 100, 'Ada', '2017-12-13'),
('0016', 'Forever 21 Women White Solid Shirt Style Top', 4, 13, 15, 'S,M,L', '0', '1213whitesolid2.jpg', 'whitesolid1.jpg,whitesolid2.jpg,whitesolid3.jpg,whitesolid4.jpg', 'White solid woven shirt style top, has a shirt collar, long sleeves, curved hem', 'Cotton blend\r\nHand-wash', '175000', '0', 100, 'Ada', '2017-12-13'),
('0017', 'Forever 21 Women White and Black Checked Wrap Top', 4, 13, 15, 'S,M,L', '0', '1213whiteblack2.jpg', 'whiteblack1.jpg,whiteblack2.jpg,whiteblack3.jpg,whiteblack4.jpg', 'White and black checked woven wrap top, has a V-neck, long cuffed sleeves,a flap detail on the front, and a high-low hemline', '97% polyester, 3% spandex\r\nHand-wash cold', '175000', '10', 100, 'Ada', '2017-12-13'),
('0018', 'Men Black Solid Smart Casual Shirt', 1, 2, 15, '38,40,42,46', '0', '1213blacksolid2.jpg', 'blacksolid1.jpg,blacksolid2.jpg,blacksolid3.jpg,blacksolid4.jpg', 'Black solid smart casual shirt with pleated detailing, has a spread collar, button placket, long sleeves, curved hem', 'Cotton\r\nMachine-wash', '214890', '20', 50, 'Ada', '2017-12-13'),
('0019', 'Men Cream Coloured and Brown Checked Hooded Casual Shirt', 1, 2, 15, '38,40,42', '0', '1213creamcolored1.jpg', 'creamcolored1.jpg,creamcolored2.jpg,creamcolored3.jpg,creamcolored4.jpg', 'Cream-coloured and brown checked casual shirt, has an attached hood, button placket, 1 pocket, short sleeves, straight hem', '100% cotton\r\nMachine-wash', '214890', '20', 50, 'Ada', '2017-12-13'),
('0020', 'Men Khaki Regular Fit Solid Casual Shirt', 1, 2, 15, '39,40,42,44', '0', '1213khakiregular1.jpg', 'khakiregular1.jpg,khakiregular2.jpg,khakiregular3.jpg,khakiregular4.jpg', 'Khaki solid casual shirt, has a spread collar, button placket, 2 pockets, long sleeves, curved hem', '100% cotton\r\nMachine-wash cold', '214890', '20', 50, 'Ada', '2017-12-13'),
('0021', 'Puma Men Black Solid Hooded Sporty Jacket', 1, 5, 10, 'S,M,L,XL', '0', '1214puma1.jpg', 'puma1.jpg,puma2.jpg,puma3.jpg,puma4.jpg', 'Black solid sporty jacket, has a hooded, 2 pockets, zip closure, long sleeves, straight hem, cotton lining', '63% cotton, 37% polyester\r\nMachine-wash', '215000', '0', 50, 'Ada', '2017-12-14'),
('0022', 'Puma Men Black Solid Padded Jacket', 1, 5, 10, 'S,M,L,XL,XXL', '0', '1214puma5.jpg', 'puma5.jpg,puma6.jpg,puma7.jpg,puma8.jpg', 'Black solid padded jacket, has a hooded, 3 pockets, zip closure, sleeveless, straight hem, polyester lining', 'Polyester\r\nMachine-wash', '215000', '0', 50, 'Ada', '2017-12-14'),
('0023', 'Puma Men Blue Solid Windcheater and Water Resistant Puffer Jacket', 1, 5, 10, 'S,M,L,XL', '0', '1214puma9.jpg', 'puma9.jpg,puma10.jpg,puma11.jpg,puma12.jpg', 'Blue solid puffer jacket, has a hooded, 2 pockets, zip closure, long sleeves, straight hem, synthetic lining', 'Nylon\r\nMachine-wash', '215000', '0', 50, 'Ada', '2017-12-14'),
('0024', 'Puma Men Grey Printed Rebel FZ Sporty Jacket', 1, 5, 10, 'S,M,L,XL', '0', '1214puma13.jpg', 'puma13.jpg,puma14.jpg,puma15.jpg,puma16.jpg', 'Grey printed sporty jacket, has a hooded, none pockets, zip closure, long sleeves, straight hem, unlined lining', '80% cotton, 20% polyester\r\nMachine-wash', '215000', '0', 50, 'Ada', '2017-12-14'),
('0025', 'Puma Men Navy Blue Solid Sporty Jacket', 1, 5, 10, 'S,M,L,XL', '0', '1214puma17.jpg', 'puma17.jpg,puma18.jpg,puma19.jpg,puma20.jpg', 'Navy blue solid sporty jacket, has a hooded, 2 pockets, zip closure, long sleeves, straight hem, mesh lining', 'Polyester\r\nMachine-wash', '215000', '0', 50, 'Ada', '2017-12-14'),
('0026', 'Puma Women Pink Solid Essentials Padded Jacket', 4, 14, 10, 'S,M,L,XL', '0', '1214puma21.jpg', 'puma21.jpg,puma22.jpg,puma23.jpg,puma24.jpg', 'Pink solid padded jacket, has a mock collar, 2 pockets, zip closure, long sleeves, straight hem, polyester lining', '100% polyester\r\nMachine-wash', '215000', '0', 50, 'Ada', '2017-12-14'),
('0027', 'Puma Women Black Printed Sporty Jacket', 4, 14, 10, 'S,M,L,XL', '0', '1214puma25.jpg', 'puma25.jpg,puma26.jpg,puma27.jpg,puma28.jpg', 'Black printed sporty jacket, has a hooded, 2 pockets, zip closure, long sleeves, straight hem, unlined lining', 'Cotton\r\nMachine-wash', '215000', '0', 50, 'Ada', '2017-12-14'),
('0028', 'Puma Grey Melange Solid Hooded Jacket', 4, 14, 10, 'S,M,L,XL', '0', '1214puma29.jpg', 'puma29.jpg,puma30.jpg,puma31.jpg,puma32.jpg', 'Grey color blocked jacket, has an attached hood, long sleeves, a full zip closure, two pockets', '60% cotton, 40% polyester\r\nMachine-wash cold', '215000', '0', 50, 'Ada', '2017-12-14'),
('0029', 'Puma Women Purple Printed Reversible Sporty Jacket', 4, 14, 10, 'S,M,L,XL', '0', '1214puma34.jpg', 'puma33.jpg,puma34.jpg,puma35.jpg,puma36.jpg', 'Purple printed sporty jacket, each side has a hooded, 2 pockets, zip closure, long sleeves, straight hem, unlined lining', 'Polyester\r\nMachine-wash', '215000', '0', 50, 'Ada', '2017-12-14'),
('0030', 'Puma Women Black and Pink Printed Bomber Jacket', 4, 14, 10, 'S,M,L,XL', '0', '1214puma37.jpg', 'puma37.jpg,puma38.jpg,puma39.jpg,puma40.jpg', 'Black printed bomber jacket, has a mandarin collar, 2 pockets, zip closure, long sleeves, straight hem, unlined lining', '58% polyester, 42% cotton\r\nMachine-wash', '215000', '0', 50, 'Ada', '2017-12-14'),
('0031', 'Puma Boys Teal Blue Printed Round Neck T-Shirt', 7, 15, 10, '4-5Y,6Y,8Y,10Y,12Y', '0', '1214puma41.jpg', 'puma41.jpg,puma42.jpg,puma43.jpg', 'Teal blue printed T-shirt, has a round neck, short sleeves. Engineered with dry technology that will keep you sweat-free', 'Cotton\r\nMachine-wash cold', '63000', '0', 50, 'Ada', '2017-12-14'),
('0032', 'Puma Boys White Minions Print Round Neck T-Shirt', 7, 15, 10, '4-5Y,6Y', '0', '1214puma47.jpg', 'puma47.jpg,puma48.jpg,puma49.jpg', 'White printed T-shirt, has a round neck, short sleeves', '100% cotton\r\nMachine-wash cold', '63000', '0', 50, 'Ada', '2017-12-14'),
('0033', 'Puma Boys Navy Blue and Orange Printed Layered Round Neck T-Shirt', 7, 15, 10, '8-9Y,10-11Y,12-13Y,14-15Y', '0', '1215puma44.jpg', 'puma44.jpg,puma45.jpg,puma46.jpg', 'Navy blue and orange printed layered T-shirt, has a round neck, sleeveless', 'Cotton and polyester\r\nMachine-wash', '70000', '0', 50, 'Ada', '2017-12-15'),
('0034', 'Puma Boys Blue Solid T-Shirt', 7, 15, 10, '4-5Y,6Y,8Y,10Y,12Y,14Y', '0', '1215puma50.jpg', 'puma50.jpg,puma51.jpg,puma52.jpg', 'Blue solid T-shirt, has a round neck, short sleeves', 'Polyester\r\nMachine-wash', '66000', '0', 50, 'Ada', '2017-12-15'),
('0035', 'Puma Boys Grey Melange Justice League Batman Print Round Neck T-Shirt', 7, 15, 10, '4-5Y,6Y', '0', '1215puma53.jpg', 'puma53.jpg,puma54.jpg,puma55.jpg', 'Grey melange Batman print T-shirt, has a round neck, long sleeves', '100% cotton\r\nMachine-wash warm', '63000', '0', 50, 'Ada', '2017-12-15'),
('0036', 'Puma Girls Red Style Sesame Printed T-Shirt', 8, 16, 10, '4-5Y,8-9Y,10-11Y', '0', '1215puma56.jpg', 'puma56.jpg,puma57.jpg,puma58.jpg', 'Red printed T-shirt engineered with dry technology, has a round neck, short sleeves, a curved hem', '100% cotton\r\nMachine-wash', '63000', '0', 50, 'Ada', '2017-12-15'),
('0037', 'Puma Girls Blue Active Dry Ess Solid Round Neck T-Shirt', 8, 16, 10, '8Y,10Y,12Y,14Y', '0', '1215puma59.jpg', 'puma59.jpg,puma60.jpg,puma61.jpg', 'Blue solid T-shirt, has a round neck, short sleeves. Engineered with dry technology that will keep you sweat-free', 'Polyester\r\nMachine-wash cold', '70000', '0', 50, 'Ada', '2017-12-15'),
('0038', 'Puma Girls Navy SU Style Printed Tank Top', 8, 16, 10, '6-7Y,8-9Y,12-13Y', '0', '1215puma62.jpg', 'puma62.jpg,puma63.jpg,puma64.jpg', 'Navy blue printed tank top, has a round neck, sleeveless, a racer back. Engineered with dry technology', 'Polyester and cotton blend\r\nMachine-wash', '63000', '0', 50, 'Ada', '2017-12-15'),
('0039', 'Puma Girls Grey Printed Minions T-Shirt', 8, 16, 10, '8Y,10Y,14Y', '0', '1215puma65.jpg', 'puma65.jpg,puma66.jpg,puma67.jpg', 'Grey printed T-shirt, has a round neck, short sleeves', 'Cotton\r\nMachine-wash', '70000', '0', 50, 'Ada', '2017-12-15'),
('0040', 'Puma Girls Pink Fun Supergirl Printed T-Shirt', 8, 16, 10, '8-9Y,10-11Y', '0', '1215puma68.jpg', 'puma68.jpg,puma69.jpg,puma70.jpg', 'Pink printed T-shirt engineered with dry technology, has a round neck, short extended sleeves, curved back hem longer than the straight front hem', '100% cotton\r\nMachine-wash cold', '65000', '0', 50, 'Ada', '2017-12-15'),
('0041', 'Pepe Jeans Boys Blue and White Dyed Back Print Casual Shirt', 7, 17, 2, '10Y,12Y,14Y,16Y', '0', '1215pepejeans1.jpg', 'pepejeans1.jpg,pepejeans2.jpg,pepejeans3.jpg', 'Blue and white dyed casual shirt, has a spread collar, a full button placket, 1 chest pocket, long sleeves, printed detail on the back, a curved hem', '100% cotton\r\nHand-wash cold', '112000', '0', 50, 'Ada', '2017-12-15'),
('0042', 'Pepe Jeans Boys Blue Checked Casual Shirt', 7, 17, 2, '4Y,6Y,8Y', '0', '1215pepejeans4.jpg', 'pepejeans4.jpg,pepejeans5.jpg,pepejeans6.jpg', 'Blue checked casual shirt, has a spread collar, button placket, 2 pockets, long sleeves, curved hem', 'Cotton\r\nMachine-wash', '112000', '0', 50, 'Ada', '2017-12-15'),
('0043', 'Pepe Jeans Boys Blue Faded Denim Casual Shirt', 7, 17, 2, '10Y,12Y,14Y,16Y', '0', '1215pepejeans7.jpg', 'pepejeans7.jpg,pepejeans8.jpg,pepejeans9.jpg', 'Blue faded denim casual shirt, has a spread collar, snap-button placket, 2 pockets, long sleeves, curved hem', 'Cotton\r\nHand-wash cold', '117900', '10', 50, 'Ada', '2017-12-15'),
('0044', 'Pepe Jeans Boys White Colourblocked Shirt ', 7, 17, 2, '10Y,12Y,14Y,16Y', '0', '1215pepejeans10.jpg', 'pepejeans10.jpg,pepejeans11.jpg,pepejeans12.jpg', 'White colourblocked shirt, has a spread collar, a full button placket, long sleeves, and a curved hem', '100% cotton\r\nHand-wash', '117900', '10', 50, 'Ada', '2017-12-15'),
('0045', 'Pepe Jeans Boys White and Blue Printed Casual Shirt', 7, 17, 2, '10Y,12Y,16Y', '0', '1215pepejeans13.jpg', 'pepejeans13.jpg,pepejeans14.jpg,pepejeans15.jpg', 'White and blue printed casual shirt, has a spread collar, button placket, short sleeves, a chest pocket, curved hem', 'Cotton\r\nHand-wash', '117900', '10', 50, 'Ada', '2017-12-15'),
('0046', 'Pepe Jeans Girls Blue Printed Shift Dress', 8, 18, 2, '6Y,8Y', '0', '1217pepejeans16.jpg', 'pepejeans16.jpg,pepejeans17.jpg,pepejeans18.jpg', 'Blue, peach-coloured and off-white woven printed shift dress, has a round neck with a short button placket, short flutter sleeves, gathers on the front and a flounced hem', 'Cotton\r\nHand-wash', '79850', '10', 50, 'Ada', '2017-12-17'),
('0047', 'Pepe Jeans Girls Coral Red Floral Print Fit and Flare Dress', 8, 18, 2, '6Y,8Y', '0', '1217pepejeans19.jpg', 'pepejeans19.jpg,pepejeans20.jpg,pepejeans21.jpg,pepejeans22.jpg', 'Coral red floral print woven fit and flare dress, has adjustable shoulder straps that form a criss-cross detail on the back, elasticated waist, an attached lining, flared hem', 'Outer shell: 100% viscose\r\nInner shell: 100% cotton\r\nHand-wash', '79850', '10', 50, 'Ada', '2017-12-17'),
('0048', 'Pepe Jeans Girls Blue Solid Denim Fit and Flare Dress', 8, 18, 2, '4Y,6Y', '0', '1217pepejeans23.jpg', 'pepejeans23.jpg,pepejeans24.jpg,pepejeans25.jpg', 'Blue solid woven denim fit and flare dress, has a round neck, short sleeves, an elasticated waist with drawstring fastening on the front, two pockets, a button-and-loop closure on the back, and a frayed hemline with printed detail', '100% cotton\r\nHand-wash', '79850', '10', 50, 'Ada', '2017-12-17'),
('0049', 'Pepe Jeans Girls Pink and White Striped A-Line Dress', 8, 18, 2, '4Y,6Y', '0', '1217pepejeans26.jpg', 'pepejeans26.jpg,pepejeans27.jpg,pepejeans28.jpg', 'Pink and white striped knitted A-line dress, has a round neck, shoulder straps, a button-and-loop closure at the back, straight hem', 'Cotton\r\nMachine-wash', '79850', '10', 50, 'Ada', '2017-12-17'),
('0050', 'Adidas Girls Blue Drop-Waist Dress', 8, 18, 4, '6-7Y,8-9Y,10-11Y,12-13Y', '0', '1217adidas1.jpg', 'adidas1.jpg,adidas3.jpg,adiddas2.jpg', 'Blue knitted panelled drop-waist dress, has a round neck, sleeveless with a racerback, layered panelling along the hem with a crossover slit on one side. Engineered with climalite and UPF 50+ technologies. Warranty 3 months from the date of purchase against manufacturing defects.', '100% polyester\r\nMachine-wash cold', '79850', '10', 50, 'Ada', '2017-12-17'),
('0051', 'Adidas Boys Burgundy ZNE HEAT Hooded Sports Jacket', 7, 19, 4, '10-11Y,12-13Y,14-15Y', '0', '1217adidas4.jpg', 'adidas4.jpg,adidas5.jpg,adidas6.jpg,adidas7.jpg', 'Burgundy solid sporty jacket, has a hooded, 2 pockets, zip closure, long sleeves, straight hem, and faux fur lining. Engineered with Climaheat technology. Warranty 3 months from the date of purchase against manufacturing defects.', 'Polyester\r\nMachine-wash', '115000', '0', 50, 'Ada', '2017-12-17'),
('0052', 'Adidas Boys Navy Blue YB ACE FZ Solid Hooded Sporty Jacket', 7, 19, 4, '8-9Y,14-15Y', '0', '1217adidas8.jpg', 'adidas8.jpg,adidas9.jpg,adidas10.jpg,adidas11.jpg', 'Navy Blue solid sporty jacket, has a hooded, 2 pockets, zip closure, long sleeves, straight hem, fleece lining', '78% polyester, 22% cotton\r\nMachine-wash cold', '115000', '0', 50, 'Ada', '2017-12-17'),
('0053', 'Adidas Boys Black Solid Quilted Jacket', 7, 19, 4, '10-11Y,12-13Y,14-15Y', '0', '1217adidas12.jpg', 'adidas12.jpg,adidas13.jpg,adidas14.jpg', 'Black and grey solid quilted jacket, has a hooded, 2 pockets, no closure closure, long sleeves, straight hem, unlined lining', 'Polyester\r\nMachine-wash', '115000', '0', 50, 'Ada', '2017-12-17'),
('0054', 'Pepe Jeans Boys Black Solid Biker Jacket', 7, 19, 2, '10Y,12Y,14Y', '0', '1217pepejeans29.jpg', 'pepejeans29.jpg,pepejeans30.jpg,pepejeans31.jpg', 'Black solid biker jacket, has a lapel collar, 2 pockets, zip closure, long sleeves, straight hem, polyester lining', 'PU\r\nDry-clean', '115000', '0', 50, 'Ada', '2017-12-17'),
('0055', 'Pepe Jeans Boys Navy Bomber Jacket', 7, 19, 2, '10Y,16Y', '0', '1217pepejeans32.jpg', 'pepejeans32.jpg,pepejeans33.jpg,pepejeans35.jpg', 'Navy blue solid bomber, has a stand collar, 2 pockets, zip closure, long sleeves, straight hem', 'Nylon\r\nHand-wash', '115000', '0', 50, 'Ada', '2017-12-17'),
('0056', 'Pepe Jeans Girls Grey Melange and Brown Patterned Cardigan', 8, 20, 2, '4Y,6Y,8Y', '0', '1217pepejeans36.jpg', 'pepejeans36.jpg,pepejeans37.jpg,pepejeans38.jpg', 'Grey melange and brown patterned cardigan, has a V-neck, long sleeves, button placket, 2 pockets, ribbed hem', 'Cotton\r\nMachine-wash cold', '115000', '0', 50, 'Ada', '2017-12-17'),
('0057', 'Pepe Jeans Girls Black Solid Cardigan', 8, 20, 2, '4Y,6Y,8Y', '0', '1217pepejeans39.jpg', 'pepejeans39.jpg,pepejeans40.jpg,pepejeans41.jpg', 'Black solid cardigan with lace inserts, has a V-neck, a full button placket, long sleeves, two pockets, ribbed hem', 'Acrylic \r\nMachine-wash', '115000', '0', 50, 'Ada', '2017-12-17'),
('0058', 'Pepe Jeans Girls Black Printed Sweater', 8, 20, 2, '10Y,12Y', '0', '1217pepejeans42.jpg', 'pepejeans42.jpg,pepejeans43.jpg,pepejeans44.jpg', 'Black and white printed sweater, has a round neck, long sleeves, ribbed hem', 'Cotton\r\nMachine-wash cold', '115000', '0', 50, 'Ada', '2017-12-17'),
('0059', 'Pepe Jeans Girls Navy Skinny Fit Clean Look Jeans', 8, 21, 2, '10Y,12Y,14Y', '0', '1217pepejeans45.jpg', 'pepejeans45.jpg,pepejeans46.jpg,pepejeans47.jpg', 'Navy dark wash 5-pocket mid-rise jeans, clean look with light fade, has a button and zip closure, waistband with belt loops and elasticated and adjustable inserts on the inner', '79% cotton, 19% polyester, 2% elastane\r\nMachine-wash', '165390', '15', 50, 'Ada', '2017-12-17'),
('0060', 'Pepe Jeans Girls Pink Solid Jogger', 8, 21, 2, '10-11Y,12-13Y,14-15Y', '0', '1217pepejeans48.jpg', 'pepejeans48.jpg,pepejeans49.jpg,pepejeans50.jpg', 'Pink solid mid-rise joggers, has a drawstring closure, 2 pockets', '80% cotton, 20% polyester\r\nMachine-wash', '165390', '15', 50, 'Ada', '2017-12-17'),
('0061', 'Pepe Jeans Boys Green Regular Fit Solid Cargos', 7, 22, 2, '4-5Y,6-7Y,8-9Y', '0', '1218pepejeans51.jpg', 'pepejeans51.jpg,pepejeans52.jpg,pepejeans53.jpg', 'Green solid mid-rise cargos, has a button closure, 6 pockets', '98% cotton, 2% elastane\r\nMachine-wash cold', '165390', '15', 50, 'Ada', '2017-12-18'),
('0062', 'Pepe Jeans Boys Black Cashed Slim Fit Mid-Rise Clean Look Stretchable Jeans', 7, 22, 2, '10-11Y,12-13Y,14-15Y,16Y', '0', '1218pepejeans54.jpg', 'pepejeans54.jpg,pepejeans55.jpg,pepejeans56.jpg', 'Black dark wash 4-pocket mid-rise jeans, clean look with light fade, has a button and zip closure, waistband with belt loops', '69% cotton, 29% polyester and 2% elastane\r\nMachine-wash', '165390', '15', 50, 'Ada', '2017-12-18'),
('0063', 'Pepe Jeans Boys Blue Regular Fit Jeans', 7, 22, 2, '10Y,12Y,14Y,16Y', '0', '1218pepejeans57.jpg', 'pepejeans57.jpg,pepejeans58.jpg,pepejeans59.jpg', 'Dark blue jeans, has a zip fly and button closure, four pockets, lightly distressed', 'Machine-wash', '165390', '15', 50, 'Ada', '2017-12-18'),
('0064', 'Pepe Jeans Boys Charcoal Grey Solid Joggers', 7, 22, 2, '4-5Y,6-7Y,8-9Y', '0', '1218pepejeans60.jpg', 'pepejeans60.jpg,pepejeans61.jpg,pepejeans63.jpg', 'Charcoal grey solid mid-rise joggers, has a drawstring closure, 3 pockets, cuffed hems', 'Cotton\r\nMachine-wash', '165390', '15', 50, 'Ada', '2017-12-18'),
('0065', 'Pepe Jeans Boys Olive Green Regular Fit Solid Trousers', 7, 22, 2, '10Y,12Y,14Y', '0', '1218pepejeans64.jpg', 'pepejeans64.jpg,pepejeans65.jpg,pepejeans66.jpg', 'Olive green solid mid-rise regular trousers, has a drawstring closure, 5 pockets', '95% cotton and 5% Lycra\r\nMachine-wash', '165390', '15', 50, 'Ada', '2017-12-18'),
('0066', 'Adidas Boys Navy Blue YB Tiro 3S Track Pants', 7, 23, 4, '8-9Y,10-11Y,12-13Y,14-15Y', '0', '1218adidas15.jpg', 'adidas15.jpg,adidas16.jpg,adidas17.jpg', 'A pair of navy blue knitted mid-rise panelled track pants, has an elasticated waistband with an inner drawstring fastening, two insert pockets on the front, zip closures along the hem. Engineered with climalite technology. Warranty 3 months from the date of purchase against manufacturing defects', '100% polyester\r\nMachine-wash cold', '165390', '15', 50, 'Ada', '2017-12-18'),
('0067', 'Adidas Boys Black ZNE Heat Track Pants', 7, 23, 4, '8-9Y,10-11Y,12-13Y,14-15Y', '0', '1218adidas18.jpg', 'adidas18.jpg,adidas19.jpg,adidas20.jpg,adidas21.jpg', 'A pair of black mid-rise panelled track pants, has two zip pockets, an elasticated waistband with an inner drawstring fastening, zip detail on both hems, and fleece lining. Engineered with Climaheat technology. Warranty 3 months from the date of purchase against manufacturing defects', '97% polyester, 3% elastane\r\nMachine-wash cold', '165390', '15', 50, 'Ada', '2017-12-18'),
('0068', 'Adidas Boys Black Track Pants', 7, 23, 4, '10-11Y,12-13Y,14-15Y', '0', '1218adidas22.jpg', 'adidas22.jpg,adidas23.jpg,adidas24.jpg', 'A pair of black mid-rise track pants, has an elasticated waistband, two pockets', 'Polyester\r\nMachine-wash', '165390', '15', 50, 'Ada', '2017-12-18'),
('0069', 'Puma Boys Blue Minions Track Pants', 7, 23, 10, '8Y,10Y,12Y', '0', '1218puma71.jpg', 'puma71.jpg,puma72.jpg,puma73.jpg', 'Blue printed track pants, has an elasticated waistband with a drawstring fastening, two pockets, ribbed hems', '66% cotton, 34% polyester\r\nMachine-wash', '165390', '15', 50, 'Ada', '2017-12-18'),
('0070', 'Puma Boys Grey Gym Track Pants', 7, 23, 10, '4-5Y,6Y', '0', '1218puma74.jpg', 'puma74.jpg,puma75.jpg,puma76.jpg,puma77.jpg', 'Grey track pants, has an elasticated waistband, zip details on the hems, engineered with dry technology', 'Polyester\r\nMachine-wash', '165390', '15', 50, 'Ada', '2017-12-18'),
('0071', 'Puma Girls Purple Track Pants', 8, 24, 10, '8Y,10Y,12Y,14Y', '0', '1218puma78.jpg', 'puma78.jpg,puma79.jpg,puma80.jpg', 'Purple jogger track pants with applique detail, has an elasticated waistband with drawstring fastening, cuffed hems', 'Cotton and polyester\r\nMachine-wash', '165390', '15', 50, 'Ada', '2017-12-18'),
('0072', 'Puma Girls Black Softsport Jersey Track Pants', 8, 24, 10, '10Y,12Y,14Y', '0', '1218puma81.jpg', 'puma81.jpg,puma82.jpg,puma83.jpg', 'Black knitted track pants with dry technology, has an elasticated waistband', '62% polyester, 34% viscose, 4% elastane\r\nMachine-wash', '165390', '15', 50, 'Ada', '2017-12-18'),
('0073', 'Adidas Girls White YG AA ZNE Track Pants', 8, 24, 4, '6-7Y,8-9Y,10-11Y,12-13Y', '0', '1218adidas25.jpg', 'adidas25.jpg,adidas26.jpg,adidas27.jpg', 'A pair of white knitted mid-rise track pants, has two pockets, an elasticated waistband with inner drawstring fastening. Warranty 3 months from the date of purchase against manufacturing defects', '70% rayon, 25% nylon and 5% spandex\r\nMachine-wash cold', '165390', '15', 50, 'Ada', '2017-12-18'),
('0074', 'Reebook Kids Navy Blue FTR WOV Track Pants', 8, 24, 12, '8-9Y,10-11Y', '0', '1218reebok1.jpg', 'reebok1.jpg,reebok2.jpg,reebok3.jpg', 'A pair of navy woven mid-rise track pants, has two pockets, an elasticated waistband with an inner drawstring fastening. Engineered with Speedwick technology', '100% polyester\r\nMachine-wash cold', '165390', '15', 50, 'Ada', '2017-12-18'),
('0075', 'Puma Girls Coral Orange FUN IND Track Pants', 8, 24, 10, '14-15Y,8Y,10Y,12Y', '0', '1218puma84.jpg', 'puma84.jpg,puma85.jpg,puma86.jpg', 'A pair of coral orange mid-rise track pants, has two pockets, an elasticated waistband with a drawstring fastening, ribbed hems', '70% cotton, 30% polyester\r\nMachine-wash', '165390', '15', 50, 'Ada', '2017-12-18'),
('0076', 'Adidas Kids Blue Solid OG CF C Sneakers', 9, 25, 4, '28,29,30,31,32,33', '0', '1219adidas28.jpg', 'adidas28.jpg,adidas29.jpg,adidas30.jpg,adidas31.jpg', 'A pair of round-toe blue sneakers, has Velcro detail. Mesh upper, cushioned footbed, textured and patterned outsole. Warranty 3 months from the date of purchase against manufacturing defects. Warranty provided by Brand Owner or Manufacturer', 'Mesh\r\nWipe with a clean, dry cloth to remove dust', '132890', '0', 50, 'Ada', '2017-12-19'),
('0077', 'Adidas Kids Red GAZELLE Leather Sneakers', 9, 25, 4, '28,29,30,31,32,33', '0', '1219adidas32.jpg', 'adidas32.jpg,adidas33.jpg,adidas34.jpg,adidas35.jpg', 'A pair of round-toe red sneakers, has regular styling, lace-up detail. Leather upper, cushioned footbed, textured and patterned outsole. Warranty 3 months from the date of purchase against manufacturing defects', 'Leather \r\nUse a branded leather conditioner to clean the product\r\nAvoid washing', '132890', '0', 50, 'Ada', '2017-12-19'),
('0078', 'Adidas Kids Sea Green and Pink ZX Flux', 9, 25, 4, '28,29,30,31,32,33', '0', '1219adidas36.jpg', 'adidas36.jpg,adidas37.jpg,adidas38.jpg,adidas39.jpg', 'A pair of round-toed sea green, pink and black sneakers, has regular styling, lace-up detail. Textile printed upper, cushioned footbed and textured and patterned rubber outsole. Warranty 3 months from the date of purchase against manufacturing defects', 'Textile \r\nWipe with a clean, dry cloth to remove dust', '132890', '0', 50, 'Ada', '2017-12-19'),
('0079', 'Reebok Boys Black Royal Dash n Drill Sneakers', 9, 25, 12, '33,34,35,36,37,38', '0', '1219reebok4.jpg', 'reebok4.jpg,reebok5.jpg,reebok6.jpg,reebok7.jpg', 'A pair of round-toe black sneakers, has mid-top styling, lace-up detail. Synthetic upper, cushioned footbed and textured and patterned outsole. Warranty 3 months', 'Synthetic\r\nWipe with a clean, dry cloth to remove dust', '132890', '0', 50, 'Ada', '2017-12-19'),
('0080', 'Puma Kids 917 FUN Denim PS Sneakers', 9, 25, 10, '28,29,30,31,32', '5,6', '1219puma87.jpg', 'puma87.jpg,puma88.jpg,puma89.jpg,puma90.jpg', 'A pair of round-toe navy blue or charcoal gray sneakers, has regular styling, lace-up detail. Canvas upper, cushioned footbed and textured and patterned outsole. Warranty for 3 months. Warranty provided by Brand Owner or Manufacturer', 'Canvas \r\nWipe with a clean, dry cloth to remove dust', '132890', '0', 50, 'Ada', '2017-12-19'),
('0081', 'Nike Boys Charcoal Grey and Black Revolution 3 GS Running Shoes', 9, 26, 9, '36,37,38', '0', '1219nike1.jpg', 'nike1.jpg,nike2.jpg,nike3.jpg,nike4.jpg', 'A pair of charcoal running shoes, has regular styling detail. Mesh and synthetic upper, cushioned footbed, textured and patterned outsole, full length foam midsole provides lightweight cushioning and deep flex grooves promote natural motion. Warranty 6 months against manufacturing defects not valid on products with more than 20% discount. Warranty provided by Brand Owner or Manufacturer', 'Mesh and synthetic\r\nWipe with a clean, dry cloth to remove dust', '132890', '0', 50, 'Ada', '2017-12-19'),
('0082', 'Nike Unisex Black and Red JR Magista Ola II Football Shoes', 9, 26, 9, '36,37,38', '0', '1219nike5.jpg', 'nike5.jpg,nike6.jpg,nike7.jpg,nike8.jpg', 'A pair of black red football sports shoes, has regular styling, lace-up detail. Synthetic upper, cushioned footbed and textured and patterned outsole. Warranty for 6 months. Warranty provided by Brand Owner or Manufacturer', 'Synthetic \r\nWipe with a clean, dry cloth to remove dust', '132890', '0', 50, 'Ada', '2017-12-19'),
('0083', 'Puma Kids Blue ONE 17.4 Football Shoes', 9, 26, 10, '36,37,38,39', '0', '1219puma91.jpg', 'puma91.jpg,puma92.jpg,puma93.jpg,puma94.jpg', 'A pair of blue football sports shoes, has lace-up detail. Synthetic upper, cushioned footbed and textured and patterned outsole witth nubs. Warranty for 3 months. Warranty provided by Brand Owner or Manufacturer', 'Synthetic \r\nWipe with a clean, dry cloth to remove dust', '132890', '0', 50, 'Ada', '2017-12-19'),
('0084', 'Puma Kids Black evoPOWER Vigor 4 Graph Football Shoes', 9, 26, 10, '36,37,38', '0', '1219puma95.jpg', 'puma95.jpg,puma96.jpg,puma97.jpg,puma98.jpg', 'A pair of black and red football sports shoes, has lace-up detail. Synthetic printed upper, engineered with evoPOWER technology, cushioned footbed, textured and patterned outsole, engineered with DUOflex technology, has cleats. Warranty for 3 months. Warranty provided by Brand Owner or Manufacturer', 'Synthetic\r\nWipe with a clean, dry cloth to remove dust', '132890', '0', 50, 'Ada', '2017-12-19'),
('0085', 'Reebok Boys White Ultra Speed Running Shoes', 9, 26, 12, '34,35,36,37,38', '0', '1219reebok8.jpg', 'reebok8.jpg,reebok9.jpg,reebok10.jpg,reebok11.jpg', 'A pair of white running sports shoes, has lace-up detail. Mesh upper, cushioned footbed and textured and patterned outsole. Warranty for 3 months. Warranty provided by Brand Owner or Manufacturer', 'Mesh\r\nWipe with a clean, dry cloth to remove dust', '132890', '0', 50, 'Ada', '2017-12-19'),
('0086', 'Forever 21 Black Maxi Skirt', 4, 27, 15, '24,26,28,30', '0', '0102forever1.jpg', 'forever1.jpg,forever2.jpg,forever3.jpg,forever4.jpg', 'Black woven maxi skirt with lace and crochet trim detail, has a waistband with a concealed zip and a hook-and-bar closure, side slits', 'Shell 1: 100% rayon\r\nShell 2: 100% nylon\r\nHand-wash cold', '163800', '10', 50, 'Ada', '2018-01-02'),
('0087', 'Forever 21 Black and White Floral Print Maxi Skirt', 4, 27, 15, '26,28,30,32', '0', '0102forever5.jpg', 'forever5.jpg,forever6.jpg,forever7.jpg,forever8.jpg', 'Black and white woven maxi skirt, has a waistband with a short concealed zip closure and a hook-and-eye closure on the back, a flared hem', '100% rayon\r\nHand-wash cold', '163800', '10', 50, 'Ada', '2018-01-02'),
('0088', 'Pepe Jeans Women Red Self Design Regular Fit Regular Short', 4, 27, 2, '26,28,30,32', '0', '0102pepejeans67.jpg', 'pepejeans67.jpg,pepejeans68.jpg,pepejeans69.jpg,pepejeans70.jpg', 'Red self-design mid-rise regular shorts, has 5 pockets, a zip closure', '97% cotton, 3% elastane\r\nMachine-wash', '163800', '10', 50, 'Ada', '2018-01-02'),
('0089', 'Levis Navy Denim Shorts', 4, 27, 8, '28,34', '0', '0102levis1.jpg', 'levis1.jpg,levis2.jpg,levis3.jpg,levis4.jpg', 'Navy blue solid mid-rise denim shorts, has 5 pockets, a button and zip closure', '79% cotton, 19% polyester, 2% elastane\r\nMachine-wash', '163800', '10', 50, 'Ada', '2018-01-02'),
('0090', 'PURYS Black Floral Printed Maxi Skirt', 4, 27, 13, '26,28', '0', '0102purys1.jpg', 'purys1.jpg,purys2.jpg,purys3.jpg,purys4.jpg', 'Black floral printed maxi skirt, has an elasticated waistband with smocking and tie-up detail, slit on both sides', 'Polyester\r\nMachine-wash', '163800', '10', 50, 'Ada', '2018-01-02'),
('0091', 'Forever 21 Beige and Charcoal Grey Waistcoat', 1, 6, 15, '42,44', '0', '0102forever10.jpg', 'forever9.jpg,forever10.jpg,forever11.jpg,forever12.jpg', 'Beige and charcoal grey waistcoat, has a V-neck, sleeveless, a full button placket, two welt pockets, a mock pocket, vented hem, adjustable belt on the back and has an attached lining', 'Shell 1: 100% cotton\r\nShell 2: 65% polyester, 35% cotton\r\nLining: 100% polyester\r\nHand-wash', '215000', '0', 50, 'Ada', '2018-01-02'),
('0092', 'Forever 21 Grey Trench Coat', 1, 6, 15, 'S,M', '0', '0102forever13.jpg', 'forever13.jpg,forever14.jpg,forever15.jpg,forever16.jpg', 'Grey trench coat, has a spread collar, concealed snap button closure, long sleeves, two pockets', '96% cotton, 4% elastane\r\nDry-clean', '215000', '0', 50, 'Ada', '2018-01-02'),
('0093', 'Pepe Jeans Navy Single Breasted Casual Blazer', 1, 6, 2, '42,44', '0', '0102pepejeans71.jpg', 'pepejeans71.jpg,pepejeans72.jpg,pepejeans73.jpg,pepejeans74.jpg', 'Navy blue blazer, has a notched lapel, long sleeves, single-breasted with double button closure, two pockets on the front, and two inner pockets', '97% cotton, 3% elastane\r\nDry-clean', '215000', '0', 50, 'Ada', '2018-01-02'),
('0094', 'John Players Men Olive Green Single Breasted Formal Blazer', 1, 6, 1, '40,42', '0', '0102johnplayer1.jpg', 'johnplayer1.jpg,johnplayer2.jpg,johnplayer3.jpg,johnplayer4.jpg', 'Olive green woven blazer, has a notched lapel, long sleeves with buttoned detail on the hems, single-breasted with double button closures on the front, lightly padded on the shoulders, a welt pocket with flap-and-button closure on the left side of the chest, a welt pocket with button-and-flap closures on either side of the front waist, panelled back, two slits on the back hem, and an attached lining with two built-in welt pockets on the left side, and a built-in welt pocket with flap-and-button closure on the right side', '65% polyester, 35% viscose\r\nDry-clean', '215000', '0', 50, 'Ada', '2018-01-02'),
('0095', 'Jack and Jones Black and White Paisley Print Single Breasted Blazer', 1, 6, 3, '46,48,50,52', '0', '0102jackjones1.jpg', 'jackjones1.jpg,jackjones2.jpg,jackjones3.jpg,jackjones4.jpg', 'Black and white paisley print single-breasted casual blazer, has a notched lapel, dual button closures, long sleeves, three pockets', 'Cotton\r\nDry-clean', '215000', '0', 50, 'Ada', '2018-01-02'),
('0096', 'Jack and Jones Men Blue Slim Fit Low Rise Clean Look Stretchable Jeans', 2, 8, 3, '28,30,32,34,36,38', '0', '0103jackjones5.jpg', 'jackjones5.jpg,jackjones6.jpg,jackjones7.jpg,jackjones8.jpg', 'Blue medium wash 5 pocket low rise jeans, clean look with light fade, has a button and zip closure, waistband with belt loops', '98% cotton and 2% elastane\r\nMachine-wash', '165350', '10', 50, 'Ada', '2018-01-03'),
('0097', 'Jack and Jones Men Black Slim Fit Mildly Distressed Strecthable Jeans', 2, 8, 3, '28,30,32,34,36', '0', '0103jackjones9.jpg', 'jackjones9.jpg,jackjones10.jpg,jackjones11.jpg,jackjones12.jpg', 'Black dark wash 5 pocket mid rise Jeans, mildly distressed with light fade, has a button and zip closure, waistband with belt loops', '66% cotton, 32.5% polyester, 1.5% elastane\r\nStretchable\r\nMachine-wash', '165350', '10', 50, 'Ada', '2018-01-03'),
('0098', 'John Players Men Blue Slim Jeans', 2, 8, 1, '30,32,34,36', '0', '0103johnplayer5.jpg', 'johnplayer5.jpg,johnplayer6.jpg,johnplayer7.jpg,johnplayer8.jpg', 'A pair of blue 5 pocket mid rise jeans, lightly washed, has a zip fly with button closure, a waistband with belt loops', 'Cotton, polyester and elastane\r\nMachine-wash', '165350', '10', 50, 'Ada', '2018-01-03'),
('0099', 'John Players Men Navy Blue Skinny Fit Mid Rise Clean Look Jeans', 2, 8, 1, '30,32,34,36', '0', '0103johnplayer9.jpg', 'johnplayer9.jpg,johnplayer10.jpg,johnplayer11.jpg,johnplayer12.jpg', 'Navy blue dark wash 5 pocket mid rise jeans, clean look with light fade, has a button and zip closure, waistband with belt loops', 'Cotton, polyester and elastane blend\r\nMachine-wash', '165350', '10', 50, 'Ada', '2018-01-03');

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `member_id` varchar(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `address` text NOT NULL,
  `city` varchar(80) NOT NULL,
  `state` varchar(60) NOT NULL,
  `zip_code` varchar(10) NOT NULL,
  `phone` varchar(18) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `reg_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`member_id`, `fullname`, `gender`, `address`, `city`, `state`, `zip_code`, `phone`, `email`, `password`, `reg_date`) VALUES
('0001', 'Aplora Sanerati', 'Perempuan', 'Perum Karanglo', 'Malang', 'Jawa Timur', '65112', '+6282345678910', 'iamaplora@gmail.com', '849f6a6ce05b17d5e5351044f1378f47', '2017-10-11');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` varchar(11) NOT NULL,
  `customer_id` varchar(11) NOT NULL,
  `owner_name` varchar(50) NOT NULL,
  `cardbank_type` varchar(12) NOT NULL,
  `card_number` varchar(100) NOT NULL,
  `payment_status` varchar(11) NOT NULL,
  `totals` varchar(11) NOT NULL,
  `creation_date` date NOT NULL,
  `creation_time` time NOT NULL DEFAULT '00:00:00',
  `order_status` varchar(11) NOT NULL,
  `order_valid_date` date NOT NULL,
  `order_valid_time` time NOT NULL DEFAULT '00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `customer_id`, `owner_name`, `cardbank_type`, `card_number`, `payment_status`, `totals`, `creation_date`, `creation_time`, `order_status`, `order_valid_date`, `order_valid_time`) VALUES
('0001', '0001', 'Aplora Sanerati', 'Bank BNI', '327381983', 'PAID', '198400', '2017-10-11', '19:27:17', 'SENT', '2017-10-11', '19:38:13'),
('0002', '0001', 'Aplora Sanerati', 'Bank BNI', '327381983', 'PAID', '103200', '2018-01-04', '18:07:24', 'SENT', '2018-01-05', '19:05:53');

-- --------------------------------------------------------

--
-- Table structure for table `order_detail`
--

CREATE TABLE `order_detail` (
  `detail_id` int(11) NOT NULL,
  `order_id` varchar(11) NOT NULL,
  `bgimg` varchar(100) NOT NULL,
  `item_code` varchar(11) NOT NULL,
  `item_name` varchar(100) NOT NULL,
  `color` varchar(11) NOT NULL,
  `size` varchar(5) NOT NULL,
  `qty` int(11) NOT NULL,
  `disc` int(3) NOT NULL,
  `price` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_detail`
--

INSERT INTO `order_detail` (`detail_id`, `order_id`, `bgimg`, `item_code`, `item_name`, `color`, `size`, `qty`, `disc`, `price`) VALUES
(1, '0001', '0818shirt13.jpg', '0007', 'PURYS Women Cream-Coloured Printed Top', '', 'M', 1, 20, '119000'),
(2, '0001', '0818shirt5.jpg', '0002', 'Relaxed Lace-Trim Sleeveless Top for Women', 'White', 'M', 1, 20, '129000'),
(3, '0002', '0818shirt5.jpg', '0002', 'Relaxed Lace-Trim Sleeveless Top for Women', 'White', 'M', 1, 20, '129000');

-- --------------------------------------------------------

--
-- Table structure for table `subcategories`
--

CREATE TABLE `subcategories` (
  `scat_id` int(11) NOT NULL,
  `subcategory` varchar(50) NOT NULL,
  `cat_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subcategories`
--

INSERT INTO `subcategories` (`scat_id`, `subcategory`, `cat_id`) VALUES
(1, 'T-Shirt', 1),
(2, 'Casual Shirts', 1),
(3, 'Formal Shirts', 1),
(4, 'Sweaters and Sweatshirts', 1),
(5, 'Jackets', 1),
(6, 'Blazers and Coats', 1),
(7, 'Suits', 1),
(8, 'Jeans', 2),
(9, 'Casual Trousers', 2),
(10, 'Formal Trousers', 2),
(11, 'Shorts', 2),
(12, 'Shirts Women', 14),
(13, 'Tops, T-Shirts and Shirts', 4),
(14, 'Jackets and Waistcoats', 4),
(15, 'Boys T-Shirts', 7),
(16, 'Girls Tops and T-shirts', 8),
(17, 'Boys Shirts', 7),
(18, 'Girls Dresses', 8),
(19, 'Boys Jackets', 7),
(20, 'Girls Sweaters', 8),
(21, 'Girls Jeans and Trousers', 8),
(22, 'Boys Jeans and Trousers', 7),
(23, 'Boys Track Pants', 7),
(24, 'Girls Track Pants', 8),
(25, 'Boys Casual Shoes', 9),
(26, 'Boys Sports Shoes', 9),
(27, 'Shorts and Skirts', 4);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `fullname` varchar(50) CHARACTER SET latin1 NOT NULL,
  `user` varchar(30) CHARACTER SET latin1 NOT NULL,
  `pass` varchar(50) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `fullname`, `user`, `pass`) VALUES
(1, 'Victory Webstore', 'admin', '0192023a7bbd73250516f069df18b500');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`brd_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `colors`
--
ALTER TABLE `colors`
  ADD PRIMARY KEY (`clr_id`);

--
-- Indexes for table `counter`
--
ALTER TABLE `counter`
  ADD PRIMARY KEY (`counter_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`member_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD PRIMARY KEY (`detail_id`);

--
-- Indexes for table `subcategories`
--
ALTER TABLE `subcategories`
  ADD PRIMARY KEY (`scat_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `brd_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `colors`
--
ALTER TABLE `colors`
  MODIFY `clr_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `counter`
--
ALTER TABLE `counter`
  MODIFY `counter_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `order_detail`
--
ALTER TABLE `order_detail`
  MODIFY `detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `subcategories`
--
ALTER TABLE `subcategories`
  MODIFY `scat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
