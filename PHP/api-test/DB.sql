CREATE DATABASE dbStock;

USE dbStock;

CREATE TABLE categories (
    id_category TINYINT UNSIGNED NOT NULL AUTO_INCREMENT,
    description VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL,
    is_enabled BOOLEAN DEFAULT TRUE,
    PRIMARY KEY (id_category)
) ENGINE=InnoDB CHARSET=utf8;

CREATE TABLE products (
    id_product INT UNSIGNED NOT NULL AUTO_INCREMENT,
    id_category TINYINT UNSIGNED NOT NULL,
    name VARCHAR(150) NOT NULL,
    additional_info VARCHAR(255) NULL,
    price DECIMAL(10, 2) NOT NULL,
    stock_quantity INT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL,
    is_enabled BOOLEAN DEFAULT TRUE,
    PRIMARY KEY (id_product),
    CONSTRAINT fk_category_product 
        FOREIGN KEY (id_category) REFERENCES categories (id_category)
        ON DELETE CASCADE
) ENGINE=InnoDB CHARSET=utf8;

CREATE TABLE movements (
    id_movement BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    id_product INT UNSIGNED NOT NULL,
    movement_datetime TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    quantity INT NOT NULL,
    comments VARCHAR(500) NULL,
    PRIMARY KEY (id_movement),
    CONSTRAINT fk_movement_product 
        FOREIGN KEY (id_product) REFERENCES products (id_product)
        ON DELETE CASCADE
) ENGINE=InnoDB CHARSET=utf8;

INSERT INTO categories (description) VALUES
('Electronics'),
('Furniture'),
('Clothing'),
('Groceries'),
('Health & Beauty'),
('Toys & Games'),
('Sports Equipment'),
('Books & Stationery'),
('Home Appliances'),
('Automotive Accessories');

INSERT INTO products (id_category, name, additional_info, price, stock_quantity) VALUES
(1, 'Smartphone Samsung Galaxy S21', '128GB, Phantom Gray', 799.99, 50),
(1, 'Laptop HP Pavilion 15', 'Intel i7, 16GB RAM, 512GB SSD', 899.99, 30),
(1, 'Wireless Mouse Logitech MX Master 3', 'Ergonomic, Bluetooth', 99.99, 150),
(2, 'Sofa Bed IKEA FRIHETEN', 'Convertible, Beige', 599.99, 25),
(2, 'Dining Table Set', 'Wooden, 6 chairs', 299.99, 20),
(2, 'Office Chair Ergonomic', 'Adjustable height, Black', 149.99, 100),
(3, 'Men\'s T-Shirt Nike', 'Size M, Cotton, Black', 29.99, 200),
(3, 'Women\'s Winter Coat Zara', 'Size L, Wool Blend, Blue', 129.99, 60),
(3, 'Adidas Running Shoes', 'Size 10, Red', 89.99, 120),
(4, 'Organic Avocados', 'Fresh, pack of 5', 3.99, 500),
(4, 'Whole Wheat Bread', '500g, Organic', 2.49, 800),
(4, 'Free-Range Eggs', '12 pack', 5.99, 300),
(5, 'Vitamin C Tablets', '100 tablets, 1000mg', 15.99, 200),
(5, 'Face Moisturizer Olay', '50ml, Fragrance Free', 22.99, 150),
(5, 'Shampoo Head & Shoulders', '500ml, Anti-Dandruff', 7.99, 250),
(6, 'Lego Technic Porsche 911', 'Model Kit, 2700 pieces', 169.99, 50),
(6, 'Barbie Dream House', 'Fully furnished, with dolls', 229.99, 40),
(6, 'Remote Control Helicopter', 'Battery Operated, 2.4 GHz', 49.99, 70),
(7, 'Tennis Racket Wilson Pro Staff', 'Head Size 100in²', 199.99, 35),
(7, 'Yoga Mat Liforme', 'Eco-Friendly, Non-slip', 79.99, 100),
(7, 'Dumbbell Set 20kg', 'Pair, Adjustable', 59.99, 150),
(8, 'Notebook Moleskine', 'Ruled, A5, Black', 19.99, 250),
(8, 'Pen Set Pilot G2', 'Pack of 10, Gel Pens', 9.99, 300),
(8, 'Planner 2025', 'Leather Bound, Weekly Layout', 29.99, 120),
(9, 'Air Fryer Philips', '2L, Digital', 119.99, 50),
(9, 'Smart Refrigerator LG', '500L, Wi-Fi Enabled', 1499.99, 10),
(9, 'Coffee Maker Nespresso', 'Compact, Black', 129.99, 70),
(10, 'Car Wash Kit', 'Includes wax, microfiber cloth', 39.99, 80),
(10, 'Portable Car Jump Starter', '12V, 6000mAh', 69.99, 50),
(10, 'Roof Rack for SUV', 'Adjustable, Steel', 89.99, 40),
(1, 'Smartwatch Garmin Venu 2', 'AMOLED, GPS, Fitness Tracker', 249.99, 90),
(1, 'Noise Cancelling Headphones Sony WH-1000XM4', 'Bluetooth, Black', 349.99, 60),
(1, 'Bluetooth Speaker JBL Flip 5', 'Waterproof, Portable', 89.99, 150),
(2, 'King Size Bed Frame', 'Wooden, with storage', 499.99, 15),
(2, 'Queen Mattress Tempur', 'Memory Foam, Medium Firm', 799.99, 30),
(2, 'Coffee Table IKEA LIATORP', 'White, 1 shelf', 149.99, 25),
(3, 'Men\'s Leather Jacket', 'Size L, Brown', 199.99, 50),
(3, 'Women\'s Boots Timberland', 'Size 7, Waterproof', 129.99, 70),
(3, 'Sports Shorts Adidas', 'Size M, Blue', 24.99, 100),
(4, 'Organic Bananas', 'Pack of 6', 2.49, 600),
(4, 'Almond Milk', '1L, Unsweetened', 3.49, 500),
(4, 'Organic Carrots', '500g', 1.99, 700),
(5, 'Collagen Supplement Vital Proteins', '300g, Powder', 39.99, 120),
(5, 'Hair Serum Kerastase', '100ml, Restorative', 59.99, 80),
(5, 'Toothpaste Colgate', 'Pack of 2', 3.49, 400);