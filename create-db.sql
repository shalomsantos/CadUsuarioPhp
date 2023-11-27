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

INSERT INTO usuario (nome, email, telefone, senha)
SELECT 'shalom pereira dos santos', 'shalomsantos@gmail.com', '85985013193', '123'
FROM dual
WHERE NOT EXISTS (
    SELECT 1
    FROM usuario
    WHERE nome = 'shalom pereira dos santos' AND email = 'shalomsantos@gmail.com'
);