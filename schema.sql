DROP TABLE login CASCADE;
DROP TABLE image CASCADE;
DROP TABLE login_attempt CASCADE;
DROP TABLE clouds CASCADE;

-- --------------------------------------------------------------------------------------------------------------------------
CREATE TABLE login(
	id SERIAL PRIMARY KEY,
	username VARCHAR(20),
	password VARCHAR(100),
	email VARCHAR(100),
	password_hint VARCHAR(50)
);

INSERT INTO login (id, username, password, email, password_hint) VALUES (1, 'dilraj1', MD5('test1'), 'blitzraj1@yahoo.com', '1');
INSERT INTO login (id, username, password, email, password_hint) VALUES (2, 'dilraj2', MD5('test2'), 'blitzraj1@yahoo.com', '2');
INSERT INTO login (id, username, password, email, password_hint) VALUES (3, '1', MD5(1), 'blitzraj1@yahoo.com', '3');


-- --------------------------------------------------------------------------------------------------------------------------
CREATE TABLE image (
	pic SERIAL PRIMARY KEY,
	username VARCHAR(20),
	picture_link VARCHAR(100) 
);

INSERT INTO image (pic, username, picture_link) VALUES (1, 'dilraj1', '');

-- -------------------------------------------------------------------------------------------------------------------------
CREATE TABLE login_attempt (
	log SERIAL PRIMARY KEY,
	username VARCHAR(20),
	status VARCHAR(5),
	login_amount VARCHAR(5),
	time VARCHAR(100)
);

INSERT INTO login_attempt (log, username, status, login_amount, time) VALUES (1, 'dilraj1', 'good', '1', '');

-- ----------------------------------------------------------------------------------------------------------------------------

CREATE TABLE clouds (
	log SERIAL PRIMARY KEY,
        time VARCHAR(40),
	username VARCHAR(40),
	html TEXT,
	likes INT
);