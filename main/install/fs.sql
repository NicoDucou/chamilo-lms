ALTER TABLE gradebook_category ADD COLUMN generate_certificates TINYINT NOT NULL DEFAULT 0;
ALTER TABLE c_group_info ADD COLUMN status tinyint DEFAULT 1;
CREATE TABLE IF NOT EXISTS c_attendance_calendar_rel_group (id int NOT NULL auto_increment PRIMARY KEY, c_id INT NOT NULL, group_id INT NOT NULL, calendar_id INT NOT NULL);
