-- created database
CREATE DATABASE IMS;
USE IMS;
-- --------------------------------------------------------
-- Table structure for table `users`

CREATE TABLE users (
  id iNT NOT NULL AUTO_INCREMENT,
  firstname VARCHAR(20) NOT NULL,
  lastname VARCHAR(20) NOT NULL,
  email VARCHAR(50) NOT NULL,
  password VARCHAR(255) NOT NULL,
  PRIMARY KEY (id)
);
-- Dumping data for table `users`

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

-- --------------------------------------------------------