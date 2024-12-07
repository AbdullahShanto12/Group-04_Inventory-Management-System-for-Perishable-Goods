-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 07, 2024 at 01:43 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventory_goods`
--

-- --------------------------------------------------------

--
-- Table structure for table `alerts`
--

CREATE TABLE `alerts` (
  `alert_id` int(11) NOT NULL,
  `alert_type` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `alert_date` date DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `alerts`
--

INSERT INTO `alerts` (`alert_id`, `alert_type`, `description`, `alert_date`, `status`) VALUES
(1, 'System', 'System maintenance scheduled.', '2024-12-01', 'Active'),
(2, 'Order', 'Order #1001 delayed.', '2024-12-02', 'Resolved'),
(3, 'Inventory', 'Low stock for product P001.', '2024-12-03', 'Active'),
(4, 'System', 'Server restarted successfully.', '2024-12-04', 'Closed'),
(5, 'Order', 'Order #1002 cancelled.', '2024-12-05', 'Closed'),
(6, 'Inventory', 'Overstock in warehouse W001.', '2024-12-06', 'Active'),
(7, 'System', 'New software version available.', '2024-12-07', 'Active'),
(8, 'Order', 'Order #1003 completed.', '2024-12-06', 'Resolved'),
(9, 'Inventory', 'New stock added for product P002.', '2024-12-07', 'Active'),
(10, 'System', 'Backup completed successfully.', '2024-12-07', 'Resolved');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` varchar(10) NOT NULL,
  `NAME` varchar(100) NOT NULL,
  `department` varchar(50) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `jobTitle` varchar(100) NOT NULL,
  `location` varchar(50) NOT NULL,
  `yearsOfService` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `NAME`, `department`, `phone`, `jobTitle`, `location`, `yearsOfService`) VALUES
('E005', 'Emily Davis', 'HR', '555-7890', 'Recruiter', 'Seattle', 4),
('E006', 'Frank Thomas', 'Sales', '555-6543', 'Account Executive', 'New York', 6),
('E007', 'Grace Miller', 'IT', '555-3456', 'Systems Analyst', 'San Francisco', 5),
('E008', 'Hannah Taylor', 'Marketing', '555-8764', 'Brand Manager', 'Chicago', 3),
('E009', 'Ian Wilson', 'Admin', '555-6789', 'Operations Manager', 'Los Angeles', 8),
('E010', 'Julia Moore', 'HR', '555-2345', 'HR Specialist', 'Seattle', 2),
('E011', 'Kevin Garcia', 'Sales', '555-9876', 'Sales Representative', 'New York', 4),
('E012', 'Laura Hernandez', 'IT', '555-3210', 'Network Engineer', 'San Francisco', 6),
('E013', 'Michael Anderson', 'Marketing', '555-7654', 'Social Media Manager', 'Chicago', 2),
('E014', 'Natalie Martinez', 'Admin', '555-5432', 'Executive Assistant', 'Los Angeles', 9),
('E015', 'Oliver Brown', 'HR', '555-8763', 'HR Generalist', 'Seattle', 3),
('E016', 'Pamela Jackson', 'Sales', '555-6541', 'Sales Coordinator', 'New York', 5),
('E017', 'Quentin Lee', 'IT', '555-9870', 'Data Analyst', 'San Francisco', 4),
('E018', 'Rachel Clark', 'Marketing', '555-4323', 'Content Strategist', 'Chicago', 1),
('E019', 'Steven Harris', 'Admin', '555-7653', 'Administrative Assistant', 'Los Angeles', 6),
('E020', 'Tina Evans', 'HR', '555-3214', 'Compensation Analyst', 'Seattle', 7);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `order_date` date NOT NULL,
  `status` enum('Pending','Processing','Completed','Cancelled') DEFAULT 'Pending',
  `total_amount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `customer_name`, `order_date`, `status`, `total_amount`) VALUES
(1, 'Alice Johnson', '2024-12-01', 'Completed', 150.75),
(2, 'Bob Smith', '2024-12-02', 'Pending', 250.00),
(3, 'Charlie Davis', '2024-12-03', 'Processing', 99.99),
(4, 'Diana White', '2024-12-04', 'Cancelled', 0.00),
(5, 'Evan Brown', '2024-12-05', 'Completed', 500.20),
(6, 'Fiona Green', '2024-12-06', 'Processing', 125.49),
(7, 'George Hill', '2024-12-07', 'Pending', 80.00),
(8, 'Hannah Adams', '2024-12-07', 'Completed', 300.10),
(9, 'Ian Black', '2024-12-06', 'Cancelled', 0.00),
(10, 'alam', '2024-12-20', 'Completed', 3600.00),
(10234, 'Abdullah', '2024-10-10', 'Completed', 450.00),
(10235, 'Shanto', '2024-10-15', 'Pending', 220.00),
(10236, 'Esha', '2024-10-20', 'Processing', 330.00),
(10237, 'Shakib', '2024-10-22', 'Cancelled', 150.00);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` varchar(50) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `stock_quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `category`, `stock_quantity`, `price`) VALUES
('12', 'potato', 'vegatable', 1000, 100.00),
('15', 'banana', 'fruits', 30, 100.00),
('14', 'apple', 'fruits', 30, 100.00),
('11', 'onion', 'vegatable', 11, 11.00),
('101', 'Milk - Full Cream', 'Dairy', 250, 3.50),
('102', 'Cheddar Cheese', 'Dairy', 120, 5.25),
('103', 'Organic Eggs', 'Eggs', 450, 2.00),
('104', 'Fresh Butter', 'Dairy', 80, 4.75),
('P001', 'Laptop', 'Electronics', 50, 999.99),
('P002', 'Smartphone', 'Electronics', 100, 799.99),
('P003', 'Tablet', 'Electronics', 30, 499.99),
('P004', 'Headphones', 'Accessories', 200, 49.99),
('P005', 'Monitor', 'Electronics', 70, 199.99),
('P006', 'Keyboard', 'Accessories', 150, 29.99),
('P007', 'Mouse', 'Accessories', 300, 19.99),
('P008', 'Smartwatch', 'Electronics', 40, 249.99),
('P009', 'Printer', 'Office Supplies', 20, 159.99),
('P010', 'Desk Lamp', 'Office Supplies', 80, 39.99);

-- --------------------------------------------------------

--
-- Table structure for table `storage`
--

CREATE TABLE `storage` (
  `storage_id` varchar(50) NOT NULL,
  `storage_name` varchar(100) DEFAULT NULL,
  `capacity` int(11) DEFAULT NULL,
  `used_capacity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `storage`
--

INSERT INTO `storage` (`storage_id`, `storage_name`, `capacity`, `used_capacity`) VALUES
('S001', 'Main Storage', 1000, 750),
('S002', 'Secondary Storage', 500, 300),
('S003', 'Backup Storage', 300, 150),
('S004', 'Overflow Storage', 200, 50),
('S005', 'Cold Storage', 400, 100),
('S006', 'Dry Storage', 600, 450),
('S007', 'Chemical Storage', 200, 180),
('S008', 'Hazmat Storage', 100, 90),
('S009', 'Raw Material Storage', 500, 350),
('S010', 'Finished Goods Storage', 700, 650);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `password`, `role`) VALUES
(0, 'ABDULLAH', 'abdullah@gmail.com', '$2y$10$bgcmsr.dpzFqunCF0LZbM.cHHxf/stMODaNpu74J3tGAEYyHMKpZ2', 'admin'),
(0, 'ABDULLAH', 'abdullah@gmail.com', '$2y$10$8.BedMM8yMhMdsym0dYyquxcZq8lZ/4cca0sLy0UuQCUxlhmAI93W', 'editor_Sales'),
(0, 'ABDULLAH', 'abdullah@gmail.com', '$2y$10$U8wsmTVNSCY4S7iI6irEXuiJjqsfcLJJvn0EHksjHyCRVdbX6Uuni', 'editor_Product'),
(0, 'ABDULLAH', 'abdullah@gmail.com', '$2y$10$T9uqzsCkkxbvhVVYaWPoUuqTxbbqZtDXzyBleD3rZbRMHshjKqJMO', 'editor_Warehouse');

-- --------------------------------------------------------

--
-- Table structure for table `warehouses`
--

CREATE TABLE `warehouses` (
  `warehouse_id` int(11) NOT NULL,
  `warehouse_name` varchar(255) NOT NULL,
  `location` varchar(50) NOT NULL,
  `capacity` int(11) NOT NULL,
  `stock_level` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `warehouses`
--

INSERT INTO `warehouses` (`warehouse_id`, `warehouse_name`, `location`, `capacity`, `stock_level`) VALUES
(1, 'Warehouse A(San Francisco)', '37.7749,-122.4194', 1000, 800),
(2, 'Warehouse B(Los Angeles)', '34.0522,-118.2437', 2000, 1500),
(3, 'Warehouse C(New York)', '40.7128,-74.0060', 1500, 1200),
(4, 'Warehouse D(London)', '51.5074,-0.1278', 2500, 2000),
(5, 'Warehouse D(London)', '53.5074,-0.1278', 3500, 2000);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alerts`
--
ALTER TABLE `alerts`
  ADD PRIMARY KEY (`alert_id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `storage`
--
ALTER TABLE `storage`
  ADD PRIMARY KEY (`storage_id`);

--
-- Indexes for table `warehouses`
--
ALTER TABLE `warehouses`
  ADD PRIMARY KEY (`warehouse_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alerts`
--
ALTER TABLE `alerts`
  MODIFY `alert_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10238;

--
-- AUTO_INCREMENT for table `warehouses`
--
ALTER TABLE `warehouses`
  MODIFY `warehouse_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
