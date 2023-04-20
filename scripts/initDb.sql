CREATE TABLE IF NOT EXISTS User (
    id int AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    solde DECIMAL(10,2) NOT NULL,
    photo VARCHAR(255),
    role VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS Article (
    id int AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    publication_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    author_id INT NOT NULL,
    image_url VARCHAR(255),
    FOREIGN KEY (author_id) REFERENCES User(id)
);

CREATE TABLE IF NOT EXISTS Cart (
    id int AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    article_id INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES User(id),
    FOREIGN KEY (article_id) REFERENCES Article(id)
);

CREATE TABLE IF NOT EXISTS Invoice (
    id int AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    transaction_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    amount DECIMAL(10,2) NOT NULL,
    billing_address VARCHAR(255) NOT NULL,
    billing_city VARCHAR(255) NOT NULL,
    billing_postal_code VARCHAR(255) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES User(id)
);

CREATE TABLE IF NOT EXISTS Stock (
    id int AUTO_INCREMENT PRIMARY KEY,
    article_id INT NOT NULL,
    quantity INT NOT NULL,
    FOREIGN KEY (article_id) REFERENCES Article(id)
);

insert into User (username, password, email, solde, role) values ('admin', '$2y$10$dKzU.t.tZdBAGXdoQM.0zeW5fuQ1gAAuPRJl3Nf1iQN5XXW5IYr.y', 'admin', 1000, 'admin');
