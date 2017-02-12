CREATE TABLE Users (
    username VARCHAR(255) PRIMARY KEY,
    password VARCHAR(255) NOT NULL,
    fullname VARCHAR(255) NOT NULL
);

CREATE TABLE Projects (
    name VARCHAR(255) NOT NULL,
    contents TEXT,
    owner VARCHAR(255) REFERENCES Users(username) ON DELETE SET NULL,
    PRIMARY KEY(name, owner)
);
