CREATE TABLE IF NOT EXISTS esc_user (
  id VARCHAR(36) PRIMARY KEY, /* UUID */
  email VARCHAR(50) NOT NULL,
  firstName VARCHAR(20) NOT NULL,
  lastName VARCHAR(20) NOT NULL,
  dob DATE NOT NULL,
  gender ENUM('M', 'F', 'T') NOT NULL
);

CREATE TABLE IF NOT EXISTS esc_user_pw (
  user_id VARCHAR(36),
  created TIMESTAMP DEFAULT NOW(),
  value VARCHAR(128) NOT NULL,

  PRIMARY KEY (user_id, value),
  FOREIGN KEY (user_id) REFERENCES esc_user(id)
);

CREATE TABLE IF NOT EXISTS esc_picture (
  id VARCHAR(36),
  user_id VARCHAR(36),
  created TIMESTAMP DEFAULT NOW(),
  thumbnail VARCHAR(128) NOT NULL,
  full VARCHAR(128) NOT NULL,

  PRIMARY KEY (id),
  FOREIGN KEY (user_id) REFERENCES esc_user(id)
);

CREATE TABLE IF NOT EXISTS esc_profil_picture (
  picture_id VARCHAR(36),
  user_id VARCHAR(36),

  PRIMARY KEY (user_id),
  FOREIGN KEY (user_id) REFERENCES esc_user(id),
  FOREIGN KEY (picture_id) REFERENCES esc_picture(id)
);

CREATE TABLE IF NOT EXISTS esc_user_verification (
  user_id VARCHAR(36),
  created TIMESTAMP DEFAULT NOW(),
  picture_id VARCHAR(36),

  PRIMARY KEY (user_id),
  FOREIGN KEY (picture_id) REFERENCES esc_picture(id)
);

CREATE TABLE IF NOT EXISTS esc_request (
  id VARCHAR(36) PRIMARY KEY,
  user_id VARCHAR(36),
  created TIMESTAMP DEFAULT NOW(),
  targetTime TIMESTAMP NOT NULL,
  ageFrom INTEGER CHECK(ageFrom >= 18),
  ageTo INTEGER,
  level ENUM ('A', 'P', 'V'), /* Alle, Profilbild, Verifiziert */
  maxPrice DECIMAL(7,2),
  expires TIMESTAMP NOT NULL,
  description VARCHAR(512),

  FOREIGN KEY (user_id) REFERENCES esc_user(id)
);

CREATE TABLE IF NOT EXISTS esc_request_keyword (
  req_id VARCHAR(36),
  expression VARCHAR(20) NOT NULL,

  PRIMARY KEY (req_id, expression),
  FOREIGN KEY (req_id) REFERENCES esc_request(id)
);

CREATE TABLE IF NOT EXISTS esc_offer (
  id VARCHAR(36) PRIMARY KEY,
  user_id VARCHAR(36),
  req_id VARCHAR(36),
  created TIMESTAMP DEFAULT NOW(),
  accepted BOOLEAN DEFAULT FALSE,
  rejected BOOLEAN DEFAULT FALSE,

  FOREIGN KEY (user_id) REFERENCES esc_user(id),
  FOREIGN KEY (req_id) REFERENCES esc_request(id)
);

CREATE TABLE IF NOT EXISTS esc_chat (
  id VARCHAR(36) PRIMARY KEY,
  user1_id VARCHAR(36),
  user2_id VARCHAR(36) CHECK(user1_id != user2_id),
  created TIMESTAMP DEFAULT NOW(),
  deleted TIMESTAMP,

  FOREIGN KEY (user1_id) REFERENCES esc_user(id),
  FOREIGN KEY (user2_id) REFERENCES esc_user(id)
);

CREATE TABLE IF NOT EXISTS esc_chat_msg (
  id VARCHAR(36) PRIMARY KEY,
  chat_id VARCHAR(36),
  sender_id VARCHAR(36),
  content VARCHAR(512),
  created TIMESTAMP DEFAULT NOW(),

  FOREIGN KEY (chat_id) REFERENCES esc_chat(id),
  FOREIGN KEY (sender_id) REFERENCES esc_user(id)
);

