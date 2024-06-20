CREATE TABLE users (
  id_user INT PRIMARY KEY AUTO_INCREMENT,
  user_firstname VARCHAR(50) NOT NULL,
  user_lastname VARCHAR(25) NOT NULL,
  user_email VARCHAR(50) NOT NULL,
  user_profile_path VARCHAR(50) NOT NULL DEFAULT 'default_profile.png',
  user_password VARCHAR(50) NOT NULL,
  created_at_dt DATETIME NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE categories (
  id_category INT PRIMARY KEY AUTO_INCREMENT,
  category_name VARCHAR(20),
  category_type VARCHAR(10),
  created_at_ts TIMESTAMP,
  id_user INT,
  
  CONSTRAINT categories_fk_01 FOREIGN KEY (id_user) REFERENCES users(id_user)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE expenses (
  id_expense INT PRIMARY KEY AUTO_INCREMENT,
  expense_description VARCHAR(255),
  expense_value DECIMAL(10,2) NOT NULL,
  made_in_dt DATE,
  created_at_ts TIMESTAMP,
  expense_category INT NOT NULL,
  id_user INT NOT NULL,
  
  CONSTRAINT expenses_fk_01 FOREIGN KEY (expense_category) REFERENCES categories(id_category),
  CONSTRAINT expenses_fk_02 FOREIGN KEY (id_user) REFERENCES users(id_user)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE revenues (
  id_revenue INT PRIMARY KEY AUTO_INCREMENT,
  revenue_description VARCHAR(255),
  revenue_value DECIMAL(10,2),
  made_in_dt DATE,
  created_at_ts TIMESTAMP,
  revenue_category INT,
  id_user INT,
  
  CONSTRAINT revenues_fk_01 FOREIGN KEY (revenue_category) REFERENCES categories(id_category),
  CONSTRAINT revenues_fk_02 FOREIGN KEY (id_user) REFERENCES users(id_user)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
