CREATE TABLE IF NOT EXISTS clients (
  id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  email VARCHAR(255) not null UNIQUE,
  phone_number varchar(255) not null,
  password VARCHAR(255) not null,
  address TEXT not null
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS staffs (
  id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  email VARCHAR(255) not null UNIQUE,
  phone_number varchar(255) not null,
  role VARCHAR(255) not null,
  password VARCHAR(255) not null
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS packages (
  id int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name varchar(255) NOT NULL UNIQUE,
  event_type varchar(255) NOT NULL,
  price int(11) NOT NULL,
  description TEXT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS events (
  id int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  title varchar(255) NOT NULL UNIQUE,
  description TEXT NOT NULL,
  venue TEXT NOT NULL,
  cost int(11) NOT NULL,
  event_date DATE NOT NULL,
  package_id int(11) UNSIGNED NOT NULL,
  client_id int(11) UNSIGNED NOT NULL,
  staff_id int(11) UNSIGNED NOT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

  FOREIGN KEY (package_id) REFERENCES packages(id),
  FOREIGN KEY (client_id) REFERENCES clients(id),
  FOREIGN KEY (staff_id) REFERENCES staffs(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



CREATE TABLE IF NOT EXISTS guests (
  id int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name varchar(255) NOT NULL,
  email varchar(255) NOT NULL UNIQUE,
  event_id INT(11) UNSIGNED NOT NULL,
  
  FOREIGN KEY (event_id) REFERENCES events(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



CREATE TABLE IF NOT EXISTS invitations (
  id int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  body TEXT NOT NULL,
  client_id INT(11) UNSIGNED NOT NULL,
  guest_id INT(11) UNSIGNED NOT NULL,
  
  FOREIGN KEY (client_id) REFERENCES clients(id),
  FOREIGN KEY (guest_id) REFERENCES guests(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



CREATE TABLE IF NOT EXISTS workflow_notes (
  id int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  message TEXT NOT NULL,
  event_id INT(11) UNSIGNED NOT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  
  FOREIGN KEY (event_id) REFERENCES events(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;





-- INSERT INTO packages (name, price, event_type, description) VALUES ('test', 1234, 'wedding', "Big big things");