-- Creazione del database
CREATE DATABASE IF NOT EXISTS multilingual;
USE multilingual;

-- Tabella per le traduzioni delle etichette
CREATE TABLE IF NOT EXISTS translations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    lang VARCHAR(2),
    `key` VARCHAR(255),
    translation TEXT
);

-- Popolamento della tabella con alcune traduzioni di esempio
INSERT INTO translations (lang, `key`, translation) VALUES
('it', 'welcome', 'Benvenuto'),
('en', 'welcome', 'Welcome'),
('it', 'news_title', 'Titolo'),
('en', 'news_title', 'Title');

-- Tabella per le notizie
CREATE TABLE IF NOT EXISTS news (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255),
    content TEXT,
    published_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Popolamento della tabella con alcune notizie di esempio
INSERT INTO news (title, content) VALUES
('Notizia 1', 'Contenuto della notizia 1'),
('Notizia 2', 'Contenuto della notizia 2');