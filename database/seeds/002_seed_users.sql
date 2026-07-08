-- Demo users. All three sign in with the password: password
-- (bcrypt hash below). Change immediately in any real deployment.
INSERT INTO users (role_id, username, email, password_hash) VALUES
 (1,'admin','admin@library.tz','$2y$10$btwCwpVrGk05k4H8UEv/qOKGP44rKw5SnSVqnl6oppyUWLXt.dy4.'),
 (2,'jbrown','j.brown@library.tz','$2y$10$btwCwpVrGk05k4H8UEv/qOKGP44rKw5SnSVqnl6oppyUWLXt.dy4.'),
 (3,'akimwaga','a.kimwaga@library.tz','$2y$10$btwCwpVrGk05k4H8UEv/qOKGP44rKw5SnSVqnl6oppyUWLXt.dy4.');
