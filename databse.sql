CREATE TABLE cart (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_name VARCHAR(255) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    quantity INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO cart (product_name, price, quantity) VALUES
('Laptop', 1200.00, 1),
('Mouse', 25.00, 1),
('Keyboard', 50.00, 1);
