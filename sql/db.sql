--
-- Table structure for roles table
--
CREATE TABLE IF NOT EXISTS roles (
  id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL UNIQUE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
--
-- Seeding data for roles table
--
INSERT INTO roles (name) VALUES
('admin'),
('accounts'),
('staff'),
('user');


--
-- Table structure for users table
--
CREATE TABLE IF NOT EXISTS users (
  id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  role_id INT(11) UNSIGNED NOT NULL DEFAULT 4,
  FOREIGN KEY (role_id) REFERENCES roles(id),
  INDEX idx_username (username)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
--
-- Seeding data for user table 
--
INSERT INTO users (username, email, password, role_id) VALUES
('olumide', 'olu@example.com', 'secret', 1),
('olamide', 'ola@example.com', 'secret', 2),
('ademide', 'ade@example.com', 'secret', 4);


--
-- Table structure for events table
--
CREATE TABLE IF NOT EXISTS events (
  id int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  title varchar(255) NOT NULL UNIQUE,
  description TEXT NOT NULL,
  cost int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
--
-- Dumping data for events table
--
INSERT INTO events (title, description, cost) VALUES
('Wedding', 'Wedding Celebration', 25000);