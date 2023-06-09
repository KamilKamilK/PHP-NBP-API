CREATE
DATABASE IF NOT EXISTS nbp;

USE
nbp;

CREATE TABLE currency
(
    id            INT AUTO_INCREMENT NOT NULL,
    name          VARCHAR(50) NOT NULL,
    currency_code VARCHAR(3)  NOT NULL,
    exchange_rate VARCHAR(10) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE conversions
(
    id               INT AUTO_INCREMENT NOT NULL,
    source_code      VARCHAR(3)  NOT NULL,
    target_code      VARCHAR(3)  NOT NULL,
    amount           VARCHAR(10) NOT NULL,
    converted_amount VARCHAR(10) NOT NULL,
    created_at       TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
);



