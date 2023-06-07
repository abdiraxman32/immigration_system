-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 07, 2023 at 03:49 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `immigration_db`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `bills_sp` (IN `_employe_id` INT, IN `_amount` DOUBLE(11,2), IN `_month` VARCHAR(100) CHARSET utf8, IN `_year` VARCHAR(100) CHARSET utf8, IN `_description` TEXT, IN `_user` VARCHAR(40) CHARSET utf8)   BEGIN
    INSERT INTO `bills`(`employe_id`, `Amount`, `month`, `year`, `description`, `user`, `date`)
    VALUES(_employe_id,_amount,_month,_year,_description,_user,CURRENT_DATE);
        SELECT 'Registered' as msg ;
    END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `charge` (IN `_month` VARCHAR(100) CHARSET utf8, IN `_year` VARCHAR(100) CHARSET utf8, IN `_description` TEXT, IN `_Account_id` INT, IN `_user_id` VARCHAR(100) CHARSET utf8)   BEGIN
if(read_salary() > read_acount_balance(_Account_id))THEN
SELECT "Deny" as msg;
else
INSERT IGNORE INTO `charge`(`employe_id`, `job_id`, `Amount`, `month`, `year`, `description`,`Account_id`,`user_id`, `date`)
 SELECT e.employe_id,j.job_id,j.salary,_month,_year,_description,_Account_id,_user_id,
CURRENT_DATE from employe e JOIN jobs  j on e.job_id=j.job_id;
IF(row_count()>0)THEN
SELECT "Registered" as msg;
ELSE
SELECT "NOt" as msg;
END IF;    
END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `login_sp` (IN `_username` VARCHAR(100), IN `_password` VARCHAR(100))   BEGIN

if EXISTS(SELECT * FROM users WHERE users.username = _username and users.password = MD5(_password))THEN	


if EXISTS(SELECT * FROM users WHERE users.username = _username)THEN
 
SELECT * FROM users where users.username = _username;

ELSE

SELECT 'Locked' Msg;

end if;
ELSE


SELECT 'Deny' Msg;

END if;


END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `read_all_citizen_pending` ()   SELECT c.fullname as citizen_name,c.phone,c.gender,pt.passport_type,o.amount,o.status,o.date_ordered from orders o JOIN citizens c on o.citizen_id=c.citizen_id JOIN passport_type pt on o.passport_type_id=pt.passport_type_id WHERE o.status='pending'$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `read_bill_statement` (IN `_telphone` INT)   BEGIN
if(_telphone = '0000-00-00')THEN
SELECT b.id,e.fullname as employee_name,b.Amount as salary,b.month,b.year,b.description,u.username as user,b.date from bills b JOIN employe e on b.employe_id=e.employe_id JOIN jobs j on e.job_id=j.job_id JOIN users u on b.user=u.id;
ELSE
SELECT b.id,e.fullname as employee_name,b.Amount as salary,b.month,b.year,b.description,u.username as user,b.date from bills b JOIN employe e on b.employe_id=e.employe_id JOIN jobs j on e.job_id=j.job_id JOIN users u on b.user=u.id WHERE e.tell=_telphone;
END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `read_citizen_paid` (IN `_telphone` INT)   BEGIN
if(_telphone = '0000-00-00')THEN
SELECT c.fullname as citizen_name,c.phone,c.gender,pt.passport_type,o.amount,o.status,o.date_ordered from orders o JOIN citizens c on o.citizen_id=c.citizen_id JOIN passport_type pt on o.passport_type_id=pt.passport_type_id WHERE o.status='paid';
ELSE
SELECT c.fullname as citizen_name,c.phone,c.gender,pt.passport_type,o.amount,o.status,o.date_ordered from orders o JOIN citizens c on o.citizen_id=c.citizen_id JOIN passport_type pt on o.passport_type_id=pt.passport_type_id  WHERE o.status='paid' and c.phone=_telphone;
END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `read_citizen_statement` (IN `_telphone` INT)   BEGIN
if(_telphone = '0000-00-00')THEN
SELECT * FROM citizens;
ELSE
SELECT * FROM citizens WHERE phone=_telphone;
END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `read_employe_salary` (IN `_employe_id` INT)   BEGIN

SELECT c.employe_id,j.salary FROM charge c JOIN employe e on c.employe_id=e.employe_id
JOIN jobs j on e.job_id=j.job_id WHERE c.employe_id=_employe_id;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `read_employe_statement` (IN `_telphone` INT)   BEGIN
if(_telphone = '0000-00-00')THEN
SELECT e.employe_id,e.fullname,e.email,e.tell,e.city,e.state,j.job_name,j.salary FROM employe e JOIN jobs j on e.job_id=j.job_id;
ELSE
SELECT e.employe_id,e.fullname,e.email,e.tell,e.city,e.state,j.job_name,j.salary FROM employe e JOIN jobs j on e.job_id=j.job_id
 WHERE tell=_telphone;
END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `read_passport_price` (IN `_passport_type_id` INT)   BEGIN

SELECT price from passport_type WHERE passport_type_id=_passport_type_id;


END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `read_payment_price` (IN `_citizen_id` INT)   BEGIN

SELECT o.amount from orders o WHERE o.citizen_id=_citizen_id;


END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `register_expense_sp` (IN `_id` INT, IN `_amount` FLOAT(11,2), IN `_type` VARCHAR(50), IN `_desc` TEXT, IN `_userId` VARCHAR(50), IN `_Account_id` INT)   BEGIN
 if(_type = 'Expense')THEN

if((SELECT read_acount_balance(_Account_id) < _amount))THEN

SELECT 'Deny' as Message;

ELSE

INSERT into expense(expense.amount,expense.type,expense.description,expense.user_id,expense.Account_id)
VALUES(_amount,_type,_desc,_userId,_Account_id);

SELECT 'Registered' as Message;

END if;
ELSE
if(_type = 'Expense')THEN

if((SELECT read_acount_balance(_Account_id) < _amount))THEN

SELECT 'Deny' as Message;
END IF;
ELSE
if EXISTS( SELECT * FROM expense WHERE expense.id = _id)THEN
UPDATE expense SET expense.amount = _amount, expense.type = _type, expense.description = _desc,expense.user_id=_userId,expense.Account_id=_Account_id
WHERE expense.id = _id;

SELECT 'Updated' as Message;
ELSE

INSERT into expense(expense.amount,expense.type,expense.description,expense.user_id,expense.Account_id)
VALUES(_amount,_type,_desc,_userId,_Account_id);

SELECT 'Registered' as Message;

END if;
END IF;

END if;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `released_passport` (IN `_citizen_id` INT)   BEGIN
SELECT pt.passport_type_id,pt.passport_type from orders o JOIN   passport_type pt 
on o.passport_type_id=pt.passport_type_id WHERE o.citizen_id=_citizen_id;
END$$

--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `read_acount_balance` (`_Account_id` INT) RETURNS INT(11)  BEGIN
SET @balance=0.00;
SELECT SUM(balance)INTO @balance FROM account WHERE Account_id
=_Account_id;
RETURN @balance;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `read_salary` () RETURNS INT(11)  BEGIN
SET @salary=0.00;
SELECT SUM(salary)INTO @salary FROM jobs;
RETURN @salary;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `Account_id` int(11) NOT NULL,
  `bank_name` varchar(100) NOT NULL,
  `holder_name` varchar(100) NOT NULL,
  `accoun_number` int(11) NOT NULL,
  `balance` decimal(10,0) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`Account_id`, `bank_name`, `holder_name`, `accoun_number`, `balance`, `date`) VALUES
(1, 'ips_bank', 'samafale', 618846254, 93000, '2023-06-07 13:32:59'),
(2, 'primary_bank', 'xaawo', 617372873, 100, '2023-06-07 10:12:59'),
(3, 'Hormuud', 'maxamed', 61729892, 200, '2023-06-07 10:13:19'),
(4, 'Edahab', 'ali', 626617872, 300, '2023-06-07 10:13:39');

-- --------------------------------------------------------

--
-- Table structure for table `bills`
--

CREATE TABLE `bills` (
  `id` int(11) NOT NULL,
  `employe_id` int(11) NOT NULL,
  `Amount` decimal(10,0) NOT NULL,
  `month` varchar(100) NOT NULL,
  `year` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `user` varchar(40) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bills`
--

INSERT INTO `bills` (`id`, `employe_id`, `Amount`, `month`, `year`, `description`, `user`, `date`) VALUES
(1, 3, 700, 'Jan', '2023', 'mushaar', 'USR002', '2023-06-06 16:00:00');

--
-- Triggers `bills`
--
DELIMITER $$
CREATE TRIGGER `bills` AFTER INSERT ON `bills` FOR EACH ROW BEGIN
UPDATE charge SET Amount=Amount-new.`Amount` where employe_id=new.employe_id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `charge`
--

CREATE TABLE `charge` (
  `charge_id` int(11) NOT NULL,
  `employe_id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `Amount` decimal(10,0) NOT NULL,
  `month` varchar(100) NOT NULL,
  `year` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `Account_id` int(11) NOT NULL,
  `user_id` varchar(100) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `charge`
--

INSERT INTO `charge` (`charge_id`, `employe_id`, `job_id`, `Amount`, `month`, `year`, `description`, `Account_id`, `user_id`, `date`) VALUES
(1, 3, 3, 700, 'Jan', '2023', 'mushaar', 1, 'USR001', '2023-06-06 16:00:00'),
(2, 4, 2, 2000, 'Jan', '2023', 'mushaar', 1, 'USR001', '2023-06-06 16:00:00');

--
-- Triggers `charge`
--
DELIMITER $$
CREATE TRIGGER `update_ac_balance` AFTER INSERT ON `charge` FOR EACH ROW BEGIN
UPDATE account SET balance= balance-new.Amount
WHERE Account_id=new.Account_id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `citizens`
--

CREATE TABLE `citizens` (
  `citizen_id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `gender` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `place_of_brith` varchar(200) NOT NULL,
  `date_of_brith` date NOT NULL,
  `nationaty` varchar(200) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `citizens`
--

INSERT INTO `citizens` (`citizen_id`, `fullname`, `phone`, `gender`, `address`, `city`, `place_of_brith`, `date_of_brith`, `nationaty`, `date`) VALUES
(1, 'xaawo cali ', '637883', 'female', 'daarusalaam', 'mugdisho', 'daarusalaam', '1989-10-03', 'Somalia', '2023-06-07 06:03:42'),
(2, 'shamso cali', '615763783', 'female', 'daarusalaam', 'mugdisho', 'daarusalaam', '2023-05-29', 'somalia', '2023-06-07 07:54:32'),
(3, 'anwar iaakh', '661727271', 'male', 'hodan', 'mugdisho', 'hodan', '2023-06-02', 'itobian', '2023-06-07 12:26:40');

-- --------------------------------------------------------

--
-- Table structure for table `employe`
--

CREATE TABLE `employe` (
  `employe_id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `tell` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `job_id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employe`
--

INSERT INTO `employe` (`employe_id`, `fullname`, `email`, `tell`, `city`, `state`, `job_id`, `date`) VALUES
(3, 'xaawo cali', 'xawo@gmail.com', '36536763', 'mugdisho', 'banadir', 3, '2023-06-07 11:10:05'),
(4, 'samafale mohamed', 'samafale@gmail.com', '618846254', 'mugdisho', 'banadir', 2, '2023-06-07 11:08:39');

-- --------------------------------------------------------

--
-- Table structure for table `expense`
--

CREATE TABLE `expense` (
  `id` int(11) NOT NULL,
  `amount` decimal(10,0) NOT NULL,
  `type` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `user_id` varchar(100) NOT NULL,
  `Account_id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `expense`
--

INSERT INTO `expense` (`id`, `amount`, `type`, `description`, `user_id`, `Account_id`, `date`) VALUES
(1, 300, 'Income', 'web', 'USR001', 1, '2023-06-05 17:56:43'),
(2, 89, 'Income', 'web', 'USR001', 2, '2023-06-05 18:00:39'),
(3, 100, 'Expense', 'kiro', 'USR001', 1, '2023-06-05 18:02:09');

--
-- Triggers `expense`
--
DELIMITER $$
CREATE TRIGGER `update_account` AFTER INSERT ON `expense` FOR EACH ROW BEGIN
    IF NEW.type = 'Income' THEN
        UPDATE account
        SET balance = balance+new.amount
        WHERE Account_id=new.Account_id;
        
        ELSE
                UPDATE account
        SET balance = balance-new.amount
        WHERE Account_id=new.Account_id;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `issuing_authority`
--

CREATE TABLE `issuing_authority` (
  `issuing_authority_id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `issuing_authority`
--

INSERT INTO `issuing_authority` (`issuing_authority_id`, `name`) VALUES
(1, 'United States'),
(2, 'United Kingdom'),
(3, 'France: Ministry of Foreign Affairs\r\n'),
(4, 'Japan: Ministry of Foreign Affairs\r\n'),
(5, 'India: Ministry of External Affairs\r\n'),
(6, 'Germany'),
(7, 'Australia');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `job_id` int(11) NOT NULL,
  `job_name` varchar(100) NOT NULL,
  `salary` decimal(10,0) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`job_id`, `job_name`, `salary`, `date`) VALUES
(1, 'cleaner', 200, '2023-06-05 08:37:19'),
(2, 'Manager', 2000, '2023-06-05 11:14:10'),
(3, 'Assistant Manager', 700, '2023-06-05 11:14:10'),
(4, 'Administrator', 3000, '2023-06-05 11:14:10');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `citizen_id` int(11) NOT NULL,
  `passport_type_id` int(11) NOT NULL,
  `amount` decimal(12,0) NOT NULL,
  `issuing_authority_id` int(11) NOT NULL,
  `status` varchar(100) NOT NULL DEFAULT 'pending',
  `date_ordered` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `citizen_id`, `passport_type_id`, `amount`, `issuing_authority_id`, `status`, `date_ordered`) VALUES
(1, 1, 3, 600, 2, 'completed', '2023-06-07 13:34:01');

-- --------------------------------------------------------

--
-- Table structure for table `passport_information`
--

CREATE TABLE `passport_information` (
  `passport_id` int(11) NOT NULL,
  `passport_name` varchar(200) NOT NULL,
  `passport_type_id` int(11) NOT NULL,
  `Passport_Number` varchar(100) NOT NULL,
  `price` decimal(12,0) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `passport_information`
--

INSERT INTO `passport_information` (`passport_id`, `passport_name`, `passport_type_id`, `Passport_Number`, `price`, `date`) VALUES
(1, 'passport_somalia', 4, 'PAS001', 800, '2023-06-07 07:24:50');

-- --------------------------------------------------------

--
-- Table structure for table `passport_type`
--

CREATE TABLE `passport_type` (
  `passport_type_id` int(11) NOT NULL,
  `passport_type` varchar(100) NOT NULL,
  `price` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `passport_type`
--

INSERT INTO `passport_type` (`passport_type_id`, `passport_type`, `price`) VALUES
(1, 'Ordinary Passport\r\n', 300),
(2, 'Official Passport\r\n', 400),
(3, 'Diplomatic Passport', 600),
(4, 'Emergency Travel Document', 800);

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `payment_id` int(11) NOT NULL,
  `citizen_id` int(11) NOT NULL,
  `amount` decimal(12,0) NOT NULL,
  `Account_id` int(11) NOT NULL,
  `payment_method_id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`payment_id`, `citizen_id`, `amount`, `Account_id`, `payment_method_id`, `date`) VALUES
(1, 1, 600, 1, 2, '2023-06-07 13:32:59');

--
-- Triggers `payment`
--
DELIMITER $$
CREATE TRIGGER `update_account_balancea` AFTER INSERT ON `payment` FOR EACH ROW BEGIN
UPDATE account SET balance= balance+new.amount
WHERE Account_id=new.Account_id;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_status` AFTER INSERT ON `payment` FOR EACH ROW BEGIN
        UPDATE orders
        SET status = 'paid'
        WHERE citizen_id=new.citizen_id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `payment_method`
--

CREATE TABLE `payment_method` (
  `p_method_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment_method`
--

INSERT INTO `payment_method` (`p_method_id`, `name`) VALUES
(1, 'EVC'),
(2, 'bank'),
(3, 'edahab');

-- --------------------------------------------------------

--
-- Table structure for table `release_passport`
--

CREATE TABLE `release_passport` (
  `release_id` int(11) NOT NULL,
  `citizen_id` int(11) NOT NULL,
  `passport_type_id` varchar(40) NOT NULL,
  `issuing_date` date NOT NULL,
  `expire_date` date NOT NULL,
  `date_released` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `release_passport`
--

INSERT INTO `release_passport` (`release_id`, `citizen_id`, `passport_type_id`, `issuing_date`, `expire_date`, `date_released`) VALUES
(1, 1, 'Diplomatic Passport', '2023-06-03', '2034-06-07', '2023-06-07 13:34:01');

--
-- Triggers `release_passport`
--
DELIMITER $$
CREATE TRIGGER `update_status_order` AFTER INSERT ON `release_passport` FOR EACH ROW BEGIN
        UPDATE orders
        SET status = 'completed'
        WHERE citizen_id=new.citizen_id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` varchar(50) NOT NULL,
  `employe_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `image` varchar(100) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `employe_id`, `username`, `password`, `image`, `date`) VALUES
('USR001', 3, 'xawo', '202cb962ac59075b964b07152d234b70', 'USR001.png', '2023-06-05 09:05:07'),
('USR002', 4, 'samafale', '202cb962ac59075b964b07152d234b70', 'USR002.png', '2023-06-07 08:06:13');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`Account_id`);

--
-- Indexes for table `bills`
--
ALTER TABLE `bills`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `charge`
--
ALTER TABLE `charge`
  ADD PRIMARY KEY (`charge_id`),
  ADD UNIQUE KEY `employe_id` (`employe_id`,`month`,`year`);

--
-- Indexes for table `citizens`
--
ALTER TABLE `citizens`
  ADD PRIMARY KEY (`citizen_id`);

--
-- Indexes for table `employe`
--
ALTER TABLE `employe`
  ADD PRIMARY KEY (`employe_id`);

--
-- Indexes for table `expense`
--
ALTER TABLE `expense`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `issuing_authority`
--
ALTER TABLE `issuing_authority`
  ADD PRIMARY KEY (`issuing_authority_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`job_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `passport_information`
--
ALTER TABLE `passport_information`
  ADD PRIMARY KEY (`passport_id`);

--
-- Indexes for table `passport_type`
--
ALTER TABLE `passport_type`
  ADD PRIMARY KEY (`passport_type_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `payment_method`
--
ALTER TABLE `payment_method`
  ADD PRIMARY KEY (`p_method_id`);

--
-- Indexes for table `release_passport`
--
ALTER TABLE `release_passport`
  ADD PRIMARY KEY (`release_id`),
  ADD KEY `passport_type_id` (`passport_type_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
  MODIFY `Account_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `bills`
--
ALTER TABLE `bills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `charge`
--
ALTER TABLE `charge`
  MODIFY `charge_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `citizens`
--
ALTER TABLE `citizens`
  MODIFY `citizen_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `employe`
--
ALTER TABLE `employe`
  MODIFY `employe_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `expense`
--
ALTER TABLE `expense`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `issuing_authority`
--
ALTER TABLE `issuing_authority`
  MODIFY `issuing_authority_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `job_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `passport_information`
--
ALTER TABLE `passport_information`
  MODIFY `passport_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `passport_type`
--
ALTER TABLE `passport_type`
  MODIFY `passport_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `payment_method`
--
ALTER TABLE `payment_method`
  MODIFY `p_method_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `release_passport`
--
ALTER TABLE `release_passport`
  MODIFY `release_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
