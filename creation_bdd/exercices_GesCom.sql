-- Active: 1745306493697@@127.0.0.1@3306@GesCom
DROP DATABASE GesCom;
CREATE DATABASE GesCom;

CREATE TABLE suppliers(
    sup_id INT NOT NULL AUTO_INCREMENT UNIQUE PRIMARY KEY,
    sup_name VARCHAR(50) NOT NULL,
    sup_city VARCHAR(50) NOT NULL,
    sup_adresse VARCHAR(150) NOT NULL,
    sup_mail VARCHAR(75),
    sup_phone INT(10)
);

CREATE TABLE customers (
    cus_id INT NOT NULL AUTO_INCREMENT UNIQUE PRIMARY KEY,
    cus_lastname VARCHAR(50) NOT NULL,
    cus_firstname VARCHAR(50) NOT NULL,
    cus_adresse VARCHAR(150) NOT NULL,
    cus_zipcode VARCHAR(5) NOT NULL,
    cus_city VARCHAR(50) NOT NULL,
    cus_mail VARCHAR(75),
    cus_phone INT(10)
);

CREATE TABLE  orders (
    ord_id INT NOT NULL AUTO_INCREMENT UNIQUE PRIMARY KEY,
    ord_order_date DATE DEFAULT CURRENT_DATE,
    ord_ship_date DATE NOT NULL,
    ord_bill_date DATE,
    ord_reception_date DATE,
    ord_status VARCHAR(25) NOT NULL,
    cus_id INT,
    FOREIGN KEY (cus_id) REFERENCES customers(cus_id)

);

CREATE TABLE categories (
    cat_id INT NOT NULL AUTO_INCREMENT UNIQUE PRIMARY KEY,
    cat_name VARCHAR(200),
    cat_parent_id INT
);


CREATE TABLE products (
    pro_id INT NOT NULL AUTO_INCREMENT UNIQUE PRIMARY KEY,
    pro_ref VARCHAR(10) NOT NULL,
    pro_name VARCHAR(200) NOT NULL,
    pro_desc TEXT(1000) NOT NULL,
    pro_price DECIMAL(6,2) NOT NULL,
    pro_stock SMALLINT(4),
    pro_color VARCHAR(30),
    pro_picture VARCHAR(40),
    pro_add_date DATE NOT NULL DEFAULT CURRENT_DATE,
    pro_update_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    pro_publish TINYINT(1) NOT NULL,
    cat_id INT,
    sup_id INT,
    FOREIGN KEY (cat_id) REFERENCES categories(cat_id),
    FOREIGN KEY (sup_id) REFERENCES suppliers(sup_id)

);

CREATE TABLE details (
    det_id INT NOT NULL AUTO_INCREMENT UNIQUE PRIMARY KEY,
    det_price DECIMAL(6,2) NOT NULL,
    det_quantity INT(5) NOT NULL,
    pro_id INT,
    ord_id INT,
    FOREIGN KEY (pro_id) REFERENCES products(pro_id),
    FOREIGN KEY (ord_id) REFERENCES orders(ord_id)
    
);

CREATE INDEX pro_ref ON products(pro_ref);



