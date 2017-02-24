CREATE TABLE IF NOT EXISTS esc_user (
  id CHAR(36) PRIMARY KEY, /* UUID */
  email VARCHAR(50) NOT NULL,
  firstName VARCHAR(20) NOT NULL,
  lastName VARCHAR(20) NOT NULL,
  dob DATE NOT NULL,
  gender ENUM('M', 'F', 'T') NOT NULL,
  listening BOOLEAN DEFAULT FALSE
);

CREATE TABLE IF NOT EXISTS esc_user_pw (
  user_id CHAR(36),
  created TIMESTAMP DEFAULT NOW(),
  value VARCHAR(128) NOT NULL,

  PRIMARY KEY (user_id, value),
  FOREIGN KEY (user_id) REFERENCES esc_user(id)
);

CREATE TABLE IF NOT EXISTS esc_picture (
  id CHAR(36),
  user_id CHAR(36),
  created TIMESTAMP DEFAULT NOW(),

  PRIMARY KEY (id),
  FOREIGN KEY (user_id) REFERENCES esc_user(id)
);

CREATE TABLE IF NOT EXISTS esc_profil_picture (
  picture_id CHAR(36),
  user_id CHAR(36),

  PRIMARY KEY (user_id),
  FOREIGN KEY (user_id) REFERENCES esc_user(id),
  FOREIGN KEY (picture_id) REFERENCES esc_picture(id)
);

CREATE TABLE IF NOT EXISTS esc_user_verification (
  user_id CHAR(36),
  created TIMESTAMP DEFAULT NOW(),
  picture_id CHAR(36),

  PRIMARY KEY (user_id),
  FOREIGN KEY (picture_id) REFERENCES esc_picture(id)
);

CREATE TABLE IF NOT EXISTS esc_user_credit(
  user_id CHAR(36),
  created TIMESTAMP DEFAULT NOW(),
  owner VARCHAR(128),
  cardNumber CHAR(12),
  expireMonth INTEGER,
  expireYear YEAR,
  signatory CHAR(3),

  PRIMARY KEY (user_id, cardNumber),
  FOREIGN KEY (user_id) REFERENCES esc_user(id)
);

CREATE TABLE IF NOT EXISTS esc_service(
  id CHAR(36),
  user_id CHAR(36),
  created TIMESTAMP DEFAULT NOW(),
  curriculum VARCHAR(512),
  minPrice DECIMAL(7,2),
  level ENUM('A', 'P', 'V'),
  genderM BOOLEAN DEFAULT FALSE,
  genderF BOOLEAN DEFAULT FALSE,
  genderT BOOLEAN DEFAULT FALSE,

  PRIMARY KEY (id, user_id),
  FOREIGN KEY (user_id) REFERENCES esc_user(id)
);

CREATE TABLE IF NOT EXISTS esc_service_keyword(
  service_id CHAR(36),
  expression VARCHAR(20) NOT NULL,

  PRIMARY KEY (service_id, expression),
  FOREIGN KEY (service_id) REFERENCES esc_service(id)
);

CREATE TABLE IF NOT EXISTS esc_request (
  id CHAR(36) PRIMARY KEY,
  user_id CHAR(36),
  created TIMESTAMP DEFAULT NOW(),
  targetTime TIMESTAMP NOT NULL,
  ageFrom INTEGER CHECK(ageFrom >= 18),
  ageTo INTEGER,
  level ENUM ('A', 'P', 'V'), /* Alle, Profilbild, Verifiziert */
  genderM BOOLEAN DEFAULT FALSE,
  genderF BOOLEAN DEFAULT FALSE,
  genderT BOOLEAN DEFAULT FALSE,
  maxPrice DECIMAL(7,2),
  expires TIMESTAMP NOT NULL,
  description VARCHAR(512),
  aborted BOOLEAN DEFAULT FALSE,

  FOREIGN KEY (user_id) REFERENCES esc_user(id)
);

CREATE TABLE IF NOT EXISTS esc_request_keyword (
  req_id CHAR(36),
  expression VARCHAR(20) NOT NULL,

  PRIMARY KEY (req_id, expression),
  FOREIGN KEY (req_id) REFERENCES esc_request(id)
);

CREATE TABLE IF NOT EXISTS esc_offer (
  id CHAR(36) PRIMARY KEY,
  user_id CHAR(36),
  req_id CHAR(36),
  created TIMESTAMP DEFAULT NOW(),
  accepted BOOLEAN DEFAULT FALSE,
  rejected BOOLEAN DEFAULT FALSE,

  FOREIGN KEY (user_id) REFERENCES esc_user(id),
  FOREIGN KEY (req_id) REFERENCES esc_request(id)
);

CREATE TABLE IF NOT EXISTS esc_chat (
  id CHAR(36) PRIMARY KEY,
  user1_id CHAR(36),
  user2_id CHAR(36) CHECK(user1_id != user2_id),
  created TIMESTAMP DEFAULT NOW(),
  deleted TIMESTAMP,

  FOREIGN KEY (user1_id) REFERENCES esc_user(id),
  FOREIGN KEY (user2_id) REFERENCES esc_user(id)
);

CREATE TABLE IF NOT EXISTS esc_chat_msg (
  id CHAR(36) PRIMARY KEY,
  chat_id CHAR(36),
  sender_id CHAR(36),
  content VARCHAR(512),
  created TIMESTAMP DEFAULT NOW(),

  FOREIGN KEY (chat_id) REFERENCES esc_chat(id),
  FOREIGN KEY (sender_id) REFERENCES esc_user(id)
);

CREATE TABLE IF NOT EXISTS esc_bell (
  id CHAR(36) PRIMARY KEY,
  user_id CHAR(36),
  created TIMESTAMP DEFAULT NOW(),
  seen TIMESTAMP,

  FOREIGN KEY (user_id) REFERENCES esc_user(id)
);

CREATE TABLE IF NOT EXISTS esc_bell_msg(
  bell_id CHAR(36) PRIMARY KEY,
  msg_id CHAR(36),

  FOREIGN KEY (bell_id) REFERENCES esc_bell(id),
  FOREIGN KEY (msg_id) REFERENCES esc_chat_msg(id)
);

CREATE TABLE IF NOT EXISTS esc_bell_request(
  bell_id CHAR(36) PRIMARY KEY,
  req_id CHAR(36),

  FOREIGN KEY (bell_id) REFERENCES esc_bell(id),
  FOREIGN KEY (req_id) REFERENCES esc_request(id)
);

CREATE TABLE IF NOT EXISTS esc_bell_offer(
  bell_id CHAR(36) PRIMARY KEY,
  offer_id CHAR(36),

  FOREIGN KEY (bell_id) REFERENCES esc_bell(id),
  FOREIGN KEY (offer_id) REFERENCES esc_offer(id)
);


/* JUSTIFY THAT */
CREATE TABLE IF NOT EXISTS esc_activitylog(
  id CHAR(36) PRIMARY KEY,
  user_id CHAR(36),
  created TIMESTAMP DEFAULT NOW(),
  target_id CHAR(36) NOT NULL
);