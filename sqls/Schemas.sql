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
    Goal INTEGER NOT NULL CONSTRAINT positive_goal CHECK(Goal > 0),
    Raised INTEGER DEFAULT 0 CONSTRAINT raised_smaller_than_goal CHECK(Raised < Goal),
    PRIMARY KEY (Project_id),
    CONSTRAINT start_date_before_end_date CHECK(Start_date <= End_date)
);
