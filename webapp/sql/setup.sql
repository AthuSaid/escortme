DROP TABLE IF EXISTS esc_activitylog;
DROP TABLE IF EXISTS esc_bell_offer;
DROP TABLE IF EXISTS esc_bell_request;
DROP TABLE IF EXISTS esc_bell_msg;
DROP TABLE IF EXISTS esc_bell;
DROP TABLE IF EXISTS esc_chat_msg;
DROP TABLE IF EXISTS esc_chat;
DROP TABLE IF EXISTS esc_offer;
DROP TABLE IF EXISTS esc_request_keyword;
DROP TABLE IF EXISTS esc_request;
DROP TABLE IF EXISTS esc_service_keyword;
DROP TABLE IF EXISTS esc_service;
DROP TABLE IF EXISTS esc_user_credit;
DROP TABLE IF EXISTS esc_user_verification;
DROP TABLE IF EXISTS esc_profil_picture;
DROP TABLE IF EXISTS esc_picture;
DROP TABLE IF EXISTS esc_user_pw;
DROP TABLE IF EXISTS esc_user;
















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
  curriculum VARCHAR(512),
  minPrice DECIMAL(7,2),
  level ENUM('A', 'P', 'V'),
  gender ENUM('M', 'F', 'T'),

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
  maxPrice DECIMAL(7,2),
  expires TIMESTAMP NOT NULL,
  description VARCHAR(512),

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


























/* DANIEL */
INSERT INTO esc_user (id, email, firstName, lastName, dob, gender)
	VALUES ('b0cc2642-f904-11e6-b0df-d3f657d113e9', 'daniel.aminati@pro7.de', 'Daniel', 'Aminati', '1988-07-03', 'M');
INSERT INTO esc_user_pw(user_id, value)
    VALUES ('b0cc2642-f904-11e6-b0df-d3f657d113e9', 'prosieben');
INSERT INTO esc_picture (id, user_id) VALUES
    ('72471646-f907-11e6-b0df-d3f657d113e9', 'b0cc2642-f904-11e6-b0df-d3f657d113e9');
INSERT INTO esc_picture (id, user_id) VALUES
    ('e7e5188b-f907-11e6-b0df-d3f657d113e9', 'b0cc2642-f904-11e6-b0df-d3f657d113e9');
INSERT INTO esc_picture (id, user_id) VALUES
    ('f255365b-f907-11e6-b0df-d3f657d113e9', 'b0cc2642-f904-11e6-b0df-d3f657d113e9');
INSERT INTO esc_picture (id, user_id) VALUES
    ('f8db84e1-f907-11e6-b0df-d3f657d113e9', 'b0cc2642-f904-11e6-b0df-d3f657d113e9');
INSERT INTO esc_picture (id, user_id) VALUES
    ('ff2fe83d-f907-11e6-b0df-d3f657d113e9', 'b0cc2642-f904-11e6-b0df-d3f657d113e9');
INSERT INTO esc_profil_picture (picture_id, user_id)
    VALUES ('f8db84e1-f907-11e6-b0df-d3f657d113e9', 'b0cc2642-f904-11e6-b0df-d3f657d113e9');
INSERT INTO esc_user_verification(user_id, picture_id)
    VALUES ('b0cc2642-f904-11e6-b0df-d3f657d113e9', 'ff2fe83d-f907-11e6-b0df-d3f657d113e9');

INSERT INTO esc_user (id, email, firstName, lastName, dob, gender)
    VALUES ('11fa6218-f905-11e6-b0df-d3f657d113e9', 'lisa.lustig@gmx.at', 'Lisa', 'Lustig', '1991-09-21', 'F');
INSERT INTO esc_user_pw(user_id, value)
    VALUES ('11fa6218-f905-11e6-b0df-d3f657d113e9', 'pass1234');
INSERT INTO esc_picture (id, user_id) VALUES
    ('b6989fbf-f908-11e6-b0df-d3f657d113e9', '11fa6218-f905-11e6-b0df-d3f657d113e9');
INSERT INTO esc_picture (id, user_id) VALUES
    ('c0e0545d-f908-11e6-b0df-d3f657d113e9', '11fa6218-f905-11e6-b0df-d3f657d113e9');
INSERT INTO esc_picture (id, user_id) VALUES
    ('c8c74a85-f908-11e6-b0df-d3f657d113e9', '11fa6218-f905-11e6-b0df-d3f657d113e9');
INSERT INTO esc_profil_picture (picture_id, user_id)
    VALUES ('f8db84e1-f907-11e6-b0df-d3f657d113e9', '11fa6218-f905-11e6-b0df-d3f657d113e9');
INSERT INTO esc_user_verification(user_id, picture_id)
    VALUES ('11fa6218-f905-11e6-b0df-d3f657d113e9', 'ff2fe83d-f907-11e6-b0df-d3f657d113e9');
