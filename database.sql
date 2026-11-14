CREATE DATABASE IF NOT EXISTS api_lab;

USE api_lab;

CREATE TABLE IF NOT EXISTS tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150) NOT NULL,
    description TEXT NULL,
    status VARCHAR(20) NOT NULL DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO tasks (title, description, status) VALUES
('Belajar API', 'Memahami endpoint dan JSON response', 'pending'),
('Membuat Laporan', 'Menyelesaikan laporan praktikum', 'done'),
('Presentasi', 'Menyiapkan presentasi kelas', 'pending');

