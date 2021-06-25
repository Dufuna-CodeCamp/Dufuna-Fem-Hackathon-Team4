-- created database
CREATE DATABASE IMS;
USE IMS;

-- --------------------------------------------------------

-- Table structure for table `users`

CREATE TABLE users (
  id iNT NOT NULL AUTO_INCREMENT,
  username VARCHAR(20) NOT NULL,
  email VARCHAR(50) NOT NULL,
  password VARCHAR(255) NOT NULL,
  PRIMARY KEY (id)
);

-- Dumping data for table `users`

INSERT INTO users (id, username, email, password) 
VALUES
(1, 'admin', 'test@mail.com', '16d7a4fca7442dda3ad93c9a726597e4'),
(2, 'moyin', 'moyin@mail.com', '16d7a4fca7442dda3ad93c9a726597e4');

-- --------------------------------------------------------


-- Table structure for table `categories`

CREATE TABLE categories (
  id INT NOT NULL AUTO_INCREMENT,
  category_name VARCHAR(100) NOT NULL,
  description VARCHAR(255) NOT NULL,
  created_at DATETIME NOT NULL DEFAULT current_timestamp(),
  user_id INT NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (user_id) REFERENCES users(id)
);


-- Dumping data for table `categories`

INSERT INTO categories (id, category_name, description, created_at, user_id) VALUES
(1, 'Food', 'To be fit', '2021-06-22 12:22:54', 1),
(2, 'Drinks', 'To keep you hydrated', '2021-06-22 12:24:26', 1),
(3, 'Toiletries', 'To keep you safe', '2021-06-22 19:49:41', 1),
(5, 'Baby care', 'To make my baby happy', '2021-06-22 19:56:38', 2);


-- --------------------------------------------------------

-- Table structure for table `vendors`

CREATE TABLE vendors (
  id INT NOT NULL AUTO_INCREMENT,
  vendor_name VARCHAR(100) NOT NULL,
  phone_number VARCHAR(15) NOT NULL,
  vendor_email VARCHAR(255) NOT NULL,
  vendor_address VARCHAR(255) NOT NULL,
  PRIMARY KEY (id)
);

-- Dumping data for table `vendors

INSERT INTO vendors (id, vendor_name, phone_number, vendor_email, vendor_address) VALUES
(5, 'Nestle', '08077781991', 'nestle@mail.com', 'Flowergate'),
(7, 'Honeywell', '09063215465', 'jumo@mail.com', 'surulere');


-- --------------------------------------------------------

-- Table structure for table `inventories

CREATE TABLE inventories (
  id INT NOT NULL AUTO_INCREMENT,
  product_name VARCHAR(100) NOT NULL,
  category_id INT NOT NULL,
  product_quantity INT NOT NULL,
  stock_status VARCHAR(20) NOT NULL,
  created_at DATETIME NOT NULL DEFAULT current_timestamp(),
  user_id INT NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (category_id) REFERENCES categories(id),
  FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Dumping data for table `inventories`

INSERT INTO inventories (id, product_name, category_id, product_quantity, stock_status, created_at, user_id) 
VALUES
(6, 'Pepsi', 2, 15, 'in stock', '2021-06-22 14:24:23', 1),
(7, 'Cornflakes', 1, 3, 'low stock', '2021-06-22 14:24:32', 1),
(8, 'Golden Morn', 1, 0, 'out of stock', '2021-06-22 14:24:41', 1),
(9, 'Bigi', 2, 2, 'low stock', '2021-06-22 19:48:40', 1),
(10, 'Harpic', 5, 0, 'out of stock', '2021-06-22 19:50:21', 1);


-- --------------------------------------------------------

-- Table structure for table `purchases

CREATE TABLE purchases (
  id INT NOT NULL AUTO_INCREMENT,
  inventory_id INT NOT NULL,
  purchase_price DECIMAL(7,2) NOT NULL,
  quantity_purchased INT NOT NULL,
  total INT NOT NULL,
  vendor_id INT NOT NULL,
  created_at DATETIME NOT NULL DEFAULT current_timestamp(),
  user_id INT NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (inventory_id) REFERENCES inventories(id),
  FOREIGN KEY (vendor_id) REFERENCES vendors(id),
  FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Dumping data for table `purchases`

INSERT INTO purchases (id, inventory_id, purchase_price, quantity_purchased, total, vendor_id, created_at, user_id) 
VALUES
(1, 9, '150.00', 10, 0, 5, '0000-00-00 00:00:00', 2),
(2, 8, '1200.00', 5, 0, 5, '0000-00-00 00:00:00', 2),
(3, 10, '550.00', 3, 0, 7, '0000-00-00 00:00:00', 2),
(4, 9, '150.00', 5, 0, 5, '0000-00-00 00:00:00', 2),
(5, 9, '150.00', 2, 0, 5, '0000-00-00 00:00:00', 2),
(6, 9, '150.00', 2, 0, 5, '0000-00-00 00:00:00', 2),
(7, 9, '150.00', 2, 0, 5, '0000-00-00 00:00:00', 2),
(8, 9, '150.00', 2, 0, 5, '0000-00-00 00:00:00', 2),
(9, 9, '150.00', 2, 0, 5, '0000-00-00 00:00:00', 2),
(10, 9, '150.00', 2, 0, 5, '0000-00-00 00:00:00', 2),
(11, 9, '150.00', 2, 0, 5, '0000-00-00 00:00:00', 2),
(12, 9, '150.00', 2, 0, 5, '0000-00-00 00:00:00', 2),
(13, 9, '150.00', 2, 0, 5, '0000-00-00 00:00:00', 2),
(14, 9, '150.00', 2, 0, 5, '0000-00-00 00:00:00', 2),
(15, 6, '150.00', 10, 0, 5, '0000-00-00 00:00:00', 2),
(16, 6, '150.00', 5, 0, 5, '0000-00-00 00:00:00', 2),
(17, 7, '1200.00', 3, 0, 5, '2021-06-22 22:05:55', 2),
(18, 6, '150.00', 4, 600, 5, '2021-06-23 11:02:18', 2);


-- --------------------------------------------------------

-- Table structure for table `sales`

CREATE TABLE sales (
  id INT NOT NULL AUTO_INCREMENT,
  inventory_id INT NOT NULL,
  sales_price DECIMAL(7,2) NOT NULL,
  quantity_sold INT NOT NULL,
  total INT NOT NULL,
  customer_name VARCHAR(100) NOT NULL,
  created_at DATETIME NOT NULL DEFAULT current_timestamp(),
  user_id INT NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (inventory_id) REFERENCES inventories(id),
  FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Dumping data for table `sales`

INSERT INTO sales (id, inventory_id, sales_price, quantity_sold, total, customer_name, created_at, user_id) 
VALUES
(1, 6, '180.00', 2, 0, 'Habiba', '2021-06-23 10:33:30', 2),
(2, 6, '180.00', 2, 360, 'Zaynab', '2021-06-23 10:57:31', 2);

-- --------------------------------------------------------
