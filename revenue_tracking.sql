-- Revenue tracking table
CREATE TABLE IF NOT EXISTS revenue_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    log_date DATE NOT NULL,
    total_orders INT NOT NULL DEFAULT 0,
    total_revenue DECIMAL(10,2) NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_date (log_date)
);

-- Archived orders table
CREATE TABLE IF NOT EXISTS archived_orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    original_order_id INT NOT NULL,
    customer_name VARCHAR(100) NOT NULL,
    customer_phone VARCHAR(20),
    total DECIMAL(10,2) NOT NULL,
    status VARCHAR(20),
    order_date TIMESTAMP,
    archived_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Archived order items table
CREATE TABLE IF NOT EXISTS archived_order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    archived_order_id INT NOT NULL,
    menu_item_name VARCHAR(100),
    quantity INT NOT NULL,
    price DECIMAL(8,2) NOT NULL,
    FOREIGN KEY (archived_order_id) REFERENCES archived_orders(id)
);
