-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 05, 2025 at 10:05 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sms_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `building`
--

CREATE TABLE `building` (
  `building_id` varchar(64) NOT NULL,
  `building_name` varchar(64) NOT NULL,
  `building_description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `class_groups`
--

CREATE TABLE `class_groups` (
  `class_group_uid` varchar(64) NOT NULL,
  `section_id` varchar(64) NOT NULL,
  `strand_id` varchar(25) NOT NULL,
  `semester_id` varchar(10) NOT NULL,
  `grade_level_id` varchar(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `class_group_learning_materials`
--

CREATE TABLE `class_group_learning_materials` (
  `class_group_uid` varchar(64) NOT NULL,
  `full_file_path` varchar(255) NOT NULL,
  `posted_on` datetime DEFAULT current_timestamp(),
  `attachement_id` int(3) NOT NULL,
  `notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `class_group_students`
--

CREATE TABLE `class_group_students` (
  `class_group_iud` varchar(64) NOT NULL,
  `LRN` varchar(12) NOT NULL,
  `UUID` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `class_group_subj_assignments`
--

CREATE TABLE `class_group_subj_assignments` (
  `class_group_uid` varchar(64) NOT NULL,
  `full_file_path` varchar(255) NOT NULL,
  `subject_lesson_id` varchar(64) NOT NULL,
  `posted_on` datetime DEFAULT current_timestamp(),
  `deadline` datetime DEFAULT NULL,
  `notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `class_group_subj_scheds`
--

CREATE TABLE `class_group_subj_scheds` (
  `class_group_uid` varchar(64) NOT NULL,
  `subject_id` varchar(25) NOT NULL,
  `time_start` datetime NOT NULL,
  `teacher_id` varchar(64) NOT NULL,
  `time_end` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `file_attachement_types`
--

CREATE TABLE `file_attachement_types` (
  `attachement_id` int(3) NOT NULL,
  `attachement_name` varchar(64) NOT NULL,
  `attachement_description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `floorlvl`
--

CREATE TABLE `floorlvl` (
  `floorlvl_id` varchar(64) NOT NULL,
  `building_id` varchar(25) NOT NULL,
  `floorlvl_name` varchar(64) NOT NULL,
  `floorlvl_description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gender_types`
--

CREATE TABLE `gender_types` (
  `gender_id` varchar(64) NOT NULL,
  `gender_name` varchar(64) NOT NULL,
  `gender_description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `grade_level`
--

CREATE TABLE `grade_level` (
  `grade_level_id` varchar(4) NOT NULL,
  `grade_level_name` varchar(10) NOT NULL,
  `grade_level_description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `log_status`
--

CREATE TABLE `log_status` (
  `log_status_id` int(2) NOT NULL,
  `log_status_name` varchar(64) NOT NULL,
  `log_status_description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `log_type`
--

CREATE TABLE `log_type` (
  `log_type_id` int(2) NOT NULL,
  `log_type_name` varchar(64) NOT NULL,
  `log_type_description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `registered_administrators`
--

CREATE TABLE `registered_administrators` (
  `professional_id` varchar(64) NOT NULL,
  `UUID` varchar(64) NOT NULL,
  `firstname` varchar(64) NOT NULL,
  `lastname` varchar(64) NOT NULL,
  `age` int(2) NOT NULL,
  `hometown` varchar(100) NOT NULL,
  `current_location` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `registered_parents`
--

CREATE TABLE `registered_parents` (
  `professional_id` varchar(64) NOT NULL,
  `UUID` varchar(64) NOT NULL,
  `firstname` varchar(64) NOT NULL,
  `lastname` varchar(64) NOT NULL,
  `age` int(2) NOT NULL,
  `hometown` varchar(100) NOT NULL,
  `current_location` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `registered_students`
--

CREATE TABLE `registered_students` (
  `LRN` varchar(12) NOT NULL,
  `UUID` varchar(64) NOT NULL,
  `firstname` varchar(64) NOT NULL,
  `lastname` varchar(64) NOT NULL,
  `age` int(2) NOT NULL,
  `hometown` varchar(100) NOT NULL,
  `current_location` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `registered_teachers`
--

CREATE TABLE `registered_teachers` (
  `professional_id` varchar(64) NOT NULL,
  `UUID` varchar(64) NOT NULL,
  `firstname` varchar(64) NOT NULL,
  `lastname` varchar(64) NOT NULL,
  `age` int(2) NOT NULL,
  `hometown` varchar(100) NOT NULL,
  `current_location` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `registration_record`
--

CREATE TABLE `registration_record` (
  `entity_id` varchar(64) NOT NULL,
  `UUID` varchar(64) NOT NULL,
  `registed_on` datetime DEFAULT current_timestamp(),
  `registration_status_id` int(2) NOT NULL,
  `register_role` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `registration_status`
--

CREATE TABLE `registration_status` (
  `registration_status_id` int(2) NOT NULL,
  `registration_status_name` varchar(64) NOT NULL,
  `registration_status_description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `room_id` varchar(64) NOT NULL,
  `floorlvl_id` varchar(25) NOT NULL,
  `room_name` varchar(64) NOT NULL,
  `room_description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `school_year`
--

CREATE TABLE `school_year` (
  `school_year_id` varchar(4) NOT NULL,
  `school_year_name` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `section`
--

CREATE TABLE `section` (
  `section_id` varchar(64) NOT NULL,
  `room_id` varchar(25) NOT NULL,
  `section_name` varchar(64) NOT NULL,
  `section_description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `semester_level`
--

CREATE TABLE `semester_level` (
  `semester_id` varchar(10) NOT NULL,
  `semester_name` varchar(64) NOT NULL,
  `semester_description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `server_files`
--

CREATE TABLE `server_files` (
  `full_file_path` varchar(255) NOT NULL,
  `UUID` varchar(64) NOT NULL,
  `file_type_name` varchar(64) NOT NULL,
  `file_extension_name` varchar(64) NOT NULL,
  `file_parent_folder_path` varchar(255) NOT NULL,
  `upload_time` datetime DEFAULT current_timestamp(),
  `file_attachement_type` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `strand`
--

CREATE TABLE `strand` (
  `strand_id` varchar(25) NOT NULL,
  `track_id` varchar(25) NOT NULL,
  `track_name` varchar(100) NOT NULL,
  `track_description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `subject_id` varchar(25) NOT NULL,
  `strand_id` varchar(25) NOT NULL,
  `subject_name` varchar(100) NOT NULL,
  `subject_type_id` int(2) NOT NULL,
  `subject_desciption` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subject_lessons`
--

CREATE TABLE `subject_lessons` (
  `subject_lesson_id` varchar(64) NOT NULL,
  `subject_id` varchar(25) NOT NULL,
  `subject_lesson_name` varchar(64) NOT NULL,
  `subject_description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subject_type`
--

CREATE TABLE `subject_type` (
  `subject_type_id` int(2) NOT NULL,
  `subject_type_name` varchar(64) NOT NULL,
  `subject_type_description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `track`
--

CREATE TABLE `track` (
  `track_id` varchar(25) NOT NULL,
  `track_name` varchar(100) NOT NULL,
  `track_description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_accounts`
--

CREATE TABLE `user_accounts` (
  `UUID` varchar(64) NOT NULL,
  `user_firstname` varchar(64) NOT NULL,
  `user_lastname` varchar(64) NOT NULL,
  `user_email` varchar(64) NOT NULL,
  `user_age` int(2) NOT NULL,
  `user_gender_type` varchar(64) NOT NULL,
  `account_created` datetime DEFAULT current_timestamp(),
  `user_role_id` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_logs`
--

CREATE TABLE `user_logs` (
  `UUID` varchar(64) NOT NULL,
  `log_type` int(2) NOT NULL,
  `log_status` int(2) NOT NULL,
  `log_time` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE `user_roles` (
  `role_id` int(3) NOT NULL,
  `role_name` varchar(64) NOT NULL,
  `role_description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `building`
--
ALTER TABLE `building`
  ADD PRIMARY KEY (`building_id`);

--
-- Indexes for table `class_groups`
--
ALTER TABLE `class_groups`
  ADD PRIMARY KEY (`class_group_uid`),
  ADD UNIQUE KEY `section_id` (`section_id`),
  ADD KEY `strand_id` (`strand_id`),
  ADD KEY `semester_id` (`semester_id`),
  ADD KEY `grade_level_id` (`grade_level_id`);

--
-- Indexes for table `class_group_learning_materials`
--
ALTER TABLE `class_group_learning_materials`
  ADD PRIMARY KEY (`full_file_path`,`class_group_uid`),
  ADD KEY `class_group_uid` (`class_group_uid`),
  ADD KEY `attachement_id` (`attachement_id`);

--
-- Indexes for table `class_group_students`
--
ALTER TABLE `class_group_students`
  ADD PRIMARY KEY (`LRN`,`class_group_iud`),
  ADD UNIQUE KEY `UUID` (`UUID`),
  ADD KEY `class_group_iud` (`class_group_iud`);

--
-- Indexes for table `class_group_subj_assignments`
--
ALTER TABLE `class_group_subj_assignments`
  ADD PRIMARY KEY (`full_file_path`,`subject_lesson_id`),
  ADD KEY `class_group_uid` (`class_group_uid`),
  ADD KEY `subject_lesson_id` (`subject_lesson_id`);

--
-- Indexes for table `class_group_subj_scheds`
--
ALTER TABLE `class_group_subj_scheds`
  ADD PRIMARY KEY (`class_group_uid`,`subject_id`),
  ADD KEY `subject_id` (`subject_id`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- Indexes for table `file_attachement_types`
--
ALTER TABLE `file_attachement_types`
  ADD PRIMARY KEY (`attachement_id`),
  ADD UNIQUE KEY `attachement_name` (`attachement_name`);

--
-- Indexes for table `floorlvl`
--
ALTER TABLE `floorlvl`
  ADD PRIMARY KEY (`floorlvl_id`),
  ADD KEY `building_id` (`building_id`);

--
-- Indexes for table `gender_types`
--
ALTER TABLE `gender_types`
  ADD PRIMARY KEY (`gender_id`),
  ADD UNIQUE KEY `gender_name` (`gender_name`);

--
-- Indexes for table `grade_level`
--
ALTER TABLE `grade_level`
  ADD PRIMARY KEY (`grade_level_id`),
  ADD UNIQUE KEY `grade_level_name` (`grade_level_name`);

--
-- Indexes for table `log_status`
--
ALTER TABLE `log_status`
  ADD PRIMARY KEY (`log_status_id`);

--
-- Indexes for table `log_type`
--
ALTER TABLE `log_type`
  ADD PRIMARY KEY (`log_type_id`);

--
-- Indexes for table `registered_administrators`
--
ALTER TABLE `registered_administrators`
  ADD PRIMARY KEY (`professional_id`),
  ADD UNIQUE KEY `UUID` (`UUID`);

--
-- Indexes for table `registered_parents`
--
ALTER TABLE `registered_parents`
  ADD PRIMARY KEY (`professional_id`),
  ADD UNIQUE KEY `UUID` (`UUID`);

--
-- Indexes for table `registered_students`
--
ALTER TABLE `registered_students`
  ADD PRIMARY KEY (`LRN`),
  ADD UNIQUE KEY `UUID` (`UUID`);

--
-- Indexes for table `registered_teachers`
--
ALTER TABLE `registered_teachers`
  ADD PRIMARY KEY (`professional_id`),
  ADD UNIQUE KEY `UUID` (`UUID`);

--
-- Indexes for table `registration_record`
--
ALTER TABLE `registration_record`
  ADD PRIMARY KEY (`entity_id`),
  ADD UNIQUE KEY `UUID` (`UUID`),
  ADD KEY `registration_status_id` (`registration_status_id`);

--
-- Indexes for table `registration_status`
--
ALTER TABLE `registration_status`
  ADD PRIMARY KEY (`registration_status_id`),
  ADD UNIQUE KEY `registration_status_name` (`registration_status_name`);

--
-- Indexes for table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`room_id`),
  ADD KEY `floorlvl_id` (`floorlvl_id`);

--
-- Indexes for table `school_year`
--
ALTER TABLE `school_year`
  ADD PRIMARY KEY (`school_year_id`);

--
-- Indexes for table `section`
--
ALTER TABLE `section`
  ADD PRIMARY KEY (`section_id`),
  ADD KEY `room_id` (`room_id`);

--
-- Indexes for table `semester_level`
--
ALTER TABLE `semester_level`
  ADD PRIMARY KEY (`semester_id`);

--
-- Indexes for table `server_files`
--
ALTER TABLE `server_files`
  ADD PRIMARY KEY (`full_file_path`),
  ADD KEY `UUID` (`UUID`),
  ADD KEY `file_attachement_type` (`file_attachement_type`);

--
-- Indexes for table `strand`
--
ALTER TABLE `strand`
  ADD PRIMARY KEY (`strand_id`),
  ADD KEY `track_id` (`track_id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`subject_id`),
  ADD KEY `strand_id` (`strand_id`),
  ADD KEY `subject_type_id` (`subject_type_id`);

--
-- Indexes for table `subject_lessons`
--
ALTER TABLE `subject_lessons`
  ADD PRIMARY KEY (`subject_lesson_id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- Indexes for table `subject_type`
--
ALTER TABLE `subject_type`
  ADD PRIMARY KEY (`subject_type_id`);

--
-- Indexes for table `track`
--
ALTER TABLE `track`
  ADD PRIMARY KEY (`track_id`);

--
-- Indexes for table `user_accounts`
--
ALTER TABLE `user_accounts`
  ADD PRIMARY KEY (`UUID`),
  ADD UNIQUE KEY `user_email` (`user_email`),
  ADD KEY `user_gender_type` (`user_gender_type`),
  ADD KEY `user_role_id` (`user_role_id`);

--
-- Indexes for table `user_logs`
--
ALTER TABLE `user_logs`
  ADD KEY `UUID` (`UUID`),
  ADD KEY `log_type` (`log_type`),
  ADD KEY `log_status` (`log_status`);

--
-- Indexes for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `file_attachement_types`
--
ALTER TABLE `file_attachement_types`
  MODIFY `attachement_id` int(3) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `log_status`
--
ALTER TABLE `log_status`
  MODIFY `log_status_id` int(2) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `log_type`
--
ALTER TABLE `log_type`
  MODIFY `log_type_id` int(2) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `registration_status`
--
ALTER TABLE `registration_status`
  MODIFY `registration_status_id` int(2) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_roles`
--
ALTER TABLE `user_roles`
  MODIFY `role_id` int(3) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `class_groups`
--
ALTER TABLE `class_groups`
  ADD CONSTRAINT `class_groups_ibfk_1` FOREIGN KEY (`section_id`) REFERENCES `section` (`section_id`),
  ADD CONSTRAINT `class_groups_ibfk_2` FOREIGN KEY (`strand_id`) REFERENCES `strand` (`strand_id`),
  ADD CONSTRAINT `class_groups_ibfk_3` FOREIGN KEY (`semester_id`) REFERENCES `semester_level` (`semester_id`),
  ADD CONSTRAINT `class_groups_ibfk_4` FOREIGN KEY (`grade_level_id`) REFERENCES `grade_level` (`grade_level_id`);

--
-- Constraints for table `class_group_learning_materials`
--
ALTER TABLE `class_group_learning_materials`
  ADD CONSTRAINT `class_group_learning_materials_ibfk_1` FOREIGN KEY (`class_group_uid`) REFERENCES `class_groups` (`class_group_uid`),
  ADD CONSTRAINT `class_group_learning_materials_ibfk_2` FOREIGN KEY (`full_file_path`) REFERENCES `server_files` (`full_file_path`),
  ADD CONSTRAINT `class_group_learning_materials_ibfk_3` FOREIGN KEY (`attachement_id`) REFERENCES `file_attachement_types` (`attachement_id`);

--
-- Constraints for table `class_group_students`
--
ALTER TABLE `class_group_students`
  ADD CONSTRAINT `class_group_students_ibfk_1` FOREIGN KEY (`class_group_iud`) REFERENCES `class_groups` (`class_group_uid`),
  ADD CONSTRAINT `class_group_students_ibfk_2` FOREIGN KEY (`LRN`) REFERENCES `registered_students` (`LRN`),
  ADD CONSTRAINT `class_group_students_ibfk_3` FOREIGN KEY (`UUID`) REFERENCES `user_accounts` (`UUID`);

--
-- Constraints for table `class_group_subj_assignments`
--
ALTER TABLE `class_group_subj_assignments`
  ADD CONSTRAINT `class_group_subj_assignments_ibfk_1` FOREIGN KEY (`class_group_uid`) REFERENCES `class_groups` (`class_group_uid`),
  ADD CONSTRAINT `class_group_subj_assignments_ibfk_2` FOREIGN KEY (`subject_lesson_id`) REFERENCES `subject_lessons` (`subject_lesson_id`),
  ADD CONSTRAINT `class_group_subj_assignments_ibfk_3` FOREIGN KEY (`full_file_path`) REFERENCES `server_files` (`full_file_path`);

--
-- Constraints for table `class_group_subj_scheds`
--
ALTER TABLE `class_group_subj_scheds`
  ADD CONSTRAINT `class_group_subj_scheds_ibfk_1` FOREIGN KEY (`class_group_uid`) REFERENCES `class_groups` (`class_group_uid`),
  ADD CONSTRAINT `class_group_subj_scheds_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`subject_id`),
  ADD CONSTRAINT `class_group_subj_scheds_ibfk_3` FOREIGN KEY (`teacher_id`) REFERENCES `registered_teachers` (`professional_id`);

--
-- Constraints for table `floorlvl`
--
ALTER TABLE `floorlvl`
  ADD CONSTRAINT `floorlvl_ibfk_1` FOREIGN KEY (`building_id`) REFERENCES `building` (`building_id`);

--
-- Constraints for table `registered_administrators`
--
ALTER TABLE `registered_administrators`
  ADD CONSTRAINT `registered_administrators_ibfk_1` FOREIGN KEY (`UUID`) REFERENCES `user_accounts` (`UUID`);

--
-- Constraints for table `registered_parents`
--
ALTER TABLE `registered_parents`
  ADD CONSTRAINT `registered_parents_ibfk_1` FOREIGN KEY (`UUID`) REFERENCES `user_accounts` (`UUID`);

--
-- Constraints for table `registered_students`
--
ALTER TABLE `registered_students`
  ADD CONSTRAINT `registered_students_ibfk_1` FOREIGN KEY (`UUID`) REFERENCES `user_accounts` (`UUID`);

--
-- Constraints for table `registered_teachers`
--
ALTER TABLE `registered_teachers`
  ADD CONSTRAINT `registered_teachers_ibfk_1` FOREIGN KEY (`UUID`) REFERENCES `user_accounts` (`UUID`);

--
-- Constraints for table `registration_record`
--
ALTER TABLE `registration_record`
  ADD CONSTRAINT `registration_record_ibfk_1` FOREIGN KEY (`registration_status_id`) REFERENCES `registration_status` (`registration_status_id`),
  ADD CONSTRAINT `registration_record_ibfk_2` FOREIGN KEY (`entity_id`) REFERENCES `registered_students` (`LRN`),
  ADD CONSTRAINT `registration_record_ibfk_3` FOREIGN KEY (`entity_id`) REFERENCES `registered_parents` (`professional_id`),
  ADD CONSTRAINT `registration_record_ibfk_4` FOREIGN KEY (`entity_id`) REFERENCES `registered_administrators` (`professional_id`),
  ADD CONSTRAINT `registration_record_ibfk_5` FOREIGN KEY (`entity_id`) REFERENCES `registered_teachers` (`professional_id`);

--
-- Constraints for table `room`
--
ALTER TABLE `room`
  ADD CONSTRAINT `room_ibfk_1` FOREIGN KEY (`floorlvl_id`) REFERENCES `floorlvl` (`floorlvl_id`);

--
-- Constraints for table `section`
--
ALTER TABLE `section`
  ADD CONSTRAINT `section_ibfk_1` FOREIGN KEY (`room_id`) REFERENCES `room` (`room_id`);

--
-- Constraints for table `server_files`
--
ALTER TABLE `server_files`
  ADD CONSTRAINT `server_files_ibfk_1` FOREIGN KEY (`UUID`) REFERENCES `user_accounts` (`UUID`),
  ADD CONSTRAINT `server_files_ibfk_2` FOREIGN KEY (`file_attachement_type`) REFERENCES `file_attachement_types` (`attachement_id`);

--
-- Constraints for table `strand`
--
ALTER TABLE `strand`
  ADD CONSTRAINT `strand_ibfk_1` FOREIGN KEY (`track_id`) REFERENCES `track` (`track_id`);

--
-- Constraints for table `subjects`
--
ALTER TABLE `subjects`
  ADD CONSTRAINT `subjects_ibfk_1` FOREIGN KEY (`strand_id`) REFERENCES `strand` (`strand_id`),
  ADD CONSTRAINT `subjects_ibfk_2` FOREIGN KEY (`subject_type_id`) REFERENCES `subject_type` (`subject_type_id`);

--
-- Constraints for table `subject_lessons`
--
ALTER TABLE `subject_lessons`
  ADD CONSTRAINT `subject_lessons_ibfk_1` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`subject_id`);

--
-- Constraints for table `user_accounts`
--
ALTER TABLE `user_accounts`
  ADD CONSTRAINT `user_accounts_ibfk_1` FOREIGN KEY (`user_gender_type`) REFERENCES `gender_types` (`gender_id`),
  ADD CONSTRAINT `user_accounts_ibfk_2` FOREIGN KEY (`user_role_id`) REFERENCES `user_roles` (`role_id`);

--
-- Constraints for table `user_logs`
--
ALTER TABLE `user_logs`
  ADD CONSTRAINT `user_logs_ibfk_1` FOREIGN KEY (`UUID`) REFERENCES `user_accounts` (`UUID`),
  ADD CONSTRAINT `user_logs_ibfk_2` FOREIGN KEY (`log_type`) REFERENCES `log_type` (`log_type_id`),
  ADD CONSTRAINT `user_logs_ibfk_3` FOREIGN KEY (`log_status`) REFERENCES `log_status` (`log_status_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
