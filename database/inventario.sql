CREATE DATABASE IF NOT EXISTS inventario_ventas CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE inventario_ventas;

CREATE TABLE IF NOT EXISTS ventas (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    product_id VARCHAR(80) NOT NULL,
    product_name VARCHAR(120) NOT NULL,
    customer_name VARCHAR(120) NOT NULL,
    quantity INT UNSIGNED NOT NULL,
    unit_price DECIMAL(10,2) NOT NULL,
    total DECIMAL(10,2) NOT NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_product_id (product_id),
    INDEX idx_created_at (created_at)
);