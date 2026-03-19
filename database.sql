-- Criação da Base de Dados
CREATE DATABASE IF NOT EXISTS db_AssetLogic;
USE db_AssetLogic;

-- Tabela de Categorias
CREATE TABLE categorias (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(50) NOT NULL
);

-- Tabela de Produtos (Ativos)
CREATE TABLE produtos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    quantidade INT DEFAULT 0,
    preco DECIMAL(10,2),
    categoria_id INT,
    FOREIGN KEY (categoria_id) REFERENCES categorias(id)
);

-- Inserir alguns dados de teste
INSERT INTO categorias (nome) VALUES ('Hardware'), ('Software'), ('Consumíveis');
INSERT INTO produtos (nome, quantidade, preco, categoria_id) VALUES 
('Portátil Dell Latitude', 12, 850.00, 1),
('Licença Microsoft 365', 45, 120.50, 2),
('Tinteiro Impressora HP', 3, 45.00, 3);