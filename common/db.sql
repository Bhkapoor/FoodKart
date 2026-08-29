-- create database restaurantProject;
-- use restaurantProject;
-- CREATE TABLE users(
--     id INT AUTO_INCREMENT PRIMARY KEY,
--     name VARCHAR(100) NOT NULL,
--     email VARCHAR(100)  NOT NULL,
--      phone VARCHAR(20),
--     password VARCHAR(255) NOT NULL,
--     role ENUM('admin','restaurant','user') default 'user',
--     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
-- );
-- CREATE TABLE food(
--     id INT AUTO_INCREMENT PRIMARY KEY,
--     foodItem varchar(50),
--     price DECIMAL(10,2) NOT NULL,
--     image VARCHAR(255) DEFAULT NULL,
--     email VARCHAR(100)  NOT NULL,
--     STATUS ENUM('pending','approve','reject') DEFAULT 'pending',
--     restaurant_id int not null,
--     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

--     FOREIGN KEY (restaurant_id)
--     REFERENCES users(id)
--     ON DELETE CASCADE
-- );
-- CREATE TABLE cart(
--     id INT AUTO_INCREMENT PRIMARY KEY,
--     user_id INT NOT NULL,
--     food_id INT NOT NULL,
--     quantity INT DEFAULT 1,
--     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

--     FOREIGN KEY(user_id)
--     REFERENCES users(id)
--     ON DELETE CASCADE,

--     FOREIGN KEY(food_id)
--     REFERENCES food(id)
--     ON DELETE CASCADE
-- );
-- CREATE TABLE wish(
--     id INT AUTO_INCREMENT PRIMARY KEY,
--     user_id INT NOT NULL,
--     food_id INT NOT NULL,
    
--     FOREIGN KEY(user_id)
--     REFERENCES users(id)
--     ON DELETE CASCADE,

--     FOREIGN KEY (food_id)
--     REFERENCES food(id)
--     ON DELETE CASCADE
-- );
-- CREATE TABLE orders(
--     order_id INT AUTO_INCREMENT PRIMARY KEY,
--     user_id INT NOT NULL,
--     address TEXT NOT NULL,
--     phone VARCHAR(20) NOT NULL,
--     payment_method VARCHAR(50) NOT NULL,
--     total DECIMAL(10,2) NOT NULL,
--     razorpay_payment_id int not null,
--     razorpay_order_id int not null,
--     paymment_status ENUM('pending','paid') DEFAULT 'pending',
--     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
--      FOREIGN KEY(user_id)
--      REFERENCES users(id)
--      ON DELETE CASCADE
-- );
-- CREATE TABLE order_items(
--     id INT AUTO_INCREMENT PRIMARY KEY,
--     order_id INT NOT NULL,
--     food_id INT NOT NULL,
--     quantity INT NOT NULL DEFAULT 1,
--     price DECIMAL(10,2) NOT NULL,
--     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
--     FOREIGN KEY(order_id)
--     REFERENCES orders(order_id)
--     ON DELETE CASCADE,
--     FOREIGN KEY(food_id)
--     REFERENCES food(id)
--     ON DELETE CASCADE
-- );
create table ressetPassword(
    id int auto_increment primary key,
    email varchar(100) not null,
    token varchar(50) not null,
    expiry datetime not null,
    created_at timestamp default CURRENT_TIMESTAMP

);
