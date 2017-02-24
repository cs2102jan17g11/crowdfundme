/*User table*/
CREATE TABLE Users (
  email VARCHAR(255) PRIMARY KEY,
  first_name VARCHAR(50) NOT NULL,
  last_name VARCHAR(50) NOT NULL,
  password VARCHAR(255) NOT NULL,
  website VARCHAR(255),
  biography VARCHAR(300),
  role VARCHAR(5) CHECK (role = 'user' OR role = 'admin')
);

/* Project Table (Projects and funding schemas below are for testing of profile only)*/
CREATE TABLE Projects (
  project_id SERIAL PRIMARY KEY,
  title VARCHAR(50) NOT NULL,
  creator VARCHAR(255) NOT NULL REFERENCES Users(email) ON DELETE CASCADE ON UPDATE CASCADE,
  img_src VARCHAR(2000) NOT NULL,
  description TEXT NOT NULL,
  start_date DATE NOT NULL,
  end_date DATE NOT NULL,
  goal INTEGER NOT NULL CONSTRAINT positive_goal CHECK(goal > 0),
  raised INTEGER DEFAULT 0 CONSTRAINT raised_smaller_than_goal CHECK(raised < goal),
  CONSTRAINT start_date_before_end_date CHECK(start_date <= end_date)
);

/*
/*Reward Table*/
CREATE TABLE Rewards (
  reward_id SERIAL NOT NULL,
  title VARCHAR(50) NOT NULL,
  pledge INTEGER NOT NULL,
  description TEXT NOT NULL,
  quantity INTEGER NOT NULL,
  project_id VARCHAR(50) NOT NULL,
  PRIMARY KEY (reward_id),
  FOREIGN KEY project_id REFERENCES Projects(project_id)
);

/*Fundings Table*/
CREATE TABLE Fundings (
  funding_id VARCHAR(50) PRIMARY KEY,
  funding_datetime TIMESTAMP NOT NULL,
  amount INTEGER NOT NULL,
  email VARCHAR(255) NOT NULL,
  project_id CHAR(50) NOT NULL,
  FOREIGN KEY reward_id REFERENCES Rewards(reward_id),
  FOREIGN KEY email REFERENCES Users(email)
);
*/