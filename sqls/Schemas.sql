CREATE TABLE Users (
    username VARCHAR(255) PRIMARY KEY,
    password VARCHAR(255) NOT NULL,
    fullname VARCHAR(255) NOT NULL
);

CREATE TABLE Projects (
    Project_id SERIAL,
    Title VARCHAR(50) NOT NULL,
    Creator VARCHAR(255) NOT NULL,
    Img_src VARCHAR(2000) NOT NULL,
    Description TEXT NOT NULL,
    Start_date DATE NOT NULL,
    End_date DATE NOT NULL,
    Goal INTEGER NOT NULL,
    Raised INTEGER,
    PRIMARY KEY (Project_id)
);
