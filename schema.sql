CREATE TABLE `building` (
  `building_id` varchar(64) PRIMARY KEY NOT NULL,
  `building_name` varchar(64) NOT NULL,
  `building_description` text DEFAULT null
);

CREATE TABLE `class_groups` (
  `class_group_uid` varchar(64) PRIMARY KEY NOT NULL,
  `section_id` varchar(64) NOT NULL,
  `strand_id` varchar(25) NOT NULL,
  `semester_id` varchar(10) NOT NULL,
  `grade_level_id` varchar(4) NOT NULL
);

CREATE TABLE `class_group_learning_materials` (
  `class_group_uid` varchar(64) NOT NULL,
  `full_file_path` varchar(255) NOT NULL,
  `posted_on` datetime DEFAULT CURRENT_TIMESTAMP,
  `attachement_id` int(3) NOT NULL,
  `notes` text DEFAULT null,
  PRIMARY KEY (`full_file_path`, `class_group_uid`)
);

CREATE TABLE `class_group_students` (
  `class_group_iud` varchar(64) NOT NULL,
  `LRN` varchar(12) NOT NULL,
  `UUID` varchar(64) NOT NULL,
  PRIMARY KEY (`LRN`, `class_group_iud`)
);

CREATE TABLE `class_group_subj_assignments` (
  `class_group_uid` varchar(64) NOT NULL,
  `full_file_path` varchar(255) NOT NULL,
  `subject_lesson_id` varchar(64) NOT NULL,
  `posted_on` datetime DEFAULT CURRENT_TIMESTAMP,
  `deadline` datetime DEFAULT null,
  `notes` text DEFAULT null,
  PRIMARY KEY (`full_file_path`, `subject_lesson_id`)
);

CREATE TABLE `class_group_subj_scheds` (
  `class_group_uid` varchar(64) NOT NULL,
  `subject_id` varchar(25) NOT NULL,
  `time_start` datetime NOT NULL,
  `teacher_id` varchar(64) NOT NULL,
  `time_end` datetime NOT NULL,
  PRIMARY KEY (`class_group_uid`, `subject_id`)
);

CREATE TABLE `file_attachement_types` (
  `attachement_id` int(3) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `attachement_name` varchar(64) NOT NULL,
  `attachement_description` text DEFAULT null
);

CREATE TABLE `floorlvl` (
  `floorlvl_id` varchar(64) PRIMARY KEY NOT NULL,
  `building_id` varchar(25) NOT NULL,
  `floorlvl_name` varchar(64) NOT NULL,
  `floorlvl_description` text DEFAULT null
);

CREATE TABLE `gender_types` (
  `gender_id` varchar(64) PRIMARY KEY NOT NULL,
  `gender_name` varchar(64) NOT NULL,
  `gender_description` text NOT NULL
);

CREATE TABLE `grade_level` (
  `grade_level_id` varchar(4) PRIMARY KEY NOT NULL,
  `grade_level_name` varchar(10) NOT NULL,
  `grade_level_description` text DEFAULT null
);

CREATE TABLE `log_status` (
  `log_status_id` int(2) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `log_status_name` varchar(64) NOT NULL,
  `log_status_description` text DEFAULT null
);

CREATE TABLE `log_type` (
  `log_type_id` int(2) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `log_type_name` varchar(64) NOT NULL,
  `log_type_description` text DEFAULT null
);

CREATE TABLE `registration_status` (
  `registration_status_id` int(2) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `registration_status_name` varchar(64) NOT NULL,
  `registration_status_description` text DEFAULT null
);

CREATE TABLE `all_registered_users` (
  `entity_id` varchar(64) PRIMARY KEY NOT NULL,
  `UUID` varchar(64) UNIQUE NOT NULL,
  `registed_on` datetime DEFAULT CURRENT_TIMESTAMP,
  `register_role` int(3) NOT NULL,
  `registration_status_id` int(3) NOT NULL
);

CREATE TABLE `registered_students` (
  `LRN` varchar(12) PRIMARY KEY NOT NULL,
  `firstname` varchar(64) NOT NULL,
  `lastname` varchar(64) NOT NULL,
  `age` int(2) NOT NULL,
  `hometown` varchar(100) NOT NULL,
  `current_location` varchar(100) NOT NULL
);

CREATE TABLE `registered_administrators` (
  `professional_id` varchar(64) PRIMARY KEY NOT NULL,
  `firstname` varchar(64) NOT NULL,
  `lastname` varchar(64) NOT NULL,
  `age` int(2) NOT NULL,
  `hometown` varchar(100) NOT NULL,
  `current_location` varchar(100) NOT NULL
);

CREATE TABLE `registered_parents` (
  `professional_id` varchar(64) PRIMARY KEY NOT NULL,
  `firstname` varchar(64) NOT NULL,
  `lastname` varchar(64) NOT NULL,
  `age` int(2) NOT NULL,
  `hometown` varchar(100) NOT NULL,
  `current_location` varchar(100) NOT NULL
);

CREATE TABLE `registered_teachers` (
  `professional_id` varchar(64) PRIMARY KEY NOT NULL,
  `firstname` varchar(64) NOT NULL,
  `lastname` varchar(64) NOT NULL,
  `age` int(2) NOT NULL,
  `hometown` varchar(100) NOT NULL,
  `current_location` varchar(100) NOT NULL
);

CREATE TABLE `room` (
  `room_id` varchar(64) PRIMARY KEY NOT NULL,
  `floorlvl_id` varchar(25) NOT NULL,
  `room_name` varchar(64) NOT NULL,
  `room_description` text DEFAULT null
);

CREATE TABLE `school_year` (
  `school_year_id` varchar(4) PRIMARY KEY NOT NULL,
  `school_year_name` varchar(25) NOT NULL
);

CREATE TABLE `section` (
  `section_id` varchar(64) PRIMARY KEY NOT NULL,
  `room_id` varchar(25) NOT NULL,
  `section_name` varchar(64) NOT NULL,
  `section_description` text DEFAULT null
);

CREATE TABLE `semester_level` (
  `semester_id` varchar(10) PRIMARY KEY NOT NULL,
  `semester_name` varchar(64) NOT NULL,
  `semester_description` text DEFAULT null
);

CREATE TABLE `server_files` (
  `full_file_path` varchar(255) PRIMARY KEY NOT NULL,
  `UUID` varchar(64) NOT NULL,
  `file_type_name` varchar(64) NOT NULL,
  `file_extension_name` varchar(64) NOT NULL,
  `file_parent_folder_path` varchar(255) NOT NULL,
  `upload_time` datetime DEFAULT CURRENT_TIMESTAMP,
  `file_attachement_type` int(3) NOT NULL
);

CREATE TABLE `strand` (
  `strand_id` varchar(25) PRIMARY KEY NOT NULL,
  `track_id` varchar(25) NOT NULL,
  `track_name` varchar(100) NOT NULL,
  `track_description` text DEFAULT null
);

CREATE TABLE `subjects` (
  `subject_id` varchar(25) PRIMARY KEY NOT NULL,
  `strand_id` varchar(25) NOT NULL,
  `subject_name` varchar(100) NOT NULL,
  `subject_type_id` int(2) NOT NULL,
  `subject_desciption` text DEFAULT null
);

CREATE TABLE `subject_lessons` (
  `subject_lesson_id` varchar(64) PRIMARY KEY NOT NULL,
  `subject_id` varchar(25) NOT NULL,
  `subject_lesson_name` varchar(64) NOT NULL,
  `subject_description` text DEFAULT null
);

CREATE TABLE `subject_type` (
  `subject_type_id` int(2) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `subject_type_name` varchar(64) NOT NULL,
  `subject_type_description` text DEFAULT null
);

CREATE TABLE `track` (
  `track_id` varchar(25) PRIMARY KEY NOT NULL,
  `track_name` varchar(100) NOT NULL,
  `track_description` text DEFAULT null
);

CREATE TABLE `user_accounts` (
  `UUID` varchar(64) PRIMARY KEY NOT NULL,
  `user_firstname` varchar(64) NOT NULL,
  `user_lastname` varchar(64) NOT NULL,
  `user_email` varchar(64) NOT NULL,
  `user_age` int(2) NOT NULL,
  `user_gender_type` varchar(64) NOT NULL,
  `user_password` varchar (255) NOT NULL,
  `account_created` datetime DEFAULT CURRENT_TIMESTAMP,
  `user_role_id` int(3) NOT NULL
);

CREATE TABLE `user_logs` (
  `UUID` varchar(64) NOT NULL,
  `log_type` int(2) NOT NULL,
  `log_status` int(2) NOT NULL,
  `log_time` datetime DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE `user_roles` (
  `role_id` int(3) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `role_name` varchar(64) NOT NULL,
  `role_description` text DEFAULT null
);

ALTER TABLE `all_registered_users` ADD FOREIGN KEY (`UUID`) REFERENCES `user_accounts` (`UUID`);

ALTER TABLE `all_registered_users` ADD FOREIGN KEY (`register_role`) REFERENCES `user_roles` (`role_id`);

ALTER TABLE `all_registered_users` ADD FOREIGN KEY (`registration_status_id`) REFERENCES `registration_status` (`registration_status_id`);

ALTER TABLE `registered_students` ADD FOREIGN KEY (`LRN`) REFERENCES `all_registered_users` (`entity_id`);

ALTER TABLE `registered_parents` ADD FOREIGN KEY (`professional_id`) REFERENCES `all_registered_users` (`entity_id`);

ALTER TABLE `registered_administrators` ADD FOREIGN KEY (`professional_id`) REFERENCES `all_registered_users` (`entity_id`);

ALTER TABLE `registered_teachers` ADD FOREIGN KEY (`professional_id`) REFERENCES `all_registered_users` (`entity_id`);

ALTER TABLE `class_groups` ADD CONSTRAINT `class_groups_ibfk_1` FOREIGN KEY (`section_id`) REFERENCES `section` (`section_id`);

ALTER TABLE `class_groups` ADD CONSTRAINT `class_groups_ibfk_2` FOREIGN KEY (`strand_id`) REFERENCES `strand` (`strand_id`);

ALTER TABLE `class_groups` ADD CONSTRAINT `class_groups_ibfk_3` FOREIGN KEY (`semester_id`) REFERENCES `semester_level` (`semester_id`);

ALTER TABLE `class_groups` ADD CONSTRAINT `class_groups_ibfk_4` FOREIGN KEY (`grade_level_id`) REFERENCES `grade_level` (`grade_level_id`);

ALTER TABLE `class_group_learning_materials` ADD CONSTRAINT `class_group_learning_materials_ibfk_1` FOREIGN KEY (`class_group_uid`) REFERENCES `class_groups` (`class_group_uid`);

ALTER TABLE `class_group_learning_materials` ADD CONSTRAINT `class_group_learning_materials_ibfk_2` FOREIGN KEY (`full_file_path`) REFERENCES `server_files` (`full_file_path`);

ALTER TABLE `class_group_learning_materials` ADD CONSTRAINT `class_group_learning_materials_ibfk_3` FOREIGN KEY (`attachement_id`) REFERENCES `file_attachement_types` (`attachement_id`);

ALTER TABLE `class_group_students` ADD CONSTRAINT `class_group_students_ibfk_1` FOREIGN KEY (`class_group_iud`) REFERENCES `class_groups` (`class_group_uid`);

ALTER TABLE `class_group_students` ADD CONSTRAINT `class_group_students_ibfk_2` FOREIGN KEY (`LRN`) REFERENCES `registered_students` (`LRN`);

ALTER TABLE `class_group_students` ADD CONSTRAINT `class_group_students_ibfk_3` FOREIGN KEY (`UUID`) REFERENCES `user_accounts` (`UUID`);

ALTER TABLE `class_group_subj_assignments` ADD CONSTRAINT `class_group_subj_assignments_ibfk_1` FOREIGN KEY (`class_group_uid`) REFERENCES `class_groups` (`class_group_uid`);

ALTER TABLE `class_group_subj_assignments` ADD CONSTRAINT `class_group_subj_assignments_ibfk_2` FOREIGN KEY (`subject_lesson_id`) REFERENCES `subject_lessons` (`subject_lesson_id`);

ALTER TABLE `class_group_subj_assignments` ADD CONSTRAINT `class_group_subj_assignments_ibfk_3` FOREIGN KEY (`full_file_path`) REFERENCES `server_files` (`full_file_path`);

ALTER TABLE `class_group_subj_scheds` ADD CONSTRAINT `class_group_subj_scheds_ibfk_1` FOREIGN KEY (`class_group_uid`) REFERENCES `class_groups` (`class_group_uid`);

ALTER TABLE `class_group_subj_scheds` ADD CONSTRAINT `class_group_subj_scheds_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`subject_id`);

ALTER TABLE `class_group_subj_scheds` ADD CONSTRAINT `class_group_subj_scheds_ibfk_3` FOREIGN KEY (`teacher_id`) REFERENCES `registered_teachers` (`professional_id`);

ALTER TABLE `floorlvl` ADD CONSTRAINT `floorlvl_ibfk_1` FOREIGN KEY (`building_id`) REFERENCES `building` (`building_id`);

ALTER TABLE `room` ADD CONSTRAINT `room_ibfk_1` FOREIGN KEY (`floorlvl_id`) REFERENCES `floorlvl` (`floorlvl_id`);

ALTER TABLE `section` ADD CONSTRAINT `section_ibfk_1` FOREIGN KEY (`room_id`) REFERENCES `room` (`room_id`);

ALTER TABLE `server_files` ADD CONSTRAINT `server_files_ibfk_1` FOREIGN KEY (`UUID`) REFERENCES `user_accounts` (`UUID`);

ALTER TABLE `server_files` ADD CONSTRAINT `server_files_ibfk_2` FOREIGN KEY (`file_attachement_type`) REFERENCES `file_attachement_types` (`attachement_id`);

ALTER TABLE `strand` ADD CONSTRAINT `strand_ibfk_1` FOREIGN KEY (`track_id`) REFERENCES `track` (`track_id`);

ALTER TABLE `subjects` ADD CONSTRAINT `subjects_ibfk_1` FOREIGN KEY (`strand_id`) REFERENCES `strand` (`strand_id`);

ALTER TABLE `subjects` ADD CONSTRAINT `subjects_ibfk_2` FOREIGN KEY (`subject_type_id`) REFERENCES `subject_type` (`subject_type_id`);

ALTER TABLE `subject_lessons` ADD CONSTRAINT `subject_lessons_ibfk_1` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`subject_id`);

ALTER TABLE `user_accounts` ADD CONSTRAINT `user_accounts_ibfk_1` FOREIGN KEY (`user_gender_type`) REFERENCES `gender_types` (`gender_id`);

ALTER TABLE `user_accounts` ADD CONSTRAINT `user_accounts_ibfk_2` FOREIGN KEY (`user_role_id`) REFERENCES `user_roles` (`role_id`);

ALTER TABLE `user_logs` ADD CONSTRAINT `user_logs_ibfk_1` FOREIGN KEY (`UUID`) REFERENCES `user_accounts` (`UUID`);

ALTER TABLE `user_logs` ADD CONSTRAINT `user_logs_ibfk_2` FOREIGN KEY (`log_type`) REFERENCES `log_type` (`log_type_id`);

ALTER TABLE `user_logs` ADD CONSTRAINT `user_logs_ibfk_3` FOREIGN KEY (`log_status`) REFERENCES `log_status` (`log_status_id`);


  -- for genders
  INSERT INTO gender_types (gender_id, gender_name, gender_description) VALUES ('M', 'Male', 'Refers to the male gender'), ('F', 'Female', 'Refers to the female gender'), ('N/A', 'N/A', 'Rather not say');

  -- for user roles
  INSERT INTO user_roles (role_name, role_description) VALUES 
  ("Regular User", "Users with limited access to the application's features."),
  ("Premium User", "Users with full access to the application's features, which means they are already enrolled or registered as part of the school"),
  ("Administrator", "The main administrator or manager of the system."),
  ("Student", "Student of the school, is identified as fully registered and has access to numerous features of the system."),
  ("Teacher", "The ones who teach studens and has access to student informations and manages classroom-student orientation.");


  -- for log types and log status
  INSERT INTO log_status (log_status_name, log_status_description) VALUES 
  ("Unsuccessful", "Something might went wrong or is invalid or inapproriate access."),
  ("Successful", "Successful access or is have granted access."),
  ("Suspicious", "Something unusual happened or malicious access of data or action.");

  INSERT INTO log_type () VALUES
  ("Login", "Accessing of account."),
  ("Logout", "Loggin out of account"),
  ("Signup", "Creating new account."),
  ("Unusual Login", "Already logged in?"),
  ("Password Error", "Wrong password? Is this you?");

  INSERT INTO registration_status (registration_status_name, registration_status_description) VALUES
  ("Pending", "Not yet approved!"),
  ("Approved", "Registration has been approved!"),
  ("Rejected", "Registration has been rejected!"),
  ("Incomplete", "User did not complete registration!");

