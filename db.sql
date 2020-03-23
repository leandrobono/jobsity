create table users (
	id int(6) AUTO_INCREMENT PRIMARY KEY,
    username varchar(30) NOT NULL,
    password varchar(150) NOT NULL,
    currency varchar(10) NOT NULL
);

create table transactions (
	id int(6) AUTO_INCREMENT PRIMARY KEY,
    user int(6) NOT NULL,
    date datetime DEFAULT CURRENT_TIMESTAMP,
    amount numeric(15,2) NOT NULL,
    from_cur varchar(10),
    to_cur varchar(10),
    FOREIGN KEY(user) REFERENCES users(id)
);