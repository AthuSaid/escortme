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
