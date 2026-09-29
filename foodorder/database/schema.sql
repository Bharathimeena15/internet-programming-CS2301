-- ============================================================
-- Restaurant Food Ordering Website - Database Schema
-- CS2307 - Internet Programming Lab Mini Project
-- ============================================================

CREATE DATABASE IF NOT EXISTS foodorder_db;
USE foodorder_db;

-- ---------------------------
-- Table: users
-- ---------------------------
CREATE TABLE IF NOT EXISTS users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone VARCHAR(15) NOT NULL,
    password VARCHAR(255) NOT NULL,
    address VARCHAR(255) DEFAULT NULL,
    role ENUM('customer','admin') DEFAULT 'customer',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ---------------------------
-- Table: categories
-- ---------------------------
CREATE TABLE IF NOT EXISTS categories (
    category_id INT AUTO_INCREMENT PRIMARY KEY,
    category_name VARCHAR(50) NOT NULL
);

-- ---------------------------
-- Table: menu_items
-- ---------------------------
CREATE TABLE IF NOT EXISTS menu_items (
    item_id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT,
    item_name VARCHAR(100) NOT NULL,
    description VARCHAR(255) DEFAULT NULL,
    price DECIMAL(8,2) NOT NULL,
    image VARCHAR(255) DEFAULT 'default.jpg',
    is_available TINYINT(1) DEFAULT 1,
    FOREIGN KEY (category_id) REFERENCES categories(category_id) ON DELETE SET NULL
);

-- ---------------------------
-- Table: orders
-- ---------------------------
CREATE TABLE IF NOT EXISTS orders (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    total_amount DECIMAL(10,2) NOT NULL,
    delivery_address VARCHAR(255) NOT NULL,
    payment_mode ENUM('COD','Online') DEFAULT 'COD',
    status ENUM('Pending','Confirmed','Preparing','Out for Delivery','Delivered','Cancelled') DEFAULT 'Pending',
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

-- ---------------------------
-- Table: order_items
-- ---------------------------
CREATE TABLE IF NOT EXISTS order_items (
    order_item_id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    item_id INT NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(8,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(order_id) ON DELETE CASCADE,
    FOREIGN KEY (item_id) REFERENCES menu_items(item_id) ON DELETE CASCADE
);

-- ============================================================
-- Seed data
-- ============================================================

INSERT INTO categories (category_name) VALUES
('Starters'), ('Main Course'), ('Beverages'), ('Desserts');

INSERT INTO menu_items (category_id, item_name, description, price, image) VALUES
(1, 'Paneer Tikka', 'Grilled cottage cheese cubes marinated in spices', 180.00, 'paneer_tikka.jpg'),
(1, 'Veg Spring Rolls', 'Crispy rolls stuffed with mixed vegetables', 150.00, 'spring_rolls.jpg'),
(2, 'Butter Chicken', 'Chicken cooked in rich tomato butter gravy', 280.00, 'butter_chicken.jpg'),
(2, 'Veg Biryani', 'Fragrant basmati rice cooked with vegetables and spices', 220.00, 'veg_biryani.jpg'),
(2, 'Paneer Butter Masala', 'Cottage cheese in creamy tomato gravy', 240.00, 'paneer_butter_masala.jpg'),
(3, 'Masala Chaas', 'Spiced buttermilk', 40.00, 'chaas.jpg'),
(3, 'Cold Coffee', 'Chilled coffee with ice cream', 90.00, 'cold_coffee.jpg'),
(4, 'Gulab Jamun', 'Soft milk dumplings soaked in sugar syrup', 80.00, 'gulab_jamun.jpg'),
(4, 'Ice Cream Sundae', 'Assorted ice cream with toppings', 120.00, 'sundae.jpg');

-- Default admin account (password: admin123)
INSERT INTO users (full_name, email, phone, password, role) VALUES
('Admin', 'admin@foodorder.com', '9999999999', '$2y$10$e0MYzXyjpJS7Pd0RVvHwHeFXH1v5v5vqW1r5b0T6XdWq8f0F8wQr6', 'admin');
-- NOTE: run reset_admin_password.php once (see README) to set a working
-- hashed password for this account, since hashes are not portable across
-- PHP/OpenSSL builds.
