CREATE DATABASE IF NOT EXISTS basicus;
USE basicus;

CREATE TABLE IF NOT EXISTS usuario (
    id INT NOT NULL auto_increment,
    nome VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL,
    telefone VARCHAR(11) NULL,
    senha VARCHAR(20) NOT NULL,
    PRIMARY KEY (id)
);

INSERT INTO usuario ('shalom pereira dos santos', 'shalomsantos@gmail.com', '85985013193', '123')