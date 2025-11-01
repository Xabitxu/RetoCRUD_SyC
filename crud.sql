CREATE DATABASE CRUD;
USE CRUD;

CREATE TABLE PROFILE_ (
USERNAME VARCHAR(40) PRIMARY KEY,
PASSWORD_ VARCHAR(60),
EMAIL VARCHAR(40) UNIQUE ,
USER_CODE INT AUTO_INCREMENT UNIQUE,
NAME_ VARCHAR(40),
TELEPHONE VARCHAR(9),
CONSTRAINT CHK_TELEPHONE
        CHECK (TELEPHONE REGEXP '^[0-9]{9}$'),
SURNAME VARCHAR(40)
);

CREATE TABLE USER_ (
USERNAME VARCHAR(40) PRIMARY KEY,
GENDER VARCHAR(40),
CARD_NUMBER VARCHAR(24),
CONSTRAINT CHK_CARD_NUMBER
        CHECK (CARD_NUMBER REGEXP '^[A-Z]{2}[0-9]{22}$'),
FOREIGN KEY (USERNAME) REFERENCES PROFILE_ (USERNAME)
);

CREATE TABLE ADMIN_ (
USERNAME VARCHAR(40) PRIMARY KEY,
CURRENT_ACCOUNT VARCHAR(40),
FOREIGN KEY (USERNAME) REFERENCES PROFILE_ (USERNAME)
);

-- jlopez: pass123
-- mramirez: pass456
-- cperez: pass789
-- asanchez: qwerty (admin)
-- rluna: zxcvbn (admin)
-- a: a (admin)
-- b: b (admin)

INSERT INTO PROFILE_ (USERNAME, PASSWORD_, EMAIL, USER_CODE, NAME_, TELEPHONE, SURNAME)
VALUES
('jlopez', '$2y$10$mUdZCGK6qlqfBrRiOOerluif6FZdLNeVVW8ln7hSt2cw9wiR0rHU6', 'jlopez@example.com', 101, 'Juan', '987654321', 'Lopez'),
('mramirez', '$2y$10$K0Wgt6YWim6kMqpWlyE0VeDYtxe/ln1eZyUYZ0dwB4veTGRjOediq', 'mramirez@example.com', 102, 'Maria', '912345678', 'Ramirez'),
('cperez', '$2y$10$UlZ/t21QiGYItXQkgeWmROk25I1bp112VgFicnflv3KWx37MqQ9h.', 'cperez@example.com', 103, 'Carlos', '934567890', 'Perez'),
('asanchez', '$2y$10$FhgliU5M6dTSquGEddiwVusxcRr6NA5gVItbnpldjeEWz5XiyYkaW', 'asanchez@example.com', 104, 'Ana', '900112233', 'Sanchez'),
('rluna', '$2y$10$AafdSHEHc17u7Ms4VFLLfO7vSO9KuKsXw0yUNHrSuik8xAEONHTam', 'rluna@example.com', 105, 'Rosa', '955667788', 'Luna'),
('a', '$2y$10$Bkg2D0arux4eXeQ2NCjHgum7nbUUKew9WFoLHML8sqoeqX49aXO0a', 'a@admin.com', 106, 'Admin', '900000001', 'A'),
('b', '$2y$10$PCu4TkaMylE2kyBfSSC2w.1K3K3Jwvf..wlpxhOgl2y4bNwPFA3ZK', 'b@admin.com', 107, 'Admin', '900000002', 'B');

INSERT INTO USER_ (USERNAME, GENDER, CARD_NUMBER)
VALUES
('jlopez', 'Masculino', 'AB1234567890123456789012'),
('mramirez', 'Femenino', 'ZX9081726354891027364512'),
('cperez', 'Masculino', 'LM0011223344556677889900');

INSERT INTO ADMIN_ (USERNAME, CURRENT_ACCOUNT)
VALUES
('asanchez', 'CTA-001'),
('rluna', 'CTA-002'),
('a', 'CTA-003'),
('b', 'CTA-004');