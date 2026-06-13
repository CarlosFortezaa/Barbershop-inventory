CREATE TABLE products (
	id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    category  VARCHAR(100),
    quantity INT NOT NULL DEFAULT 0,
    min_stock INT NOT NULL DEFAULT 0,
    price DECIMAL(10,2),
    image_path VARCHAR(255) DEFAULT NULL, 
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE users(
	id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(30) NOT NULL,
    email VARCHAR(255) NOT NULL,
);

CREATE TABLE inventory_movement(
	id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    quantity_change INT NOT NULL,
    movement_type ENUM('restock','usage') NOT NULL,
    timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(id)
);

DROP TABLE inventory_movement;
SELECT * FROM products;
DESCRIBE products;
SELECT * FROM inventory_movement;

DESCRIBE products;

SELECT name, quantity, min_stock FROM products WHERE quantity < min_stock LIMIT 5
