CREATE TABLE Users (
  email VARCHAR(255) PRIMARY KEY,
  first_name VARCHAR(50) NOT NULL,
  last_name VARCHAR(50) NOT NULL,
  password VARCHAR(255) NOT NULL,
  website VARCHAR(255),
  biography VARCHAR(300),
  role VARCHAR(5) CHECK (role = 'user' OR role = 'admin')
);

INSERT INTO Users (email, first_name, last_name, password, role)
VALUES ('admin@admin.com', 'Admin', 'Admin', '$2y$10$/MV3fWHlSCzfqZAHD6ky7eCINm072KknluyL0.cR6R/bqOKwcWs0G', 'admin');

/* Projects and funding schemas below are for testing of profile only*/
Create Table Projects(
  project_id VARCHAR(50) PRIMARY KEY,
  title VARCHAR(50) NOT NULL,
  blurb VARCHAR(2000) NOT NULL,
  description TEXT NOT NULL,
  start_date DATE NOT NULL,
  end_date DATE NOT NULL,
  goal INTEGER NOT NULL,
  raised INTEGER,
  creator VARCHAR(255) NOT NULL REFERENCES Users(email) ON DELETE CASCADE ON UPDATE CASCADE,
  CHECK (end_date > start_date)
);

Create Table Funding(
  funding_id VARCHAR(50) PRIMARY KEY,
  funding_datetime TIMESTAMP NOT NULL,
  amount INTEGER NOT NULL,
  email VARCHAR(255) NOT NULL,
  project_id CHAR(50) NOT NULL,
  FOREIGN KEY Reward_id REFERENCES Reward(Reward_id),
  FOREIGN KEY Email REFERENCES User(Email)
);

/*
CREATE TABLE Projects (
    name VARCHAR(255) NOT NULL,
    contents TEXT,
    owner VARCHAR(255) REFERENCES Users(username) ON DELETE SET NULL,
    PRIMARY KEY(name, owner)
);
*/



