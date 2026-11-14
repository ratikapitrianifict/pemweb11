CREATE DATABASE IF NOT EXISTS api_lab;

USE api_lab;

CREATE TABLE IF NOT EXISTS tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150) NOT NULL,
    category VARCHAR(50) NOT NULL DEFAULT 'Elektronik',
    price INT NOT NULL DEFAULT 0,
    stock INT NOT NULL DEFAULT 0,
    image VARCHAR(255) NULL,
    description TEXT NULL,
    status VARCHAR(20) NOT NULL DEFAULT 'ready',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO tasks (title, category, price, stock, image, description, status) VALUES
('Mechanical Keyboard', 'Elektronik', 550000, 8, 'https://images.unsplash.com/photo-1587829741301-dc798b83add3?w=600&auto=format&fit=crop&q=80', 'Keyboard mekanikal RGB switch biru dengan kabel braided responsif.', 'ready'),
('Wireless Mouse', 'Elektronik', 180000, 12, 'https://images.unsplash.com/photo-1615663245857-ac93bb7c39e7?w=600&auto=format&fit=crop&q=80', 'Mouse wireless ergonomis konektivitas 2.4GHz hemat daya.', 'ready'),
('Laptop Stand', 'Aksesoris', 250000, 4, 'https://images.unsplash.com/photo-1544244015-0df4b3ffc6b0?w=600&auto=format&fit=crop&q=80', 'Stand laptop bahan aluminium kokoh dengan sudut kemiringan fleksibel.', 'ready'),
('Gaming Laptop ROG', 'Elektronik', 18500000, 3, 'https://images.unsplash.com/photo-1603302576837-37561b2e2302?w=600&auto=format&fit=crop&q=80', 'Laptop gaming high performance prosesor Ryzen 9 dan kartu grafis RTX.', 'ready'),
('MacBook Air M2', 'Elektronik', 16200000, 5, 'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?w=600&auto=format&fit=crop&q=80', 'Laptop Apple chip M2 layar Liquid Retina 13.6 inci warna Midnight.', 'ready'),
('Monitor UltraWide 29 Inch', 'Elektronik', 3200000, 6, 'https://images.unsplash.com/photo-1527443224154-c4a3942d3acf?w=600&auto=format&fit=crop&q=80', 'Monitor IPS UltraWide 21:9 75Hz HDR dengan bezel tipis.', 'ready');
