-- Skapa databasen
CREATE DATABASE IF NOT EXISTS notes_db;
USE notes_db;

-- Skapa användartabellen
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Skapa anteckningstabellen
CREATE TABLE IF NOT EXISTS notes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(100) NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Skapa databasanvändare och ge behörigheter
CREATE USER IF NOT EXISTS 'notes_user'@'%' IDENTIFIED BY 'notes_password';
GRANT ALL PRIVILEGES ON notes_db.* TO 'notes_user'@'%';
FLUSH PRIVILEGES;